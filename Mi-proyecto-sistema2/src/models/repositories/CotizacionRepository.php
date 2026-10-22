<?php
declare(strict_types=1);

namespace App\Models\Repositories;

use App\Config\Database;
use PDO;

final class CotizacionRepository
{
    private PDO $pdo;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo ?? Database::getConnection();
    }

    /** Inserta la cabecera. Puede lanzar PDOException (23000) si el número ya existe. */
    public function insertar(array $d): int
    {
        $st = $this->pdo->prepare(
            'INSERT INTO cotizaciones
                (no_cotizacion, id_cliente, id_usuario, subtotal, iva, total, estado, fecha_emision, fecha_vencimiento)
             VALUES
                (:numero, :cliente, :usuario, :subtotal, :iva, :total, :estado, :emision, :vencimiento)'
        );
        $st->execute([
            ':numero'     => $d['numero'],
            ':cliente'    => $d['id_cliente'],
            ':usuario'    => $d['id_usuario'],
            ':subtotal'   => $d['subtotal'],
            ':iva'        => $d['iva'],
            ':total'      => $d['total'],
            ':estado'     => $d['estado'],
            ':emision'    => $d['fecha_emision'],
            ':vencimiento'=> $d['fecha_vencimiento'],
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    public function insertarDetalle(int $idCotizacion, array $linea): void
    {
        $st = $this->pdo->prepare(
            'INSERT INTO detalle_cotizaciones (id_cotizacion, id_producto, cantidad, precio_unitario, subtotal)
             VALUES (:cotizacion, :producto, :cantidad, :precio, :subtotal)'
        );
        $st->execute([
            ':cotizacion' => $idCotizacion,
            ':producto'   => $linea['id_producto'],
            ':cantidad'   => $linea['cantidad'],
            ':precio'     => $linea['precio_unitario'],
            ':subtotal'   => $linea['subtotal'],
        ]);
    }

    public function obtenerPorId(int $id): ?array
    {
        $st = $this->pdo->prepare(
            'SELECT c.*, cl.nombre_razon_social, cl.email AS cliente_email, cl.nit AS cliente_nit
             FROM cotizaciones c
             INNER JOIN clientes cl ON cl.id_cliente = c.id_cliente
             WHERE c.id_cotizacion = :id'
        );
        $st->execute([':id' => $id]);
        $fila = $st->fetch();
        return $fila ?: null;
    }

    public function obtenerDetalle(int $id): array
    {
        $st = $this->pdo->prepare(
            'SELECT d.cantidad, d.precio_unitario, d.subtotal,
                    p.id_producto, p.codigo, p.nombre, p.marca, p.imagen
             FROM detalle_cotizaciones d
             INNER JOIN productos p ON p.id_producto = d.id_producto
             WHERE d.id_cotizacion = :id
             ORDER BY d.id_detalle_cotizacion'
        );
        $st->execute([':id' => $id]);
        return $st->fetchAll();
    }
}
