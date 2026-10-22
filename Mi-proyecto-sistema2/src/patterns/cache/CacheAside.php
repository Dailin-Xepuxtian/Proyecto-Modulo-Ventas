<?php
declare(strict_types=1);

namespace App\Patterns\Cache;

/**
 * Patrón Cache-Aside: la aplicación consulta primero la caché; si no hay dato (miss),
 * lo carga de la fuente (MySQL), lo guarda con TTL y lo devuelve.
 * Si la caché falla (por ejemplo Redis caído), se degrada a consultar la fuente.
 */
final class CacheAside
{
    public function __construct(private CacheInterface $cache)
    {
    }

    /** @param callable $cargar función que consulta la fuente de verdad cuando hay miss */
    public function obtener(string $clave, int $ttlSegundos, callable $cargar): mixed
    {
        try {
            $enCache = $this->cache->get($clave);
            if ($enCache !== null) {
                return $enCache;
            }
        } catch (\Throwable $e) {
            // La caché no está disponible: se continúa con la fuente de datos.
        }

        $valor = $cargar();

        try {
            $this->cache->set($clave, $valor, $ttlSegundos);
        } catch (\Throwable $e) {
            // Si no se puede guardar, la respuesta sigue siendo correcta.
        }
        return $valor;
    }

    /** Se llama al modificar el dato en MySQL (por ejemplo, producto o inventario). */
    public function invalidar(string $clave): void
    {
        try {
            $this->cache->delete($clave);
        } catch (\Throwable $e) {
            // Sin caché disponible no hay nada que invalidar.
        }
    }
}
