<?php
declare(strict_types=1);

namespace App\Patterns\Resilience;

use App\Patterns\Cache\CacheInterface;

/**
 * Patrón Circuit Breaker con tres estados:
 *  - cerrado:     las llamadas pasan; se cuentan los fallos consecutivos.
 *  - abierto:     tras N fallos, se rechazan las llamadas durante un tiempo de recuperación.
 *  - semiabierto: pasado ese tiempo, se permite un intento; si funciona se cierra, si falla se reabre.
 * El estado se guarda en la caché (Redis en producción) para compartirlo entre solicitudes PHP.
 */
final class CircuitBreaker
{
    public function __construct(
        private CacheInterface $cache,
        private string $nombre,
        private int $umbralFallos = 3,
        private int $segundosRecuperacion = 30,
        private ?\Closure $reloj = null
    ) {
    }

    public function ejecutar(callable $accion): mixed
    {
        $estado = $this->cargar();

        if ($estado['estado'] === 'abierto') {
            if ($this->ahora() - $estado['abierto_desde'] < $this->segundosRecuperacion) {
                throw new CircuitoAbiertoException("Circuito '{$this->nombre}' abierto: servicio no disponible");
            }
            $estado['estado'] = 'semiabierto';
            $this->guardar($estado);
        }

        try {
            $resultado = $accion();
        } catch (\Throwable $e) {
            $this->registrarFallo($estado);
            throw $e;
        }

        $this->guardar(['estado' => 'cerrado', 'fallos' => 0, 'abierto_desde' => 0]);
        return $resultado;
    }

    public function estado(): string
    {
        return $this->cargar()['estado'];
    }

    private function registrarFallo(array $estado): void
    {
        $estado['fallos']++;
        if ($estado['estado'] === 'semiabierto' || $estado['fallos'] >= $this->umbralFallos) {
            $estado['estado'] = 'abierto';
            $estado['abierto_desde'] = $this->ahora();
        }
        $this->guardar($estado);
    }

    private function cargar(): array
    {
        $estado = $this->cache->get($this->clave());
        return is_array($estado) ? $estado : ['estado' => 'cerrado', 'fallos' => 0, 'abierto_desde' => 0];
    }

    private function guardar(array $estado): void
    {
        $this->cache->set($this->clave(), $estado, 3600);
    }

    private function clave(): string
    {
        return 'circuit:' . $this->nombre;
    }

    private function ahora(): int
    {
        return $this->reloj ? (int) ($this->reloj)() : time();
    }
}
