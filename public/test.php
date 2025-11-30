<?php
// Simple test endpoint to verify PHP is working
header('Content-Type: text/plain');
echo "PHP is working!\n";
echo "Server: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'unknown') . "\n";
echo "PHP Version: " . PHP_VERSION . "\n";
echo "Document Root: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'unknown') . "\n";
echo "Request URI: " . ($_SERVER['REQUEST_URI'] ?? 'unknown') . "\n";
echo "Script Name: " . ($_SERVER['SCRIPT_NAME'] ?? 'unknown') . "\n";
phpinfo();

