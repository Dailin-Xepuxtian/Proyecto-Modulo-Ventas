# Registros de Decisiones de Arquitectura (ADR)

Formato basado en **ISO/IEC/IEEE 42010:2011**: cada ADR identifica interesados, preocupaciones, contexto, decisión, alternativas y consecuencias.

## Interesados y preocupaciones

| Interesado | Preocupaciones principales |
|---|---|
| Catedrático / evaluador | Cumplimiento de estándares, trazabilidad |
| Equipo de desarrollo | Mantenibilidad, facilidad de pruebas, curva de aprendizaje |
| Personal de ventas | Disponibilidad, rapidez al cotizar |
| Administración de Giganet | Integridad de ventas e inventario, seguridad de datos |

## Índice

| ID | Decisión | Estado |
|---|---|---|
| [ADR-001](ADR-001-estilo-arquitectonico.md) | Monolito modular en capas | Aceptado |
| [ADR-002](ADR-002-mysql-base-transaccional.md) | MySQL como base transaccional | Aceptado |
| [ADR-003](ADR-003-persistencia-poliglota.md) | Persistencia políglota como arquitectura objetivo | Propuesto |
| [ADR-004](ADR-004-cache-aside-redis.md) | Caché Cache-Aside con Redis y TTL | Propuesto |
| [ADR-005](ADR-005-autenticacion-jwt.md) | Autenticación JWT sin estado | Aceptado |
| [ADR-006](ADR-006-consistencia-eventual-saga.md) | Consistencia eventual con saga coreografiada | Propuesto |
| [ADR-007](ADR-007-patrones-gof.md) | Patrones GoF del proyecto | Parcialmente aceptado |

## Estados posibles
Propuesto → Aceptado → Reemplazado / Obsoleto. «Aceptado» significa decidido e implementado o en implementación; «Propuesto» es arquitectura objetivo documentada pero no implementada.
