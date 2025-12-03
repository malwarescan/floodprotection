<?php

// Set error reporting based on environment
$isProduction = ($_ENV['APP_ENV'] ?? 'production') === 'production';
if ($isProduction) {
    error_reporting(E_ALL);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', __DIR__ . '/../logs/php_errors.log');
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

// Set timezone
date_default_timezone_set('America/New_York');

// Load configuration and autoloader
require_once __DIR__ . '/../app/Config.php';
require_once __DIR__ . '/../app/Util.php';
require_once __DIR__ . '/../app/Schema.php';
require_once __DIR__ . '/../app/View.php';
require_once __DIR__ . '/../app/SEO.php';
require_once __DIR__ . '/../app/Router.php';
require_once __DIR__ . '/../app/SEOKernel.php';
require_once __DIR__ . '/../app/NewsArticleGenerator.php';
require_once __DIR__ . '/../app/QueryDrivenContent.php';
require_once __DIR__ . '/../app/SWFLContent.php';

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
    } elseif ($result === null || $result === false) {
        // Router didn't return anything - might be a 404 or redirect
        http_response_code(404);
        echo \App\View::renderPage('404', [
            'title' => 'Page Not Found - ' . \App\Config::get('app_name'),
            'description' => 'The page you are looking for could not be found.'
        ]);
    }
} catch (\Exception $e) {
    http_response_code(500);
    if ($isProduction) {
        // Log error but don't show details in production
        error_log("Router error: " . $e->getMessage());
        error_log("Stack trace: " . $e->getTraceAsString());
        echo \App\View::renderPage('404', [
            'title' => 'Error - ' . \App\Config::get('app_name'),
            'description' => 'An error occurred. Please try again later.'
        ]);
    } else {
        echo "Error: " . $e->getMessage();
        echo "<br>Stack trace:<br>" . nl2br($e->getTraceAsString());
    }
}
