# ADR-007: Patrones GoF del proyecto

- **Estado:** Aceptado (Repository integrado; Strategy, Observer, Gateway y Circuit Breaker implementados como módulo independiente)
- **Fecha:** 2026-10-21
- **Preocupaciones (ISO 42010):** mantenibilidad (ES-01), fiabilidad

## Contexto
El enunciado exige aplicar de forma explícita los patrones Strategy, Repository, Gateway, Observer y Circuit Breaker.

## Decisión

| Patrón | Dónde se aplica | Estado |
|---|---|---|
| Repository | `ClienteRepository`, `CotizacionRepository`, `ProductoRepository`, `UsuarioRepository` aíslan el acceso a MySQL | Implementado e integrado en los endpoints |
| Strategy | Verificación de pago según el método (`efectivo`, `transferencia`, `tarjeta_credito`) en `src/patterns/strategy/` | Implementado (módulo independiente en `src/patterns/`, aún sin conectar a endpoints) |
| Observer | Cambio de estado de la cotización notifica a inventario (reserva) y a la bitácora, en `src/patterns/observer/` | Implementado (módulo independiente en `src/patterns/`, aún sin conectar a endpoints) |
| Gateway | `PasarelaPagoSimulada` y `PasarelaPagoConCircuitBreaker` encapsulan el servicio externo de pago, en `src/patterns/gateway/` | Implementado (módulo independiente en `src/patterns/`, aún sin conectar a endpoints) |
| Circuit Breaker | `CircuitBreaker` en `src/patterns/resilience/`: tras N fallos seguidos abre el circuito y responde con error controlado | Implementado (módulo independiente en `src/patterns/`, aún sin conectar a endpoints) |

**Verificación:** los cuatro módulos independientes se probaron con `tools/demo_patrones.php`, que no requiere MySQL ni Redis.

## Alternativas consideradas
- Lógica condicional en los servicios (`if/else` por método de pago): más rápido al inicio, pero incumple ES-01.

## Consecuencias
**Positivas:** nuevas variantes (otro método de pago, otro canal de envío) se agregan sin modificar código existente.
**Negativas:** más clases e interfaces; se justifica por el crecimiento previsto. Mientras los módulos no estén conectados a los endpoints, su efecto en el sistema real es nulo y solo se demuestran con el script.
