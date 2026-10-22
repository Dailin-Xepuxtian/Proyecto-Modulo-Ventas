<?php
declare(strict_types=1);

namespace App\Models\DTOs;

use App\Controllers\Http\HttpException;

/**
 * Cuerpo de POST /cotizaciones (esquema CotizacionRequest del OpenAPI).
 * Valida formato de los datos; las reglas que dependen de la BD (stock, producto activo)
 * se validan en CotizacionService.
 */
final class CotizacionRequest
{
    public string $nombre;
    public string $apellido;
    public string $correo;
    public string $nit;
    /** @var array<int, array{productoId:int, cantidad:int}> */
    public array $items;

    public function __construct(string $nombre, string $apellido, string $correo, string $nit, array $items)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->correo = $correo;
        $this->nit = $nit;
        $this->items = $items;
    }

    public static function fromArray(array $d): self
    {
        $errores = [];

        // ---- Cliente ----
        $c = $d['cliente'] ?? null;
        if (!is_array($c)) {
            $errores[] = "El campo 'cliente' es obligatorio";
            $c = [];
        }
        $nombre   = self::texto($c['nombre'] ?? null);
        $apellido = self::texto($c['apellido'] ?? null);
        $correo   = self::texto($c['correo'] ?? null);
        $nit      = self::texto($c['nit'] ?? null);

        if ($nombre === '')   { $errores[] = "El campo 'cliente.nombre' es obligatorio"; }
        if ($apellido === '') { $errores[] = "El campo 'cliente.apellido' es obligatorio"; }
        if (mb_strlen($nombre . ' ' . $apellido) > 150) {
            $errores[] = "El nombre completo del cliente no puede superar 150 caracteres";
        }
        if ($correo === '') {
            $errores[] = "El campo 'cliente.correo' es obligatorio";
        } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL) || mb_strlen($correo) > 150) {
            $errores[] = "El campo 'cliente.correo' no es un correo válido";
        }
        if ($nit === '') {
            $nit = 'CF'; // Consumidor Final
        } elseif (!preg_match('/^(CF|\d{1,12}-?[0-9K])$/i', $nit)) {
            $errores[] = "El campo 'cliente.nit' no tiene un formato válido (ej. 1234567-8 o CF)";
        }
        $nit = strtoupper($nit);

        // ---- Items del carrito ----
        $items = [];
        $rawItems = $d['items'] ?? null;
        if (!is_array($rawItems) || count($rawItems) === 0) {
            // RN-05: no se genera una cotización con el carrito vacío
            $errores[] = "El carrito está vacío: 'items' debe contener al menos un producto";
        } else {
            foreach (array_values($rawItems) as $i => $it) {
                if (!is_array($it)) {
                    $errores[] = "items[$i] debe ser un objeto con productoId y cantidad";
                    continue;
                }
                $idProducto = self::entero($it['productoId'] ?? null);
                $cantidad   = self::entero($it['cantidad'] ?? null);

                if ($idProducto === null || $idProducto < 1) {
                    $errores[] = "items[$i].productoId debe ser un entero positivo";
                }
                // RN-03: la cantidad debe ser un entero mayor que cero
                if ($cantidad === null || $cantidad < 1) {
                    $errores[] = "items[$i].cantidad debe ser un entero mayor que cero";
                }
                if ($idProducto !== null && $idProducto >= 1 && $cantidad !== null && $cantidad >= 1) {
                    $items[] = ['productoId' => $idProducto, 'cantidad' => $cantidad];
                }
            }
        }

        if ($errores) {
            throw new HttpException(400, 'BAD_REQUEST', 'Datos de la cotización inválidos', $errores);
        }
        return new self($nombre, $apellido, $correo, $nit, $items);
    }

    private static function texto($v): string
    {
        return is_string($v) ? trim($v) : '';
    }

    private static function entero($v): ?int
    {
        if (is_int($v)) {
            return $v;
        }
        if (is_string($v) && ctype_digit($v)) {
            return (int) $v;
        }
        return null;
    }
}
