# Product Backlog --- Módulo de Ventas

## 1. Objetivo

Definir y priorizar los requerimientos ágiles del módulo de Ventas para
el sistema de comercio electrónico especializado en dispositivos de red.

El módulo permitirá al cliente consultar productos, seleccionar
dispositivos, administrar su carrito, registrar los datos necesarios
para la compra, seleccionar un método de pago y confirmar el pedido.
También permitirá al administrador consultar las ventas realizadas.

## 2. Tablero ágil

**Herramienta:** GitHub Projects

**Enlace al tablero:**
`PENDIENTE: colocar aquí la URL pública del GitHub Project`

El tablero contiene las historias de usuario y permite dar seguimiento a
su estado mediante las columnas:

-   Product Backlog
-   Ready
-   In Progress
-   Done

Campos utilizados en el proyecto:

-   Prioridad
-   Story Points
-   MVP
-   Épica

------------------------------------------------------------------------

## 3. Estructura jerárquica de Épicas

### EP-01 --- Catálogo y disponibilidad

Agrupa las funcionalidades relacionadas con la consulta, búsqueda,
filtrado y visualización de los dispositivos de red disponibles.

### EP-02 --- Carrito de compras

Agrupa las funcionalidades necesarias para administrar los productos
seleccionados antes de realizar la compra.

### EP-03 --- Proceso de venta

Agrupa las funcionalidades relacionadas con el registro de los datos de
entrega y la confirmación de la compra.

### EP-04 --- Pagos

Agrupa las funcionalidades relacionadas con la selección y confirmación
del método de pago.

### EP-05 --- Gestión del pedido

Agrupa las funcionalidades relacionadas con la identificación y consulta
de los pedidos generados.

### EP-06 --- Historial y seguimiento

Agrupa las funcionalidades relacionadas con la consulta del historial de
compras del cliente y las ventas realizadas por el administrador.

------------------------------------------------------------------------

## 4. Producto Mínimo Viable (MVP)

El MVP contempla las funcionalidades indispensables para realizar una
venta de dispositivos de red de principio a fin.

### Historias incluidas en el MVP

-   US-01 --- Consultar catálogo de dispositivos
-   US-02 --- Buscar productos
-   US-04 --- Consultar detalle del producto
-   US-05 --- Agregar productos al carrito
-   US-06 --- Modificar cantidad de productos
-   US-07 --- Eliminar productos del carrito
-   US-08 --- Consultar resumen de compra
-   US-09 --- Registrar datos de entrega
-   US-10 --- Seleccionar método de pago
-   US-11 --- Confirmar compra
-   US-12 --- Generar número de pedido
-   US-15 --- Consultar ventas realizadas

### Historias fuera del MVP

-   US-03 --- Filtrar productos
-   US-13 --- Consultar estado del pedido
-   US-14 --- Consultar historial de compras

------------------------------------------------------------------------

## 5. Criterio de estimación

Las historias fueron estimadas mediante **Story Points** utilizando la
escala de Fibonacci:

**1, 2, 3, 5, 8, 13, 21**

Los Story Points representan el tamaño relativo de una historia
considerando factores como complejidad, esfuerzo, incertidumbre y
dependencias. No representan horas de trabajo.

------------------------------------------------------------------------

## 6. Marco de priorización

Se utiliza **MoSCoW**:

-   **Must Have:** funcionalidad indispensable para el producto.
-   **Should Have:** funcionalidad importante, pero el MVP puede
    funcionar sin ella.
-   **Could Have:** funcionalidad deseable, pero no esencial.
-   **Won't Have:** funcionalidad que no se contempla para esta versión.

------------------------------------------------------------------------

