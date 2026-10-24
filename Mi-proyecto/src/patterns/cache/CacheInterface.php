<?php
declare(strict_types=1);

namespace App\Patterns\Cache;

/** Contrato de caché clave-valor con expiración (TTL). Un valor null significa «no está en caché». */
interface CacheInterface
{
    public function get(string $clave): mixed;

    public function set(string $clave, mixed $valor, int $ttlSegundos): void;

    public function delete(string $clave): void;
}
