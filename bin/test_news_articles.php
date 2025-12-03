#!/usr/bin/env php
<?php

/**
 * Test script to verify all programmatic news articles generate correctly
 */

require_once __DIR__ . '/../app/Config.php';
require_once __DIR__ . '/../app/NewsArticleGenerator.php';

$cities = [
    'fort-myers' => 'Fort Myers',
    'cape-coral' => 'Cape Coral',
    'naples' => 'Naples',
    'bonita-springs' => 'Bonita Springs',
    'estero' => 'Estero',
    'sanibel' => 'Sanibel',
    'pine-island' => 'Pine Island',
    'marco-island' => 'Marco Island',
    'sarasota' => 'Sarasota',
    'tampa' => 'Tampa',
    'st-petersburg' => 'St. Petersburg',
    'clearwater' => 'Clearwater',
    'bradenton' => 'Bradenton',
    'venice' => 'Venice',
    'port-charlotte' => 'Port Charlotte',
    'punta-gorda' => 'Punta Gorda',
    'miami' => 'Miami',
    'miami-beach' => 'Miami Beach',
    'key-west' => 'Key West',
    'key-largo' => 'Key Largo'
];

echo "Testing Programmatic News Article Generation\n";
echo str_repeat("=", 60) . "\n\n";

$success = 0;
$errors = [];

foreach ($cities as $slug => $name) {
    try {
        $article = \App\NewsArticleGenerator::generateArticle($slug);
        
        if (empty($article['title'])) {
            throw new \Exception("Empty title");
        }
        
        if (empty($article['content']) || !is_array($article['content'])) {
            throw new \Exception("Invalid content");
        }
        
        if (empty($article['schema'])) {
            throw new \Exception("Missing schema");
        }
        
        $url = \App\Config::get('app_url') . '/news/flood-barriers-' . $slug;
        
        echo "✓ {$name} ({$slug})\n";
        echo "  URL: {$url}\n";
        echo "  Title: " . substr($article['title'], 0, 70) . "...\n";
        echo "  Sections: " . count($article['content']) . "\n";
        echo "  Schema: " . ($article['schema']['@type'] ?? 'N/A') . "\n";
        echo "\n";
        
        $success++;
    } catch (\Exception $e) {
        echo "✗ {$name} ({$slug}) - ERROR: {$e->getMessage()}\n\n";
        $errors[$slug] = $e->getMessage();
    }
}

echo str_repeat("=", 60) . "\n";
echo "Summary: {$success}/" . count($cities) . " articles generated successfully\n";

if (!empty($errors)) {
    echo "\nErrors:\n";
    foreach ($errors as $slug => $error) {
        echo "  - {$slug}: {$error}\n";
    }
    exit(1);
}

echo "\nAll articles generated successfully! ✓\n";
exit(0);

