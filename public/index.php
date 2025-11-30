<?php

// Set error reporting based on environment
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set timezone
date_default_timezone_set('America/New_York');

// Load configuration and autoloader
require_once __DIR__ . '/../app/Config.php';
require_once __DIR__ . '/../app/Util.php';
require_once __DIR__ . '/../app/Schema.php';
require_once __DIR__ . '/../app/View.php';
require_once __DIR__ . '/../app/SEO.php';
require_once __DIR__ . '/../app/Router.php';

// Load all controllers
$controllerPath = __DIR__ . '/../app/Controllers/';
$controllers = glob($controllerPath . '*.php');
foreach ($controllers as $controller) {
    require_once $controller;
}

// Initialize and run the router
try {
    $router = new App\Router();
    $result = $router->dispatch();
    
    // If the router returns content, output it
    if ($result && is_string($result)) {
        echo $result;
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    echo "<br>Stack trace:<br>" . nl2br($e->getTraceAsString());
}
