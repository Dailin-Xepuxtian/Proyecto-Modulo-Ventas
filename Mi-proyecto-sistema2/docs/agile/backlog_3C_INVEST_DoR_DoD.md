# Product Backlog — Módulo de Ventas y cotizaciones de Giganet, S.A.

**Formato:** historias de usuario 3C (Card, Conversation, Confirmation), validación INVEST, Definition of Ready (DoR) y Definition of Done (DoD).

## 1. Objetivo

Definir y priorizar los requerimientos ágiles del módulo de Ventas para el sistema de comercio electrónico especializado en dispositivos de red.

El módulo permitirá al cliente consultar productos, seleccionar dispositivos, administrar su carrito, registrar los datos necesarios para la compra, seleccionar un método de pago y confirmar el pedido. También permitirá al administrador consultar las ventas realizadas.

## 2. Tablero ágil

**Herramienta:** GitHub Projects

**Enlace al tablero:** https://github.com/users/Dailin-Xepuxtian/projects/2

El tablero contiene las historias de usuario y permite dar seguimiento a su estado mediante las columnas:

- Product Backlog
- Ready
- In Progress
- Done

Campos utilizados en el proyecto:

- Prioridad
- Story Points
- MVP
- Épica

**Reglas de paso entre columnas:**

- Una historia pasa de **Product Backlog** a **Ready** solo si cumple la Definition of Ready (sección 11).
- Una historia pasa de **In Progress** a **Done** solo si cumple la Definition of Done (sección 12).

---

## 3. Estructura jerárquica de Épicas

### EP-01 — Catálogo y disponibilidad

Agrupa las funcionalidades relacionadas con la consulta, búsqueda, filtrado y visualización de los dispositivos de red disponibles.

### EP-02 — Carrito de compras

Agrupa las funcionalidades necesarias para administrar los productos seleccionados antes de realizar la compra.

### EP-03 — Proceso de venta

Agrupa las funcionalidades relacionadas con el registro de los datos de entrega y la confirmación de la compra.

### EP-04 — Pagos

Agrupa las funcionalidades relacionadas con la selección y confirmación del método de pago.

### EP-05 — Gestión del pedido

Agrupa las funcionalidades relacionadas con la identificación y consulta de los pedidos generados.

### EP-06 — Historial y seguimiento

Agrupa las funcionalidades relacionadas con la consulta del historial de compras del cliente y las ventas realizadas por el administrador.

---

## 4. Producto Mínimo Viable (MVP)

El MVP contempla las funcionalidades indispensables para realizar una venta de dispositivos de red de principio a fin.

### Historias incluidas en el MVP

- US-01 — Consultar catálogo de dispositivos
- US-02 — Buscar productos
- US-04 — Consultar detalle del producto
- US-05 — Agregar productos al carrito
- US-06 — Modificar cantidad de productos
- US-07 — Eliminar productos del carrito
- US-08 — Consultar resumen de compra
- US-09 — Registrar datos de entrega
- US-10 — Seleccionar método de pago
- US-11 — Confirmar compra
- US-12 — Generar número de pedido
- US-15 — Consultar ventas realizadas

### Historias fuera del MVP

- US-03 — Filtrar productos
- US-13 — Consultar estado del pedido
- US-14 — Consultar historial de compras

---

## 5. Criterio de estimación

Las historias fueron estimadas mediante **Story Points** utilizando la escala de Fibonacci: **1, 2, 3, 5, 8, 13, 21**.

Los Story Points representan el tamaño relativo de una historia considerando factores como complejidad, esfuerzo, incertidumbre y dependencias. No representan horas de trabajo.

## 6. Marco de priorización

Se utiliza **MoSCoW**:

- **Must Have:** funcionalidad indispensable para el producto.
- **Should Have:** funcionalidad importante, pero el MVP puede funcionar sin ella.
- **Could Have:** funcionalidad deseable, pero no esencial.
- **Won't Have:** funcionalidad que no se contempla para esta versión.

---

## 7. Product Backlog priorizado

