# Backlog ágil: Módulo de ventas y cotizaciones de Giganet, S.A.

**Proyecto:** Análisis de Sistemas II, UMG
**Equipo:** Dailin Mireya Xepuxtian Hernández, Kevin Esteban Quinteros Quiñonez, Sofía Abigail Morales Pineda

**Tablero del proyecto:** https://github.com/kquinterosq-cell/proyecto-modulo-ventas

**Escenarios BDD:** [`features/`](../../features/) (`autenticacion.feature` y `gestion_recursos.feature`)

---

## Épicas

| Id | Épica | Descripción |
|---|---|---|
| E1 | Autenticación | Acceso seguro a la API mediante JWT. |
| E2 | Catálogo | Consulta de productos y categorías para armar cotizaciones. |
| E3 | Cotizaciones | Creación y consulta de cotizaciones con sus reglas de negocio. |
| E4 | Experiencia de usuario | Prototipo navegable y accesible que consume la API. |

## Historias de usuario

| Id | Épica | Historia | Prioridad | Puntos | Estado |
|---|---|---|---|---|---|
| HU-01 | E1 | Como usuario, quiero iniciar sesión con mi correo y contraseña para obtener un token y usar el sistema. | Alta | 3 | Hecho |
| HU-02 | E1 | Como sistema, quiero rechazar las peticiones sin token o con token inválido para proteger los datos. | Alta | 2 | Hecho |
| HU-03 | E2 | Como asesor, quiero ver el catálogo de productos con su precio y existencia para saber qué puedo cotizar. | Alta | 3 | Hecho |
| HU-04 | E2 | Como asesor, quiero buscar productos por código y filtrarlos por categoría para encontrarlos más rápido. | Media | 3 | Hecho |
| HU-05 | E2 | Como asesor, quiero listar las categorías para filtrar el catálogo. | Baja | 1 | Hecho |
| HU-06 | E3 | Como asesor, quiero crear una cotización para un cliente con varios productos para ofrecerle un precio formal. | Alta | 8 | Hecho |
| HU-07 | E3 | Como asesor, quiero que el sistema calcule subtotal, IVA 12 % y total para evitar errores de cálculo. | Alta | 3 | Hecho |
| HU-08 | E3 | Como asesor, quiero que cada cotización tenga un número único y una fecha de vencimiento a 15 días para darle seguimiento. | Media | 2 | Hecho |
| HU-09 | E3 | Como asesor, quiero que el sistema impida cotizar productos sin existencia suficiente, con cantidad cero o con el carrito vacío, para no ofrecer lo que no se puede entregar. | Alta | 5 | Hecho |
| HU-10 | E3 | Como asesor, quiero consultar una cotización ya creada para revisarla o compartirla con el cliente. | Media | 2 | Hecho |
| HU-11 | E4 | Como asesor, quiero un prototipo navegable en el celular y en la computadora para generar cotizaciones sin usar herramientas técnicas. | Alta | 8 | Hecho |
| HU-12 | E4 | Como persona con dificultades visuales, quiero que la interfaz cumpla las pautas WCAG 2.1 para poder usarla sin barreras. | Media | 5 | Hecho |

## Criterios de aceptación (resumen)

| Historia | Criterio principal | Escenario BDD |
|---|---|---|
| HU-01 | `POST /auth/login` con datos correctos devuelve 200 y un token Bearer que expira en 3600 s. | `autenticacion.feature` |
| HU-02 | Sin token o con token inválido, los endpoints protegidos devuelven 401. | `autenticacion.feature` |
| HU-03 | `GET /productos` devuelve 200 con la lista de productos. | `gestion_recursos.feature` |
| HU-04 | Los filtros `codigo` e `id_categoria` devuelven solo coincidencias; un `id_categoria` inválido devuelve 400. | `gestion_recursos.feature` |
| HU-05 | `GET /categorias` devuelve 200 con las categorías. | `gestion_recursos.feature` |
| HU-06 | `POST /cotizaciones` con datos válidos devuelve 201 y la cotización queda en estado borrador. | `gestion_recursos.feature` |
| HU-07 | El IVA es 12 % del subtotal y el total es subtotal más IVA. | `gestion_recursos.feature` |
| HU-08 | El número tiene el formato `COT-AAAAMMDD-HHMMSS` y vence a los 15 días. | `gestion_recursos.feature` |
| HU-09 | Carrito vacío (RN-05), cantidad cero (RN-03) o sin existencia (RN-01, RN-02) devuelven 400 y no se guarda nada. | `gestion_recursos.feature` |
| HU-10 | `GET /cotizaciones/{id}` devuelve 200 si existe y 404 si no. | `gestion_recursos.feature` |
| HU-11 | El prototipo consume la API y permite armar y generar una cotización. | Reporte de usabilidad |
| HU-12 | El reporte de usabilidad documenta el cumplimiento de WCAG 2.1 (contrastes, teclado, etiquetas). | Reporte de usabilidad |

## Fuera de alcance de esta entrega

- PDF de la cotización
- Historial de cotizaciones
- Cambio de estado de la cotización (PATCH)
- Pagos, facturas y notificaciones

## Definición de terminado

- El endpoint o la pantalla funciona y fue probado (colección de Postman: 38 pruebas pasadas, 0 fallidas).
- Cumple los escenarios BDD de la historia.
- La documentación y el código están en el repositorio.
