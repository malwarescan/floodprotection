<?php

// Router for PHP built-in server
// This file handles all requests and routes them to index.php

$requestUri = $_SERVER['REQUEST_URI'];
$requestPath = parse_url($requestUri, PHP_URL_PATH);

// Remove query string
$requestPath = strtok($requestPath, '?');

// If it's a file that exists, serve it directly
if ($requestPath !== '/' && file_exists(__DIR__ . $requestPath)) {
    return false; // Let PHP serve the file
}

// Otherwise, route everything through index.php
require __DIR__ . '/index.php';