| Orden | ID | Épica | Historia de usuario | SP | MoSCoW | MVP |
|---:|---|---|---|---:|---|---|
| 1 | US-11 | EP-03 | Como cliente, quiero confirmar mi compra para generar un pedido. | 8 | Must Have | Sí |
| 2 | US-05 | EP-02 | Como cliente, quiero agregar productos al carrito para comprarlos posteriormente. | 5 | Must Have | Sí |
| 3 | US-08 | EP-02 | Como cliente, quiero ver el resumen de mi compra para verificar productos, cantidades, subtotal y total antes de confirmar. | 5 | Must Have | Sí |
| 4 | US-09 | EP-03 | Como cliente, quiero registrar mis datos de entrega para recibir los productos adquiridos. | 5 | Must Have | Sí |
| 5 | US-10 | EP-04 | Como cliente, quiero seleccionar un método de pago para completar mi compra. | 5 | Must Have | Sí |
| 6 | US-15 | EP-06 | Como administrador, quiero consultar las ventas realizadas para dar seguimiento a las transacciones. | 5 | Must Have | Sí |
| 7 | US-01 | EP-01 | Como cliente, quiero consultar el catálogo de dispositivos de red para conocer los productos disponibles. | 3 | Must Have | Sí |
| 8 | US-02 | EP-01 | Como cliente, quiero buscar productos por nombre o código para encontrar rápidamente un dispositivo. | 3 | Must Have | Sí |
| 9 | US-04 | EP-01 | Como cliente, quiero consultar el detalle de un producto para conocer sus características, precio y disponibilidad. | 3 | Must Have | Sí |
| 10 | US-06 | EP-02 | Como cliente, quiero modificar la cantidad de productos del carrito para ajustar mi compra. | 3 | Must Have | Sí |
| 11 | US-12 | EP-05 | Como cliente, quiero recibir un número de pedido para identificar mi compra. | 3 | Must Have | Sí |
| 12 | US-07 | EP-02 | Como cliente, quiero eliminar productos del carrito para corregir mi selección antes de comprar. | 2 | Must Have | Sí |
| 13 | US-03 | EP-01 | Como cliente, quiero filtrar productos por categoría, marca y precio para encontrar dispositivos que se ajusten a mis necesidades. | 5 | Should Have | No |
| 14 | US-13 | EP-05 | Como cliente, quiero consultar el estado de mi pedido para conocer el avance de la entrega. | 5 | Should Have | No |
| 15 | US-14 | EP-06 | Como cliente, quiero consultar mi historial de compras para revisar mis pedidos anteriores. | 5 | Could Have | No |

---

## 8. Cómo leer las historias (3C e INVEST)

- **Card (tarjeta):** la historia en una frase: *Como [rol], quiero [necesidad], para [beneficio]*, con su estimación y prioridad.
- **Conversation (conversación):** los puntos que el Product Owner y el equipo deben aclarar antes de construir: reglas de negocio, casos límite y decisiones pendientes.
- **Confirmation (confirmación):** los criterios de aceptación verificables, redactados como *Dado que… cuando… entonces…*.
- **INVEST:** la historia debe ser **I**ndependiente, **N**egociable, **V**aliosa, **E**stimable, pequeña (**S**mall) y **T**esteable. La validación está en la sección 10.

---

# 9. Historias de usuario (3C)

## US-01 — Consultar catálogo de dispositivos

**Épica:** EP-01 · Catálogo y disponibilidad · **SP:** 3 · **Prioridad:** Must Have · **MVP:** Sí · **Reglas:** RN-01, RN-14

### Card

Como cliente, quiero consultar el catálogo de dispositivos de red para conocer los productos disponibles.

*Descripción:* el sistema permitirá al cliente visualizar los dispositivos de red disponibles para la venta, mostrando información básica como nombre, precio y disponibilidad.

### Conversation

- Datos mínimos por producto: nombre, precio y disponibilidad.
- RN-01: solo se muestran productos activos para la venta.
- RN-14: el precio mostrado es el precio vigente.
- Por definir con el PO: cómo se presenta un producto sin existencias.

