<?php
declare(strict_types=1);

namespace App\Patterns\Strategy;

/** Transferencia, depósito y cheque: exigen referencia y banco, y quedan pendientes hasta verificarse. */
final class ReferenciaBancariaStrategy implements MetodoPagoStrategy
{
    public function metodos(): array
    {
        return ['transferencia', 'deposito', 'cheque'];
    }

    public function procesar(int $montoCentavos, array $datos): string
    {
        if ($montoCentavos <= 0) {
            throw new \InvalidArgumentException('El monto debe ser mayor a cero');
        }
        if (trim((string) ($datos['no_referencia'] ?? '')) === '') {
            throw new \InvalidArgumentException('Falta el número de referencia');
        }
        if (trim((string) ($datos['banco'] ?? '')) === '') {
            throw new \InvalidArgumentException('Falta el banco');
        }
        return 'pendiente';
    }
}