## 7. Product Backlog priorizado

  ------------------------------------------------------------------------------------
         Orden ID        Épica     Historia de        Story Points MoSCoW    MVP
                                   usuario                                   
  ------------ --------- --------- ------------------ ------------ --------- ---------
             1 US-11     EP-03     Como cliente,                 8 Must Have Sí
                                   quiero confirmar                          
                                   mi compra para                            
                                   generar un pedido.                        

             2 US-05     EP-02     Como cliente,                 5 Must Have Sí
                                   quiero agregar                            
                                   productos al                              
                                   carrito para                              
                                   comprarlos                                
                                   posteriormente.                           

             3 US-08     EP-02     Como cliente,                 5 Must Have Sí
                                   quiero ver el                             
                                   resumen de mi                             
                                   compra para                               
                                   verificar                                 
                                   productos,                                
                                   cantidades,                               
                                   subtotal y total                          
                                   antes de                                  
                                   confirmar.                                

             4 US-09     EP-03     Como cliente,                 5 Must Have Sí
                                   quiero registrar                          
                                   mis datos de                              
                                   entrega para                              
                                   recibir los                               
                                   productos                                 
                                   adquiridos.                               

             5 US-10     EP-04     Como cliente,                 5 Must Have Sí
                                   quiero seleccionar                        
                                   un método de pago                         
                                   para completar mi                         
                                   compra.                                   

             6 US-15     EP-06     Como                          5 Must Have Sí
                                   administrador,                            
                                   quiero consultar                          
                                   las ventas                                
                                   realizadas para                           
                                   dar seguimiento a                         
                                   las transacciones.                        

             7 US-01     EP-01     Como cliente,                 3 Must Have Sí
                                   quiero consultar                          
                                   el catálogo de                            
                                   dispositivos de                           
                                   red para conocer                          
                                   los productos                             
                                   disponibles.                              

             8 US-02     EP-01     Como cliente,                 3 Must Have Sí
                                   quiero buscar                             
                                   productos por                             
                                   nombre o código                           
                                   para encontrar                            
                                   rápidamente un                            
                                   dispositivo.                              

             9 US-04     EP-01     Como cliente,                 3 Must Have Sí
                                   quiero consultar                          
                                   el detalle de un                          
                                   producto para                             
                                   conocer sus                               
                                   características,                          
                                   precio y                                  
                                   disponibilidad.                           

            10 US-06     EP-02     Como cliente,                 3 Must Have Sí
                                   quiero modificar                          
                                   la cantidad de                            
                                   productos del                             
                                   carrito para                              
                                   ajustar mi compra.                        

            11 US-12     EP-05     Como cliente,                 3 Must Have Sí
                                   quiero recibir un                         
                                   número de pedido                          
                                   para identificar                          
                                   mi compra.                                

            12 US-07     EP-02     Como cliente,                 2 Must Have Sí
                                   quiero eliminar                           
                                   productos del                             
                                   carrito para                              
                                   corregir mi                               
                                   selección antes de                        
                                   comprar.                                  

            13 US-03     EP-01     Como cliente,                 5 Should    No
                                   quiero filtrar                  Have      
                                   productos por                             
                                   categoría, marca y                        
                                   precio para                               
                                   encontrar                                 
                                   dispositivos que                          
                                   se ajusten a mis                          
                                   necesidades.                              

            14 US-13     EP-05     Como cliente,                 5 Should    No
                                   quiero consultar                Have      
                                   el estado de mi                           
                                   pedido para                               
                                   conocer el avance                         
                                   de la entrega.                            

            15 US-14     EP-06     Como cliente,                 5 Could     No
                                   quiero consultar                Have      
                                   mi historial de                           
                                   compras para                              
                                   revisar mis                               
                                   pedidos                                   
                                   anteriores.                               
  ------------------------------------------------------------------------------------

------------------------------------------------------------------------

# 8. Detalle de historias de usuario

## US-01 --- Consultar catálogo de dispositivos

**Épica:** EP-01 · Catálogo y disponibilidad

### Historia de usuario

Como cliente, quiero consultar el catálogo de dispositivos de red para
conocer los productos disponibles.

### Descripción

El sistema permitirá al cliente visualizar los dispositivos de red
disponibles para la venta, mostrando información básica como nombre,
precio y disponibilidad.

**Estimación:** 3 Story Points

**Prioridad:** Must Have

**MVP:** Sí

### Reglas de negocio relacionadas

-   RN-01: Solo se deben mostrar productos activos para la venta.
-   RN-14: El precio mostrado debe corresponder al precio vigente del
    producto.

------------------------------------------------------------------------

## US-02 --- Buscar productos

**Épica:** EP-01 · Catálogo y disponibilidad

### Historia de usuario

Como cliente, quiero buscar productos por nombre o código para encontrar
rápidamente un dispositivo.

### Descripción

El sistema permitirá al cliente realizar búsquedas de dispositivos de
red mediante el nombre o código del producto, facilitando la
localización de artículos dentro del catálogo.

**Estimación:** 3 Story Points

