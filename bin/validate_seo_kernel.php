#!/usr/bin/env php
<?php
/**
 * SEO Kernel Validation Script
 * 
 * Validates all pages against SEO Absolute Standard v1
 * Blocks deployment if violations are found
 * 
 * Usage: php bin/validate_seo_kernel.php [--enforce]
 */

require_once __DIR__ . '/../app/Config.php';
require_once __DIR__ . '/../app/View.php';
require_once __DIR__ . '/../app/SEOKernel.php';
require_once __DIR__ . '/../app/Router.php';
require_once __DIR__ . '/../app/Util.php';

use App\Config;
use App\View;
use App\SEOKernel;
use App\Router;

$enforce = in_array('--enforce', $argv);

echo "🔍 SEO Kernel Validation - SEO Absolute Standard v1\n";
echo str_repeat('=', 60) . "\n\n";

$violations = [];
$warnings = [];
$pages = [];

// Test critical pages
$testPages = [
    '/' => 'Homepage',
    '/products' => 'Products Index',
    '/products/modular-flood-barrier' => 'Modular Flood Barrier',
    '/products/garage-dam-kit' => 'Garage Dam Kit',
    '/products/doorway-flood-panel' => 'Doorway Flood Panel',
    '/testimonials' => 'Testimonials',
    '/blog' => 'Blog Index',
    '/home-flood-barriers/miami' => 'Matrix Page (Miami)',
    '/fl/miami/modular-flood-barrier' => 'Location Page (Miami)',
];

foreach ($testPages as $path => $name) {
    echo "Validating: {$name} ({$path})...\n";
    
    // Simulate request
    $_SERVER['REQUEST_URI'] = $path;
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['HTTP_HOST'] = parse_url(Config::get('app_url'), PHP_HOST);
    
    try {
        $router = new Router();
        ob_start();
        $router->dispatch();
        $html = ob_get_clean();
        
        // Extract page data from HTML
        preg_match('/<title>(.*?)<\/title>/i', $html, $titleMatch);
        preg_match('/<meta name="description" content="([^"]+)"/i', $html, $descMatch);
        preg_match('/<link rel="canonical" href="([^"]+)"/i', $html, $canonicalMatch);
        preg_match('/<script type="application\/ld\+json">(.*?)<\/script>/is', $html, $schemaMatch);
        
        $pageData = [
            'title' => $titleMatch[1] ?? '',
            'description' => $descMatch[1] ?? '',
            'canonical' => $canonicalMatch[1] ?? '',
            'url' => Config::get('app_url') . $path
        ];
        
        $schema = [];
        if (!empty($schemaMatch[1])) {
            $schema = json_decode($schemaMatch[1], true);
        }
        
        $result = SEOKernel::validatePage($pageData, $html, $schema);
        
        if (!$result['valid']) {
            $violations = array_merge($violations, array_map(function($v) use ($name) {
                return "[{$name}] {$v}";
            }, $result['violations']));
        }
        
        $warnings = array_merge($warnings, array_map(function($w) use ($name) {
            return "[{$name}] {$w}";
        }, $result['warnings']));
        
        $pages[] = [
            'name' => $name,
            'path' => $path,
            'score' => $result['score'],
            'status' => $result['valid'] ? 'PASS' : 'FAIL',
            'violations' => count($result['violations']),
            'warnings' => count($result['warnings'])
        ];
        
        echo "  Status: " . ($result['valid'] ? "✅ PASS" : "❌ FAIL") . " (Score: {$result['score']}/100)\n";
        if (!empty($result['violations'])) {
            foreach ($result['violations'] as $v) {
                echo "    ❌ {$v}\n";
            }
        }
        if (!empty($result['warnings'])) {
            foreach ($result['warnings'] as $w) {
                echo "    ⚠️  {$w}\n";
            }
        }
        
    } catch (\Exception $e) {
        echo "  ❌ ERROR: " . $e->getMessage() . "\n";
        $violations[] = "[{$name}] Page failed to render: " . $e->getMessage();
    }
    
    echo "\n";
}

// Summary
echo str_repeat('=', 60) . "\n";
echo "📊 VALIDATION SUMMARY\n";
echo str_repeat('=', 60) . "\n\n";

$totalPages = count($pages);
$passedPages = count(array_filter($pages, fn($p) => $p['status'] === 'PASS'));
$avgScore = $totalPages > 0 ? round(array_sum(array_column($pages, 'score')) / $totalPages) : 0;

echo "Total Pages Tested: {$totalPages}\n";
echo "Pages Passing: {$passedPages}\n";
echo "Pages Failing: " . ($totalPages - $passedPages) . "\n";
echo "Average Score: {$avgScore}/100\n";
echo "Total Violations: " . count($violations) . "\n";
echo "Total Warnings: " . count($warnings) . "\n\n";

if (!empty($violations)) {
    echo "❌ VIOLATIONS FOUND:\n";
    foreach ($violations as $v) {
        echo "  • {$v}\n";
    }
    echo "\n";
}

if (!empty($warnings)) {
    echo "⚠️  WARNINGS:\n";
    foreach (array_slice($warnings, 0, 10) as $w) {
        echo "  • {$w}\n";
    }
    if (count($warnings) > 10) {
        echo "  ... and " . (count($warnings) - 10) . " more warnings\n";
    }
    echo "\n";
}

// Deployment block
if (!empty($violations)) {
    if ($enforce) {
        echo "🚫 DEPLOYMENT BLOCKED\n";
        echo "SEO Kernel violations detected. Fix all violations before deploying.\n";
        exit(1);
    } else {
        echo "⚠️  DEPLOYMENT WARNING\n";
        echo "SEO Kernel violations detected. Run with --enforce to block deployment.\n";
        exit(0);
    }
} else {
    echo "✅ ALL VALIDATIONS PASSED\n";
    echo "No SEO Kernel violations detected. Safe to deploy.\n";
    exit(0);
}

