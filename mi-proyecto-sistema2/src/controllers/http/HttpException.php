<?php
declare(strict_types=1);

namespace App\Controllers\Http;

/** Error controlado que se traduce a una respuesta HTTP con el formato "Error" del OpenAPI. */
class HttpException extends \RuntimeException
{
    private int $status;
    private string $codigoError;
    private array $detalles;

    public function __construct(int $status, string $codigoError, string $mensaje, array $detalles = [])
    {
        parent::__construct($mensaje);
        $this->status = $status;
        $this->codigoError = $codigoError;
        $this->detalles = $detalles;
    }

    public function getStatus(): int { return $this->status; }
    public function getCodigoError(): string { return $this->codigoError; }
    public function getDetalles(): array { return $this->detalles; }
}