### Confirmation

- Dado que existen productos activos e inactivos, cuando el cliente abre el catálogo, entonces solo se listan los productos activos.
- Dado que se muestra un producto, cuando el cliente ve su información, entonces aparecen nombre, precio y disponibilidad.
- Dado que un producto tiene un precio vigente, cuando se muestra en el catálogo, entonces el precio coincide con el registrado.

---

## US-02 — Buscar productos

**Épica:** EP-01 · Catálogo y disponibilidad · **SP:** 3 · **Prioridad:** Must Have · **MVP:** Sí · **Reglas:** RN-01, RN-14

### Card

Como cliente, quiero buscar productos por nombre o código para encontrar rápidamente un dispositivo.

*Descripción:* el sistema permitirá al cliente realizar búsquedas de dispositivos de red mediante el nombre o código del producto, facilitando la localización de artículos dentro del catálogo.

### Conversation

- La búsqueda puede admitir coincidencia parcial y no distinguir mayúsculas de minúsculas.
- RN-01: solo se consideran productos activos.
- RN-14: los datos mostrados son los vigentes.
- Por definir: mensaje cuando no hay coincidencias.

### Confirmation

- Dado que existen productos que contienen el texto buscado, cuando el cliente busca por nombre o por código, entonces se listan los productos coincidentes.
- Dado que un producto está inactivo, cuando coincide con la búsqueda, entonces no aparece en los resultados.
- Dado que no hay coincidencias, cuando el cliente busca, entonces se muestra el mensaje «Sin resultados».

---

## US-03 — Filtrar productos

**Épica:** EP-01 · Catálogo y disponibilidad · **SP:** 5 · **Prioridad:** Should Have · **MVP:** No · **Reglas:** RN-01, RN-14

### Card

Como cliente, quiero filtrar productos por categoría, marca y precio para encontrar dispositivos que se ajusten a mis necesidades.

*Descripción:* el sistema permitirá al cliente aplicar filtros al catálogo de dispositivos de red utilizando criterios como categoría, marca y rango de precio.

### Conversation

- Los filtros activos se combinan: el producto debe cumplirlos todos.
- RN-14: el rango de precio se evalúa con el precio vigente.
- Por definir: cómo se limpian los filtros y qué se muestra si ningún producto cumple.

### Confirmation

- Dado que hay filtros de categoría y marca activos, cuando el cliente los aplica, entonces no aparece ningún producto que incumpla alguno de los dos.
- Dado que se indica un rango de precio, cuando se aplica el filtro, entonces solo se muestran productos con precio vigente dentro del rango.
- Dado que ningún producto cumple los filtros, cuando se aplican, entonces se muestra un mensaje de que no hay resultados.

---

## US-04 — Consultar detalle del producto

**Épica:** EP-01 · Catálogo y disponibilidad · **SP:** 3 · **Prioridad:** Must Have · **MVP:** Sí · **Reglas:** RN-01, RN-02, RN-14

### Card

Como cliente, quiero consultar el detalle de un producto para conocer sus características, precio y disponibilidad.

*Descripción:* el sistema permitirá al cliente seleccionar un dispositivo del catálogo y consultar información detallada, incluyendo sus características, precio y disponibilidad.

### Conversation

- Qué características se muestran según el tipo de dispositivo.
- RN-02: la disponibilidad corresponde a las existencias registradas.
- RN-14: el precio mostrado es el vigente.
- Por definir: si el detalle permite agregar al carrito directamente.

### Confirmation

- Dado que el cliente selecciona un producto activo, cuando se abre el detalle, entonces se muestran características, precio y disponibilidad.
- Dado que se muestra la disponibilidad, cuando se compara con el registro de existencias, entonces coinciden.
- Dado que un producto no está activo, cuando el cliente intenta consultarlo para venta, entonces no se le permite.

---

## US-05 — Agregar productos al carrito

**Épica:** EP-02 · Carrito de compras · **SP:** 5 · **Prioridad:** Must Have · **MVP:** Sí · **Reglas:** RN-01, RN-02, RN-03

### Card

