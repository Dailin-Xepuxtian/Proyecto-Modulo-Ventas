# language: es
@EP-04 @US-10
Característica: US-10 Seleccionar un método de pago
  Como cliente
  Quiero seleccionar un método de pago
  Para completar mi compra

  Antecedentes:
    Dado que el cliente ha iniciado sesión
    Y ha registrado sus datos de entrega
    Y el sistema tiene habilitados los métodos de pago "Tarjeta de crédito", "Tarjeta de débito" y "Transferencia bancaria"

  @camino_feliz
  Escenario: Pagar con tarjeta con datos válidos
    Cuando el cliente selecciona el método "Tarjeta de crédito"
    Y ingresa un número de tarjeta válido, fecha de vencimiento vigente y CVV correcto
    Y confirma el pago
    Entonces el sistema envía la transacción a la pasarela de pago
    Y registra el método de pago seleccionado en la compra

  @alterno
  Escenario: Cambiar de método de pago antes de confirmar
    Dado que el cliente seleccionó "Tarjeta de crédito"
    Cuando el cliente cambia a "Transferencia bancaria"
    Entonces el sistema muestra las instrucciones de transferencia
    Y descarta los datos de tarjeta ingresados

  @excepcion
  Escenario: Continuar sin seleccionar un método de pago
    Cuando el cliente intenta confirmar sin elegir un método de pago
    Entonces el sistema muestra el mensaje "Seleccione un método de pago"

  @excepcion
  Escenario Esquema del escenario: Datos de tarjeta inválidos
    Cuando el cliente selecciona "Tarjeta de crédito"
    Y ingresa número "<numero>", vencimiento "<vencimiento>" y CVV "<cvv>"
    Y confirma el pago
    Entonces el sistema muestra el mensaje "<mensaje>"
    Y no procesa la transacción

    Ejemplos:
      | numero           | vencimiento | cvv  | mensaje                          |
      | 1234             | 12/30       | 123  | Número de tarjeta inválido       |
      | 4111111111111111 | 01/20       | 123  | La tarjeta se encuentra vencida  |
      | 4111111111111111 | 12/30       | 12   | CVV inválido                     |
      | abcd111122223333 | 12/30       | 123  | Número de tarjeta inválido       |

  @excepcion
  Escenario: Método de pago no habilitado
    Dado que el método "Transferencia bancaria" fue deshabilitado por el administrador
    Cuando el cliente intenta seleccionarlo
    Entonces el sistema rechaza la selección
    Y muestra el mensaje "El método de pago no está disponible"

  @excepcion
  Escenario: Pasarela de pago no disponible
    Dado que la pasarela de pago no responde
    Cuando el cliente confirma el pago con tarjeta
    Entonces el sistema muestra el mensaje "No fue posible procesar el pago, intente nuevamente"
    Y la compra permanece en estado "Pendiente de pago"
    Y no se realiza ningún cobro
