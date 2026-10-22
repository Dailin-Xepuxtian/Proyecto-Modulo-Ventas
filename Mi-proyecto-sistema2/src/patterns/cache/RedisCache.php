<?php
declare(strict_types=1);

namespace App\Patterns\Cache;

/**
 * Adaptador de Redis (requiere la extensión phpredis).
 * Uso:  $redis = new \Redis(); $redis->connect('127.0.0.1', 6379);
 *       $cache = new RedisCache($redis);
 */
final class RedisCache implements CacheInterface
{
    public function __construct(private \Redis $redis, private string $prefijo = 'giganet:')
    {
    }

    public function get(string $clave): mixed
    {
        $crudo = $this->redis->get($this->prefijo . $clave);
        if ($crudo === false || $crudo === null) {
            return null;
        }
        return json_decode((string) $crudo, true);
    }

    public function set(string $clave, mixed $valor, int $ttlSegundos): void
    {
        $this->redis->setex($this->prefijo . $clave, $ttlSegundos, json_encode($valor, JSON_UNESCAPED_UNICODE));
    }

    public function delete(string $clave): void
    {
        $this->redis->del($this->prefijo . $clave);
    }
}
