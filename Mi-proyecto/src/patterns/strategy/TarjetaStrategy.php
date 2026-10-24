<?php
declare(strict_types=1);

namespace App\Patterns\Strategy;

use App\Patterns\Gateway\PasarelaPagoGateway;

/** Tarjeta de crédito o débito: se autoriza con la pasarela. Si la pasarela no responde, el pago queda pendiente. */
final class TarjetaStrategy implements MetodoPagoStrategy
{
    public function __construct(private PasarelaPagoGateway $pasarela)
    {
    }

    public function metodos(): array
    {
        return ['tarjeta_credito', 'tarjeta_debito'];
    }

    public function procesar(int $montoCentavos, array $datos): string
    {
        if ($montoCentavos <= 0) {
            throw new \InvalidArgumentException('El monto debe ser mayor a cero');
        }
        $token = trim((string) ($datos['token_tarjeta'] ?? ''));
        if ($token === '') {
            throw new \InvalidArgumentException('Falta el token de la tarjeta (el número de tarjeta nunca se almacena)');
        }

        try {
            $respuesta = $this->pasarela->autorizar($montoCentavos, $token);
        } catch (\RuntimeException $e) {
            return 'pendiente'; // degradación controlada: se reintenta cuando la pasarela vuelva
        }
        return $respuesta->aprobado ? 'verificado' : 'rechazado';
    }
}
