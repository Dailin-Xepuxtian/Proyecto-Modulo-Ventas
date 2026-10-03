# language: es
@EP-01 @US-03
Característica: US-03 Filtrar productos por categoría, marca y precio
  Como cliente
  Quiero filtrar productos por categoría, marca y precio
  Para encontrar dispositivos que se ajusten a mis necesidades

  Antecedentes:
    Dado que existen los siguientes productos activos en el catálogo:
      | nombre            | categoria | marca    | precio |
      | Switch 24 puertos | Switch    | Cisco    | 450.00 |
      | Switch 8 puertos  | Switch    | TP-Link  | 60.00  |
      | Router WiFi 6     | Router    | TP-Link  | 120.00 |
      | Access Point PoE  | AP        | Ubiquiti | 150.00 |

  @camino_feliz
  Escenario: Filtrar por categoría
    Cuando el cliente selecciona la categoría "Switch"
    Entonces el sistema muestra "Switch 24 puertos" y "Switch 8 puertos"

  @camino_feliz
  Escenario: Filtrar por marca
    Cuando el cliente selecciona la marca "TP-Link"
    Entonces el sistema muestra "Switch 8 puertos" y "Router WiFi 6"

  @camino_feliz
  Escenario: Filtrar por rango de precio
    Cuando el cliente establece el precio mínimo en 100 y el máximo en 200
    Entonces el sistema muestra "Router WiFi 6" y "Access Point PoE"

  @alterno
  Escenario: Combinar varios filtros
    Cuando el cliente selecciona la categoría "Switch"
    Y selecciona la marca "TP-Link"
    Y establece el precio máximo en 100
    Entonces el sistema muestra únicamente "Switch 8 puertos"

  @alterno
  Escenario: Limpiar los filtros aplicados
    Dado que el cliente tiene aplicados los filtros categoría "Switch" y marca "Cisco"
    Cuando el cliente selecciona "Limpiar filtros"
    Entonces el sistema muestra el catálogo completo

  @excepcion
  Escenario: Filtros sin resultados
    Cuando el cliente selecciona la categoría "Router" y la marca "Cisco"
    Entonces el sistema muestra el mensaje "No hay productos que coincidan con los filtros seleccionados"

  @excepcion
  Escenario: Rango de precio inválido (mínimo mayor que máximo)
    Cuando el cliente establece el precio mínimo en 500 y el máximo en 100
    Entonces el sistema muestra el mensaje "El precio mínimo no puede ser mayor al máximo"
    Y no aplica el filtro de precio

  @excepcion
  Escenario Esquema del escenario: Valores de precio no válidos
    Cuando el cliente ingresa "<minimo>" como precio mínimo y "<maximo>" como precio máximo
    Entonces el sistema muestra el mensaje "Ingrese valores de precio numéricos y positivos"

    Ejemplos:
      | minimo | maximo |
      | abc    | 100    |
      | -50    | 100    |
      | 10     | xyz    |
