<?php
declare(strict_types=1);

namespace App\Services;

use App\Controllers\Http\HttpException;
use App\Services\Jwt;
use App\Models\DTOs\LoginRequest;
use App\Models\Repositories\UsuarioRepository;

final class AuthService
{
    private UsuarioRepository $usuarios;

    public function __construct(?UsuarioRepository $usuarios = null)
    {
        $this->usuarios = $usuarios ?? new UsuarioRepository();
    }

    public function login(LoginRequest $dto): array
    {
        $u = $this->usuarios->buscarPorEmail($dto->email);

        // Siempre se ejecuta password_verify (aunque el usuario no exista) para no revelar por tiempo si el correo existe
        $hash = $u['password'] ?? '$2y$10$abcdefghijklmnopqrstuuABCDEFGHIJKLMNOPQRSTUVWXYZ01234';
        $passwordOk = password_verify($dto->password, $hash);

        if (!$u || !$passwordOk || $u['estado'] !== 'activo') {
            throw new HttpException(401, 'UNAUTHORIZED', 'Email o contraseña incorrectos');
        }

        $ahora = time();
        $token = Jwt::encode([
            'sub'    => (int) $u['id_usuario'],
            'email'  => $u['email'],
            'rol'    => (int) $u['id_rol'],
            'iat'    => $ahora,
            'exp'    => $ahora + JWT_TTL,
        ]);

        return [
            'token'     => $token,
            'tipo'      => 'Bearer',
            'expiraEn'  => JWT_TTL,
            'usuario'   => [
                'id'     => (int) $u['id_usuario'],
                'nombre' => trim($u['nombres'] . ' ' . $u['apellidos']),
                'rol'    => $u['nombre_rol'],
            ],
        ];
    }
}
