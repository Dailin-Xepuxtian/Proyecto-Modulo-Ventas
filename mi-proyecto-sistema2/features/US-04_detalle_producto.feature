# language: es
@EP-01 @US-04
Característica: US-04 Consultar el detalle de un producto
  Como cliente
  Quiero consultar el detalle de un producto
  Para conocer sus características, precio y disponibilidad

  Antecedentes:
    Dado que existe el producto "Switch 24 puertos" con código "SW-24-01", marca "Cisco", precio 450.00 y stock 10

  @camino_feliz
  Escenario: Ver el detalle de un producto disponible
    Cuando el cliente selecciona el producto "Switch 24 puertos"
    Entonces el sistema muestra nombre, código, marca, categoría y descripción
    Y muestra las especificaciones técnicas del producto
    Y muestra el precio "450.00"
    Y muestra la disponibilidad "En stock"

  @alterno
  Escenario: Ver el detalle de un producto agotado
    Dado que el producto "Switch 24 puertos" tiene stock 0
    Cuando el cliente selecciona el producto "Switch 24 puertos"
    Entonces el sistema muestra la disponibilidad "Agotado"
    Y el botón "Agregar al carrito" aparece deshabilitado

  @excepcion
  Escenario: Producto no encontrado
    Cuando el cliente intenta acceder al detalle del producto con código "XX-000"
    Entonces el sistema responde con el mensaje "El producto solicitado no existe"
    Y ofrece volver al catálogo

  @excepcion
  Escenario: Producto desactivado
    Dado que el producto "Switch 24 puertos" fue desactivado por el administrador
    Cuando el cliente intenta acceder a su detalle
    Entonces el sistema responde con el mensaje "El producto ya no está disponible"
