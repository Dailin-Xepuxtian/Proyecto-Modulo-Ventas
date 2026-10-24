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

try {
    $cliente = App\Config\Firestore::getClient();
    echo "OK: Firestore conectado\n";
} catch (Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    if ($e->getPrevious()) {
        echo "CAUSA: " . $e->getPrevious()->getMessage() . "\n";
    }
}
