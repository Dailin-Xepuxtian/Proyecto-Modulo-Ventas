# language: es
@EP-06 @epica
Característica: EP-06 Historial y seguimiento
  Objetivo: permitir al cliente consultar sus compras anteriores y su estado.

  Historias de usuario que componen la épica:
    US-14 Consultar el historial de compras
  (El seguimiento del estado de un pedido individual se cubre en US-13, dentro de EP-05.)

  Antecedentes:
    Dado que el cliente ha iniciado sesión

  @camino_feliz
  Escenario: El cliente revisa sus compras anteriores y da seguimiento a una de ellas
    Dado que el cliente tiene los pedidos "PED-000101" en estado "Entregado" y "PED-000115" en estado "Enviado"
    Cuando el cliente accede a su historial de compras
    Y selecciona el pedido "PED-000115"
    Entonces el sistema muestra el detalle del pedido y su estado "Enviado"
    Y el historial está ordenado del más reciente al más antiguo

  @alterno
  Escenario: El estado en el historial refleja las actualizaciones del administrador
    Dado que el administrador cambia el pedido "PED-000115" a "Entregado"
    Cuando el cliente accede a su historial de compras
    Entonces el pedido "PED-000115" aparece con el estado "Entregado"

  @excepcion
  Escenario: Cliente sin compras
    Dado que el cliente no tiene pedidos registrados
    Cuando accede a su historial de compras
    Entonces el sistema muestra el mensaje "Aún no has realizado compras"

  @excepcion
  Escenario: Acceso sin sesión al historial
    Dado que el cliente no ha iniciado sesión
    Cuando intenta acceder al historial de compras
    Entonces el sistema responde con error de autenticación

  @excepcion
  Escenario: El historial nunca expone pedidos de otros clientes
    Dado que existen pedidos de otros clientes en el sistema
    Cuando el cliente accede a su historial de compras
    Entonces el sistema muestra únicamente sus propios pedidos
