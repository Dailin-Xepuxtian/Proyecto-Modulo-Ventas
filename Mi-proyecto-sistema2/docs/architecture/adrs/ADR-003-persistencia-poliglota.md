# ADR-003: Persistencia políglota como arquitectura objetivo

- **Estado:** Propuesto (MongoDB previsto parcialmente en el esquema)
- **Fecha:** 2026-10-21
- **Preocupaciones (ISO 42010):** escalabilidad, desempeño, adecuación del modelo de datos

## Contexto
No todos los datos tienen la misma forma ni el mismo patrón de acceso. La tabla `ventas` ya incluye `id_envio_mongodb`, una referencia a un documento externo. Las reservas de inventario tienen `fecha_expiracion` y estados `activa/completada/cancelada/expirada`, que se parecen a datos con caducidad. La relación producto–proveedor es de muchos a muchos.

## Decisión
Se define el siguiente reparto de responsabilidades:

| Almacén | Tipo | Uso en Giganet |
|---|---|---|
| MySQL | Relacional | Cotizaciones, ventas, pagos, clientes, productos, usuarios |
| MongoDB | Documental | Datos de envío (documentos de estructura variable), referenciados desde `ventas.id_envio_mongodb` |
| Redis | En memoria | Caché del catálogo (ADR-004) y reservas temporales con TTL |
| Neo4j | Grafos | Relaciones producto–proveedor y recomendaciones por historial de compra |

MySQL sigue siendo la **fuente de verdad** de los datos transaccionales; los demás almacenes complementan.

## Alternativas consideradas
- **Solo MySQL:** más simple, pero sin ventajas para documentos flexibles, caducidad automática ni consultas de relaciones profundas.

## Consecuencias
**Positivas:** cada dato en el almacén que mejor lo atiende; mejor desempeño de lectura.
**Negativas:** más componentes que operar, consistencia eventual entre almacenes (ADR-006), mayor costo de pruebas.
**Alcance actual:** se implementa primero MySQL; Redis es el siguiente paso de mayor valor.
