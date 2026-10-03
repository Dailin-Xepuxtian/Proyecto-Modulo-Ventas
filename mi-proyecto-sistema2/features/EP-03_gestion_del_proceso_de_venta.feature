# language: es
@EP-03 @epica
Característica: EP-03 Gestión del proceso de venta
  Objetivo: registrar y confirmar una venta.

  Historias de usuario que componen la épica:
    US-08 Ver el resumen de la compra
    US-09 Registrar datos de entrega
    US-15 Consultar las ventas realizadas (administrador)

  Antecedentes:
    Dado que el cliente ha iniciado sesión
    Y su carrito contiene 2 unidades de "Switch 24 puertos" con precio 450.00

  @camino_feliz
  Escenario: El cliente revisa el resumen, registra la entrega y la venta queda registrada
    Cuando el cliente accede al resumen de compra
    Y verifica que el total a pagar es 900.00
    Y registra datos de entrega válidos
    Y completa el pago
    Entonces la venta queda registrada con sus productos, total y datos de entrega
    Y el administrador puede consultarla en el módulo de ventas

  @alterno
  Escenario: El administrador filtra las ventas del período
    Dado que existen ventas registradas en distintas fechas
    Cuando el administrador filtra por un rango de fechas válido
    Entonces el sistema muestra solo las ventas de ese rango

  @excepcion
  Escenario: No se puede avanzar con un carrito vacío o sin stock suficiente
    Dado que el stock de "Switch 24 puertos" es menor a la cantidad del carrito
    Cuando el cliente accede al resumen de compra
    Entonces el sistema indica el stock disponible
    Y no permite registrar la venta hasta ajustar la cantidad

  @excepcion
  Escenario: No se registra la venta sin datos de entrega válidos
    Cuando el cliente intenta continuar sin completar los datos de entrega obligatorios
    Entonces el sistema muestra los mensajes de validación correspondientes
    Y la venta no se registra

  @excepcion
  Escenario: Acceso no autorizado al módulo de ventas
    Dado que un usuario sin rol de administrador ha iniciado sesión
    Cuando intenta acceder al módulo de ventas
    Entonces el sistema responde con error de autorización
