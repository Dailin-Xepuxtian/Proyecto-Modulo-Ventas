# language: es
@EP-05 @US-13
Característica: US-13 Consultar el estado de un pedido
  Como cliente
  Quiero consultar el estado de mi pedido
  Para conocer el avance de la entrega

  Antecedentes:
    Dado que el cliente ha iniciado sesión
    Y existe el pedido "PED-000123" del cliente en estado "Enviado"

  @camino_feliz
  Escenario: Consultar el estado de un pedido propio
    Cuando el cliente consulta el pedido "PED-000123"
    Entonces el sistema muestra el estado "Enviado"
    Y muestra la fecha de la última actualización
    Y muestra el historial de estados del pedido

  @alterno
  Escenario Esquema del escenario: Visualizar distintos estados del pedido
    Dado que el pedido "PED-000123" se encuentra en estado "<estado>"
    Cuando el cliente consulta el pedido "PED-000123"
    Entonces el sistema muestra el estado "<estado>"

    Ejemplos:
      | estado              |
      | Recibido            |
      | En preparación      |
      | Enviado             |
      | Entregado           |
      | Cancelado           |

  @excepcion
  Escenario: Pedido no encontrado
    Cuando el cliente consulta el pedido "PED-999999"
    Entonces el sistema responde con el mensaje "El pedido solicitado no existe"

  @excepcion
  Escenario: Consultar un pedido que pertenece a otro cliente
    Dado que el pedido "PED-000456" pertenece a otro cliente
    Cuando el cliente consulta el pedido "PED-000456"
    Entonces el sistema responde con error de autorización
    Y no revela información del pedido

  @excepcion
  Escenario: Número de pedido con formato inválido
    Cuando el cliente consulta el pedido "ABC-123"
    Entonces el sistema muestra el mensaje "El número de pedido no tiene un formato válido"

  @excepcion
  Escenario: Cliente no autenticado consulta un pedido
    Dado que el cliente no ha iniciado sesión
    Cuando intenta consultar el pedido "PED-000123"
    Entonces el sistema responde con error de autenticación
    Y redirige a la pantalla de inicio de sesión
