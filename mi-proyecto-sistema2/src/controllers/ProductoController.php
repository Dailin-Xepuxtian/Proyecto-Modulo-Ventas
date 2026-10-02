<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\Http\HttpException;
use App\Controllers\Http\Response;
use App\Services\ProductoService;

final class ProductoController
{
    /** GET /productos?id_categoria=1&codigo=HK- */
    public function listar(array $params, array $auth): void
    {
        $idCategoria = null;
        if (isset($_GET['id_categoria']) && $_GET['id_categoria'] !== '') {
            $v = $_GET['id_categoria'];
            if (!is_string($v) || !ctype_digit($v) || (int) $v < 1) {
                throw new HttpException(400, 'BAD_REQUEST', "El parámetro 'id_categoria' debe ser un entero positivo");
            }
            $idCategoria = (int) $v;
        }

        // 'codigo' busca por código y también por nombre (buscador dinámico del catálogo, US-02)
        $busqueda = null;
        if (isset($_GET['codigo']) && is_string($_GET['codigo'])) {
            $busqueda = mb_substr(trim($_GET['codigo']), 0, 50);
        }

        Response::json((new ProductoService())->listar($idCategoria, $busqueda), 200);
    }

    /** GET /categorias */
    public function categorias(array $params, array $auth): void
    {
        Response::json((new ProductoService())->categorias(), 200);
    }
}