**Prioridad:** Must Have

**MVP:** Sí

### Reglas de negocio relacionadas

-   RN-01: Solo se deben considerar productos activos para la venta.
-   RN-14: La información del producto debe corresponder a los datos
    vigentes registrados en el sistema.

------------------------------------------------------------------------

## US-03 --- Filtrar productos

**Épica:** EP-01 · Catálogo y disponibilidad

### Historia de usuario

Como cliente, quiero filtrar productos por categoría, marca y precio
para encontrar dispositivos que se ajusten a mis necesidades.

### Descripción

El sistema permitirá al cliente aplicar filtros al catálogo de
dispositivos de red utilizando criterios como categoría, marca y rango
de precio.

**Estimación:** 5 Story Points

**Prioridad:** Should Have

**MVP:** No

### Reglas de negocio relacionadas

-   RN-01: Solo se deben mostrar productos activos para la venta.
-   RN-14: Los precios utilizados como criterio de filtrado deben
    corresponder a los precios vigentes.

------------------------------------------------------------------------

## US-04 --- Consultar detalle del producto

**Épica:** EP-01 · Catálogo y disponibilidad

### Historia de usuario

Como cliente, quiero consultar el detalle de un producto para conocer
sus características, precio y disponibilidad.

### Descripción

El sistema permitirá al cliente seleccionar un dispositivo del catálogo
y consultar información detallada, incluyendo sus características,
precio y disponibilidad.

**Estimación:** 3 Story Points

**Prioridad:** Must Have

**MVP:** Sí

### Reglas de negocio relacionadas

-   RN-01: El producto debe estar activo para poder ser consultado para
    venta.
-   RN-02: La disponibilidad debe corresponder a las existencias
    registradas.
-   RN-14: El precio mostrado debe ser el precio vigente del producto.

------------------------------------------------------------------------

## US-05 --- Agregar productos al carrito

**Épica:** EP-02 · Carrito de compras

### Historia de usuario

Como cliente, quiero agregar productos al carrito para comprarlos
posteriormente.

### Descripción

El sistema permitirá al cliente seleccionar un dispositivo de red del
catálogo y agregarlo al carrito, indicando la cantidad deseada.

**Estimación:** 5 Story Points

**Prioridad:** Must Have

**MVP:** Sí

### Reglas de negocio relacionadas

-   RN-01: El producto debe estar activo para poder agregarse al
    carrito.
-   RN-02: La cantidad solicitada no puede superar las existencias
    disponibles.
-   RN-03: La cantidad debe ser un número entero mayor que cero.

------------------------------------------------------------------------

## US-06 --- Modificar cantidad de productos

**Épica:** EP-02 · Carrito de compras

### Historia de usuario

Como cliente, quiero modificar la cantidad de productos del carrito para
ajustar mi compra.

### Descripción

El sistema permitirá al cliente modificar la cantidad de unidades de un
producto que ya se encuentra agregado al carrito.

**Estimación:** 3 Story Points

**Prioridad:** Must Have

**MVP:** Sí

### Reglas de negocio relacionadas

-   RN-02: La cantidad solicitada no puede superar las existencias
    disponibles.
-   RN-03: La cantidad debe ser un número entero mayor que cero.

------------------------------------------------------------------------

## US-07 --- Eliminar productos del carrito

**Épica:** EP-02 · Carrito de compras

### Historia de usuario

Como cliente, quiero eliminar productos del carrito para corregir mi
selección antes de comprar.

### Descripción

El sistema permitirá al cliente eliminar uno o más productos previamente
agregados al carrito antes de confirmar la compra.

**Estimación:** 2 Story Points

**Prioridad:** Must Have

**MVP:** Sí

### Reglas de negocio relacionadas

-   RN-03: Las cantidades de productos deben manejarse como números
    enteros mayores que cero.
-   RN-05: Una venta no puede confirmarse si el carrito se encuentra
    vacío.

------------------------------------------------------------------------

## US-08 --- Consultar resumen de compra

**Épica:** EP-02 · Carrito de compras

### Historia de usuario

Como cliente, quiero ver el resumen de mi compra para verificar
productos, cantidades, subtotal y total antes de confirmar.

### Descripción

El sistema permitirá al cliente revisar los productos seleccionados, sus
cantidades, precios, subtotal y total de la compra antes de continuar
con la confirmación.

