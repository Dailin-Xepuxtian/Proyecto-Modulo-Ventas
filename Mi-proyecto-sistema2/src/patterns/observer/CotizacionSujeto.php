<?php
declare(strict_types=1);

namespace App\Patterns\Observer;

/**
 * Patrón Observer (sujeto): al cambiar el estado de una cotización avisa a todos los observadores.
 * Usa las interfaces estándar SplSubject y SplObserver de PHP.
 */
final class CotizacionSujeto implements \SplSubject
{
    private \SplObjectStorage $observadores;
    private int $idCotizacion = 0;
    private string $estadoAnterior = '';
    private string $estadoNuevo = '';

    public function __construct()
    {
        $this->observadores = new \SplObjectStorage();
    }

    public function attach(\SplObserver $observer): void
    {
        $this->observadores->attach($observer);
    }

    public function detach(\SplObserver $observer): void
    {
        $this->observadores->detach($observer);
    }

    public function notify(): void
    {
        foreach ($this->observadores as $observador) {
            $observador->update($this);
        }
    }

    public function cambiarEstado(int $idCotizacion, string $estadoAnterior, string $estadoNuevo): void
    {
        $this->idCotizacion   = $idCotizacion;
        $this->estadoAnterior = $estadoAnterior;
        $this->estadoNuevo    = $estadoNuevo;
        $this->notify();
    }

    public function idCotizacion(): int
    {
        return $this->idCotizacion;
    }

    public function estadoAnterior(): string
    {
        return $this->estadoAnterior;
    }

    public function estadoNuevo(): string
    {
        return $this->estadoNuevo;
    }
}
