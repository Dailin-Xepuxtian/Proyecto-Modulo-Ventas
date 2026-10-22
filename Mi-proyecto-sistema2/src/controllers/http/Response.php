<?php
declare(strict_types=1);

namespace App\Controllers\Http;

final class Response
{
    public static function json($data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRESERVE_ZERO_FRACTION);
    }

    public static function error(HttpException $e): void
    {
        self::json([
            'codigo'   => $e->getCodigoError(),
            'mensaje'  => $e->getMessage(),
            'detalles' => $e->getDetalles(),
        ], $e->getStatus());
    }
}