Como cliente, quiero agregar productos al carrito para comprarlos posteriormente.

*Descripción:* el sistema permitirá al cliente seleccionar un dispositivo de red del catálogo y agregarlo al carrito, indicando la cantidad deseada.

### Conversation

- RN-01: solo se agregan productos activos.
- RN-02: la cantidad no puede superar las existencias.
- RN-03: la cantidad es un entero mayor que cero.
- Por definir: qué ocurre si el producto ya está en el carrito (sumar a la cantidad existente) y qué aviso se muestra sin existencias.

### Confirmation

- Dado que el producto está activo y hay existencias, cuando el cliente lo agrega con una cantidad válida, entonces aparece en el carrito con esa cantidad.
- Dado que la cantidad supera las existencias, cuando el cliente intenta agregarlo, entonces se rechaza la acción y se muestra un aviso.
- Dado que la cantidad es cero, negativa o decimal, cuando el cliente intenta agregarlo, entonces se rechaza la acción.

---

## US-06 — Modificar cantidad de productos

**Épica:** EP-02 · Carrito de compras · **SP:** 3 · **Prioridad:** Must Have · **MVP:** Sí · **Reglas:** RN-02, RN-03

### Card

Como cliente, quiero modificar la cantidad de productos del carrito para ajustar mi compra.

*Descripción:* el sistema permitirá al cliente modificar la cantidad de unidades de un producto que ya se encuentra agregado al carrito.

### Conversation

- RN-02: la nueva cantidad no puede superar las existencias.
- RN-03: la cantidad es un entero mayor que cero.
- Decisión sugerida: una cantidad de cero no elimina el producto; para eso existe US-07.

### Confirmation

- Dado que un producto está en el carrito, cuando el cliente cambia a una cantidad válida, entonces se actualizan subtotal y total.
- Dado que la nueva cantidad supera las existencias, cuando el cliente la cambia, entonces se rechaza el cambio y se conserva la cantidad anterior.
- Dado que la cantidad no es un entero mayor que cero, cuando el cliente la cambia, entonces se rechaza el cambio.

---

## US-07 — Eliminar productos del carrito

**Épica:** EP-02 · Carrito de compras · **SP:** 2 · **Prioridad:** Must Have · **MVP:** Sí · **Reglas:** RN-03, RN-05

### Card

Como cliente, quiero eliminar productos del carrito para corregir mi selección antes de comprar.

*Descripción:* el sistema permitirá al cliente eliminar uno o más productos previamente agregados al carrito antes de confirmar la compra.

### Conversation

- Se pueden eliminar uno o varios productos.
- RN-05: si el carrito queda vacío no se puede confirmar la venta.
- Por definir: si se pide confirmación antes de eliminar.

### Confirmation

- Dado que el carrito tiene varios productos, cuando el cliente elimina uno, entonces desaparece del carrito y el total se recalcula con los restantes.
- Dado que el cliente elimina el último producto, cuando el carrito queda vacío, entonces no se permite continuar con la confirmación de la compra.

---

## US-08 — Consultar resumen de compra

**Épica:** EP-02 · Carrito de compras · **SP:** 5 · **Prioridad:** Must Have · **MVP:** Sí · **Reglas:** RN-04, RN-05, RN-14

### Card

Como cliente, quiero ver el resumen de mi compra para verificar productos, cantidades, subtotal y total antes de confirmar.

*Descripción:* el sistema permitirá al cliente revisar los productos seleccionados, sus cantidades, precios, subtotal y total de la compra antes de continuar con la confirmación.

### Conversation

- Contenido del resumen: productos, cantidades, precios, subtotal y total.
- RN-04: el total se calcula con el precio vigente y la cantidad de cada producto.
- RN-14: el precio mostrado es el mismo que se usa para calcular el total.
- Por definir: si el resumen incluye impuestos o costo de envío.

### Confirmation

- Dado que el carrito tiene productos, cuando el cliente abre el resumen, entonces el total es igual a la suma de los subtotales calculados con el precio vigente.
- Dado que se muestra un precio en el resumen, cuando se compara con el usado en el cálculo, entonces coinciden.
- Dado que el carrito está vacío, cuando el cliente intenta abrir el resumen para confirmar, entonces no se permite continuar.

