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
