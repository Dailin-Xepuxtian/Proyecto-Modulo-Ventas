<?php
declare(strict_types=1);

namespace App\Patterns\Cache;

/**
 * Caché en archivos con expiración (TTL). Persiste entre solicitudes HTTP sin necesitar Redis.
 * Guarda JSON en storage/cache/. Un valor null significa «no está en caché».
 */
final class FileCache implements CacheInterface
{
    private string $dir;

    public function __construct(?string $dir = null)
    {
        $this->dir = rtrim($dir ?? __DIR__ . '/../../../storage/cache', '/\\');
    }

    public function get(string $clave): mixed
    {
        $ruta = $this->ruta($clave);
        if (!is_file($ruta)) {
            return null;
        }
        $datos = json_decode((string) file_get_contents($ruta), true);
        if (!is_array($datos) || !isset($datos['expira']) || $datos['expira'] < time()) {
            @unlink($ruta);
            return null;
        }
        return $datos['valor'];
    }

    public function set(string $clave, mixed $valor, int $ttlSegundos): void
    {
        if (!is_dir($this->dir) && !mkdir($this->dir, 0775, true) && !is_dir($this->dir)) {
            throw new \RuntimeException('No se pudo crear la carpeta de caché');
        }
        $ruta = $this->ruta($clave);
        $tmp  = $ruta . '.' . bin2hex(random_bytes(4)) . '.tmp';
        file_put_contents($tmp, json_encode(['expira' => time() + $ttlSegundos, 'valor' => $valor]));
        rename($tmp, $ruta); // escritura atómica: nunca se lee un archivo a medias
    }

    public function delete(string $clave): void
    {
        $ruta = $this->ruta($clave);
        if (is_file($ruta)) {
            @unlink($ruta);
        }
    }

    /** Borra todas las entradas en caché (p. ej. tras cambiar inventario). */
    public function vaciar(): void
    {
        if (!is_dir($this->dir)) {
            return;
        }
        foreach (glob($this->dir . '/*.cache') ?: [] as $archivo) {
            @unlink($archivo);
        }
    }

    private function ruta(string $clave): string
    {
        return $this->dir . '/' . sha1($clave) . '.cache';
    }
}
