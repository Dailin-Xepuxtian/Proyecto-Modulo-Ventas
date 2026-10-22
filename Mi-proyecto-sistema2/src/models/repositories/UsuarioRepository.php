<?php
declare(strict_types=1);

namespace App\Models\Repositories;

use App\Config\Database;
use PDO;

final class UsuarioRepository
{
    private PDO $pdo;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo ?? Database::getConnection();
    }

    public function buscarPorEmail(string $email): ?array
    {
        $st = $this->pdo->prepare(
            'SELECT u.id_usuario, u.id_rol, u.nombres, u.apellidos, u.email, u.password, u.estado, r.nombre_rol
             FROM usuarios u
             INNER JOIN roles r ON r.id_rol = u.id_rol
             WHERE u.email = :email
             LIMIT 1'
        );
        $st->execute([':email' => $email]);
        $fila = $st->fetch();
        return $fila ?: null;
    }
}
