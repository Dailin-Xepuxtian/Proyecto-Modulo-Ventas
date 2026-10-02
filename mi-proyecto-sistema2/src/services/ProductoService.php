<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\DTOs\ProductoResponse;
use App\Models\Repositories\ProductoRepository;

final class ProductoService
{
    private ProductoRepository $productos;

    public function __construct(?ProductoRepository $productos = null)
    {
        $this->productos = $productos ?? new ProductoRepository();
    }

    public function listar(?int $idCategoria, ?string $busqueda): array
    {
        return array_map([ProductoResponse::class, 'fromRow'], $this->productos->listar($idCategoria, $busqueda));
    }

    public function categorias(): array
    {
        return array_map(static fn(array $c) => [
            'id_categoria'     => (int) $c['id_categoria'],
            'nombre_categoria' => $c['nombre_categoria'],
            'descripcion'      => $c['descripcion'],
        ], $this->productos->categorias());
    }
}
