# Persistencia políglota, caché y patrones de diseño (Componente 2)

**Sistema:** Módulo de ventas y cotizaciones de Giganet, S.A.
**Relacionado con:** ADR-003, ADR-004, ADR-006 y ADR-007 (`docs/architecture/adrs/`).

## 1. Persistencia políglota

MySQL es la fuente de verdad. Los demás almacenes son la arquitectura objetivo (ADR-003).

| Almacén | Tipo | Uso en Giganet | Estado |
|---|---|---|---|
| MySQL (`giganet_db`) | Relacional | Cotizaciones, ventas, pagos, clientes, productos, usuarios | Implementado |
| MongoDB | Documental | Datos de envío, referenciados desde `ventas.id_envio_mongodb` | Objetivo |
| Redis | En memoria | Caché del catálogo y estado del Circuit Breaker | Adaptador escrito (`RedisCache`); sin conectar. En uso: `FileCache` |
| Neo4j | Grafos | Relaciones producto–proveedor y recomendaciones | Objetivo |

## 2. Caché Cache-Aside con expiración (TTL)

Flujo: consultar caché → si hay dato, responderlo → si no, consultar MySQL, guardar con TTL y responder. Al modificar un dato en MySQL se invalida su clave. Si la caché falla, el sistema sigue funcionando con MySQL.

| Clave | TTL | Justificación |
|---|---|---|
| `productos:{hash de filtros}` | 300 s | El inventario cambia con las ventas |
| `categorias` | 3600 s | Cambia muy rara vez |

Código: `src/patterns/cache/` (`CacheInterface`, `ArrayCache`, `RedisCache`, `CacheAside`). `FileCache` (caché en archivos, `storage/cache/`) está conectado a `ProductoService` para el catálogo y las categorías, con TTL de 300 s y 3600 s; Redis queda como siguiente paso. Ejemplo de uso:

```php
$cacheAside = new CacheAside(new RedisCache($redis));
$productos = $cacheAside->obtener('productos:' . md5(json_encode($filtros)), 300,
    fn () => /* consulta actual al ProductoRepository */ []);
```

## 3. Consistencia eventual

Dentro de MySQL, cada operación usa una transacción ACID (por ejemplo, `CotizacionService::crear` abre una transacción para la cabecera y los detalles). Entre almacenes se usa una saga coreografiada (ADR-006). El patrón Observer (sección 4) es el mecanismo que dispara cada paso:

| Cambio de estado de la cotización | Reacción del observador de inventario |
|---|---|
| `aprobada` | Crea la reserva (`activa`) |
| `rechazada` | Cancela la reserva |
| `convertida_a_venta` | Completa la reserva |

## 4. Patrones GoF

| Patrón | Clases | Ubicación | Estado |
|---|---|---|---|
| Repository | `ClienteRepository`, `CotizacionRepository`, `ProductoRepository`, `UsuarioRepository` | `src/models/repositories/` | Implementado y en uso |
| Strategy | `MetodoPagoStrategy`, `EfectivoStrategy`, `ReferenciaBancariaStrategy`, `TarjetaStrategy`, `ProcesadorPago` (contexto) | `src/patterns/strategy/` | Implementado; no conectado a un endpoint |
| Gateway | `PasarelaPagoGateway`, `PasarelaPagoSimulada`, `RespuestaPasarela` | `src/patterns/gateway/` | Implementado con pasarela simulada |
| Circuit Breaker | `CircuitBreaker`, `CircuitoAbiertoException`, `PasarelaPagoConCircuitBreaker` | `src/patterns/resilience/` y `src/patterns/gateway/` | Implementado; el estado se guarda en la caché |
| Observer | `CotizacionSujeto` (SplSubject), `ReservaInventarioObserver`, `BitacoraObserver` (SplObserver) | `src/patterns/observer/` | Implementado; no conectado a `CotizacionService` |

Cómo se relacionan:
- **Strategy** elige cómo procesar cada valor del enum `metodo_pago` de la tabla `pagos`. Agregar un método nuevo es agregar una clase (escenario ES-01).
- **Gateway** encapsula la pasarela externa; **Circuit Breaker** la protege. Si la pasarela falla, `TarjetaStrategy` deja el pago en `pendiente` en lugar de romper la solicitud.
- **Observer** desacopla el cambio de estado de la cotización de sus consecuencias (reservas, bitácora).

## 5. Demostración

Desde la raíz del proyecto:

```
php tools/demo_patrones.php
```

Salida esperada (resumen): 1, 2 y 3 consultas a MySQL en la sección de caché; `verificado`, `pendiente` y `verificado` en los métodos de pago; el circuito pasa de `cerrado` a `abierto` tras 3 fallos y, con el circuito abierto, hay 0 llamadas reales a la pasarela; luego se recupera a `cerrado`; y el Observer crea, completa y cancela reservas según el estado.

## 6. Limitaciones

- Strategy, Gateway, Circuit Breaker y Observer son módulos independientes, no conectados a los endpoints. Cache-Aside sí está conectado a `ProductoService`.
- La pasarela de pago es simulada; MongoDB, Neo4j y Redis no están integrados en la aplicación.
- Crear una cotización no invalida la caché; el stock mostrado puede estar atrasado hasta 5 minutos.
- Los servicios existentes crean sus dependencias con `new`; para integrar estos módulos conviene aplicar inyección de dependencias por constructor.
