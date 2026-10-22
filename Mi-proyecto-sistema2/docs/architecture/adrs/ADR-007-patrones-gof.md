# ADR-007: Patrones GoF del proyecto

- **Estado:** Parcialmente aceptado (Repository implementado; el resto, propuesto)
- **Fecha:** 2026-10-21
- **Preocupaciones (ISO 42010):** mantenibilidad (ES-01), fiabilidad

## Contexto
El enunciado exige aplicar de forma explícita los patrones Strategy, Repository, Gateway, Observer y Circuit Breaker.

## Decisión

| Patrón | Dónde se aplica | Estado |
|---|---|---|
| Repository | `ClienteRepository`, `CotizacionRepository`, `ProductoRepository`, `UsuarioRepository` aíslan el acceso a MySQL | Implementado |
| Strategy | Cálculo según método de pago (`efectivo`, `tarjeta_credito`, `tarjeta_debito`, `transferencia`, `deposito`, `cheque`) y verificación de pago | Propuesto |
| Observer | Cambio de estado de la cotización notifica a inventario (crear reserva) y a envíos | Propuesto |
| Gateway | `PasarelaPagoGateway` y `EnvioGateway` encapsulan servicios externos y MongoDB | Propuesto |
| Circuit Breaker | Envuelve las llamadas del Gateway: tras N fallos seguidos abre el circuito y responde con error controlado | Propuesto |

## Alternativas consideradas
- Lógica condicional en los servicios (`if/else` por método de pago): más rápido al inicio, pero incumple ES-01.

## Consecuencias
**Positivas:** nuevas variantes (otro método de pago, otro canal de envío) se agregan sin modificar código existente.
**Negativas:** más clases e interfaces; se justifica por el crecimiento previsto.
