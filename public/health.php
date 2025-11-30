<?php
// Railway health check endpoint
header('Content-Type: application/json');

$health = [
    'status' => 'ok',
    'timestamp' => date('c'),
    'environment' => $_ENV['APP_ENV'] ?? 'production',
    'railway' => isset($_ENV['RAILWAY_ENVIRONMENT']),
    'php_version' => PHP_VERSION,
    'server' => $_SERVER['SERVER_SOFTWARE'] ?? 'unknown',
    'document_root' => $_SERVER['DOCUMENT_ROOT'] ?? 'unknown',
    'script_name' => $_SERVER['SCRIPT_NAME'] ?? 'unknown',
];

// Test if classes can be loaded
try {
    require_once __DIR__ . '/../app/Config.php';
    require_once __DIR__ . '/../app/Util.php';
    $health['classes_loaded'] = true;
    $health['app_url'] = \App\Config::get('app_url');
} catch (Exception $e) {
    $health['classes_loaded'] = false;
    $health['error'] = $e->getMessage();
}

echo json_encode($health, JSON_PRETTY_PRINT);