**Estimación:** 5 Story Points

**Prioridad:** Must Have

**MVP:** Sí

### Reglas de negocio relacionadas

-   RN-04: El total de la venta debe calcularse de acuerdo con el precio
    vigente y la cantidad de cada producto.
-   RN-05: No se puede confirmar una venta con el carrito vacío.
-   RN-14: El precio mostrado debe coincidir con el precio utilizado
    para calcular el total.

------------------------------------------------------------------------

## US-09 --- Registrar datos de entrega

**Épica:** EP-03 · Proceso de venta

### Historia de usuario

Como cliente, quiero registrar mis datos de entrega para recibir los
productos adquiridos.

### Descripción

El sistema permitirá al cliente ingresar y registrar la información
necesaria para realizar la entrega de los productos adquiridos.

**Estimación:** 5 Story Points

**Prioridad:** Must Have

**MVP:** Sí

### Reglas de negocio relacionadas

-   RN-06: Los datos de entrega requeridos deben validarse antes de
    confirmar el pedido.
-   RN-05: No se puede confirmar una venta si el carrito está vacío.

------------------------------------------------------------------------

## US-10 --- Seleccionar método de pago

**Épica:** EP-04 · Pagos

### Historia de usuario

Como cliente, quiero seleccionar un método de pago para completar mi
compra.

### Descripción

El sistema permitirá al cliente seleccionar uno de los métodos de pago
disponibles para realizar la compra de los dispositivos de red.

**Estimación:** 5 Story Points

**Prioridad:** Must Have

**MVP:** Sí

### Reglas de negocio relacionadas

-   RN-08: La venta solamente se considerará pagada cuando el pago haya
    sido confirmado.
-   RN-05: No se puede confirmar una venta con el carrito vacío.

------------------------------------------------------------------------

## US-11 --- Confirmar compra

**Épica:** EP-03 · Proceso de venta

### Historia de usuario

Como cliente, quiero confirmar mi compra para generar un pedido.

### Descripción

El sistema permitirá al cliente revisar la información de su compra y
confirmar la operación para generar formalmente un pedido.

**Estimación:** 8 Story Points

**Prioridad:** Must Have

**MVP:** Sí

### Reglas de negocio relacionadas

-   RN-05: No se puede confirmar una venta si el carrito está vacío.
-   RN-06: Los datos de entrega requeridos deben estar validados antes
    de confirmar el pedido.
-   RN-07: Cada venta confirmada debe generar un identificador único de
    pedido.
-   RN-09: Una vez confirmada la venta, las existencias deben
    actualizarse.

------------------------------------------------------------------------

## US-12 --- Generar número de pedido

**Épica:** EP-05 · Gestión del pedido

### Historia de usuario

Como cliente, quiero recibir un número de pedido para identificar mi
compra.

### Descripción

El sistema generará un número único para cada compra confirmada y lo
mostrará al cliente como referencia de su pedido.

**Estimación:** 3 Story Points

**Prioridad:** Must Have

**MVP:** Sí

### Reglas de negocio relacionadas

-   RN-07: Cada venta confirmada debe generar un identificador único de
    pedido.
-   RN-13: Una venta cancelada no debe contabilizarse como una venta
    completada.

------------------------------------------------------------------------

## US-13 --- Consultar estado del pedido

**Épica:** EP-05 · Gestión del pedido

### Historia de usuario

Como cliente, quiero consultar el estado de mi pedido para conocer el
avance de la entrega.

### Descripción

El sistema permitirá al cliente consultar el estado actual de sus
pedidos mediante el número o registro correspondiente.

**Estimación:** 5 Story Points

**Prioridad:** Should Have

**MVP:** No

### Reglas de negocio relacionadas

-   RN-10: El cliente únicamente puede consultar sus propios pedidos.
-   RN-12: Solo los usuarios autorizados pueden modificar el estado de
    un pedido.
-   RN-13: Los pedidos cancelados no deben considerarse como ventas
    completadas.

------------------------------------------------------------------------

## US-14 --- Consultar historial de compras

**Épica:** EP-06 · Historial y seguimiento

### Historia de usuario

Como cliente, quiero consultar mi historial de compras para revisar mis
pedidos anteriores.

### Descripción

El sistema permitirá al cliente consultar el registro de sus compras
anteriores, incluyendo información básica de cada pedido.

