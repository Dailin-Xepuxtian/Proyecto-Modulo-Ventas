<<<<<<< HEAD
# Giganet – Módulo de Ventas y Cotizaciones (API)

Proyecto del curso **Análisis de Sistemas II**, Universidad Mariano Gálvez de Guatemala.
Backend en **PHP 8** sin framework, arquitectura por capas, **MySQL** con PDO y autenticación **JWT**.
El usuario del sistema es el asesor de ventas de Giganet, S.A.; el administrador ve todas las cotizaciones.

**Integrantes:** Dailin Mireya Xepuxtian Hernández · Kevin Esteban Quinteros Quiñonez · Sofía Abigail Morales Pineda

## Requisitos
- PHP 8.0 o superior (extensiones `pdo_mysql`, `mbstring`, y para Firestore en Windows: `grpc` + `protobuf`)
- Composer 2.x (o `php composer.phar`) para instalar el SDK de Firebase
- MySQL / MariaDB
- Apache con `mod_rewrite` (XAMPP en Windows funciona sin cambios)
- Postman para las pruebas

## Instalación (XAMPP)
1. Copiar esta carpeta a `C:\xampp\htdocs\giganet`.
2. Copiar `.env.example` a `.env` y ajustar usuario y contraseña de MySQL si es necesario.
3. Crear la base de datos importando `docs/database/schema.sql` (crea `giganet_db` con datos de prueba).
   En `cmd` (no PowerShell):
   `C:\xampp\mysql\bin\mysql.exe -u root --default-character-set=utf8mb4 < docs\database\schema.sql`
4. Ejecutar `php composer.phar update` (instala `kreait/firebase-php` y `google/cloud-firestore`).
5. En XAMPP Windows, instalar extensiones PECL `grpc` y `protobuf` (ver `docs/database/firebase-windows-xampp.md`).
6. Configurar `FIREBASE_PROJECT_ID` y `FIREBASE_CREDENTIALS` en `.env` con una cuenta de servicio de Firebase.
7. Iniciar Apache y MySQL desde el panel de XAMPP.
8. Verificar en el navegador: `http://localhost/giganet/public/categorias` debe responder `401` en JSON (requiere token).

**URL base de la API:** `http://localhost/giganet/public`  (también acepta el prefijo `/v1`).

**Usuarios de prueba** (contraseña `Manager1`): `kquinteros@giganet.com.gt` (administrador), `galfonso@giganet.com.gt` (asesora).

## Estructura
```text
proyecto/
├── informe/                informe_requerimientos_ui_backend.pdf
├── features/               escenarios BDD (Gherkin)
├── docs/
│   ├── agile/              backlog.md
│   ├── ui/                 reporte_usabilidad.pdf, wireframes, mapa de navegación, prototipo/
│   ├── architecture/       secuencia_endpoint.png
│   └── database/           schema.sql
├── src/
│   ├── app.php             arranque y router
│   ├── config/             config.php, Env.php, Database.php (conexión PDO)
│   ├── controllers/        reciben la petición HTTP (y controllers/http: Request, Response, HttpException)
│   ├── services/           reglas de negocio y Jwt
│   └── models/             repositories/ (SQL) y dtos/ (validación y formato de salida)
├── public/                 index.php (único archivo expuesto) + .htaccess
├── test-api/               coleccion_postman.json
├── .env.example
└── README.md
```

Flujo de una petición: `public/index.php → src/app.php (router + JWT) → Controller → Service → Repository → MySQL`.

## Endpoints implementados
| Método | Ruta                | Descripción                                 | Auth |
|--------|---------------------|---------------------------------------------|------|
| POST   | /auth/login         | Valida credenciales y devuelve el JWT       | No   |
| GET    | /productos          | Catálogo (filtros `id_categoria`, `codigo`) | JWT  |
| GET    | /categorias         | Categorías de productos                     | JWT  |
| POST   | /cotizaciones       | Genera una cotización desde el carrito      | JWT  |
| GET    | /cotizaciones       | Listado resumido (historial ventas / cotizaciones) | JWT  |
| GET    | /cotizaciones/{id}  | Detalle de una cotización                   | JWT  |
| POST   | /cotizaciones/{id}/pago-envio | Registra pago simulado y envío en Firestore | JWT  |

Reglas aplicadas en `POST /cotizaciones`: RN-01 producto disponible, RN-02 cantidad ≤ existencia,
RN-03 cantidad entera > 0, RN-05 carrito no vacío, IVA 12 %, número `COT-YYYYMMDD-HHMMSS`,
vencimiento a 15 días y transacción en la base de datos.

