<?php
declare(strict_types=1);

namespace App\Models\DTOs;

use App\Controllers\Http\HttpException;

/** Valida el cuerpo de POST /cotizaciones/{id}/pago-envio antes de ejecutar reglas de negocio. */
final class PagoEnvioRequest
{
    public string $tipoPago;
    public array $pago;
    public string $empresaTransporte;
    public ?string $numeroGuia;
    public string $tipoEnvio;
    public float $costoEnvio;
    public array $direccionDestino;
    public array $destinatario;
    public ?array $dimensionesPaquete;

    private const TIPOS_PAGO = ['efectivo', 'transferencia', 'tarjeta_credito', 'tarjeta_debito'];

    public function __construct(
        string $tipoPago,
        array $pago,
        string $empresaTransporte,
        ?string $numeroGuia,
        string $tipoEnvio,
        float $costoEnvio,
        array $direccionDestino,
        array $destinatario,
        ?array $dimensionesPaquete
    ) {
        $this->tipoPago = $tipoPago;
        $this->pago = $pago;
        $this->empresaTransporte = $empresaTransporte;
        $this->numeroGuia = $numeroGuia;
        $this->tipoEnvio = $tipoEnvio;
        $this->costoEnvio = $costoEnvio;
        $this->direccionDestino = $direccionDestino;
        $this->destinatario = $destinatario;
        $this->dimensionesPaquete = $dimensionesPaquete;
    }

    public static function fromArray(array $d): self
    {
        $errores = [];

        $tipoPago = self::texto($d['tipo_pago'] ?? null);
        if (!in_array($tipoPago, self::TIPOS_PAGO, true)) {
            $errores[] = "El campo 'tipo_pago' debe ser efectivo, transferencia, tarjeta_credito o tarjeta_debito";
        }

        $pago = $d['pago'] ?? [];
        if (!is_array($pago)) {
            $errores[] = "El campo 'pago' debe ser un objeto";
            $pago = [];
        }

        $empresaTransporte = self::texto($d['empresa_transporte'] ?? null);
        $numeroGuia = self::texto($d['numero_guia'] ?? null) ?: null;
        $tipoEnvio = self::texto($d['tipo_envio'] ?? null);
        $costoEnvio = self::decimal($d['costo_envio'] ?? null);

        if ($empresaTransporte === '') { $errores[] = "El campo 'empresa_transporte' es obligatorio"; }
        if ($tipoEnvio === '') { $errores[] = "El campo 'tipo_envio' es obligatorio"; }
        if ($costoEnvio === null || $costoEnvio < 0) { $errores[] = "El campo 'costo_envio' debe ser un número mayor o igual a cero"; }

        $direccion = self::objeto($d['direccion_destino'] ?? null, 'direccion_destino', $errores);
        foreach (['departamento', 'municipio', 'direccion_exacta'] as $campo) {
            if (self::texto($direccion[$campo] ?? null) === '') {
                $errores[] = "El campo 'direccion_destino.$campo' es obligatorio";
            }
        }
        $direccionDestino = [
            'departamento' => self::texto($direccion['departamento'] ?? null),
            'municipio' => self::texto($direccion['municipio'] ?? null),
            'zona' => self::texto($direccion['zona'] ?? null),
            'direccion_exacta' => self::texto($direccion['direccion_exacta'] ?? null),
            'referencias' => self::texto($direccion['referencias'] ?? null),
        ];

        $dest = self::objeto($d['destinatario'] ?? null, 'destinatario', $errores);
        foreach (['nombre_completo', 'contacto_recepcion', 'telefono'] as $campo) {
            if (self::texto($dest[$campo] ?? null) === '') {
                $errores[] = "El campo 'destinatario.$campo' es obligatorio";
            }
        }
        $email = self::texto($dest['email_notificacion'] ?? null);
        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errores[] = "El campo 'destinatario.email_notificacion' no es un correo válido";
        }
        $destinatario = [
            'nombre_completo' => self::texto($dest['nombre_completo'] ?? null),
            'contacto_recepcion' => self::texto($dest['contacto_recepcion'] ?? null),
            'telefono' => self::texto($dest['telefono'] ?? null),
            'email_notificacion' => $email,
        ];

        $dimensiones = self::dimensiones($d['dimensiones_paquete'] ?? null, $errores);

        if ($errores) {
            throw new HttpException(400, 'BAD_REQUEST', 'Datos de pago y envío inválidos', $errores);
        }

        return new self(
            $tipoPago,
            $pago,
            $empresaTransporte,
            $numeroGuia,
            $tipoEnvio,
            (float) $costoEnvio,
            $direccionDestino,
            $destinatario,
            $dimensiones
        );
    }

    private static function texto($v): string
    {
        return is_string($v) ? trim($v) : '';
    }

    private static function decimal($v): ?float
    {
        if (is_int($v) || is_float($v)) {
            return (float) $v;
        }
        if (is_string($v) && is_numeric($v)) {
            return (float) $v;
        }
        return null;
    }

    private static function objeto($v, string $nombre, array &$errores): array
    {
        if (!is_array($v)) {
            $errores[] = "El campo '$nombre' debe ser un objeto";
            return [];
        }
        return $v;
    }

    private static function dimensiones($v, array &$errores): ?array
    {
        if ($v === null) {
            return null;
        }
        if (!is_array($v)) {
            $errores[] = "El campo 'dimensiones_paquete' debe ser un objeto";
            return null;
        }

        $salida = [];
        foreach (['peso_kg', 'bultos', 'alto_cm', 'ancho_cm', 'profundidad_cm'] as $campo) {
            if (!array_key_exists($campo, $v) || $v[$campo] === null || $v[$campo] === '') {
                continue;
            }
            $valor = self::decimal($v[$campo]);
            if ($valor === null || $valor < 0) {
                $errores[] = "El campo 'dimensiones_paquete.$campo' debe ser un número mayor o igual a cero";
                continue;
            }
            $salida[$campo] = $campo === 'bultos' ? (int) $valor : $valor;
        }
        return $salida ?: null;
    }
}
