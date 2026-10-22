<?php
declare(strict_types=1);

namespace App\Patterns\Observer;

/** Reacciona a los cambios de estado según la saga del ADR-006. */
final class ReservaInventarioObserver implements \SplObserver
{
    public function __construct(private ReservaInventario $reservas)
    {
    }

    public function update(\SplSubject $subject): void
    {
        if (!$subject instanceof CotizacionSujeto) {
            return;
        }
        $id = $subject->idCotizacion();

        switch ($subject->estadoNuevo()) {
            case 'aprobada':
                $this->reservas->crear($id);
                break;
            case 'rechazada':
                $this->reservas->cancelar($id);
                break;
            case 'convertida_a_venta':
                $this->reservas->completar($id);
                break;
        }
    }
}
