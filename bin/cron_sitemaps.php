#!/usr/bin/env php
<?php
declare(strict_types=1);

/**
 * Cron script for automated sitemap regeneration
 * 
 * Usage:
 *   php bin/cron_sitemaps.php
 * 
 * Cron schedule examples:
 *   # Daily at 2 AM
 *   0 2 * * * php /path/to/bin/cron_sitemaps.php
 *   
 *   # Every 6 hours
 *   0 *\/6 * * * php /path/to/bin/cron_sitemaps.php
 *   
 *   # Weekly on Sunday at 3 AM
 *   0 3 * * 0 php /path/to/bin/cron_sitemaps.php
 */

$ROOT = realpath(__DIR__.'/..') ?: dirname(__DIR__);
$LOG_FILE = $ROOT . '/logs/sitemap_cron.log';

// Ensure logs directory exists
$logDir = dirname($LOG_FILE);
if (!is_dir($logDir)) {
    mkdir($logDir, 0755, true);
}

function logMessage(string $message): void
{
    global $LOG_FILE;
    $timestamp = date('Y-m-d H:i:s');
    $logEntry = "[$timestamp] $message\n";
    file_put_contents($LOG_FILE, $logEntry, FILE_APPEND | LOCK_EX);
    echo $logEntry;
}

logMessage("Starting sitemap regeneration cron job");

try {
    // Change to project root directory
    chdir($ROOT);
    
    // Run the sitemap generator
    $command = "php bin/build_sitemaps.php --gzip=1 2>&1";
    $output = [];
    $returnCode = 0;
    
    exec($command, $output, $returnCode);
    
    if ($returnCode === 0) {
        logMessage("Sitemap regeneration completed successfully");
        logMessage("Output: " . implode("\n", $output));
    } else {
        logMessage("Sitemap regeneration failed with return code: $returnCode");
        logMessage("Error output: " . implode("\n", $output));
        exit(1);
    }
    
    // Optional: Submit to Google Search Console (requires GSC API setup)
    // logMessage("Submitting sitemap to Google Search Console...");
    // $gscCommand = "php bin/submit_to_gsc.php";
    // exec($gscCommand, $gscOutput, $gscReturnCode);
    
    logMessage("Cron job completed successfully");
    
} catch (Exception $e) {
    logMessage("Cron job failed with exception: " . $e->getMessage());
    logMessage("Stack trace: " . $e->getTraceAsString());
    exit(1);
}
