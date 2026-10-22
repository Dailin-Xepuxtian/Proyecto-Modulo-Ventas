<?php
declare(strict_types=1);

namespace App\Patterns\Resilience;

/** Se lanza cuando el circuito está abierto y la llamada se rechaza sin intentar el servicio. */
final class CircuitoAbiertoException extends \RuntimeException
{
}
