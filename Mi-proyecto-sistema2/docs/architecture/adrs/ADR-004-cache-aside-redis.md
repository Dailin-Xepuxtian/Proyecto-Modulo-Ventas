# ADR-004: Caché Cache-Aside con Redis y expiración (TTL)

- **Estado:** Aceptado (Cache-Aside implementado con caché en archivos en `GET /productos` y `GET /categorias`; Redis sigue como arquitectura objetivo)
- **Fecha:** 2026-10-21
- **Preocupaciones (ISO 42010):** desempeño, escalabilidad (escenarios ES-02 y ES-03)

## Contexto
`GET /productos` y `GET /categorias` son las lecturas más frecuentes y cambian poco comparado con su consumo.

## Decisión
Se aplica el patrón **Cache-Aside** en la capa de servicios:

1. El servicio consulta Redis con una clave.
2. Si hay acierto (*hit*), responde desde Redis.
3. Si hay fallo (*miss*), consulta el repositorio MySQL, guarda el resultado en Redis con TTL y responde.
4. Al modificar un producto o su inventario, se invalida la clave afectada.

```php
public function listar(array $filtros): array
{
    $clave = 'productos:' . md5(json_encode($filtros));
    $cache = $this->redis->get($clave);
    if ($cache !== false) {
        return json_decode($cache, true);
    }
    $datos = $this->productoRepository->listar($filtros);
    $this->redis->setex($clave, 300, json_encode($datos));
    return $datos;
}
```

| Clave | TTL propuesto | Justificación |
|---|---|---|
| `productos:{hash filtros}` | 300 s | El inventario cambia con las ventas |
| `categorias` | 3600 s | Cambia muy rara vez |
| `reserva:{id}` | hasta `fecha_expiracion` | Coincide con la expiración de la reserva |

## Alternativas consideradas
- **Write-Through:** mantiene la caché siempre actual, pero escribe en dos sitios en cada cambio; innecesario para este volumen.
- **Sin caché:** viable hoy, pero no cumple ES-02 con crecimiento.

## Consecuencias
**Positivas:** menor carga en MySQL y menor latencia en lecturas.
**Negativas:** posibles datos desactualizados hasta el vencimiento del TTL; hay que invalidar correctamente. Si Redis falla, el servicio debe seguir funcionando consultando MySQL (degradación controlada).

**Implementación actual:** `ProductoService` usa `CacheAside` con `FileCache` (`src/patterns/cache/`), que guarda en `storage/cache/` con TTL de 300 s (productos) y 3600 s (categorías). No requiere Redis. Pasar a Redis consiste en sustituir `FileCache` por `RedisCache`, ya que ambos implementan `CacheInterface`. Crear una cotización no invalida la caché, por lo que el stock mostrado puede estar atrasado hasta 5 minutos.
