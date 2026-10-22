<?php
declare(strict_types=1);

namespace App\Models\Repositories;

use App\Config\Database;
use PDO;

final class ProductoRepository
{
    private PDO $pdo;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo ?? Database::getConnection();
    }

    /** Catálogo: productos + categoría + existencias + proveedor principal. */
    public function listar(?int $idCategoria, ?string $busqueda): array
    {
        $sql = "SELECT p.id_producto, p.codigo, p.nombre, p.marca, p.descripcion, p.imagen,
                       p.stock_minimo, p.stock_maximo, p.precio_compra, p.precio_venta, p.estado_stock,
                       DATE(p.creado_en) AS fecha_ingreso,
                       c.id_categoria, c.nombre_categoria,
                       COALESCE(i.cant_total_disponible, 0) AS stock,
                       pr.id_proveedor, pr.nombre_empresa AS proveedor_nombre,
                       pr.contacto_nombre AS proveedor_contacto, pr.email AS proveedor_correo,
                       pr.telefono AS proveedor_telefono
                FROM productos p
                INNER JOIN categorias c ON c.id_categoria = p.id_categoria
                LEFT JOIN producto_inventario i ON i.id_producto = p.id_producto
                LEFT JOIN producto_proveedores pp ON pp.id_producto_proveedor = (
                    SELECT MIN(x.id_producto_proveedor)
                    FROM producto_proveedores x
                    WHERE x.id_producto = p.id_producto
                )
                LEFT JOIN proveedores pr ON pr.id_proveedor = pp.id_proveedor
                WHERE 1 = 1";
        $params = [];

        if ($idCategoria !== null) {
            $sql .= ' AND p.id_categoria = :categoria';
            $params[':categoria'] = $idCategoria;
        }
        if ($busqueda !== null && $busqueda !== '') {
            $sql .= ' AND (p.codigo LIKE :busqueda_codigo OR p.nombre LIKE :busqueda_nombre)';
            $like = '%' . addcslashes($busqueda, '%_\\') . '%';
            $params[':busqueda_codigo'] = $like;
            $params[':busqueda_nombre'] = $like;
        }
        $sql .= ' ORDER BY p.nombre ASC';

        $st = $this->pdo->prepare($sql);
        $st->execute($params);
        return $st->fetchAll();
    }

    public function categorias(): array
    {
        return $this->pdo
            ->query('SELECT id_categoria, nombre_categoria, descripcion FROM categorias ORDER BY id_categoria')
            ->fetchAll();
    }

    /**
     * Productos por id con su existencia, para validar una cotización.
     * @return array<int, array> indexado por id_producto
     */
    public function buscarPorIds(array $ids): array
    {
        if (!$ids) {
            return [];
        }
        $marcadores = implode(',', array_fill(0, count($ids), '?'));
        $st = $this->pdo->prepare(
            "SELECT p.id_producto, p.codigo, p.nombre, p.precio_venta, p.estado_stock,
                    COALESCE(i.cant_total_disponible, 0) AS stock
             FROM productos p
             LEFT JOIN producto_inventario i ON i.id_producto = p.id_producto
             WHERE p.id_producto IN ($marcadores)"
        );
        $st->execute(array_values($ids));

        $resultado = [];
        foreach ($st->fetchAll() as $fila) {
            $resultado[(int) $fila['id_producto']] = $fila;
        }
        return $resultado;
    }
}
