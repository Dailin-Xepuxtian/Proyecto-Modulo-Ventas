<?php
declare(strict_types=1);

namespace App\Patterns\Strategy;

/**
 * Patrón Strategy: cada método de pago (enum metodo_pago de la tabla pagos) se procesa con su propia estrategia.
 * Agregar un método nuevo = agregar una clase, sin modificar las existentes (escenario ES-01).
 */
interface MetodoPagoStrategy
{
    /** @return string[] valores de metodo_pago que atiende esta estrategia */
    public function metodos(): array;

    /**
     * @return string estado_pago resultante: 'pendiente' | 'verificado' | 'rechazado'
     * @throws \InvalidArgumentException si faltan datos obligatorios
     */
    public function procesar(int $montoCentavos, array $datos): string;
}
