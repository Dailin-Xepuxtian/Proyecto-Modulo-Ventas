# language: es
@EP-06 @US-14
Característica: US-14 Consultar el historial de compras
  Como cliente
  Quiero consultar mi historial de compras
  Para revisar mis pedidos anteriores

  Antecedentes:
    Dado que el cliente ha iniciado sesión

  @camino_feliz
  Escenario: Ver el historial con pedidos anteriores
    Dado que el cliente tiene los siguientes pedidos:
      | pedido     | fecha      | total   | estado    |
      | PED-000101 | 2026-08-10 | 450.00  | Entregado |
      | PED-000115 | 2026-09-15 | 1020.00 | Enviado   |
    Cuando el cliente accede a su historial de compras
    Entonces el sistema muestra los pedidos "PED-000115" y "PED-000101"
    Y cada pedido muestra fecha, total y estado
    Y los pedidos se ordenan del más reciente al más antiguo

  @alterno
  Escenario: Ver el detalle de un pedido desde el historial
    Dado que el cliente tiene el pedido "PED-000101" en su historial
    Cuando el cliente selecciona el pedido "PED-000101"
    Entonces el sistema muestra los productos, cantidades y totales de ese pedido

  @alterno
  Escenario: Filtrar el historial por estado
    Dado que el cliente tiene pedidos "Entregado" y "Enviado"
    Cuando el cliente filtra el historial por el estado "Entregado"
    Entonces el sistema muestra únicamente los pedidos en estado "Entregado"

  @alterno
  Escenario: El historial solo muestra pedidos del cliente autenticado
    Dado que existen pedidos de otros clientes en el sistema
    Cuando el cliente accede a su historial de compras
    Entonces el sistema muestra únicamente los pedidos del cliente autenticado

  @excepcion
  Escenario: Cliente sin compras previas
    Dado que el cliente no tiene pedidos registrados
    Cuando el cliente accede a su historial de compras
    Entonces el sistema muestra el mensaje "Aún no has realizado compras"
    Y ofrece un enlace al catálogo

  @excepcion
  Escenario: Cliente no autenticado
    Dado que el cliente no ha iniciado sesión
    Cuando intenta acceder al historial de compras
    Entonces el sistema responde con error de autenticación
    Y redirige a la pantalla de inicio de sesión

  @excepcion
  Escenario: Falla del servicio al cargar el historial
    Dado que el servicio de pedidos no está disponible
    Cuando el cliente accede a su historial de compras
    Entonces el sistema muestra el mensaje "No fue posible cargar su historial, intente nuevamente"