---

## US-09 — Registrar datos de entrega

**Épica:** EP-03 · Proceso de venta · **SP:** 5 · **Prioridad:** Must Have · **MVP:** Sí · **Reglas:** RN-05, RN-06

### Card

Como cliente, quiero registrar mis datos de entrega para recibir los productos adquiridos.

*Descripción:* el sistema permitirá al cliente ingresar y registrar la información necesaria para realizar la entrega de los productos adquiridos.

### Conversation

- Campos requeridos: nombre del receptor, dirección y teléfono.
- RN-06: los datos requeridos se validan antes de confirmar el pedido.
- Por definir: formato válido del teléfono y si se reutilizan direcciones anteriores.

### Confirmation

- Dado que todos los campos requeridos están completos y son válidos, cuando el cliente continúa, entonces los datos de entrega se guardan.
- Dado que falta algún campo requerido, cuando el cliente continúa, entonces se muestra un error y no se avanza al pago.
- Dado que el carrito está vacío, cuando el cliente intenta registrar datos de entrega, entonces no se permite continuar.

---

## US-10 — Seleccionar método de pago

**Épica:** EP-04 · Pagos · **SP:** 5 · **Prioridad:** Must Have · **MVP:** Sí · **Reglas:** RN-05, RN-08

### Card

Como cliente, quiero seleccionar un método de pago para completar mi compra.

*Descripción:* el sistema permitirá al cliente seleccionar uno de los métodos de pago disponibles para realizar la compra de los dispositivos de red.

### Conversation

- Métodos habilitados por definir con el PO (por ejemplo: efectivo, referencia bancaria y tarjeta).
- RN-08: la venta solo se considera pagada cuando el pago se confirma.
- Por definir: qué datos adicionales solicita cada método.

### Confirmation

- Dado que el cliente llega al paso de pago, cuando abre la selección, entonces ve los métodos de pago habilitados y puede elegir uno.
- Dado que no se ha elegido un método, cuando el cliente intenta finalizar la compra, entonces no se le permite.
- Dado que se eligió un método pero el pago no está confirmado, cuando se consulta la venta, entonces no se considera pagada.

---

## US-11 — Confirmar compra

**Épica:** EP-03 · Proceso de venta · **SP:** 8 · **Prioridad:** Must Have · **MVP:** Sí · **Reglas:** RN-05, RN-06, RN-07, RN-09

### Card

Como cliente, quiero confirmar mi compra para generar un pedido.

*Descripción:* el sistema permitirá al cliente revisar la información de su compra y confirmar la operación para generar formalmente un pedido.

### Conversation

- Validaciones previas a confirmar: carrito no vacío (RN-05) y datos de entrega validados (RN-06).
- RN-07: cada venta confirmada genera un identificador único de pedido.
- RN-09: al confirmar, las existencias se actualizan; revisar qué pasa si dos clientes compran el último producto al mismo tiempo.
- Con 8 SP la historia es grande: valorar dividirla (ver sección 10).

### Confirmation

- Dado que el carrito está vacío, cuando el cliente intenta confirmar, entonces se rechaza la confirmación.
- Dado que los datos de entrega no están validados, cuando el cliente intenta confirmar, entonces se rechaza la confirmación.
- Dado que el carrito y los datos de entrega son válidos, cuando el cliente confirma, entonces se genera un pedido con un identificador único.
- Dado que la venta fue confirmada, cuando termina el proceso, entonces las existencias de los productos comprados se actualizan.

---

## US-12 — Generar número de pedido

**Épica:** EP-05 · Gestión del pedido · **SP:** 3 · **Prioridad:** Must Have · **MVP:** Sí · **Reglas:** RN-07, RN-13

### Card

Como cliente, quiero recibir un número de pedido para identificar mi compra.

*Descripción:* el sistema generará un número único para cada compra confirmada y lo mostrará al cliente como referencia de su pedido.

