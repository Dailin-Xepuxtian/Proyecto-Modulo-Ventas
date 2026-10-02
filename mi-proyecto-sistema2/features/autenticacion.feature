# language: es
Característica: Autenticación de usuarios
  Como usuario del módulo de ventas de Giganet
  Quiero iniciar sesión con mi correo y contraseña
  Para obtener un token JWT y usar los endpoints protegidos

  Escenario: Inicio de sesión correcto de un administrador
    Dado que existe un usuario administrador registrado
    Cuando envío POST /auth/login con su correo y su contraseña correctos
    Entonces el estado de la respuesta es 200
    Y la respuesta incluye un token de tipo "Bearer"
    Y la respuesta indica que el token expira en 3600 segundos
    Y la respuesta incluye los datos del usuario (id y nombre)

  Escenario: Inicio de sesión con contraseña incorrecta
    Dado que existe un usuario registrado
    Cuando envío POST /auth/login con su correo y una contraseña incorrecta
    Entonces el estado de la respuesta es 401
    Y la respuesta incluye el código "UNAUTHORIZED"
    Y no se entrega ningún token

  Escenario: Inicio de sesión con campos faltantes
    Cuando envío POST /auth/login sin el correo o sin la contraseña
    Entonces el estado de la respuesta es 400
    Y la respuesta indica qué campos faltan en "detalles"

  Escenario: Acceso a un recurso protegido sin token
    Dado que no envío el encabezado Authorization
    Cuando envío GET /productos
    Entonces el estado de la respuesta es 401
    Y el mensaje indica que el token no fue proporcionado o es inválido

  Escenario: Acceso a un recurso protegido con token inválido o vencido
    Dado que envío un token alterado o expirado en el encabezado Authorization
    Cuando envío GET /productos
    Entonces el estado de la respuesta es 401
    Y el mensaje indica que el token no fue proporcionado o es inválido
