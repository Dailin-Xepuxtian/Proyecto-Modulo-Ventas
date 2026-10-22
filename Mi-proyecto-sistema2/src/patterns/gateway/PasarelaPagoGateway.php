<?php
declare(strict_types=1);

namespace App\Patterns\Gateway;

/**
 * Patrón Gateway: oculta el servicio externo de pagos detrás de una interfaz propia.
 * Lanza \RuntimeException si el servicio no responde.
 * Se recibe un token de la tarjeta; el número de la tarjeta nunca pasa por el sistema.
 */
interface PasarelaPagoGateway
{
    public function autorizar(int $montoCentavos, string $tokenTarjeta): RespuestaPasarela;
}
