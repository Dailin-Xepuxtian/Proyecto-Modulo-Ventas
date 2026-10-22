<?php
declare(strict_types=1);

namespace App\Patterns\Gateway;

/** Implementación simulada de la pasarela (no hay un proveedor real conectado). */
final class PasarelaPagoSimulada implements PasarelaPagoGateway
{
    public int $llamadas = 0;

    public function __construct(private bool $disponible = true, private int $limiteCentavos = 5000000)
    {
    }

    public function setDisponible(bool $disponible): void
    {
        $this->disponible = $disponible;
    }

    public function autorizar(int $montoCentavos, string $tokenTarjeta): RespuestaPasarela
    {
        $this->llamadas++;
        if (!$this->disponible) {
            throw new \RuntimeException('La pasarela de pago no responde');
        }
        return new RespuestaPasarela(
            $montoCentavos <= $this->limiteCentavos,
            'SIM-' . substr(md5($tokenTarjeta . $montoCentavos), 0, 8)
        );
    }
}