### Conversation

- Formato del número de pedido y cómo se garantiza que sea único.
- RN-07: el número se genera solo cuando la venta queda confirmada.
- RN-13: una venta cancelada no cuenta como venta completada.
- Aclarar el límite con US-11: US-11 crea el pedido; US-12 asigna y muestra su número.

### Confirmation

- Dado que la compra fue confirmada, cuando termina el proceso, entonces se muestra al cliente el número de pedido.
- Dado que existen varios pedidos, cuando se comparan sus números, entonces no hay dos iguales.
- Dado que una venta fue cancelada, cuando se contabilizan las ventas, entonces no se cuenta como venta completada.

---

## US-13 — Consultar estado del pedido

**Épica:** EP-05 · Gestión del pedido · **SP:** 5 · **Prioridad:** Should Have · **MVP:** No · **Reglas:** RN-10, RN-12, RN-13

### Card

Como cliente, quiero consultar el estado de mi pedido para conocer el avance de la entrega.

*Descripción:* el sistema permitirá al cliente consultar el estado actual de sus pedidos mediante el número o registro correspondiente.

### Conversation

- Estados posibles del pedido por definir (por ejemplo: recibido, pagado, en preparación, en camino, entregado, cancelado).
- RN-10: el cliente solo consulta sus propios pedidos.
- RN-12: solo usuarios autorizados modifican el estado; esa modificación no tiene historia en el backlog (ver sección 10).

### Confirmation

- Dado que el cliente tiene un pedido, cuando lo consulta con su número, entonces ve el estado actual registrado.
- Dado que el pedido pertenece a otro cliente, cuando intenta consultarlo, entonces se deniega el acceso.
- Dado que un pedido está cancelado, cuando se consulta, entonces se muestra como cancelado y no como venta completada.

---

## US-14 — Consultar historial de compras

**Épica:** EP-06 · Historial y seguimiento · **SP:** 5 · **Prioridad:** Could Have · **MVP:** No · **Reglas:** RN-10, RN-13

### Card

Como cliente, quiero consultar mi historial de compras para revisar mis pedidos anteriores.

*Descripción:* el sistema permitirá al cliente consultar el registro de sus compras anteriores, incluyendo información básica de cada pedido.

### Conversation

- Requiere que el cliente esté identificado en el sistema.
- RN-10: solo se muestran sus propios pedidos.
- Por definir: información básica de cada pedido (número, fecha, total y estado) y orden de la lista.

### Confirmation

- Dado que el cliente tiene compras anteriores, cuando abre su historial, entonces solo aparecen sus propios pedidos.
- Dado que hay varias compras, cuando se listan, entonces se ordenan de la más reciente a la más antigua.
- Dado que una venta fue cancelada, cuando aparece en el historial, entonces no se contabiliza como venta completada.

---

## US-15 — Consultar ventas realizadas

**Épica:** EP-06 · Historial y seguimiento · **SP:** 5 · **Prioridad:** Must Have · **MVP:** Sí · **Reglas:** RN-11, RN-13, RN-14

### Card

Como administrador, quiero consultar las ventas realizadas para dar seguimiento a las transacciones.

*Descripción:* el sistema permitirá al administrador consultar las ventas realizadas, incluyendo información de los pedidos, clientes, productos y montos correspondientes.

### Conversation

- RN-11: solo el administrador consulta todas las ventas.
- RN-13: las ventas canceladas no se cuentan como completadas.
- RN-14: los montos coinciden con los usados en la operación de venta.
- Por definir: si se necesita filtrar por fecha o por cliente.

### Confirmation

- Dado que existen ventas registradas, cuando el administrador abre el módulo, entonces ve los pedidos con cliente, productos y montos.
- Dado que un usuario no es administrador, cuando intenta abrir el módulo, entonces se deniega el acceso.
- Dado que una venta está cancelada, cuando se listan las ventas, entonces no se contabiliza como venta completada.
- Dado que se muestra el monto de una venta, cuando se compara con el de la operación original, entonces coincide.

---

# 10. Validación INVEST

