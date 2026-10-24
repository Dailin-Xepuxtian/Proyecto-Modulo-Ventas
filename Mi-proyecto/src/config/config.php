<?php
/**
 * Configuración general del backend. Los valores se leen del archivo .env
 * de la raíz del proyecto (copiar .env.example a .env y ajustar).
 */
require_once __DIR__ . '/Env.php';

$autoload = dirname(__DIR__, 2) . '/vendor/autoload.php';
if (is_file($autoload)) {
    require_once $autoload;
}

\App\Config\Env::load(dirname(__DIR__, 2) . '/.env');

define('DB_HOST', \App\Config\Env::get('DB_HOST', 'localhost'));
define('DB_NAME', \App\Config\Env::get('DB_NAME', 'giganet_db'));
define('DB_USER', \App\Config\Env::get('DB_USER', 'root'));
define('DB_PASS', \App\Config\Env::get('DB_PASS', ''));

// Clave para firmar los JWT. Cambiarla en cualquier entorno real.
define('JWT_SECRET', \App\Config\Env::get('JWT_SECRET', 'giganet-clave-secreta-cambiar-en-produccion'));
define('JWT_TTL', (int) \App\Config\Env::get('JWT_TTL', '3600')); // segundos (coincide con "expiraEn" del OpenAPI)

// Reglas de negocio de cotizaciones
define('IVA_PORCENTAJE', (int) \App\Config\Env::get('IVA_PORCENTAJE', '12'));   // IVA 12 %
define('DIAS_VENCIMIENTO', (int) \App\Config\Env::get('DIAS_VENCIMIENTO', '15')); // vencimiento = emisión + 15 días

// Firebase Admin SDK: el JSON de cuenta de servicio queda fuera del repositorio.
define('FIREBASE_PROJECT_ID', \App\Config\Env::get('FIREBASE_PROJECT_ID', ''));
define('FIREBASE_CREDENTIALS', \App\Config\Env::get('FIREBASE_CREDENTIALS', ''));

date_default_timezone_set(\App\Config\Env::get('APP_TIMEZONE', 'America/Guatemala'));
