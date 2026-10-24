<?php
declare(strict_types=1);

namespace App\Patterns\Gateway;

use App\Patterns\Resilience\CircuitBreaker;

/** Envuelve cualquier pasarela con un Circuit Breaker (mismo contrato, así que es transparente para quien la usa). */
final class PasarelaPagoConCircuitBreaker implements PasarelaPagoGateway
{
    public function __construct(private PasarelaPagoGateway $interna, private CircuitBreaker $breaker)
    {
    }

    public function autorizar(int $montoCentavos, string $tokenTarjeta): RespuestaPasarela
    {
        return $this->breaker->ejecutar(fn () => $this->interna->autorizar($montoCentavos, $tokenTarjeta));
    }
}
