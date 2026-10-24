<?php
declare(strict_types=1);

namespace App\Services;

use App\Config\Database;
use App\Controllers\Http\HttpException;
use App\Models\DTOs\PagoEnvioRequest;
use App\Models\Repositories\ProductoRepository;
use App\Patterns\Gateway\FirestoreEnvioGateway;
use App\Patterns\Gateway\PasarelaPagoSimulada;
use App\Patterns\Strategy\EfectivoStrategy;
use App\Patterns\Strategy\ProcesadorPago;
use App\Patterns\Strategy\ReferenciaBancariaStrategy;
use App\Patterns\Strategy\TarjetaStrategy;
use Google\Cloud\Firestore\FieldValue;

/** Coordina cotización, pago simulado y documento de envío en Firestore. */
final class PagoEnvioService
{
    private CotizacionService $cotizaciones;
    private ProcesadorPago $procesadorPago;
    private ?FirestoreEnvioGateway $envios;

    public function __construct(?FirestoreEnvioGateway $envios = null)
    {
        $this->cotizaciones = new CotizacionService();
        $this->procesadorPago = new ProcesadorPago(
            new EfectivoStrategy(),
            new ReferenciaBancariaStrategy(),
            new TarjetaStrategy(new PasarelaPagoSimulada())
        );
        $this->envios = $envios;
    }

    public function registrar(int $idCotizacion, PagoEnvioRequest $dto, array $auth): array
    {
        $cotizacion = $this->cotizaciones->obtener($idCotizacion, $auth);
        if (in_array($cotizacion['estado'], ['RECHAZADA', 'ARCHIVADA'], true)) {
            throw new HttpException(400, 'COTIZACION_NO_PAGABLE', 'La cotización no permite registrar pago y envío');
        }

        $montoCentavos = (int) round(((float) $cotizacion['total']) * 100);
        try {
            $estadoPago = $this->procesadorPago->procesar($dto->tipoPago, $montoCentavos, $dto->pago);
        } catch (\InvalidArgumentException $e) {
            throw new HttpException(400, 'PAGO_INVALIDO', $e->getMessage());
        }

        if ($estadoPago === 'rechazado') {
            throw new HttpException(400, 'PAGO_RECHAZADO', 'La tarjeta fue rechazada por la pasarela simulada');
        }

        try {
            $gateway = $this->envios ?? new FirestoreEnvioGateway();
            if ($gateway->buscarIdPorCotizacion($idCotizacion) !== null) {
                throw new HttpException(409, 'PAGO_ENVIO_DUPLICADO', 'La cotización ya tiene pago y envío registrado');
            }

            $numeroGuia = $dto->numeroGuia ?? $this->generarNumeroGuia($idCotizacion);
            $documento = $this->crearDocumento($idCotizacion, $cotizacion, $dto, $estadoPago, $numeroGuia, $montoCentavos);

            $pdo = Database::getConnection();
            $productos = new ProductoRepository($pdo);
            $descontados = [];
            $pdo->beginTransaction();
            try {
                foreach ($cotizacion['items'] as $item) {
                    $idProducto = (int) $item['producto']['id_producto'];
                    $cantidad = (int) $item['cantidad'];
                    if (!$productos->descontarStock($idProducto, $cantidad)) {
                        throw new HttpException(
                            400,
                            'REGLA_DE_NEGOCIO',
                            'No hay existencia suficiente para completar la venta',
                            ["Stock insuficiente para {$item['producto']['codigo']}"]
                        );
                    }
                    $descontados[] = ['id_producto' => $idProducto, 'cantidad' => $cantidad];
                }
                $pdo->commit();
            } catch (HttpException $e) {
                if ($pdo->inTransaction()) {
                    $pdo->rollBack();
                }
                throw $e;
            } catch (\Throwable $e) {
                if ($pdo->inTransaction()) {
                    $pdo->rollBack();
                }
                throw $e;
            }

            try {
                $firestoreId = $gateway->crear($documento);
            } catch (\Throwable $e) {
                foreach ($descontados as $linea) {
                    $productos->devolverStock($linea['id_producto'], $linea['cantidad']);
                }
                throw $e;
            }

            ProductoService::invalidarCatalogo();
        } catch (HttpException $e) {
            throw $e;
        } catch (\Throwable $e) {
            error_log('[Giganet API] Error Firestore pago-envio: ' . $e->getMessage());
            throw new HttpException(502, 'FIRESTORE_ERROR', 'No se pudo registrar el pago y envío en Firestore');
        }

        return [
            'id_cotizacion' => $idCotizacion,
            'no_cotizacion' => $cotizacion['numeroCotizacion'],
            'firestoreId' => $firestoreId,
            'tipo_pago' => $dto->tipoPago,
            'monto_compra' => (float) $cotizacion['total'],
            'estado_pago' => $estadoPago,
            'referencia_pago' => $documento['referencia_pago'],
            'estado_actual' => $documento['estado_actual'],
            'costo_envio' => $dto->costoEnvio,
            'numero_guia' => $numeroGuia,
        ];
    }

    private function crearDocumento(
        int $idCotizacion,
        array $cotizacion,
        PagoEnvioRequest $dto,
        string $estadoPago,
        string $numeroGuia,
        int $montoCentavos
    ): array {
        $documento = [
            'id_cotizacion' => $idCotizacion,
            'no_cotizacion' => $cotizacion['numeroCotizacion'],
            'tipo_pago' => $dto->tipoPago,
            'monto_compra' => (float) $cotizacion['total'],
            'estado_pago' => $estadoPago,
            'referencia_pago' => $this->referenciaPago($idCotizacion, $dto, $montoCentavos),
            'empresa_transporte' => $dto->empresaTransporte,
            'numero_guia' => $numeroGuia,
            'tipo_envio' => $dto->tipoEnvio,
            'costo_envio' => $dto->costoEnvio,
            'direccion_destino' => $dto->direccionDestino,
            'destinatario' => $dto->destinatario,
            'estado_actual' => 'Pendiente de envío',
            'fecha_registro' => FieldValue::serverTimestamp(),
        ];

        if ($dto->dimensionesPaquete !== null) {
            $documento['dimensiones_paquete'] = $dto->dimensionesPaquete;
        }

        return $documento;
    }

    private function referenciaPago(int $idCotizacion, PagoEnvioRequest $dto, int $montoCentavos): string
    {
        if ($dto->tipoPago === 'efectivo') {
            return 'EFE-' . $idCotizacion . '-' . date('YmdHis');
        }
        if ($dto->tipoPago === 'transferencia') {
            return trim((string) ($dto->pago['no_referencia'] ?? ''));
        }

        $token = trim((string) ($dto->pago['token_tarjeta'] ?? ''));
        return 'SIM-' . substr(md5($token . $montoCentavos), 0, 8);
    }

    private function generarNumeroGuia(int $idCotizacion): string
    {
        return 'GX-' . date('Y') . '-' . $idCotizacion;
    }
}
