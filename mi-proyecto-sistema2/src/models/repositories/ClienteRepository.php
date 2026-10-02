<?php
declare(strict_types=1);

namespace App\Models\Repositories;

use App\Config\Database;
use PDO;

final class ClienteRepository
{
    private PDO $pdo;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo ?? Database::getConnection();
    }

    public function buscarPorEmail(string $email): ?array
    {
        $st = $this->pdo->prepare('SELECT * FROM clientes WHERE email = :email ORDER BY id_cliente LIMIT 1');
        $st->execute([':email' => $email]);
        $fila = $st->fetch();
        return $fila ?: null;
    }

    /** Crea el cliente y le asigna un código correlativo CLI-001, CLI-002... */
    public function crear(string $razonSocial, string $nit, string $email): int
    {
        $st = $this->pdo->prepare(
            'INSERT INTO clientes (codigo_cliente, nombre_razon_social, nit, email)
             VALUES (:codigo, :nombre, :nit, :email)'
        );
        $st->execute([
            ':codigo' => 'TMP-' . bin2hex(random_bytes(6)), // temporal, único
            ':nombre' => $razonSocial,
            ':nit'    => $nit,
            ':email'  => $email,
        ]);
        $id = (int) $this->pdo->lastInsertId();

        $up = $this->pdo->prepare('UPDATE clientes SET codigo_cliente = :codigo WHERE id_cliente = :id');
        $up->execute([':codigo' => 'CLI-' . str_pad((string) $id, 3, '0', STR_PAD_LEFT), ':id' => $id]);

        return $id;
    }
}
