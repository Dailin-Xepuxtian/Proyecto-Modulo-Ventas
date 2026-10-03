# language: es
@EP-01 @US-01
Característica: US-01 Consultar el catálogo de dispositivos de red
  Como cliente
  Quiero consultar el catálogo de dispositivos de red
  Para conocer los productos disponibles

  Antecedentes:
    Dado que existen los siguientes productos activos en el catálogo:
      | codigo   | nombre               | categoria | marca   | precio | stock |
      | SW-24-01 | Switch 24 puertos    | Switch    | Cisco   | 450.00 | 10    |
      | RT-AX-02 | Router WiFi 6        | Router    | TP-Link | 120.00 | 25    |
      | AP-PO-03 | Access Point PoE     | AP        | Ubiquiti| 150.00 | 0     |

  @camino_feliz
  Escenario: Visualizar el catálogo con productos disponibles
    Cuando el cliente accede a la sección de catálogo
    Entonces el sistema muestra la lista de productos activos
    Y cada producto muestra nombre, marca, precio y disponibilidad
    Y los productos se presentan paginados

  @alterno
  Escenario: Producto sin existencias se muestra como agotado
    Cuando el cliente accede a la sección de catálogo
    Entonces el producto "Access Point PoE" se muestra con la etiqueta "Agotado"
    Y el botón "Agregar al carrito" de ese producto aparece deshabilitado

  @alterno
  Escenario: Navegar entre páginas del catálogo
    Dado que el catálogo contiene más productos que el tamaño de página
    Cuando el cliente selecciona la página siguiente
    Entonces el sistema muestra el siguiente conjunto de productos

  @excepcion
  Escenario: Catálogo vacío
    Dado que no existen productos activos en el catálogo
    Cuando el cliente accede a la sección de catálogo
    Entonces el sistema muestra el mensaje "No hay productos disponibles por el momento"

  @excepcion
  Escenario: Falla del servicio al cargar el catálogo
    Dado que el servicio de catálogo no está disponible
    Cuando el cliente accede a la sección de catálogo
    Entonces el sistema muestra el mensaje "No fue posible cargar el catálogo, intente nuevamente"
    Y ofrece la opción de reintentar
