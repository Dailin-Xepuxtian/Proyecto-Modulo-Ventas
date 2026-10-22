<?php
declare(strict_types=1);

namespace App\Patterns\Cache;

/** Caché en memoria con TTL. Sirve para pruebas y demostraciones sin Redis. */
final class ArrayCache implements CacheInterface
{
    /** @var array<string, array{0: mixed, 1: int}> */
    private array $datos = [];

    /** @param \Closure|null $reloj función que devuelve la hora actual (permite probar el TTL sin esperar) */
    public function __construct(private ?\Closure $reloj = null)
    {
    }

    public function get(string $clave): mixed
    {
        if (!isset($this->datos[$clave])) {
            return null;
        }
        [$valor, $expira] = $this->datos[$clave];
        if ($expira <= $this->ahora()) {
            unset($this->datos[$clave]);
            return null;
        }
        return $valor;
    }

    public function set(string $clave, mixed $valor, int $ttlSegundos): void
    {
        $this->datos[$clave] = [$valor, $this->ahora() + $ttlSegundos];
    }

    public function delete(string $clave): void
    {
        unset($this->datos[$clave]);
    }

    private function ahora(): int
    {
        return $this->reloj ? (int) ($this->reloj)() : time();
    }
}
