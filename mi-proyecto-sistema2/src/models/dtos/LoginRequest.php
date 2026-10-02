<?php
declare(strict_types=1);

namespace App\Models\DTOs;

use App\Controllers\Http\HttpException;

/** Cuerpo de POST /auth/login */
final class LoginRequest
{
    public string $email;
    public string $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public static function fromArray(array $d): self
    {
        $email = is_string($d['email'] ?? null) ? trim($d['email']) : '';
        $password = is_string($d['password'] ?? null) ? $d['password'] : '';

        $errores = [];
        if ($email === '') {
            $errores[] = "El campo 'email' es obligatorio";
        }
        if ($password === '') {
            $errores[] = "El campo 'password' es obligatorio";
        }
        if ($errores) {
            throw new HttpException(400, 'BAD_REQUEST', 'Datos de acceso incompletos', $errores);
        }
        return new self($email, $password);
    }
}
