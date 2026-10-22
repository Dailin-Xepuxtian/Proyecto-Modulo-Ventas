<?php
declare(strict_types=1);

namespace App\Patterns\Strategy;

final class EfectivoStrategy implements MetodoPagoStrategy
{
    public function metodos(): array
    {
        return ['efectivo'];
    }

    public function procesar(int $montoCentavos, array $datos): string
    {
        if ($montoCentavos <= 0) {
            throw new \InvalidArgumentException('El monto debe ser mayor a cero');
        }
        return 'verificado'; // el efectivo se confirma al recibirlo
    }
}
