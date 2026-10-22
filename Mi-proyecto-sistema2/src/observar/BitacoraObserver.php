<?php
declare(strict_types=1);

namespace App\Patterns\Observer;

/** Segundo observador: deja constancia de cada transición de estado. */
final class BitacoraObserver implements \SplObserver
{
    /** @var string[] */
    private array $registro = [];

    public function update(\SplSubject $subject): void
    {
        if (!$subject instanceof CotizacionSujeto) {
            return;
        }
        $this->registro[] = sprintf(
            'Cotización %d: %s -> %s',
            $subject->idCotizacion(),
            $subject->estadoAnterior(),
            $subject->estadoNuevo()
        );
    }

    /** @return string[] */
    public function registro(): array
    {
        return $this->registro;
    }
}
