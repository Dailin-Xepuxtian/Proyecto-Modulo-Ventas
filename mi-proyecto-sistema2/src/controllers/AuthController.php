<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\Http\Request;
use App\Controllers\Http\Response;
use App\Models\DTOs\LoginRequest;
use App\Services\AuthService;

final class AuthController
{
    /** POST /auth/login */
    public function login(array $params, array $auth): void
    {
        $dto = LoginRequest::fromArray(Request::json());
        Response::json((new AuthService())->login($dto), 200);
    }
}
