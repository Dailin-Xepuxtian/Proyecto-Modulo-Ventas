# Kevin Esteban Quinteros Quiñonez
# Dailin Mirella Xepuxtian Hernández
# Sofía Abigail Morales Pineda
# Evaluación de estilos arquitectónicos según ISO/IEC 25010

**Sistema:** Módulo de ventas y cotizaciones de Giganet, S.A.
**Contexto técnico actual:** PHP 8 sin framework, MySQL (`giganet_db`), autenticación JWT, API REST con 5 endpoints, prototipo web en HTML/Tailwind.

## 1. Metodología de la evaluación

La evaluación sigue, de forma simplificada, el enfoque **ATAM** (*Architecture Tradeoff Analysis Method*, SEI) y las decisiones se registran como ADR, con el formato de Nygard ampliado con los elementos de ISO/IEC/IEEE 42010.

| Paso | Qué se hizo | Evidencia usada |
|---|---|---|
| 1. Identificar atributos de calidad | Se priorizaron según el dominio de ventas y cotizaciones y las características de ISO 25010 | Informe de requerimientos y reglas de negocio |
| 2. Definir escenarios | Se redactaron escenarios con fuente, estímulo, entorno, respuesta y medida | Sección 3 |
| 3. Analizar el sistema actual | Se revisaron la estructura del backend, el modelo de datos y las pruebas de la API | Carpeta `src/`, diagrama de `giganet_db`, colección de Postman |
| 4. Evaluar alternativas | Se compararon cuatro estilos frente a los escenarios, anotando ventajas y riesgos | Sección 4 |
| 5. Registrar decisiones | Cada decisión se documentó en un ADR con contexto, alternativas y consecuencias | `docs/architecture/adrs/` |

**Alcance y limitaciones.** Las valoraciones (Alta, Media, Baja) son un juicio cualitativo basado en el análisis del código y del modelo de datos, no en mediciones. Las metas numéricas de los escenarios son objetivos de diseño propuestos.

**Validación pendiente.** Medir los tiempos de respuesta de `GET /productos` con el Collection Runner de Postman, con y sin caché, y ajustar los escenarios ES-02 y ES-03 con esos datos.

**Referencias.**
- Kazman, R., Klein, M., Clements, P. (2000). *ATAM: Method for Architecture Evaluation*. Software Engineering Institute.
- Bass, L., Clements, P., Kazman, R. *Software Architecture in Practice*. Addison-Wesley.
- Nygard, M. (2011). *Documenting Architecture Decisions*.
- ISO/IEC 25010:2011; ISO/IEC/IEEE 42010:2011.

## 2. Atributos de calidad priorizados (ISO/IEC 25010)

| Característica ISO 25010 | Subcaracterística relevante | Por qué importa en Giganet |
|---|---|---|
| Eficiencia de desempeño | Comportamiento temporal | El catálogo y las cotizaciones se consultan constantemente |
| Mantenibilidad | Modularidad, modificabilidad, capacidad de ser probado | El equipo es pequeño y el alcance crecerá (pagos, envíos, inventario) |
| Fiabilidad | Madurez, tolerancia a fallos | No debe haber sobreventa ni reservas huérfanas |
| Seguridad | Autenticidad, confidencialidad | Hay usuarios con roles y datos de clientes (NIT, correo) |
| Adecuación funcional | Corrección funcional | IVA 12 %, reglas de negocio RN-01 a RN-05 |

Escalabilidad se evalúa dentro de *Eficiencia de desempeño* (subcaracterística *capacidad*) y se trata aquí como atributo propio porque el documento lo exige.

## 3. Escenarios de calidad

Los objetivos medibles son **propuestas de diseño** para validar la arquitectura; se ajustan con pruebas reales.

| ID | Atributo | Fuente | Estímulo | Entorno | Respuesta | Medida |
|---|---|---|---|---|---|---|
| ES-01 | Mantenibilidad | Desarrollador | Agregar un nuevo método de pago | Desarrollo | Se añade una clase Strategy y se registra, sin tocar controladores | ≤ 1 archivo existente modificado |
| ES-02 | Desempeño | Vendedor | Consulta `GET /productos` con filtros | Operación normal, 50 usuarios concurrentes | Respuesta desde caché Redis (arquitectura objetivo, ADR-004) | p95 < 500 ms |
| ES-03 | Escalabilidad | Aumento de demanda | 5 veces el tráfico en cotizaciones | Temporada alta | Se replican instancias de la API (sin estado, JWT) | Sin cambios en la lógica de dominio |
| ES-04 | Fiabilidad | Dos vendedores | Reservan la última unidad a la vez | Operación normal | Solo una reserva queda `activa` | 0 sobreventas |
| ES-05 | Seguridad | Cliente no autenticado | Llama a `POST /cotizaciones` sin token | Operación normal | La API rechaza la solicitud | 100 % de respuestas 401 |

## 4. Comparativa de estilos

Escala: **Alta / Media / Baja** (qué tan bien cumple el estilo cada atributo).

| Atributo | Capas (monolito modular) | Repositorio (datos centralizados) | Microservicios | Orientada a eventos (EDA) |
|---|---|---|---|---|
| Escalabilidad | Media (se replica el conjunto) | Baja (cuello de botella en el repositorio) | Alta (por servicio) | Alta (productores y consumidores desacoplados) |
| Mantenibilidad | Alta con equipo pequeño | Media (acoplamiento por el esquema) | Media con equipo pequeño, alta en equipos grandes | Media (flujo difícil de seguir) |
| Desempeño | Alta (llamadas en proceso) | Alta | Media (latencia de red) | Alta en rendimiento, latencia variable |
| Fiabilidad / consistencia | Alta (ACID en MySQL) | Alta | Eventual, requiere sagas | Eventual, requiere idempotencia |
| Complejidad operativa | Baja | Baja | Alta (orquestación, observabilidad) | Alta (broker, reintentos) |
| Seguridad | Un único punto de control | Un único punto de control | Superficie mayor, más puntos de autenticación | Superficie mayor, mensajes por proteger |
| Costo y tiempo de entrega | Bajo | Bajo | Alto | Alto |

## 5. Resultado de la evaluación

Se elige **monolito modular en capas** (Controller → Service → Repository) como estilo base (ver [ADR-001](adrs/ADR-001-estilo-arquitectonico.md)). Cumple mejor ES-01 y ES-05, mantiene la consistencia ACID que exige ES-04 y tiene el menor costo operativo para el equipo.

Los estilos distribuidos quedan como **ruta de evolución**:

1. Eventos internos con el patrón Observer (cambios de estado de cotización y reservas).
2. Extraer inventario y notificaciones como servicios si la carga lo justifica (ES-03).
3. EDA con un broker solo para los flujos asíncronos (envíos, notificaciones).

El estilo Repositorio como arquitectura se descarta; el patrón Repository sí se usa dentro de las capas (ADR-007).
