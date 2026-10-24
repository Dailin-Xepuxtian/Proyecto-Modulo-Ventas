<?php
declare(strict_types=1);

namespace App\Models\DTOs;

/** Convierte cabecera + detalle SQL en el esquema "Cotizacion" del contrato OpenAPI. */
final class CotizacionResponse
{
    /** Estados de la BD -> estados del contrato OpenAPI */
    private const ESTADOS = [
        'borrador'           => 'PENDIENTE',
        'enviada'            => 'ENVIADA',
        'aprobada'           => 'APROBADA',
        'rechazada'          => 'RECHAZADA',
        'convertida_a_venta' => 'ARCHIVADA',
    ];

    public static function build(array $c, array $detalle): array
    {
        // La BD guarda una sola columna "nombre_razon_social"; el contrato pide nombre y apellido
        $partes = preg_split('/\s+/', trim($c['nombre_razon_social']), 2);

        $items = [];
        foreach ($detalle as $d) {
            $items[] = [
                'producto' => [
                    'id_producto' => (int) $d['id_producto'],
                    'codigo'      => $d['codigo'],
                    'nombre'      => $d['nombre'],
                    'marca'       => $d['marca'],
                    'imagen'      => $d['imagen'],
                ],
                'cantidad'       => (int) $d['cantidad'],
                'precioUnitario' => (float) $d['precio_unitario'],
                'subtotal'       => (float) $d['subtotal'],
            ];
        }

        return [
            'id'               => (int) $c['id_cotizacion'],
            'numeroCotizacion' => $c['no_cotizacion'],
            'cliente'          => [
                'nombre'      => $partes[0] ?? '',
                'apellido'    => $partes[1] ?? '',
                'correo'      => $c['cliente_email'],
                'nit'         => $c['cliente_nit'],
                'razonSocial' => $c['nombre_razon_social'],
            ],
            'items'            => $items,
            'subtotal'         => (float) $c['subtotal'],
            'iva'              => (float) $c['iva'],
            'total'            => (float) $c['total'],
            'estado'           => self::estadoApi((string) $c['estado']),
            'fechaCotizacion'  => date('c', strtotime($c['fecha_emision'])),
            'fechaVencimiento' => date('Y-m-d', strtotime($c['fecha_vencimiento'])),
            'usuarioId'        => (int) $c['id_usuario'],
            'urlPdf'           => null, // la generación del PDF con FPDF queda para la siguiente fase
        ];
    }

    /** Mapea el estado de la BD al valor expuesto en la API. */
    public static function estadoApi(string $estadoBd): string
    {
        return self::ESTADOS[$estadoBd] ?? strtoupper($estadoBd);
    }

    /** Fila resumida para GET /cotizaciones (sin ítems del carrito). */
    public static function resumenListado(array $fila, bool $tienePagoEnvio, ?array $pagoEnvio): array
    {
        return [
            'id'               => (int) $fila['id_cotizacion'],
            'numeroCotizacion' => $fila['no_cotizacion'],
            'cliente'          => $fila['nombre_razon_social'],
            'total'            => (float) $fila['total'],
            'estadoCotizacion' => self::estadoApi((string) $fila['estado']),
            'fechaCotizacion'  => date('c', strtotime($fila['fecha_emision'])),
            'fechaVencimiento' => date('Y-m-d', strtotime($fila['fecha_vencimiento'])),
            'tienePagoEnvio'   => $tienePagoEnvio,
            'pagoEnvio'        => $tienePagoEnvio && $pagoEnvio !== null
                ? [
                    'estadoPago'  => $pagoEnvio['estadoPago'],
                    'estadoEnvio' => $pagoEnvio['estadoEnvio'],
                ]
                : null,
        ];
    }
}
