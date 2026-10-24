<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/config/config.php';

spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    if (strncmp($class, $prefix, strlen($prefix)) !== 0) {
        return;
    }
    $relativa = substr($class, strlen($prefix));
    $pos = strrpos($relativa, '\\');
    $dir = $pos === false ? '' : strtolower(str_replace('\\', '/', substr($relativa, 0, $pos))) . '/';
    $clase = $pos === false ? $relativa : substr($relativa, $pos + 1);
    $file = __DIR__ . '/../src/' . $dir . $clase . '.php';
    if (is_file($file)) {
        require $file;
    }
});

use App\Patterns\Gateway\FirestoreEnvioGateway;
use Google\Cloud\Firestore\FieldValue;

try {
    $gw = new FirestoreEnvioGateway();
    $id = $gw->crear([
        'id_cotizacion' => 99999,
        'no_cotizacion' => 'TEST-WRITE',
        'tipo_pago' => 'efectivo',
        'monto_compra' => 1.0,
        'estado_pago' => 'verificado',
        'referencia_pago' => 'TEST',
        'empresa_transporte' => 'Test',
        'numero_guia' => 'GX-TEST',
        'tipo_envio' => 'Test',
        'costo_envio' => 0,
        'direccion_destino' => ['departamento' => 'Guatemala', 'municipio' => 'Guatemala', 'zona' => '1', 'direccion_exacta' => 'Test', 'referencias' => ''],
        'destinatario' => ['nombre_completo' => 'Test', 'contacto_recepcion' => 'Test', 'telefono' => '1', 'email_notificacion' => ''],
        'estado_actual' => 'Pendiente de envío',
        'fecha_registro' => FieldValue::serverTimestamp(),
    ]);
    echo "OK write id=$id\n";
} catch (Throwable $e) {
    echo 'ERROR: ' . $e->getMessage() . "\n";
    if ($e->getPrevious()) {
        echo 'CAUSA: ' . $e->getPrevious()->getMessage() . "\n";
    }
}
