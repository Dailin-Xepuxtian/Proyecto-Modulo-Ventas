# language: es
@EP-02 @US-06
Característica: US-06 Modificar la cantidad de productos del carrito
  Como cliente
  Quiero modificar la cantidad de productos del carrito
  Para ajustar mi compra

  Antecedentes:
    Dado que existe el producto "Switch 24 puertos" con precio 450.00 y stock 10
    Y el carrito del cliente contiene 2 unidades de "Switch 24 puertos"

  @camino_feliz
  Escenario: Aumentar la cantidad de un producto
    Cuando el cliente cambia la cantidad de "Switch 24 puertos" a 4
    Entonces el carrito contiene 4 unidades de "Switch 24 puertos"
    Y el subtotal de la línea se recalcula a 1800.00
    Y el total del carrito se actualiza

  @camino_feliz
  Escenario: Disminuir la cantidad de un producto
    Cuando el cliente cambia la cantidad de "Switch 24 puertos" a 1
    Entonces el carrito contiene 1 unidad de "Switch 24 puertos"
    Y el subtotal de la línea se recalcula a 450.00

  @alterno
  Escenario: Establecer la cantidad en cero elimina el producto
    Cuando el cliente cambia la cantidad de "Switch 24 puertos" a 0
    Entonces el sistema solicita confirmar la eliminación del producto
    Y al confirmar, el producto se elimina del carrito

  @excepcion
  Escenario: Cantidad mayor al stock disponible
    Cuando el cliente cambia la cantidad de "Switch 24 puertos" a 15
    Entonces el sistema rechaza el cambio
    Y muestra el mensaje "Solo hay 10 unidades disponibles"
    Y la cantidad en el carrito permanece en 2

  @excepcion
  Escenario Esquema del escenario: Cantidad inválida
    Cuando el cliente cambia la cantidad de "Switch 24 puertos" a "<cantidad>"
    Entonces el sistema muestra el mensaje "La cantidad debe ser un número entero válido"
    Y la cantidad en el carrito permanece en 2

    Ejemplos:
      | cantidad |
      | -3       |
      | 2.5      |
      | abc      |

  @excepcion
  Escenario: Producto no existe en el carrito
    Dado que el carrito no contiene "Router WiFi 6"
    Cuando el cliente intenta modificar la cantidad de "Router WiFi 6"
    Entonces el sistema muestra el mensaje "El producto no se encuentra en el carrito"

  @excepcion
  Escenario: Producto desactivado mientras estaba en el carrito
    Dado que el producto "Switch 24 puertos" fue desactivado
    Cuando el cliente intenta modificar su cantidad
    Entonces el sistema muestra el mensaje "El producto ya no está disponible"
    Y ofrece eliminarlo del carrito
