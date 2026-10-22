# ADR-006: Consistencia eventual con saga coreografiada

- **Estado:** Propuesto
- **Fecha:** 2026-10-21
- **Preocupaciones (ISO 42010):** fiabilidad (ES-04), consistencia entre almacenes

## Contexto
El flujo cotización → venta → reserva de inventario → pago toca varias tablas y, en la arquitectura objetivo, varios almacenes (MySQL, MongoDB, Redis). No existe una transacción ACID que abarque todos.

## Decisión
- **Dentro de MySQL:** una sola transacción ACID para operaciones atómicas (cotización + `detalle_cotizaciones`; venta + `detalle_ventas`).
- **Entre almacenes:** consistencia eventual mediante una **saga coreografiada**; cada paso publica un evento y define su compensación.

| Paso | Evento | Estado resultante | Compensación |
|---|---|---|---|
| 1. Se crea la cotización | `CotizacionCreada` | `borrador` / `enviada` | Anular cotización |
| 2. Se aprueba | `CotizacionAprobada` | `aprobada`, reserva `activa` | Reserva `cancelada` |
| 3. Se convierte en venta | `VentaCreada` | `convertida_a_venta`, venta `pendiente` | Venta `anulada`, reserva `cancelada` |
| 4. Se registra el pago | `PagoVerificado` | venta `completada`, reserva `completada` | — |
| 4b. Pago rechazado o reserva vencida | `PagoRechazado` / `ReservaExpirada` | pago `rechazado`, reserva `expirada` | Venta `anulada`, stock liberado |

Los consumidores deben ser **idempotentes** (procesar dos veces el mismo evento no duplica efectos).

## Alternativas consideradas
- **Transacción distribuida (2PC):** no está soportada de forma práctica entre MySQL, MongoDB y Redis y reduce la disponibilidad.
- **Saga orquestada:** centraliza el control, pero agrega un componente más; innecesario con cuatro pasos.

## Consecuencias
**Positivas:** sin bloqueos largos; los fallos se compensan de forma explícita.
**Negativas:** hay ventanas breves de inconsistencia; hay que diseñar eventos, reintentos e idempotencia.
