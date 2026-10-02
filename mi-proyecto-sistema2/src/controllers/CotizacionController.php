<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\Http\Request;
use App\Controllers\Http\Response;
use App\Models\DTOs\CotizacionRequest;
use App\Services\CotizacionService;

final class CotizacionController
{
    /** POST /cotizaciones */
    public function crear(array $params, array $auth): void
    {
        $dto = CotizacionRequest::fromArray(Request::json());
        $cotizacion = (new CotizacionService())->crear($dto, (int) $auth['sub']);
        Response::json($cotizacion, 201);
    }

    /** GET /cotizaciones/{cotizacionId} */
    public function obtener(array $params, array $auth): void
    {
        $cotizacion = (new CotizacionService())->obtener((int) $params['cotizacionId'], $auth);
        Response::json($cotizacion, 200);
    }
}
