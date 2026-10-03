# language: es
@EP-05 @epica
Característica: EP-05 Gestión del pedido
  Objetivo: consultar y actualizar el estado de las órdenes.

  Historias de usuario que componen la épica:
    US-12 Recibir un número de pedido
    US-13 Consultar el estado de un pedido
    US-16 Actualizar el estado de un pedido (administrador)

  @camino_feliz
  Escenario: Del pago aprobado al pedido enviado, visible para el cliente
    Dado que el pago de una compra fue aprobado
    Cuando el sistema registra el pedido
    Entonces el cliente recibe un número de pedido único
    Cuando el administrador cambia el estado del pedido a "En preparación" y luego a "Enviado"
    Entonces el cliente ve el estado "Enviado" al consultar su pedido
    Y el historial del pedido registra cada cambio con fecha y usuario

  @alterno
  Escenario: El administrador cancela un pedido aún no enviado
    Dado que existe un pedido en estado "Recibido"
    Cuando el administrador lo cambia a "Cancelado"
    Entonces el cliente ve el estado "Cancelado"
    Y el inventario de los productos se repone

  @excepcion
  Escenario: No se genera pedido cuando el pago fue rechazado
    Dado que el pago de una compra fue rechazado
    Cuando el sistema evalúa la generación del pedido
    Entonces no se genera número de pedido

  @excepcion
  Escenario: Transición de estado inválida
    Dado que un pedido está en estado "Entregado"
    Cuando el administrador intenta cambiarlo a "En preparación"
    Entonces el sistema rechaza el cambio y mantiene el estado "Entregado"

  @excepcion
  Escenario: Un cliente no puede ver pedidos de otro cliente
    Dado que el pedido "PED-000456" pertenece a otro cliente
    Cuando el cliente intenta consultarlo
    Entonces el sistema responde con error de autorización

  @excepcion
  Escenario: Solo un administrador autenticado puede actualizar estados
    Cuando un usuario sin sesión o sin rol de administrador intenta cambiar el estado de un pedido
    Entonces el sistema responde con error de autenticación o autorización
    Y el estado del pedido no cambia
