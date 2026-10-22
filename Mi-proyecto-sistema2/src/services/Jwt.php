<?php
declare(strict_types=1);

namespace App\Services;

use App\Controllers\Http\HttpException;

/** JWT HS256 mínimo (sin dependencias externas). */
final class Jwt
{
    public static function encode(array $payload): string
    {
        $header = self::b64(json_encode(['alg' => 'HS256', 'typ' => 'JWT']));
        $cuerpo = self::b64(json_encode($payload));
        $firma  = self::b64(hash_hmac('sha256', "$header.$cuerpo", JWT_SECRET, true));
        return "$header.$cuerpo.$firma";
    }

    public static function decode(string $jwt): array
    {
        $invalido = new HttpException(401, 'UNAUTHORIZED', 'Token no proporcionado o inválido');

        $partes = explode('.', $jwt);
        if (count($partes) !== 3) {
            throw $invalido;
        }
        [$header, $cuerpo, $firma] = $partes;

        $esperada = self::b64(hash_hmac('sha256', "$header.$cuerpo", JWT_SECRET, true));
        if (!hash_equals($esperada, $firma)) {
            throw $invalido;
        }

        $h = json_decode(self::unb64($header), true);
        if (!is_array($h) || ($h['alg'] ?? '') !== 'HS256') {
            throw $invalido;
        }

        $payload = json_decode(self::unb64($cuerpo), true);
        if (!is_array($payload) || (int) ($payload['exp'] ?? 0) < time()) {
            throw $invalido; // malformado o expirado
        }
        return $payload;
    }

    private static function b64(string $s): string
    {
        return rtrim(strtr(base64_encode($s), '+/', '-_'), '=');
    }

    private static function unb64(string $s): string
    {
        return (string) base64_decode(strtr($s, '-_', '+/'));
    }
}
