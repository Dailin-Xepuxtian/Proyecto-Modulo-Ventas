# ADR-005: Autenticación con JWT sin estado

- **Estado:** Aceptado
- **Fecha:** 2026-10-21
- **Preocupaciones (ISO 42010):** seguridad, escalabilidad (ES-03, ES-05)

## Contexto
La API se consume desde un prototipo web en otro origen. La tabla de rutas de `app.php` marca por ruta si se requiere token: `POST auth/login` es pública y el resto exige JWT. Existe un servicio `Jwt` y un `AuthService`.

## Decisión
Se usa **JWT firmado** emitido en `POST /auth/login` y enviado en la cabecera `Authorization`. El servidor no guarda sesiones.

## Alternativas consideradas
- **Sesiones PHP en servidor:** simples, pero atan al cliente a una instancia y dificultan replicar la API.
- **OAuth 2.0 con proveedor externo:** excesivo para un sistema interno.

## Consecuencias
**Positivas:** la API es replicable sin compartir sesiones; validación rápida en cada solicitud.
**Negativas:** un token emitido no se puede revocar antes de que expire.
**Mitigaciones:** expiración corta, secreto en variables de entorno (`Env.php`), y restringir CORS al origen del prototipo en producción (hoy permite cualquier origen).