`POST /cotizaciones/{id}/pago-envio` valida permisos de la cotización, procesa el pago con las estrategias
existentes y crea un único documento en Firestore (`envios`). Un segundo registro para la misma cotización
responde `409`.

### Contrato `GET /cotizaciones`

Requiere JWT. Sin parámetros de consulta en v1. Orden: `fecha_emision` descendente.

- **RN-10 / RN-11:** el administrador recibe todas las filas; el asesor solo las que él generó (`id_usuario` del token).
- **Venta operativa (UI):** el cliente distingue pestañas con `tienePagoEnvio` (`true` si existe documento en Firestore `envios` para esa cotización). Las filas `convertida_a_venta` del seed MySQL no aparecen como venta hasta tener ese documento.

Respuesta `200`:

```json
{
  "total": 1,
  "items": [
    {
      "id": 10,
      "numeroCotizacion": "COT-20260902-141005",
      "cliente": "Nombre del cliente",
      "total": 3584.0,
      "estadoCotizacion": "ENVIADA",
      "fechaCotizacion": "2026-09-02T14:10:05+00:00",
      "fechaVencimiento": "2026-09-17",
      "tienePagoEnvio": false,
      "pagoEnvio": null
    }
  ]
}
```

Si `tienePagoEnvio` es `true`, `pagoEnvio` incluye `estadoPago` y `estadoEnvio` (campos `estado_pago` y `estado_actual` del documento Firestore).

Errores: `401 UNAUTHORIZED`; `502 FIRESTORE_ERROR` si no se puede consultar Firestore al armar el listado.

Prueba rápida:
```bash
curl -X POST http://localhost/giganet/public/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"kquinteros@giganet.com.gt","password":"Manager1"}'
```

## Pruebas con Postman
1. Importar `test-api/coleccion_postman.json`.
2. Verificar que la variable de colección `baseUrl` valga `http://localhost/giganet/public`.
3. Ejecutar la colección completa con el Collection Runner. Las pruebas de pago-envío requieren Firestore configurado.

## Prototipo de interfaz
Abrir `http://localhost/giganet/docs/ui/prototipo/index.html` (no con doble clic). Cada pantalla muestra la
etiqueta `API: ...` del endpoint que consume. Si la API no responde, entra en modo demostración.

## Fuera de alcance de esta entrega
PDF de la cotización, cambio de estado, pagos reales, facturas y notificaciones.
=======
# Proyecto-Modulo-Ventas

# GIGANET - Módulo de Ventas de Soluciones Tecnológicas
_**Página web de ventas desarrollada con PHP, html, css y MySQL para la base de datos**_

Este repositorio contiene la documentación de análisis y diseño de arquitectura de software para el proyecto **GIGANET**, una plataforma especializada en el flujo de cotización, venta y aprovisionamiento de soluciones tecnológicas de infraestructura (UPS, servidores, equipamiento de red y accesorios de conectividad).

---

## Descripción General

**GIGANET** es una solución diseñada para modernizar y automatizar el ciclo de vida de ventas B2B y B2C de hardware empresarial. El sistema permite gestionar catálogos con configuraciones complejas, cálculo automático de compatibilidad de componentes, generación de cotizaciones en tiempo real e integración con servicios de inventario y facturación.

### Objetivos Principales
- **Automatización del flujo de ventas:** Reducción de errores en la configuración de productos de infraestructura crítica (UPS, servidores, *rack mountables*).
- **Trazabilidad:** Seguimiento preciso desde la solicitud del cliente hasta el despacho y entrega.
- **Escalabilidad e Integración:** Arquitectura orientada a servicios para facilitar la comunicación entre el core de ventas y los sistemas heredados (*Legacy*).

---

## Estructura del Repositorio

```text
proyecto/
├── informe/
│   └── informe_arquitectura.pdf
├── docs/
│   ├── legacy/
│   │   ├── arquitectura_legado.png
│   │   └── arquitectura_legado.puml
│   ├── api/
│   │   ├── openapi.yaml
│   │   ├── swagger.json
│   │   └── swagger_ui.png
│   ├── c4/
│   │   ├── c4_nivel1_contexto.png
│   │   ├── c4_nivel1_contexto.puml
│   │   ├── c4_nivel2_contenedores.png
│   │   ├── c4_nivel2_contenedores.puml
│   │   ├── c4_nivel3_componentes.png
│   │   ├── c4_nivel3_componentes.puml
│   │   └── c4_nivel4_diagramas.puml
│   ├── database/
│   │   ├── modelo_datos.png
│   │   └── schema.sql
│   └── evidence/
│       └── swagger_validacion.png
└── README.md
```

