# language: es
@EP-01 @epica
Característica: EP-01 Catálogo y disponibilidad
  Objetivo: permitir consultar dispositivos de red disponibles para la venta.

  Historias de usuario que componen la épica:
    US-01 Consultar el catálogo de dispositivos de red
    US-02 Buscar productos por nombre o código
    US-03 Filtrar productos por categoría, marca y precio
    US-04 Consultar el detalle de un producto
    US-05 Agregar productos al carrito

  Antecedentes:
    Dado que existen los siguientes productos activos en el catálogo:
      | codigo   | nombre            | categoria | marca   | precio | stock |
      | SW-24-01 | Switch 24 puertos | Switch    | Cisco   | 450.00 | 10    |
      | RT-AX-02 | Router WiFi 6     | Router    | TP-Link | 120.00 | 25    |
      | AP-PO-03 | Access Point PoE  | AP        | Ubiquiti| 150.00 | 0     |

  @camino_feliz
  Escenario: El cliente encuentra un producto disponible y lo agrega al carrito
    Cuando el cliente accede al catálogo
    Y filtra por la categoría "Switch"
    Y busca "SW-24-01"
    Y consulta el detalle de "Switch 24 puertos"
    Y agrega 1 unidad al carrito
    Entonces el carrito contiene 1 unidad de "Switch 24 puertos"
    Y la disponibilidad mostrada coincide con el stock real del producto

  @alterno
  Escenario: La disponibilidad es consistente en todo el recorrido
    Cuando el cliente ve "Access Point PoE" en el listado, en la búsqueda y en el detalle
    Entonces en los tres lugares se muestra como "Agotado"
    Y en ninguno se permite agregarlo al carrito

  @excepcion
  Escenario: Ningún producto cumple la búsqueda y los filtros combinados
    Cuando el cliente busca "Firewall" con la categoría "Router"
    Entonces el sistema muestra un mensaje de "sin resultados"
    Y permite limpiar los filtros para volver al catálogo completo

  @excepcion
  Escenario: Un producto deja de existir durante la navegación
    Dado que el cliente tiene abierto el detalle de "Switch 24 puertos"
    Y el administrador desactiva ese producto
    Cuando el cliente intenta agregarlo al carrito
    Entonces el sistema rechaza la operación
    Y muestra el mensaje "El producto ya no está disponible"
