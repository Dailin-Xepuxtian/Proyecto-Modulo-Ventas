<?php
declare(strict_types=1);

namespace App\Controllers\Http;

final class Request
{
    /** Lee y decodifica el cuerpo JSON de la petición. */
    public static function json(): array
    {
        $raw = file_get_contents('php://input');
        if ($raw === false || trim($raw) === '') {
            throw new HttpException(400, 'BAD_REQUEST', 'El cuerpo de la solicitud es obligatorio');
        }
        $data = json_decode($raw, true);
        if (!is_array($data)) {
            throw new HttpException(400, 'BAD_REQUEST', 'El cuerpo de la solicitud debe ser un JSON válido');
        }
        return $data;
    }

    /** Extrae el token del encabezado "Authorization: Bearer {token}". */
    public static function bearerToken(): ?string
    {
        $header = $_SERVER['HTTP_AUTHORIZATION'] ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? null;
        if ($header === null && function_exists('getallheaders')) {
            foreach (getallheaders() as $nombre => $valor) {
                if (strtolower($nombre) === 'authorization') {
                    $header = $valor;
                    break;
                }
            }
        }
        if ($header !== null && preg_match('/^Bearer\s+(.+)$/i', trim($header), $m)) {
            return $m[1];
        }
        return null;
    }
}
