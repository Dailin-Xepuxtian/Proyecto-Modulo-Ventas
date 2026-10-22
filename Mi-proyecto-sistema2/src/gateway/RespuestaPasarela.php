<?php
declare(strict_types=1);

namespace App\Patterns\Gateway;

final class RespuestaPasarela
{
    public function __construct(public bool $aprobado, public string $referencia)
    {
    }
}