**Estimación:** 5 Story Points

**Prioridad:** Could Have

**MVP:** No

### Reglas de negocio relacionadas

-   RN-10: El cliente únicamente puede consultar sus propios pedidos.
-   RN-13: Las ventas canceladas no deben contabilizarse como ventas
    completadas.

------------------------------------------------------------------------

## US-15 --- Consultar ventas realizadas

**Épica:** EP-06 · Historial y seguimiento

### Historia de usuario

Como administrador, quiero consultar las ventas realizadas para dar
seguimiento a las transacciones.

### Descripción

El sistema permitirá al administrador consultar las ventas realizadas,
incluyendo información de los pedidos, clientes, productos y montos
correspondientes.

**Estimación:** 5 Story Points

**Prioridad:** Must Have

**MVP:** Sí

### Reglas de negocio relacionadas

-   RN-11: Únicamente el administrador puede consultar todas las ventas
    realizadas.
-   RN-13: Las ventas canceladas no deben contabilizarse como ventas
    completadas.
-   RN-14: Los montos registrados deben corresponder a los valores
    utilizados en la operación de venta.

------------------------------------------------------------------------

# 9. Reglas de negocio

  -----------------------------------------------------------------------
  ID                                  Regla de negocio
  ----------------------------------- -----------------------------------
  RN-01                               Un producto solo puede venderse si
                                      se encuentra activo para la venta.

  RN-02                               La cantidad solicitada no puede
                                      superar las existencias
                                      disponibles.

  RN-03                               La cantidad de productos debe ser
                                      un número entero mayor que cero.

  RN-04                               El total de la venta se calcula
                                      utilizando el precio vigente y la
                                      cantidad de cada producto.

  RN-05                               No se puede confirmar una venta si
                                      el carrito está vacío.

  RN-06                               Los datos de entrega requeridos
                                      deben validarse antes de confirmar
                                      el pedido.

  RN-07                               Cada venta confirmada debe generar
                                      un identificador único de pedido.

  RN-08                               Una venta solamente se considera
                                      pagada cuando el pago ha sido
                                      confirmado.

  RN-09                               Al confirmarse la venta, las
                                      existencias de los productos deben
                                      actualizarse.

  RN-10                               El cliente únicamente puede
                                      consultar sus propios pedidos e
                                      historial.

  RN-11                               Solo el administrador puede
                                      consultar todas las ventas
                                      realizadas.

  RN-12                               Solo los usuarios autorizados
                                      pueden modificar el estado de un
                                      pedido.

  RN-13                               Una venta cancelada no se
                                      contabiliza como venta completada.

  RN-14                               El precio mostrado al cliente debe
                                      coincidir con el precio utilizado
                                      para calcular el total.
  -----------------------------------------------------------------------

------------------------------------------------------------------------

# 10. Relación entre historias y reglas de negocio

  Historia   Reglas relacionadas
  ---------- ----------------------------
  US-01      RN-01, RN-14
  US-02      RN-01, RN-14
  US-03      RN-01, RN-14
  US-04      RN-01, RN-02, RN-14
  US-05      RN-01, RN-02, RN-03
  US-06      RN-02, RN-03
  US-07      RN-03, RN-05
  US-08      RN-04, RN-05, RN-14
  US-09      RN-05, RN-06
  US-10      RN-05, RN-08
  US-11      RN-05, RN-06, RN-07, RN-09
  US-12      RN-07, RN-13
  US-13      RN-10, RN-12, RN-13
  US-14      RN-10, RN-13
  US-15      RN-11, RN-13, RN-14

------------------------------------------------------------------------

# 11. Lecciones para el desarrollo ágil

El Product Backlog permite organizar el desarrollo del módulo de Ventas
mediante funcionalidades pequeñas y priorizadas. La utilización de
épicas facilita agrupar las historias por dominio funcional, mientras
que MoSCoW permite identificar las funcionalidades necesarias para el
MVP.

Los Story Points permiten realizar una estimación relativa de la
complejidad de las historias y facilitar la planificación del trabajo
del equipo.

Las reglas de negocio se documentan desde esta etapa para establecer las
restricciones que deberá respetar posteriormente la implementación del
sistema.

> **Nota:** Los criterios de aceptación de cada historia de usuario se
> documentarán en el Componente 2, por lo que no se incluyen en este
> Product Backlog.
