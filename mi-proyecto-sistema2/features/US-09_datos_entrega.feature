# language: es
@EP-03 @US-09
Característica: US-09 Registrar datos de entrega
  Como cliente
  Quiero registrar mis datos de entrega
  Para recibir los productos adquiridos

  Antecedentes:
    Dado que el cliente ha iniciado sesión
    Y tiene productos en el carrito
    Y se encuentra en el paso "Datos de entrega"

  @camino_feliz
  Escenario: Registrar datos de entrega válidos
    Cuando el cliente ingresa los siguientes datos:
      | campo           | valor                         |
      | nombre completo | Ana López                     |
      | teléfono        | 55123456                      |
      | dirección       | 5a Avenida 10-20, zona 1      |
      | ciudad          | Guatemala                     |
      | referencia      | Edificio azul, segundo nivel  |
    Y confirma los datos
    Entonces el sistema guarda los datos de entrega asociados a la compra
    Y permite continuar al paso de selección de pago

  @alterno
  Escenario: Usar una dirección guardada previamente
    Dado que el cliente tiene una dirección guardada "Casa"
    Cuando el cliente selecciona la dirección "Casa"
    Entonces el sistema precarga los datos de entrega
    Y permite continuar al paso de selección de pago

  @excepcion
  Escenario Esquema del escenario: Campo obligatorio vacío
    Cuando el cliente deja vacío el campo "<campo>"
    Y intenta confirmar los datos
    Entonces el sistema muestra el mensaje "<mensaje>"
    Y no permite continuar

    Ejemplos:
      | campo           | mensaje                            |
      | nombre completo | El nombre completo es obligatorio  |
      | teléfono        | El teléfono es obligatorio         |
      | dirección       | La dirección es obligatoria        |
      | ciudad          | La ciudad es obligatoria           |

  @excepcion
  Escenario Esquema del escenario: Teléfono con formato inválido
    Cuando el cliente ingresa "<telefono>" como teléfono
    Y intenta confirmar los datos
    Entonces el sistema muestra el mensaje "El teléfono ingresado no es válido"

    Ejemplos:
      | telefono     |
      | abc12345     |
      | 123          |
      | 5512-34-56-7 |

  @excepcion
  Escenario: Dirección fuera de la zona de cobertura
    Cuando el cliente ingresa una ciudad fuera de la zona de cobertura de entrega
    Y intenta confirmar los datos
    Entonces el sistema muestra el mensaje "No realizamos entregas en la ciudad indicada"

  @excepcion
  Escenario: Sesión expirada al registrar los datos
    Dado que la sesión del cliente ha expirado
    Cuando intenta confirmar los datos de entrega
    Entonces el sistema responde con error de autenticación
    Y solicita iniciar sesión nuevamente
