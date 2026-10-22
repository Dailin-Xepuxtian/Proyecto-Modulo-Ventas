<?php
/**
 * Configuración general del backend. Los valores se leen del archivo .env
 * de la raíz del proyecto (copiar .env.example a .env y ajustar).
 */
require_once __DIR__ . '/Env.php';

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

date_default_timezone_set(\App\Config\Env::get('APP_TIMEZONE', 'America/Guatemala'));
