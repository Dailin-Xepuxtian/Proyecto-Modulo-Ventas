# language: es
@EP-05 @US-16
Característica: US-16 Actualizar el estado de un pedido (administrador)
  Como administrador
  Quiero actualizar el estado de un pedido
  Para mantener informado al cliente sobre su compra

  Antecedentes:
    Dado que el administrador ha iniciado sesión
    Y existe el pedido "PED-000123" en estado "Recibido"

  @camino_feliz
  Escenario: Actualizar el pedido al siguiente estado válido
    Cuando el administrador cambia el estado del pedido "PED-000123" a "En preparación"
    Entonces el sistema guarda el nuevo estado "En preparación"
    Y registra la fecha, hora y usuario que realizó el cambio
    Y el cliente puede ver el estado actualizado en su consulta de pedido

  @alterno
  Escenario: Notificar al cliente cuando el pedido es enviado
    Dado que el pedido "PED-000123" está en estado "En preparación"
    Cuando el administrador cambia el estado a "Enviado"
    Entonces el sistema envía una notificación por correo al cliente
    Y el historial del pedido incluye el cambio de estado

  @alterno
  Escenario: Cancelar un pedido aún no enviado
    Cuando el administrador cambia el estado del pedido "PED-000123" a "Cancelado"
    Entonces el sistema guarda el estado "Cancelado"
    Y repone el inventario de los productos del pedido

  @excepcion
  Escenario Esquema del escenario: Transición de estado no permitida
    Dado que el pedido "PED-000123" se encuentra en estado "<actual>"
    Cuando el administrador intenta cambiar el estado a "<nuevo>"
    Entonces el sistema rechaza el cambio
    Y muestra el mensaje "Transición de estado no permitida de <actual> a <nuevo>"
    Y el estado del pedido permanece en "<actual>"

    Ejemplos:
      | actual    | nuevo          |
      | Recibido  | Entregado      |
      | Entregado | En preparación |
      | Cancelado | Enviado        |
      | Enviado   | Cancelado      |

  @excepcion
  Escenario: Estado inexistente
    Cuando el administrador intenta cambiar el estado del pedido "PED-000123" a "Perdido en el espacio"
    Entonces el sistema muestra el mensaje "El estado indicado no es válido"
    Y el estado del pedido no cambia

  @excepcion
  Escenario: Pedido no encontrado
    Cuando el administrador intenta actualizar el estado del pedido "PED-999999"
    Entonces el sistema responde con el mensaje "El pedido solicitado no existe"

  @excepcion
  Escenario: Pedido con pago no confirmado
    Dado que el pedido "PED-000123" tiene el pago en estado "Rechazado"
    Cuando el administrador intenta cambiar el estado a "En preparación"
    Entonces el sistema rechaza el cambio
    Y muestra el mensaje "El pedido no tiene un pago confirmado"

  @excepcion
  Escenario: Usuario sin rol de administrador intenta actualizar el estado
    Dado que un cliente ha iniciado sesión sin rol de administrador
    Cuando intenta cambiar el estado del pedido "PED-000123"
    Entonces el sistema responde con error de autorización
    Y el estado del pedido no cambia

  @excepcion
  Escenario: Usuario no autenticado intenta actualizar el estado
    Dado que el usuario no ha iniciado sesión
    Cuando intenta cambiar el estado del pedido "PED-000123"
    Entonces el sistema responde con error de autenticación

  @excepcion
  Escenario: Conflicto por actualización simultánea
    Dado que otro administrador cambió el pedido "PED-000123" a "En preparación" hace un instante
    Cuando el administrador intenta cambiarlo a "Enviado" con datos desactualizados
    Entonces el sistema rechaza el cambio por conflicto de versión
    Y solicita recargar el pedido antes de intentarlo nuevamente