✔ = cumple. ⚠ = cumple con una observación que conviene atender antes de construir la historia.

| Historia | I | N | V | E | S | T | Observación |
|---|:-:|:-:|:-:|:-:|:-:|:-:|---|
| US-01 | ✔ | ✔ | ✔ | ✔ | ✔ | ✔ | Sin observaciones. |
| US-02 | ✔ | ✔ | ✔ | ✔ | ✔ | ✔ | Sin observaciones. |
| US-03 | ⚠ | ✔ | ✔ | ✔ | ✔ | ✔ | Se apoya en el catálogo (US-01). |
| US-04 | ⚠ | ✔ | ✔ | ✔ | ✔ | ✔ | Se apoya en el catálogo (US-01). |
| US-05 | ⚠ | ✔ | ✔ | ✔ | ✔ | ✔ | Depende de conocer el producto y sus existencias. |
| US-06 | ⚠ | ✔ | ✔ | ✔ | ✔ | ✔ | Depende de US-05. |
| US-07 | ⚠ | ✔ | ✔ | ✔ | ✔ | ✔ | Depende de US-05. |
| US-08 | ⚠ | ✔ | ✔ | ✔ | ✔ | ✔ | Depende del carrito (US-05 a US-07). |
| US-09 | ⚠ | ✔ | ✔ | ✔ | ✔ | ✔ | Depende de que exista un carrito con productos. |
| US-10 | ⚠ | ✔ | ✔ | ✔ | ✔ | ✔ | Depende de US-09. |
| US-11 | ⚠ | ✔ | ✔ | ✔ | ⚠ | ✔ | Con 8 SP es la más grande; depende de US-08, US-09 y US-10. |
| US-12 | ⚠ | ✔ | ✔ | ✔ | ✔ | ✔ | Depende de US-11; se solapa con RN-07 de US-11. |
| US-13 | ⚠ | ✔ | ✔ | ✔ | ✔ | ✔ | Depende de US-12 y de identificar al cliente. |
| US-14 | ⚠ | ✔ | ✔ | ✔ | ✔ | ✔ | Depende de US-12 y de identificar al cliente. |
| US-15 | ⚠ | ✔ | ✔ | ✔ | ✔ | ✔ | Depende de US-11 y de identificar al administrador. |

## Observaciones sobre el backlog

- **Cadena de dependencias del MVP:** US-01 → US-05 → US-06 / US-07 → US-08 → US-09 → US-10 → US-11 → US-12. Respétala al mover historias de Product Backlog a Ready.
- **US-11 (8 SP):** conviene dividirla en historias más pequeñas, por ejemplo: validar carrito y datos de entrega antes de confirmar; crear el pedido con su identificador único; actualizar las existencias (RN-09).
- **US-11 y US-12:** ambas mencionan el identificador único del pedido (RN-07). Define que US-11 crea el pedido y US-12 solo lo asigna y lo muestra al cliente.
- **Falta de historias de autenticación:** RN-10, RN-11 y RN-12 exigen distinguir al cliente del administrador, pero el backlog no tiene historias de registro, inicio y cierre de sesión. Se recomienda agregarlas (por ejemplo, en una épica «Usuarios y autenticación»).
- **Falta una historia para modificar el estado del pedido:** RN-12 habla de usuarios autorizados que lo modifican, pero ninguna historia lo cubre. US-13 solo permite consultarlo.

---

# 11. Definition of Ready (DoR)

Una historia solo pasa a la columna **Ready** cuando cumple todo lo siguiente:

- [ ] Está redactada como Card: *Como [rol], quiero [necesidad], para [beneficio]*.
- [ ] Tiene Épica, prioridad MoSCoW y marca de MVP asignadas.
- [ ] Tiene Story Points asignados (escala de Fibonacci) y no supera 8; si supera 5, se evaluó si puede dividirse.
- [ ] Sus reglas de negocio (RN) están identificadas y las preguntas de la Conversation están resueltas o registradas como decisiones del PO.
- [ ] Tiene al menos dos criterios de Confirmation en formato *Dado / Cuando / Entonces*, medibles y verificables.
- [ ] Cumple INVEST; sus dependencias están identificadas y resueltas o planificadas.
- [ ] El equipo la entiende y acuerda que puede terminarse en una iteración.

