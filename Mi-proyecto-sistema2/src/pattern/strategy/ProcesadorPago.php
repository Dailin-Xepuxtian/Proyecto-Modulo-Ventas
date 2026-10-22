<?php
declare(strict_types=1);

namespace App\Patterns\Strategy;

/** Contexto del patrón Strategy: elige la estrategia según el método de pago. */
final class ProcesadorPago
{
    /** @var array<string, MetodoPagoStrategy> */
    private array $estrategias = [];

    public function __construct(MetodoPagoStrategy ...$estrategias)
    {
        foreach ($estrategias as $estrategia) {
            foreach ($estrategia->metodos() as $metodo) {
                $this->estrategias[$metodo] = $estrategia;
            }
        }
    }

    public function procesar(string $metodo, int $montoCentavos, array $datos = []): string
    {
        if (!isset($this->estrategias[$metodo])) {
            throw new \InvalidArgumentException("Método de pago no soportado: $metodo");
        }
        return $this->estrategias[$metodo]->procesar($montoCentavos, $datos);
    }
}
