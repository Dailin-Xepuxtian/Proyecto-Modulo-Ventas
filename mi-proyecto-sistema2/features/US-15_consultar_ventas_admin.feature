# language: es
@EP-03 @US-15
Característica: US-15 Consultar las ventas realizadas (administrador)
  Como administrador
  Quiero consultar las ventas realizadas
  Para dar seguimiento a las transacciones

  Antecedentes:
    Dado que existen las siguientes ventas registradas:
      | venta    | cliente   | fecha      | total   | estado_pago |
      | V-000001 | Ana López | 2026-09-10 | 450.00  | Pagado      |
      | V-000002 | Luis Paz  | 2026-09-20 | 1020.00 | Pagado      |
      | V-000003 | Mara Gil  | 2026-09-25 | 120.00  | Rechazado   |

  @camino_feliz
  Escenario: Administrador consulta el listado de ventas
    Dado que el administrador ha iniciado sesión
    Cuando accede al módulo de ventas
    Entonces el sistema muestra las ventas con número, cliente, fecha, total y estado de pago
    Y las ventas se ordenan de la más reciente a la más antigua

  @alterno
  Escenario: Filtrar ventas por rango de fechas
    Dado que el administrador ha iniciado sesión
    Cuando filtra las ventas del "2026-09-15" al "2026-09-30"
    Entonces el sistema muestra las ventas "V-000002" y "V-000003"
    Y no muestra la venta "V-000001"

  @alterno
  Escenario: Filtrar ventas por estado de pago
    Dado que el administrador ha iniciado sesión
    Cuando filtra las ventas por el estado de pago "Pagado"
    Entonces el sistema muestra las ventas "V-000001" y "V-000002"

  @alterno
  Escenario: Consultar el detalle de una venta
    Dado que el administrador ha iniciado sesión
    Cuando selecciona la venta "V-000002"
    Entonces el sistema muestra los productos, cantidades, datos de entrega y método de pago de la venta

  @excepcion
  Escenario: Consulta sin ventas en el período
    Dado que el administrador ha iniciado sesión
    Cuando filtra las ventas del "2020-01-01" al "2020-01-31"
    Entonces el sistema muestra el mensaje "No se encontraron ventas en el período seleccionado"

  @excepcion
  Escenario: Rango de fechas inválido
    Dado que el administrador ha iniciado sesión
    Cuando filtra las ventas con fecha inicial "2026-09-30" y fecha final "2026-09-01"
    Entonces el sistema muestra el mensaje "La fecha inicial no puede ser posterior a la fecha final"

  @excepcion
  Escenario: Venta no encontrada
    Dado que el administrador ha iniciado sesión
    Cuando consulta la venta "V-999999"
    Entonces el sistema responde con el mensaje "La venta solicitada no existe"

  @excepcion
  Escenario: Usuario sin rol de administrador intenta consultar ventas
    Dado que un cliente ha iniciado sesión sin rol de administrador
    Cuando intenta acceder al módulo de ventas
    Entonces el sistema responde con error de autorización
    Y no muestra información de las ventas

  @excepcion
  Escenario: Usuario no autenticado intenta consultar ventas
    Dado que el usuario no ha iniciado sesión
    Cuando intenta acceder al módulo de ventas
    Entonces el sistema responde con error de autenticación
