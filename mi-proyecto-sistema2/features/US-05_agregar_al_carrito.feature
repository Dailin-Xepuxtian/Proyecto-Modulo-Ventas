# language: es
@EP-01 @US-05
Característica: US-05 Agregar productos al carrito
  Como cliente
  Quiero agregar productos al carrito
  Para comprarlos posteriormente

  Antecedentes:
    Dado que existe el producto "Switch 24 puertos" con precio 450.00 y stock 10
    Y el cliente tiene un carrito vacío

  @camino_feliz
  Escenario: Agregar un producto disponible al carrito
    Cuando el cliente agrega 2 unidades de "Switch 24 puertos" al carrito
    Entonces el carrito contiene 2 unidades de "Switch 24 puertos"
    Y el sistema muestra el mensaje "Producto agregado al carrito"
    Y el contador del carrito se actualiza a 2

  @alterno
  Escenario: Agregar un producto que ya está en el carrito acumula la cantidad
    Dado que el carrito contiene 2 unidades de "Switch 24 puertos"
    Cuando el cliente agrega 3 unidades de "Switch 24 puertos" al carrito
    Entonces el carrito contiene 5 unidades de "Switch 24 puertos"

  @excepcion
  Escenario: Agregar un producto agotado
    Dado que el producto "Switch 24 puertos" tiene stock 0
    Cuando el cliente intenta agregarlo al carrito
    Entonces el sistema rechaza la operación
    Y muestra el mensaje "El producto no tiene existencias"

  @excepcion
  Escenario: Cantidad solicitada mayor al stock disponible
    Cuando el cliente intenta agregar 11 unidades de "Switch 24 puertos"
    Entonces el sistema rechaza la operación
    Y muestra el mensaje "Solo hay 10 unidades disponibles"
    Y el carrito permanece sin cambios

  @excepcion
  Escenario: Acumulado en el carrito supera el stock
    Dado que el carrito contiene 8 unidades de "Switch 24 puertos"
    Cuando el cliente intenta agregar 3 unidades más
    Entonces el sistema rechaza la operación
    Y muestra el mensaje "Solo hay 10 unidades disponibles"

  @excepcion
  Escenario Esquema del escenario: Cantidad inválida
    Cuando el cliente intenta agregar "<cantidad>" unidades de "Switch 24 puertos"
    Entonces el sistema muestra el mensaje "La cantidad debe ser un número entero mayor a cero"
    Y el carrito permanece sin cambios

    Ejemplos:
      | cantidad |
      | 0        |
      | -1       |
      | 1.5      |
      | abc      |

  @excepcion
  Escenario: Producto inexistente al agregar
    Dado que el producto fue eliminado del catálogo después de ser mostrado
    Cuando el cliente intenta agregarlo al carrito
    Entonces el sistema muestra el mensaje "El producto solicitado no existe"
