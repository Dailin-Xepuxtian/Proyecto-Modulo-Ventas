<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\DTOs\ProductoResponse;
use App\Models\Repositories\ProductoRepository;
use App\Patterns\Cache\CacheAside;
use App\Patterns\Cache\FileCache;

final class ProductoService
{
    private const TTL_PRODUCTOS  = 300;   // el inventario cambia con las ventas (ADR-004)
    private const TTL_CATEGORIAS = 3600;  // cambia muy rara vez

    private ProductoRepository $productos;
    private CacheAside $cache;

    public function __construct(?ProductoRepository $productos = null, ?CacheAside $cache = null)
    {
        $this->productos = $productos ?? new ProductoRepository();
        $this->cache     = $cache ?? new CacheAside(new FileCache());
    }

    public function listar(?int $idCategoria, ?string $busqueda): array
    {
        $clave = 'productos:' . md5(json_encode([$idCategoria, $busqueda]));
        return $this->cache->obtener($clave, self::TTL_PRODUCTOS, fn() =>
            array_map([ProductoResponse::class, 'fromRow'], $this->productos->listar($idCategoria, $busqueda))
        );
    }

    public function categorias(): array
    {
        return $this->cache->obtener('categorias', self::TTL_CATEGORIAS, fn() =>
            array_map(static fn(array $c) => [
                'id_categoria'     => (int) $c['id_categoria'],
                'nombre_categoria' => $c['nombre_categoria'],
                'descripcion'      => $c['descripcion'],
            ], $this->productos->categorias())
        );
    }
}