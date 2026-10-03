# language: es
@EP-04 @US-11
Característica: US-11 Recibir la confirmación del pago
  Como cliente
  Quiero recibir la confirmación del pago
  Para saber que mi transacción fue procesada

  Antecedentes:
    Dado que el cliente tiene una compra con total 1020.00 en estado "Pendiente de pago"
    Y ha seleccionado el método de pago "Tarjeta de crédito"

  @camino_feliz
  Escenario: Pago aprobado
    Cuando la pasarela de pago aprueba la transacción
    Entonces el estado del pago cambia a "Pagado"
    Y el sistema muestra la confirmación con monto 1020.00, fecha y referencia de transacción
    Y envía un comprobante al correo del cliente
    Y descuenta del inventario los productos comprados

  @alterno
  Escenario: Pago por transferencia pendiente de verificación
    Dado que el cliente eligió "Transferencia bancaria"
    Cuando el cliente informa haber realizado la transferencia
    Entonces el estado del pago cambia a "En verificación"
    Y el sistema muestra el mensaje "Su pago está siendo verificado"

  @excepcion
  Escenario: Pago rechazado por la pasarela
    Cuando la pasarela de pago rechaza la transacción por fondos insuficientes
    Entonces el estado del pago cambia a "Rechazado"
    Y el sistema muestra el mensaje "Su pago fue rechazado"
    Y permite reintentar con el mismo u otro método de pago
    Y no descuenta el inventario

  @excepcion
  Escenario: Tiempo de espera agotado en la pasarela
    Cuando la pasarela de pago no responde en el tiempo límite
    Entonces el estado del pago cambia a "Pendiente"
    Y el sistema muestra el mensaje "No pudimos confirmar su pago, le notificaremos el resultado"
    Y el sistema consulta posteriormente el estado real de la transacción

  @excepcion
  Escenario: Intento de pagar una compra ya pagada
    Dado que la compra ya está en estado "Pagado"
    Cuando el cliente intenta pagarla nuevamente
    Entonces el sistema rechaza la operación
    Y muestra el mensaje "Esta compra ya fue pagada"
    Y no genera un segundo cobro

  @excepcion
  Escenario: Consultar confirmación de una compra inexistente
    Cuando el cliente consulta la confirmación de la compra "COMP-999999"
    Entonces el sistema responde con el mensaje "La compra solicitada no existe"

  @excepcion
  Escenario: Consultar confirmación de una compra de otro cliente
    Dado que la compra "COMP-000123" pertenece a otro cliente
    Cuando el cliente intenta consultar su confirmación
    Entonces el sistema responde con error de autorización
