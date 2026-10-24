<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\Http\Request;
use App\Controllers\Http\Response;
use App\Models\DTOs\PagoEnvioRequest;
use App\Services\PagoEnvioService;

final class PagoEnvioController
{
    /** POST /cotizaciones/{cotizacionId}/pago-envio */
    public function registrar(array $params, array $auth): void
    {
        $dto = PagoEnvioRequest::fromArray(Request::json());
        $respuesta = (new PagoEnvioService())->registrar((int) $params['cotizacionId'], $dto, $auth);
        Response::json($respuesta, 201);
    }
}
