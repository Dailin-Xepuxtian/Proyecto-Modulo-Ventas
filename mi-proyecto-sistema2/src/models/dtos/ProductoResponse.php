<?php
declare(strict_types=1);

namespace App\Models\DTOs;

/** Convierte una fila SQL en el esquema "Producto" del contrato OpenAPI. */
final class ProductoResponse
{
    public static function fromRow(array $r): array
    {
        $precioVenta = $r['precio_venta'] === null ? null : (float) $r['precio_venta'];
        $stock = (int) $r['stock'];

        return [
            'id_producto'   => (int) $r['id_producto'],
            'codigo'        => $r['codigo'],
            'nombre'        => $r['nombre'],
            'marca'         => $r['marca'],
            'descripcion'   => $r['descripcion'],
            'categoria'     => [
                'id_categoria'     => (int) $r['id_categoria'],
                'nombre_categoria' => $r['nombre_categoria'],
            ],
            'stock'         => $stock,
            'stock_minimo'  => (int) $r['stock_minimo'],
            'stock_maximo'  => (int) $r['stock_maximo'],
            'precio_compra' => (float) $r['precio_compra'],
            'precio_venta'  => $precioVenta,
            'imagen'        => $r['imagen'],
            'fecha_ingreso' => $r['fecha_ingreso'],
            'estado_stock'  => $r['estado_stock'],
            // RN-01: solo se puede cotizar un producto activo y disponible
            'disponible'    => $r['estado_stock'] !== 'sin_stock' && $precioVenta !== null && $stock > 0,
            'proveedor'     => $r['id_proveedor'] === null ? null : [
                'id_proveedor' => (int) $r['id_proveedor'],
                'nombre'       => $r['proveedor_nombre'],
                'contacto'     => $r['proveedor_contacto'],
                'telefono'     => $r['proveedor_telefono'],
                'correo'       => $r['proveedor_correo'],
            ],
        ];
    }
}
