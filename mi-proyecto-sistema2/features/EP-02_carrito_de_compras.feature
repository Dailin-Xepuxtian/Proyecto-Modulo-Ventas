# language: es
@EP-02 @epica
Característica: EP-02 Carrito de compras
  Objetivo: permitir seleccionar productos y administrar cantidades.

  Historias de usuario que componen la épica:
    US-06 Modificar la cantidad de productos del carrito
    US-07 Eliminar productos del carrito
  (El alta de productos al carrito se cubre en US-05, dentro de EP-01.)

  Antecedentes:
    Dado que existen los productos "Switch 24 puertos" con precio 450.00 y stock 10 y "Router WiFi 6" con precio 120.00 y stock 25
    Y el cliente ha agregado 2 unidades de "Switch 24 puertos" y 1 unidad de "Router WiFi 6" al carrito

  @camino_feliz
  Escenario: El cliente ajusta su carrito y el total se mantiene coherente
    Cuando el cliente cambia la cantidad de "Switch 24 puertos" a 3
    Y elimina "Router WiFi 6"
    Entonces el carrito contiene únicamente 3 unidades de "Switch 24 puertos"
    Y el total del carrito es 1350.00

  @alterno
  Escenario: Vaciar el carrito deshabilita la continuación de la compra
    Cuando el cliente elimina todos los productos del carrito
    Entonces el sistema muestra el mensaje "Su carrito está vacío"
    Y no permite avanzar al resumen de compra

  @excepcion
  Escenario: Los cambios respetan el stock en todas las operaciones del carrito
    Cuando el cliente intenta cambiar la cantidad de "Switch 24 puertos" a 11
    Entonces el sistema rechaza el cambio
    Y el carrito conserva las cantidades anteriores

  @excepcion
  Escenario: Edición de un carrito modificado desde otra sesión
    Dado que "Router WiFi 6" fue eliminado del carrito desde otro dispositivo
    Cuando el cliente intenta modificar la cantidad de "Router WiFi 6"
    Entonces el sistema muestra el mensaje "El producto no se encuentra en el carrito"
    Y actualiza la vista del carrito
