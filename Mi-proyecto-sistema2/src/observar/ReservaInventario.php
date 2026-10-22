<?php
declare(strict_types=1);

namespace App\Patterns\Observer;

/** Operaciones sobre la tabla reservas_inventario (estados activa, completada, cancelada, expirada). */
interface ReservaInventario
{
    public function crear(int $idCotizacion): void;

    public function cancelar(int $idCotizacion): void;

    public function completar(int $idCotizacion): void;
}