---

## 1. Informe Ejecutivo de Arquitectura

El documento consolidado de arquitectura detalla los requerimientos funcionales y no funcionales, atributos de calidad (escalabilidad, disponibilidad, seguridad) y decisiones de diseño tomadas para el módulo de ventas de **GIGANET**.

* **Documento Principal:** [Informe de Arquitectura (PDF)](./informe/informe_arquitectura.pdf)

---

## 2. Sistema Legado (As-Is)

Análisis de la arquitectura previa y sistemas monolíticos existentes sobre los cuales interactúa o migra la solución GIGANET.

* **Diagrama de Arquitectura Legada:**
  
  ![Arquitectura Legada](./docs/legacy/arquitectura_legado.png)

* **Código Fuente PlantUML:** [`docs/legacy/arquitectura_legado.puml`](./docs/legacy/arquitectura_legado.puml)

---

## 3. Modelo C4 (To-Be)

Diseño de arquitectura de software para el nuevo módulo de ventas siguiendo el estándar C4 Model en sus 4 niveles de abstracción.

### Nivel 1: Diagrama de Contexto
Muestra el módulo GIGANET en relación con los actores (clientes, ejecutivos de ventas, administradores) y sistemas externos (pasarelas de pago, ERP heredado).
* ![C4 Nivel 1 - Contexto](./docs/c4/c4_nivel1_contexto.png)
* **Fuente PlantUML:** [`docs/c4/c4_nivel1_contexto.puml`](./docs/c4/c4_nivel1_contexto.puml)

### Nivel 2: Diagrama de Contenedores
Ilustra las aplicaciones, microservicios, bases de datos y frontends que conforman el módulo GIGANET.
* ![C4 Nivel 2 - Contenedores](./docs/c4/c4_nivel2_contenedores.png)
* **Fuente PlantUML:** [`docs/c4/c4_nivel2_contenedores.puml`](./docs/c4/c4_nivel2_contenedores.puml)

### Nivel 3: Diagrama de Componentes
Desglose interno de los servicios clave (ej. *Servicio de Cotización*, *Catálogo de Hardware*, *Motor de Reglas de Ventas*).
* ![C4 Nivel 3 - Componentes](./docs/c4/c4_nivel3_componentes.png)
* **Fuente PlantUML:** [`docs/c4/c4_nivel3_componentes.puml`](./docs/c4/c4_nivel3_componentes.puml)

### Nivel 4: Código / Diagramas Detallados
Especificación de modelos de clases, secuencias y detalles de implementación.
* **Fuente PlantUML:** [`docs/c4/c4_nivel4_diagramas.puml`](./docs/c4/c4_nivel4_diagramas.puml)

---

## 4. Base de Datos y Persistencia

Modelo relacional diseñado para soportar el catálogo de productos (servidores, equipos de red, UPS con sus especificaciones de potencia/voltaje), órdenes de compra, cotizaciones y clientes.

* **Modelo Entidad-Relación:**
  
  ![Modelo de Datos](./docs/database/modelo_datos.png)

* **Script DDL SQL:** [`docs/database/schema.sql`](./docs/database/schema.sql)

---

## 5. Especificación de API

Contratos de interfaz RESTful para la integración de clientes web, móviles y sistemas de terceros con el módulo de ventas GIGANET.

* **Especificación OpenAPI v3:** [`docs/api/openapi.yaml`](./docs/api/openapi.yaml)
* **Definición Swagger JSON:** [`docs/api/swagger.json`](./docs/api/swagger.json)
* **Vista Previa de Interfaz (Swagger UI):**
  
  ![Swagger UI](./docs/api/swagger_ui.png)

---

## 6. Evidencias de Pruebas y Validación

Documentación gráfica y evidencias de ejecución exitosa de pruebas de integración y validación de endpoints.

* **Pruebas de Integración de API:**
  
  ![Validación Swagger](./docs/evidence/swagger_validacion.png)

---

## Herramientas Utilizadas

Para visualizar.

1. **Diagramas UML / C4 (`.puml`):**
2. **APIs (`.yaml` / `.json`):**
   - [Swagger Editor](https://editor.swagger.io/).
3. **Base de Datos (`.sql`):**
   - Gestor RDBMS compatible MySQL y MongoDB.
>>>>>>> c32af36d344ebce7de59ad29580502851a3069f9
