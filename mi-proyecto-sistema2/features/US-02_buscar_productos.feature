# language: es
@EP-01 @US-02
Característica: US-02 Buscar productos por nombre o código
  Como cliente
  Quiero buscar productos por nombre o código
  Para encontrar rápidamente un dispositivo

  Antecedentes:
    Dado que existen los siguientes productos activos en el catálogo:
      | codigo   | nombre            |
      | SW-24-01 | Switch 24 puertos |
      | SW-48-02 | Switch 48 puertos |
      | RT-AX-03 | Router WiFi 6     |

  @camino_feliz
  Escenario: Buscar un producto por nombre
    Cuando el cliente busca "Switch"
    Entonces el sistema muestra los productos "Switch 24 puertos" y "Switch 48 puertos"
    Y no muestra el producto "Router WiFi 6"

  @camino_feliz
  Escenario: Buscar un producto por código exacto
    Cuando el cliente busca "RT-AX-03"
    Entonces el sistema muestra únicamente el producto "Router WiFi 6"

  @alterno
  Escenario: La búsqueda no distingue mayúsculas de minúsculas
    Cuando el cliente busca "switch 24"
    Entonces el sistema muestra el producto "Switch 24 puertos"

  @excepcion
  Escenario: Búsqueda sin resultados
    Cuando el cliente busca "Firewall inexistente"
    Entonces el sistema muestra el mensaje "No se encontraron productos para su búsqueda"
    Y sugiere revisar el texto ingresado o explorar el catálogo completo

  @excepcion
  Escenario: Búsqueda con texto vacío
    Cuando el cliente ejecuta la búsqueda sin ingresar texto
    Entonces el sistema muestra el catálogo completo
    O solicita ingresar un término de búsqueda

  @excepcion
  Escenario: Búsqueda con caracteres inválidos
    Cuando el cliente busca "<script>alert(1)</script>"
    Entonces el sistema sanitiza el texto ingresado
    Y muestra el mensaje "No se encontraron productos para su búsqueda"
