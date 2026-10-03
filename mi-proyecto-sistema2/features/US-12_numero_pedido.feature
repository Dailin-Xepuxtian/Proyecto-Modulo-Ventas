# language: es
@EP-05 @US-12
Característica: US-12 Recibir un número de pedido
  Como cliente
  Quiero recibir un número de pedido
  Para identificar y consultar mi compra

  @camino_feliz
  Escenario: Generar número de pedido tras un pago aprobado
    Dado que el pago de la compra del cliente fue aprobado
    Cuando el sistema registra el pedido
    Entonces el sistema genera un número de pedido único
    Y el pedido queda en estado "Recibido"
    Y el sistema muestra el número de pedido al cliente
    Y envía el número de pedido por correo electrónico

  @alterno
  Escenario: Los números de pedido son únicos y consecutivos
    Dado que existen los pedidos "PED-000001" y "PED-000002"
    Cuando se registra un nuevo pedido
    Entonces el sistema le asigna el número "PED-000003"

  @alterno
  Escenario: Pago en verificación genera pedido pendiente
    Dado que el pago por transferencia está en estado "En verificación"
    Cuando el sistema registra el pedido
    Entonces el pedido queda en estado "Pendiente de pago"
    Y se asigna un número de pedido al cliente

  @excepcion
  Escenario: No se genera pedido si el pago fue rechazado
    Dado que el pago de la compra fue rechazado
    Cuando el sistema evalúa la generación del pedido
    Entonces no se genera ningún número de pedido
    Y la compra permanece sin pedido asociado

  @excepcion
  Escenario: No se duplica el pedido ante una solicitud repetida
    Dado que ya existe el pedido "PED-000010" para la compra del cliente
    Cuando se recibe nuevamente la confirmación del mismo pago
    Entonces el sistema no genera un nuevo número de pedido
    Y devuelve el pedido existente "PED-000010"

  @excepcion
  Escenario: Falla al registrar el pedido
    Dado que el pago fue aprobado
    Y el servicio de pedidos no está disponible
    Cuando el sistema intenta registrar el pedido
    Entonces el sistema reintenta el registro
    Y muestra el mensaje "Su pago fue recibido, su número de pedido será enviado en breve"
