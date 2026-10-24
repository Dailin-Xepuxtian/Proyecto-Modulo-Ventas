<?php
declare(strict_types=1);

namespace App\Config;

/** Lector mínimo de archivos .env (sin dependencias externas). */
final class Env
{
    private static array $vars = [];

    public static function load(string $path): void
    {
        if (!is_file($path)) {
            return; // sin .env se usan los valores por defecto de config.php
        }
        foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $linea) {
            $linea = trim($linea);
            if ($linea === '' || $linea[0] === '#' || strpos($linea, '=') === false) {
                continue;
            }
            [$clave, $valor] = explode('=', $linea, 2);
            $valor = trim($valor);
            if (strlen($valor) >= 2 && ($valor[0] === '"' || $valor[0] === "'") && substr($valor, -1) === $valor[0]) {
                $valor = substr($valor, 1, -1);
            }
            self::$vars[trim($clave)] = $valor;
        }
    }

    public static function get(string $clave, string $porDefecto = ''): string
    {
        return self::$vars[$clave] ?? (getenv($clave) !== false ? (string) getenv($clave) : $porDefecto);
    }
}
