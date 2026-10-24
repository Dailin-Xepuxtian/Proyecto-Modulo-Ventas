<?php
declare(strict_types=1);

namespace App\Patterns\Gateway;

use App\Config\Firestore;
use Google\Cloud\Firestore\FirestoreClient;

/** Gateway documental para consultar y crear envíos en Firestore. */
final class FirestoreEnvioGateway
{
    private const COLECCION = 'envios';

    private FirestoreClient $cliente;

    public function __construct(?FirestoreClient $cliente = null)
    {
        $this->cliente = $cliente ?? Firestore::getClient();
    }

    public function buscarIdPorCotizacion(int $idCotizacion): ?string
    {
        $documentos = $this->cliente
            ->collection(self::COLECCION)
            ->where('id_cotizacion', '=', $idCotizacion)
            ->limit(1)
            ->documents();

        foreach ($documentos as $documento) {
            if ($documento->exists()) {
                return $documento->id();
            }
        }

        return null;
    }

    /** Devuelve estado de pago y envío si existe documento para la cotización. */
    public function resumenPorCotizacion(int $idCotizacion): ?array
    {
        $documentos = $this->cliente
            ->collection(self::COLECCION)
            ->where('id_cotizacion', '=', $idCotizacion)
            ->limit(1)
            ->documents();

        foreach ($documentos as $documento) {
            if (!$documento->exists()) {
                continue;
            }
            $datos = $documento->data();
            return [
                'estado_pago'   => (string) ($datos['estado_pago'] ?? ''),
                'estado_actual' => (string) ($datos['estado_actual'] ?? ''),
            ];
        }

        return null;
    }

    public function crear(array $documento): string
    {
        return $this->cliente->collection(self::COLECCION)->add($documento)->id();
    }
}
