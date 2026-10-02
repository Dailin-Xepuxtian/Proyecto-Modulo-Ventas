<?php
declare(strict_types=1);

namespace App\Services;

use App\Config\Database;
use App\Controllers\Http\HttpException;
use App\Models\DTOs\CotizacionRequest;
use App\Models\DTOs\CotizacionResponse;
use App\Models\Repositories\ClienteRepository;
use App\Models\Repositories\CotizacionRepository;
use App\Models\Repositories\ProductoRepository;
use PDO;
use PDOException;

/**
 * Reglas de negocio de cotizaciones:
 *  RN-01 producto activo/disponible · RN-02 cantidad <= existencia · RN-03 cantidad entera > 0
 *  RN-04/RN-14 total = precio vigente x cantidad · RN-05 carrito no vacío · RN-07 número único
 *  RN-10/RN-11 un asesor solo ve sus cotizaciones; el administrador ve todas
 */
final class CotizacionService
{
    private const ROL_ADMINISTRADOR = 1;

    private PDO $pdo;
    private ProductoRepository $productos;
    private ClienteRepository $clientes;
    private CotizacionRepository $cotizaciones;

    public function __construct()
    {
        $this->pdo          = Database::getConnection();
        $this->productos    = new ProductoRepository($this->pdo);
        $this->clientes     = new ClienteRepository($this->pdo);
        $this->cotizaciones = new CotizacionRepository($this->pdo);
    }

    public function crear(CotizacionRequest $dto, int $idUsuario): array
    {
        // Si el mismo producto aparece varias veces en el carrito, se suman las cantidades
        $solicitado = [];
        foreach ($dto->items as $item) {
            $solicitado[$item['productoId']] = ($solicitado[$item['productoId']] ?? 0) + $item['cantidad'];
        }

        $productos = $this->productos->buscarPorIds(array_keys($solicitado));

        // ---- Validaciones contra la BD y cálculo (en centavos para evitar errores de redondeo) ----
        $errores = [];
        $lineas = [];
        $subtotalCent = 0;

        foreach ($solicitado as $idProducto => $cantidad) {
            if (!isset($productos[$idProducto])) {
                $errores[] = "El producto con id $idProducto no existe";
                continue;
            }
            $p = $productos[$idProducto];

            if ($p['estado_stock'] === 'sin_stock' || $p['precio_venta'] === null) { // RN-01
                $errores[] = "El producto {$p['codigo']} no está disponible para la venta";
                continue;
            }
            if ($cantidad > (int) $p['stock']) { // RN-02
                $errores[] = "La cantidad solicitada de {$p['codigo']} ($cantidad) supera la existencia disponible ({$p['stock']})";
                continue;
            }

            $precioCent = (int) round(((float) $p['precio_venta']) * 100); // RN-04 / RN-14
            $subCent = $precioCent * $cantidad;
            $subtotalCent += $subCent;
            $lineas[] = [
                'id_producto'     => (int) $idProducto,
                'cantidad'        => $cantidad,
                'precio_unitario' => self::dinero($precioCent),
                'subtotal'        => self::dinero($subCent),
            ];
        }

        if ($errores) {
            throw new HttpException(400, 'REGLA_DE_NEGOCIO', 'No se pudo generar la cotización', $errores);
        }

        $ivaCent   = (int) round($subtotalCent * IVA_PORCENTAJE / 100);
        $totalCent = $subtotalCent + $ivaCent;

        // ---- Persistencia en una sola transacción ----
        $this->pdo->beginTransaction();
        try {
            $cliente = $this->clientes->buscarPorEmail($dto->correo);
            $idCliente = $cliente
                ? (int) $cliente['id_cliente']
                : $this->clientes->crear($dto->nombre . ' ' . $dto->apellido, $dto->nit, $dto->correo);

            $idCotizacion = $this->insertarConNumeroUnico([
                'id_cliente' => $idCliente,
                'id_usuario' => $idUsuario,
                'subtotal'   => self::dinero($subtotalCent),
                'iva'        => self::dinero($ivaCent),
                'total'      => self::dinero($totalCent),
                'estado'     => 'borrador', // se expone como PENDIENTE
            ]);

            foreach ($lineas as $linea) {
                $this->cotizaciones->insertarDetalle($idCotizacion, $linea);
            }

            $this->pdo->commit();
        } catch (\Throwable $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            throw $e;
        }

        return $this->obtener($idCotizacion, null);
    }

    /**
     * Devuelve una cotización. Si se pasa $auth, aplica RN-10/RN-11:
     * el administrador ve todas; los demás roles solo las que ellos generaron.
     */
    public function obtener(int $id, ?array $auth): array
    {
        $cotizacion = $this->cotizaciones->obtenerPorId($id);
        if (!$cotizacion) {
            throw new HttpException(404, 'NOT_FOUND', 'Cotización no encontrada');
        }

        if ($auth !== null
            && (int) $auth['rol'] !== self::ROL_ADMINISTRADOR
            && (int) $cotizacion['id_usuario'] !== (int) $auth['sub']) {
            throw new HttpException(403, 'FORBIDDEN', 'No tienes permiso para consultar esta cotización');
        }

        return CotizacionResponse::build($cotizacion, $this->cotizaciones->obtenerDetalle($id));
    }

    /** RN-07: número COT-YYYYMMDD-HHMMSS único; si dos cotizaciones coinciden en el mismo segundo, se avanza 1 s. */
    private function insertarConNumeroUnico(array $datos): int
    {
        for ($i = 0; $i < 5; $i++) {
            $ts = time() + $i;
            $datos['numero'] = 'COT-' . date('Ymd-His', $ts);
            $datos['fecha_emision'] = date('Y-m-d H:i:s', $ts);
            $datos['fecha_vencimiento'] = date('Y-m-d H:i:s', strtotime('+' . DIAS_VENCIMIENTO . ' days', $ts));

            try {
                return $this->cotizaciones->insertar($datos);
            } catch (PDOException $e) {
                $duplicado = $e->getCode() === '23000' && stripos($e->getMessage(), 'no_cotizacion') !== false;
                if (!$duplicado) {
                    throw $e;
                }
            }
        }
        throw new HttpException(500, 'INTERNAL_ERROR', 'No se pudo generar un número de cotización único');
    }

    private static function dinero(int $centavos): string
    {
        return number_format($centavos / 100, 2, '.', '');
    }
}
