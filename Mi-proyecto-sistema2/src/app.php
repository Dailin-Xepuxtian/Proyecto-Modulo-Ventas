<?php
declare(strict_types=1);

/**
 * Arranque de la API Giganet (front controller). Lo invoca public/index.php.
 * Flujo: Router -> (JWT) -> Controller -> Service -> Repository -> MySQL
 */

require_once __DIR__ . '/config/config.php';

// Autoloader simple: App\Carpeta\Subcarpeta\Clase -> src/carpeta/subcarpeta/Clase.php
spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    if (strncmp($class, $prefix, strlen($prefix)) !== 0) {
        return;
    }
    $relativa = substr($class, strlen($prefix));
    $pos      = strrpos($relativa, '\\');
    $dir      = $pos === false ? '' : strtolower(str_replace('\\', '/', substr($relativa, 0, $pos))) . '/';
    $clase    = $pos === false ? $relativa : substr($relativa, $pos + 1);
    $file     = __DIR__ . '/' . $dir . $clase . '.php';
    if (is_file($file)) {
        require $file;
    }
});

use App\Controllers\AuthController;
use App\Controllers\CotizacionController;
use App\Controllers\ProductoController;
use App\Controllers\Http\HttpException;
use App\Controllers\Http\Request;
use App\Controllers\Http\Response;
use App\Services\Jwt;

// CORS: permite que el prototipo de la interfaz (otro origen) consuma la API
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// Tabla de rutas: [método, patrón, controlador, acción, requiere JWT]
$routes = [
    ['POST', 'auth/login',                           AuthController::class,       'login',      false],
    ['GET',  'productos',                            ProductoController::class,   'listar',     true],
    ['GET',  'categorias',                           ProductoController::class,   'categorias', true],
    ['POST', 'cotizaciones',                         CotizacionController::class, 'crear',      true],
    ['GET',  'cotizaciones/(?<cotizacionId>\d+)',    CotizacionController::class, 'obtener',    true],
];

try {
    // Ruta solicitada, sin la carpeta base, sin "index.php" y sin el prefijo "/v1"
    $uri  = (string) parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $base = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
    if ($base !== '' && strpos($uri, $base) === 0) {
        $uri = substr($uri, strlen($base));
    }
    $uri  = preg_replace('#^/index\.php#', '', $uri);
    $uri  = preg_replace('#^/v1(?=/|$)#', '', $uri);
    $path = trim($uri, '/');
    $metodo = $_SERVER['REQUEST_METHOD'];

    $rutaExiste = false;
    foreach ($routes as [$m, $patron, $clase, $accion, $requiereAuth]) {
        if (!preg_match('#^' . $patron . '$#', $path, $coincidencias)) {
            continue;
        }
        $rutaExiste = true;
        if ($m !== $metodo) {
            continue;
        }

        $auth = [];
        if ($requiereAuth) {
            $token = Request::bearerToken();
            if ($token === null) {
                throw new HttpException(401, 'UNAUTHORIZED', 'Token no proporcionado o inválido');
            }
            $auth = Jwt::decode($token);
        }

        $params = array_filter($coincidencias, 'is_string', ARRAY_FILTER_USE_KEY);
        (new $clase())->$accion($params, $auth);
        exit;
    }

    if ($rutaExiste) {
        throw new HttpException(405, 'METHOD_NOT_ALLOWED', 'Método no permitido para este recurso');
    }
    throw new HttpException(404, 'NOT_FOUND', 'Recurso no encontrado');

} catch (HttpException $e) {
    Response::error($e);
} catch (PDOException $e) {
    error_log('[Giganet API] Error de base de datos: ' . $e->getMessage());
    Response::json(['codigo' => 'DB_ERROR', 'mensaje' => 'Error interno del servidor', 'detalles' => []], 500);
} catch (Throwable $e) {
    error_log('[Giganet API] ' . $e->getMessage());
    Response::json(['codigo' => 'INTERNAL_ERROR', 'mensaje' => 'Error interno del servidor', 'detalles' => []], 500);
}
