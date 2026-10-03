# language: es
@EP-04 @epica
Característica: EP-04 Pagos
  Objetivo: gestionar la información y el estado del pago.

  Historias de usuario que componen la épica:
    US-10 Seleccionar un método de pago
    US-11 Recibir la confirmación del pago

  Antecedentes:
    Dado que el cliente ha iniciado sesión
    Y tiene una compra con total 1020.00 y datos de entrega registrados

  @camino_feliz
  Escenario: El cliente paga con tarjeta y recibe la confirmación
    Cuando el cliente selecciona "Tarjeta de crédito" e ingresa datos válidos
    Y la pasarela de pago aprueba la transacción
    Entonces el estado del pago es "Pagado"
    Y el cliente recibe la confirmación con monto, fecha y referencia

  @alterno
  Escenario: Pago por transferencia queda en verificación
    Cuando el cliente selecciona "Transferencia bancaria" e informa su transferencia
    Entonces el estado del pago es "En verificación"

  @excepcion
  Escenario: Pago rechazado permite reintentar sin cobros duplicados
    Dado que la pasarela de pago rechaza la transacción
    Cuando el cliente reintenta con otro método de pago
    Entonces el sistema procesa un único cobro si el nuevo intento es aprobado
    Y el inventario se descuenta una sola vez

  @excepcion
  Escenario: Falla de la pasarela deja la compra pendiente
    Dado que la pasarela de pago no responde
    Cuando el cliente confirma el pago
    Entonces el sistema muestra un mensaje de reintento
    Y la compra permanece en "Pendiente de pago" sin cobro

  @excepcion
  Escenario: No se permite pagar una compra ya pagada
    Dado que la compra ya está en estado "Pagado"
    Cuando el cliente intenta pagarla nuevamente
    Entonces el sistema rechaza la operación y no genera un segundo cobro
