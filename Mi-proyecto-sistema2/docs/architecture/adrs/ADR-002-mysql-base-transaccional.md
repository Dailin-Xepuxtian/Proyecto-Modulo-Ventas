# ADR-002: MySQL como base de datos transaccional principal

- **Estado:** Aceptado
- **Fecha:** 2026-10-21
- **Preocupaciones (ISO 42010):** integridad de datos, fiabilidad, curva de aprendizaje

## Contexto
`giganet_db` modela clientes, productos, inventario, cotizaciones, ventas y pagos con claves foráneas entre tablas (por ejemplo `cotizaciones` → `detalle_cotizaciones`, `ventas` → `pagos`). Las operaciones críticas (crear una cotización con sus detalles) requieren transacciones.

## Decisión
Se usa **MySQL** como almacén relacional principal. El documento de requerimientos menciona PostgreSQL como referencia; aquí se documenta la desviación y su justificación.

## Alternativas consideradas
- **PostgreSQL:** mejor soporte de tipos avanzados (JSONB, arrays) y extensiones, pero el entorno de desarrollo del equipo (phpMyAdmin) y su experiencia ya están en MySQL, y el modelo actual no necesita esas capacidades.

## Consecuencias
**Positivas:** integridad referencial, transacciones, herramientas conocidas por el equipo, sin costo de migración.
**Negativas:** menos flexibilidad para datos semiestructurados; esos casos se atienden con MongoDB (ADR-003).
**Nota:** el cambio a PostgreSQL es viable porque el acceso a datos está aislado en repositorios.
