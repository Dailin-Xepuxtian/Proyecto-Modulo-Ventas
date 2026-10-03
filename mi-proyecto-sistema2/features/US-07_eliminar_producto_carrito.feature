# language: es
@EP-02 @US-07
Característica: US-07 Eliminar productos del carrito
  Como cliente
  Quiero eliminar productos del carrito
  Para corregir mi selección antes de comprar

  Antecedentes:
    Dado que el carrito del cliente contiene:
      | producto          | cantidad | precio |
      | Switch 24 puertos | 2        | 450.00 |
      | Router WiFi 6     | 1        | 120.00 |

  @camino_feliz
  Escenario: Eliminar un producto del carrito
    Cuando el cliente elimina "Router WiFi 6" del carrito
    Entonces el carrito ya no contiene "Router WiFi 6"
    Y el carrito conserva "Switch 24 puertos"
    Y el total del carrito se recalcula a 900.00

  @alterno
  Escenario: Eliminar el último producto deja el carrito vacío
    Dado que el cliente elimina "Router WiFi 6" del carrito
    Cuando el cliente elimina "Switch 24 puertos" del carrito
    Entonces el sistema muestra el mensaje "Su carrito está vacío"
    Y el total del carrito es 0.00
    Y la opción de continuar con la compra aparece deshabilitada

  @alterno
  Escenario: Cancelar la eliminación
    Cuando el cliente selecciona eliminar "Router WiFi 6"
    Y cancela la confirmación
    Entonces el carrito conserva "Router WiFi 6"

  @excepcion
  Escenario: Eliminar un producto que no está en el carrito
    Cuando el cliente intenta eliminar "Firewall Pro" del carrito
    Entonces el sistema muestra el mensaje "El producto no se encuentra en el carrito"
    Y el carrito permanece sin cambios

  @excepcion
  Escenario: Eliminar un producto ya eliminado desde otra sesión
    Dado que "Router WiFi 6" fue eliminado del carrito desde otro dispositivo
    Cuando el cliente intenta eliminar "Router WiFi 6"
    Entonces el sistema muestra el mensaje "El producto no se encuentra en el carrito"
    Y actualiza la vista del carrito
