<?php
declare(strict_types=1);

/**
 * Demostración de los patrones del Componente 2 (no necesita MySQL ni Redis).
 * Ejecutar desde la raíz del proyecto:   php tools/demo_patrones.php
 */

use App\Patterns\Cache\ArrayCache;
use App\Patterns\Cache\CacheAside;
use App\Patterns\Gateway\PasarelaPagoConCircuitBreaker;
use App\Patterns\Gateway\PasarelaPagoSimulada;
use App\Patterns\Observer\BitacoraObserver;
use App\Patterns\Observer\CotizacionSujeto;
use App\Patterns\Observer\ReservaInventario;
use App\Patterns\Observer\ReservaInventarioObserver;
use App\Patterns\Resilience\CircuitBreaker;
use App\Patterns\Strategy\EfectivoStrategy;
use App\Patterns\Strategy\ProcesadorPago;
use App\Patterns\Strategy\ReferenciaBancariaStrategy;
use App\Patterns\Strategy\TarjetaStrategy;

// Autoloader con la misma regla que app.php: App\Carpeta\Subcarpeta\Clase -> src/carpeta/subcarpeta/Clase.php
spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    if (strncmp($class, $prefix, strlen($prefix)) !== 0) {
        return;
    }
    $relativa = substr($class, strlen($prefix));
    $pos      = strrpos($relativa, '\\');
    $dir      = $pos === false ? '' : strtolower(str_replace('\\', '/', substr($relativa, 0, $pos))) . '/';
    $clase    = $pos === false ? $relativa : substr($relativa, $pos + 1);
    $file     = __DIR__ . '/../src/' . $dir . $clase . '.php';
    if (is_file($file)) {
        require $file;
    }
});

function titulo(string $texto): void
{
    echo "\n=== $texto ===\n";
}

// ------------------------------------------------------------------ 1. Cache-Aside con TTL
titulo('1. Cache-Aside con TTL');

$hora  = 1000;
$cache = new ArrayCache(function () use (&$hora): int {
    return $hora;
});
$cacheAside     = new CacheAside($cache);
$consultasMysql = 0;
$cargarProductos = function () use (&$consultasMysql): array {
    $consultasMysql++;
    return [['id_producto' => 1, 'codigo' => 'HK-Q650']];
};

$cacheAside->obtener('productos:todos', 300, $cargarProductos);
$cacheAside->obtener('productos:todos', 300, $cargarProductos);
echo "Consultas a MySQL tras 2 lecturas seguidas: $consultasMysql (esperado: 1)\n";

$hora += 301;
$cacheAside->obtener('productos:todos', 300, $cargarProductos);
echo "Consultas a MySQL tras vencer el TTL de 300 s: $consultasMysql (esperado: 2)\n";

$cacheAside->invalidar('productos:todos');
$cacheAside->obtener('productos:todos', 300, $cargarProductos);
echo "Consultas a MySQL tras invalidar la clave: $consultasMysql (esperado: 3)\n";

// ------------------------------------------------------------------ 2. Strategy + Gateway + Circuit Breaker
titulo('2. Strategy (métodos de pago)');

$tiempo   = 5000;
$pasarela = new PasarelaPagoSimulada();
$breaker  = new CircuitBreaker(new ArrayCache(), 'pasarela-pago', 3, 30, function () use (&$tiempo): int {
    return $tiempo;
});
$procesador = new ProcesadorPago(
    new EfectivoStrategy(),
    new ReferenciaBancariaStrategy(),
    new TarjetaStrategy(new PasarelaPagoConCircuitBreaker($pasarela, $breaker))
);
$total   = 341600; // Q3,416.00 en centavos
$tarjeta = ['token_tarjeta' => 'tok_demo'];

echo 'efectivo:        ' . $procesador->procesar('efectivo', $total) . "\n";
echo 'transferencia:   ' . $procesador->procesar('transferencia', $total, ['no_referencia' => 'TR-001', 'banco' => 'Banco de ejemplo']) . "\n";
try {
    $procesador->procesar('transferencia', $total, ['no_referencia' => 'TR-002']);
} catch (\InvalidArgumentException $e) {
    echo 'transferencia sin banco -> error: ' . $e->getMessage() . "\n";
}
echo 'tarjeta_credito: ' . $procesador->procesar('tarjeta_credito', $total, $tarjeta) . "\n";

titulo('3. Gateway con Circuit Breaker');

echo 'Circuito al inicio: ' . $breaker->estado() . "\n";
$pasarela->setDisponible(false);
for ($i = 1; $i <= 3; $i++) {
    echo "Intento $i con la pasarela caída: " . $procesador->procesar('tarjeta_credito', $total, $tarjeta)
        . ' | circuito: ' . $breaker->estado() . "\n";
}
$llamadasAntes = $pasarela->llamadas;
echo 'Con el circuito abierto: ' . $procesador->procesar('tarjeta_credito', $total, $tarjeta)
    . ' | llamadas reales a la pasarela: ' . ($pasarela->llamadas - $llamadasAntes) . " (esperado: 0)\n";

$tiempo += 31;
$pasarela->setDisponible(true);
echo 'Tras 31 s y con la pasarela recuperada: ' . $procesador->procesar('tarjeta_credito', $total, $tarjeta)
    . ' | circuito: ' . $breaker->estado() . "\n";

// ------------------------------------------------------------------ 4. Observer
titulo('4. Observer (cambios de estado de la cotización)');

$reservas = new class implements ReservaInventario {
    public function crear(int $idCotizacion): void
    {
        echo "  [reserva] creada para la cotización $idCotizacion\n";
    }

    public function cancelar(int $idCotizacion): void
    {
        echo "  [reserva] cancelada para la cotización $idCotizacion\n";
    }

    public function completar(int $idCotizacion): void
    {
        echo "  [reserva] completada para la cotización $idCotizacion\n";
    }
};

$sujeto   = new CotizacionSujeto();
$bitacora = new BitacoraObserver();
$sujeto->attach(new ReservaInventarioObserver($reservas));
$sujeto->attach($bitacora);

$sujeto->cambiarEstado(12, 'enviada', 'aprobada');
$sujeto->cambiarEstado(12, 'aprobada', 'convertida_a_venta');
$sujeto->cambiarEstado(14, 'enviada', 'rechazada');

foreach ($bitacora->registro() as $linea) {
    echo "  [bitácora] $linea\n";
}
echo "\nDemostración terminada.\n";
