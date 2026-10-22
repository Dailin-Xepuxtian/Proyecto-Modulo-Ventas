# language: es
Característica: Gestión de recursos del módulo de ventas y cotizaciones
  Como asesor de ventas de Giganet
  Quiero consultar el catálogo y generar cotizaciones para mis clientes
  Para ofrecer precios correctos y con existencia disponible

  Antecedentes:
    Dado que inicié sesión y tengo un token JWT válido

  # ---------- Catálogo ----------

  Escenario: Listar el catálogo completo de productos
    Cuando envío GET /productos
    Entonces el estado de la respuesta es 200
    Y la respuesta es una lista de productos con código, nombre, marca, categoría, precio y stock

  Escenario: Buscar productos por código
    Cuando envío GET /productos con el filtro codigo "HK-"
    Entonces el estado de la respuesta es 200
    Y todos los productos devueltos tienen un código que coincide con la búsqueda

  Escenario: Filtrar productos por categoría
    Cuando envío GET /productos con el filtro id_categoria 1
    Entonces el estado de la respuesta es 200
    Y todos los productos devueltos pertenecen a la categoría 1

  Escenario: Filtrar productos con una categoría inválida
    Cuando envío GET /productos con un id_categoria que no es un número válido
    Entonces el estado de la respuesta es 400

  Escenario: Listar las categorías
    Cuando envío GET /categorias
    Entonces el estado de la respuesta es 200
    Y la respuesta es una lista de categorías con su id y nombre

  # ---------- Cotizaciones ----------

  Escenario: Crear una cotización correctamente
    Dado que el cliente tiene datos válidos (nombre, apellido, correo y NIT)
    Y el carrito tiene productos con cantidad mayor a cero y con existencia suficiente
    Cuando envío POST /cotizaciones
    Entonces el estado de la respuesta es 201
    Y la cotización tiene un número con el formato "COT-AAAAMMDD-HHMMSS"
    Y la cotización queda en estado "borrador"
    Y el IVA es el 12 % del subtotal y el total es subtotal más IVA
    Y la fecha de vencimiento es 15 días después de la fecha de creación

  Escenario: Consultar una cotización existente
    Dado que se creó una cotización con un id conocido
    Cuando envío GET /cotizaciones/{id}
    Entonces el estado de la respuesta es 200
    Y la respuesta incluye el cliente, los productos del detalle y los totales

  Escenario: Consultar una cotización que no existe
    Cuando envío GET /cotizaciones/999999
    Entonces el estado de la respuesta es 404

  Escenario: Crear una cotización con el carrito vacío
    Cuando envío POST /cotizaciones sin ningún producto
    Entonces el estado de la respuesta es 400
    Y el error corresponde a la regla RN-05
    Y no se guarda ninguna cotización

  Escenario: Crear una cotización con cantidad cero
    Cuando envío POST /cotizaciones con un producto de cantidad 0
    Entonces el estado de la respuesta es 400
    Y el error corresponde a la regla RN-03
    Y no se guarda ninguna cotización

  Escenario: Crear una cotización con un correo inválido
    Cuando envío POST /cotizaciones con un correo de cliente mal formado
    Entonces el estado de la respuesta es 400
    Y la respuesta indica el campo inválido en "detalles"

  Escenario: Crear una cotización con un producto sin existencia suficiente
    Dado que un producto del carrito no tiene stock o la cantidad supera su existencia
    Cuando envío POST /cotizaciones
    Entonces el estado de la respuesta es 400
    Y el código de error es "REGLA_DE_NEGOCIO" (reglas RN-01 y RN-02)
    Y no se guarda ninguna cotización, porque la transacción se revierte
