# ADR-001: Monolito modular en capas

- **Estado:** Aceptado
- **Fecha:** 2026-10-21
- **Preocupaciones (ISO 42010):** mantenibilidad, desempeño, costo de entrega

## Contexto
El módulo de ventas y cotizaciones lo desarrolla un equipo pequeño en PHP 8 sin framework. El punto de entrada es `app.php`, con una tabla de rutas que despacha a controladores. El resto del código ya está separado en `controllers/`, `services/` y `models/repositories/`, con DTOs de entrada y salida.

## Decisión
Se adopta un **monolito modular en capas**: Controller (HTTP) → Service (reglas de negocio) → Repository (acceso a datos). Los controladores no acceden a la base de datos y los repositorios no contienen reglas de negocio.

## Alternativas consideradas
- **Repositorio / datos centralizados:** descartado por acoplamiento al esquema y cuello de botella.
- **Microservicios:** descartado por costo operativo y complejidad desproporcionados al tamaño del equipo y del sistema.
- **EDA:** descartado como estilo base; se reserva para flujos asíncronos (ver ADR-006).

## Consecuencias
**Positivas:** despliegue simple, transacciones ACID, pruebas de integración por capa, menor latencia.
**Negativas:** se escala el conjunto completo; un módulo defectuoso puede afectar a todos. Además, los servicios crean sus dependencias directamente con `new` en lugar de recibirlas por inyección de dependencias, lo que dificulta las pruebas unitarias aisladas (no se pueden sustituir los repositorios por dobles de prueba).
**Mitigación:** límites claros entre módulos (productos, cotizaciones, ventas, inventario) que permitan extraerlos más adelante. Como mejora futura, inyectar los repositorios por constructor en los servicios, de modo que sea posible probarlos de forma unitaria sin MySQL.