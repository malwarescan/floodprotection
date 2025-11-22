<?php
/**
 * Apply GSC audit recommendations to actual codebase
 * Updates meta titles/descriptions based on gsc_audit_output.jsonl
 */

require_once __DIR__ . '/app/Config.php';
require_once __DIR__ . '/app/Util.php';

// Load GSC recommendations
$recommendations = [];
$handle = fopen(__DIR__ . '/gsc_audit_output.jsonl', 'r');
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        $data = json_decode($line, true);
        if ($data && isset($data['action']) && $data['action'] === 'REWRITE_META') {
            $recommendations[] = $data;
        }
    }
    fclose($handle);
}

echo "Found " . count($recommendations) . " URLs to update\n\n";

// Group by URL pattern
$updates = [
    'matrix' => [],      // /home-flood-barriers/{city}, /residential-flood-panels/{city}, etc.
    'city' => [],        // /city/{city}
    'blog' => [],        // /blog/{slug}
    'faq' => [],         // /faq/{slug}
    'location' => [],    // /fl/{city}/{product}
    'flood-protection' => [], // /flood-protection/{city}
    'homepage' => null,
    'sitemaps' => []     // sitemap files
];

foreach ($recommendations as $rec) {
    $url = $rec['url'];
    $path = parse_url($url, PHP_URL_PATH);
    
    if (preg_match('#^/home-flood-barriers/([^/]+)$#', $path, $m)) {
        $updates['matrix'][] = [
            'keyword' => 'home-flood-barriers',
            'city' => $m[1],
            'title' => $rec['recommended_meta_title'],
            'description' => $rec['recommended_meta_description']
        ];
    } elseif (preg_match('#^/residential-flood-panels/([^/]+)$#', $path, $m)) {
        $updates['matrix'][] = [
            'keyword' => 'residential-flood-panels',
            'city' => $m[1],
            'title' => $rec['recommended_meta_title'],
            'description' => $rec['recommended_meta_description']
        ];
    } elseif (preg_match('#^/flood-protection-for-homes/([^/]+)$#', $path, $m)) {
        $updates['matrix'][] = [
            'keyword' => 'flood-protection-for-homes',
            'city' => $m[1],
            'title' => $rec['recommended_meta_title'],
            'description' => $rec['recommended_meta_description']
        ];
    } elseif (preg_match('#^/city/([^/]+)$#', $path, $m)) {
        $updates['city'][] = [
            'city' => $m[1],
            'title' => $rec['recommended_meta_title'],
            'description' => $rec['recommended_meta_description']
        ];
    } elseif (preg_match('#^/blog/([^/]+)$#', $path, $m)) {
        $updates['blog'][] = [
            'slug' => $m[1],
            'title' => $rec['recommended_meta_title'],
            'description' => $rec['recommended_meta_description']
        ];
    } elseif (preg_match('#^/faq/([^/]+)$#', $path, $m)) {
        $updates['faq'][] = [
            'slug' => $m[1],
            'title' => $rec['recommended_meta_title'],
            'description' => $rec['recommended_meta_description']
        ];
    } elseif (preg_match('#^/fl/([^/]+)/([^/]+)$#', $path, $m)) {
        $updates['location'][] = [
            'city' => $m[1],
            'product' => $m[2],
            'title' => $rec['recommended_meta_title'],
            'description' => $rec['recommended_meta_description']
        ];
    } elseif (preg_match('#^/flood-protection/([^/]+)$#', $path, $m)) {
        $updates['flood-protection'][] = [
            'city' => $m[1],
            'title' => $rec['recommended_meta_title'],
            'description' => $rec['recommended_meta_description']
        ];
    } elseif ($path === '/' || $path === '') {
        $updates['homepage'] = [
            'title' => $rec['recommended_meta_title'],
            'description' => $rec['recommended_meta_description']
        ];
    } elseif (strpos($path, '/sitemap') !== false || strpos($path, '.xml') !== false || strpos($path, '.ndjson') !== false) {
        $updates['sitemaps'][] = $path;
    }
}

echo "Updates by type:\n";
echo "- Matrix pages: " . count($updates['matrix']) . "\n";
echo "- City pages: " . count($updates['city']) . "\n";
echo "- Blog posts: " . count($updates['blog']) . "\n";
echo "- FAQ pages: " . count($updates['faq']) . "\n";
echo "- Location pages: " . count($updates['location']) . "\n";
echo "- Flood protection pages: " . count($updates['flood-protection']) . "\n";
echo "- Homepage: " . ($updates['homepage'] ? 'Yes' : 'No') . "\n";
echo "- Sitemaps: " . count($updates['sitemaps']) . "\n\n";

// Save updates to JSON file for processing
file_put_contents(__DIR__ . '/gsc_updates.json', json_encode($updates, JSON_PRETTY_PRINT));
echo "Saved updates to gsc_updates.json\n";