# 12. Definition of Done (DoD)

Una historia solo pasa a la columna **Done** cuando cumple todo lo siguiente:

- [ ] Todos los criterios de Confirmation se probaron y pasan.
- [ ] Se cumplen las reglas de negocio (RN) asociadas a la historia.
- [ ] El código fue revisado por otra persona (pull request aprobado) e integrado a la rama principal sin romper lo existente.
- [ ] Se ejecutaron las pruebas necesarias y no quedan defectos críticos abiertos.
- [ ] La documentación afectada está actualizada (backlog, diseño y diagramas si cambiaron).
- [ ] El Product Owner revisó la funcionalidad en una demostración y la aceptó.
- [ ] El issue está enlazado a su pull request, cerrado y movido a Done en el tablero.

---

# 13. Reglas de negocio

| ID | Regla de negocio |
|---|---|
| RN-01 | Un producto solo puede venderse si se encuentra activo para la venta. |
| RN-02 | La cantidad solicitada no puede superar las existencias disponibles. |
| RN-03 | La cantidad de productos debe ser un número entero mayor que cero. |
| RN-04 | El total de la venta se calcula utilizando el precio vigente y la cantidad de cada producto. |
| RN-05 | No se puede confirmar una venta si el carrito está vacío. |
| RN-06 | Los datos de entrega requeridos deben validarse antes de confirmar el pedido. |
| RN-07 | Cada venta confirmada debe generar un identificador único de pedido. |
| RN-08 | Una venta solamente se considera pagada cuando el pago ha sido confirmado. |
| RN-09 | Al confirmarse la venta, las existencias de los productos deben actualizarse. |
| RN-10 | El cliente únicamente puede consultar sus propios pedidos e historial. |
| RN-11 | Solo el administrador puede consultar todas las ventas realizadas. |
| RN-12 | Solo los usuarios autorizados pueden modificar el estado de un pedido. |
| RN-13 | Una venta cancelada no se contabiliza como venta completada. |
| RN-14 | El precio mostrado al cliente debe coincidir con el precio utilizado para calcular el total. |

# 14. Relación entre historias y reglas de negocio

| Historia | Reglas relacionadas |
|---|---|
| US-01 | RN-01, RN-14 |
| US-02 | RN-01, RN-14 |
| US-03 | RN-01, RN-14 |
| US-04 | RN-01, RN-02, RN-14 |
| US-05 | RN-01, RN-02, RN-03 |
| US-06 | RN-02, RN-03 |
| US-07 | RN-03, RN-05 |
| US-08 | RN-04, RN-05, RN-14 |
| US-09 | RN-05, RN-06 |
| US-10 | RN-05, RN-08 |
| US-11 | RN-05, RN-06, RN-07, RN-09 |
| US-12 | RN-07, RN-13 |
| US-13 | RN-10, RN-12, RN-13 |
| US-14 | RN-10, RN-13 |
| US-15 | RN-11, RN-13, RN-14 |

---

# 15. Lecciones para el desarrollo ágil

El Product Backlog permite organizar el desarrollo del módulo de Ventas mediante funcionalidades pequeñas y priorizadas. La utilización de épicas facilita agrupar las historias por dominio funcional, mientras que MoSCoW permite identificar las funcionalidades necesarias para el MVP.

Los Story Points permiten realizar una estimación relativa de la complejidad de las historias y facilitar la planificación del trabajo del equipo.

Las reglas de negocio se documentan desde esta etapa para establecer las restricciones que deberá respetar posteriormente la implementación del sistema.

El formato 3C separa la historia (Card), lo que hay que aclarar (Conversation) y cómo se comprueba que está bien hecha (Confirmation). INVEST permite detectar a tiempo las historias demasiado grandes o dependientes, y el DoR y el DoD definen cuándo una historia puede empezar y cuándo está realmente terminada.
