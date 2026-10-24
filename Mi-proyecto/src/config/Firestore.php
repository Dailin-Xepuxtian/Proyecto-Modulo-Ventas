<?php
declare(strict_types=1);

namespace App\Config;

use App\Controllers\Http\HttpException;
use Google\Cloud\Firestore\FirestoreClient;
use Kreait\Firebase\Factory;

/** Crea una única conexión a Firestore usando la cuenta de servicio configurada en .env. */
final class Firestore
{
    private static ?FirestoreClient $cliente = null;

    public static function getClient(): FirestoreClient
    {
        if (self::$cliente !== null) {
            return self::$cliente;
        }

        if (FIREBASE_PROJECT_ID === '' || FIREBASE_CREDENTIALS === '') {
            throw new HttpException(503, 'FIRESTORE_CONFIG_MISSING', 'Firestore no está configurado');
        }
        if (!is_file(FIREBASE_CREDENTIALS)) {
            throw new HttpException(503, 'FIRESTORE_CREDENTIALS_MISSING', 'No se encontraron las credenciales de Firebase');
        }
        if (!class_exists(Factory::class)) {
            throw new HttpException(503, 'FIRESTORE_DEPENDENCY_MISSING', 'Ejecuta composer install para habilitar Firestore');
        }

        self::$cliente = (new Factory())
            ->withServiceAccount(FIREBASE_CREDENTIALS)
            ->withProjectId(FIREBASE_PROJECT_ID)
            ->createFirestore()
            ->database();

        return self::$cliente;
    }
}
