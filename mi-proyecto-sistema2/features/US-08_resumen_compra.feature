# language: es
@EP-03 @US-08
Característica: US-08 Ver el resumen de la compra
  Como cliente
  Quiero ver el resumen de mi compra
  Para verificar productos, cantidades, subtotal y total antes de confirmar

  @camino_feliz
  Escenario: Visualizar el resumen de una compra con varios productos
    Dado que el carrito del cliente contiene:
      | producto          | cantidad | precio |
      | Switch 24 puertos | 2        | 450.00 |
      | Router WiFi 6     | 1        | 120.00 |
    Cuando el cliente accede al resumen de compra
    Entonces el sistema muestra cada producto con su cantidad y precio unitario
    Y muestra el subtotal por producto: 900.00 y 120.00
    Y muestra el subtotal general 1020.00
    Y muestra el total a pagar 1020.00

  @alterno
  Escenario: El resumen refleja un cambio de precio vigente
    Dado que el precio de "Router WiFi 6" cambió de 120.00 a 110.00 después de agregarse al carrito
    Cuando el cliente accede al resumen de compra
    Entonces el sistema muestra el precio actualizado 110.00
    Y notifica "Algunos precios fueron actualizados"

  @excepcion
  Escenario: Resumen con carrito vacío
    Dado que el carrito del cliente está vacío
    Cuando el cliente intenta acceder al resumen de compra
    Entonces el sistema muestra el mensaje "Su carrito está vacío"
    Y redirige al catálogo

  @excepcion
  Escenario: Producto sin stock suficiente al momento del resumen
    Dado que el carrito contiene 5 unidades de "Switch 24 puertos"
    Y el stock actual de "Switch 24 puertos" es 3
    Cuando el cliente accede al resumen de compra
    Entonces el sistema muestra el mensaje "Stock insuficiente para Switch 24 puertos, disponible: 3"
    Y no permite continuar con la confirmación hasta ajustar la cantidad

  @excepcion
  Escenario: Cliente no autenticado intenta ver el resumen
    Dado que el cliente no ha iniciado sesión
    Cuando intenta acceder al resumen de compra
    Entonces el sistema responde con error de autenticación
    Y redirige a la pantalla de inicio de sesión
