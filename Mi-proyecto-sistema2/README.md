# Giganet – Módulo de Ventas y Cotizaciones (API)

Proyecto del curso **Análisis de Sistemas II**, Universidad Mariano Gálvez de Guatemala.
Backend en **PHP 8** sin framework, arquitectura por capas, **MySQL** con PDO y autenticación **JWT**.
El usuario del sistema es el asesor de ventas de Giganet, S.A.; el administrador ve todas las cotizaciones.

**Integrantes:** Dailin Mireya Xepuxtian Hernández · Kevin Esteban Quinteros Quiñonez · Sofía Abigail Morales Pineda

## Requisitos
- PHP 8.0 o superior (extensiones `pdo_mysql`, `mbstring`)
- MySQL / MariaDB
- Apache con `mod_rewrite` (XAMPP en Windows funciona sin cambios)
- Postman para las pruebas

## Instalación (XAMPP)
1. Copiar esta carpeta a `C:\xampp\htdocs\giganet`.
2. Copiar `.env.example` a `.env` y ajustar usuario y contraseña de MySQL si es necesario.
3. Crear la base de datos importando `docs/database/schema.sql` (crea `giganet_db` con datos de prueba).
   En `cmd` (no PowerShell):
   `C:\xampp\mysql\bin\mysql.exe -u root --default-character-set=utf8mb4 < docs\database\schema.sql`
4. Iniciar Apache y MySQL desde el panel de XAMPP.
5. Verificar en el navegador: `http://localhost/giganet/public/categorias` debe responder `401` en JSON (requiere token).

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
| GET    | /cotizaciones/{id}  | Detalle de una cotización                   | JWT  |

Reglas aplicadas en `POST /cotizaciones`: RN-01 producto disponible, RN-02 cantidad ≤ existencia,
RN-03 cantidad entera > 0, RN-05 carrito no vacío, IVA 12 %, número `COT-YYYYMMDD-HHMMSS`,
vencimiento a 15 días y transacción en la base de datos.

Prueba rápida:
```bash
curl -X POST http://localhost/giganet/public/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"kquinteros@giganet.com.gt","password":"Manager1"}'
```

## Pruebas con Postman
1. Importar `test-api/coleccion_postman.json`.
2. Verificar que la variable de colección `baseUrl` valga `http://localhost/giganet/public`.
3. Ejecutar la colección completa con el Collection Runner (18 peticiones, 38 pruebas).

## Prototipo de interfaz
Abrir `http://localhost/giganet/docs/ui/prototipo/index.html` (no con doble clic). Cada pantalla muestra la
etiqueta `API: ...` del endpoint que consume. Si la API no responde, entra en modo demostración.

## Fuera de alcance de esta entrega
PDF de la cotización, historial/listado de cotizaciones, cambio de estado, pagos, facturas y notificaciones.
