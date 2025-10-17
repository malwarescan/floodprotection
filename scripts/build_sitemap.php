#!/usr/bin/env php
<?php
/**
 * Sitemap Builder
 * Generates comprehensive XML sitemap from matrix data
 */

require_once __DIR__ . '/../app/Config.php';
require_once __DIR__ . '/../app/Util.php';

use App\Config;
use App\Util;

echo "=== Building Sitemap ===\n\n";

$baseUrl = Config::get('app_url');
$now = date('c'); // ISO 8601 format
$lastmod = date('Y-m-d');

// Start XML
$xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

// Homepage
$xml .= "  <url>\n";
$xml .= "    <loc>{$baseUrl}</loc>\n";
$xml .= "    <lastmod>{$lastmod}</lastmod>\n";
$xml .= "    <changefreq>weekly</changefreq>\n";
$xml .= "    <priority>1.0</priority>\n";
$xml .= "  </url>\n";

$urlCount = 1;

// Main product pages
$products = [
    '/products/modular-flood-barrier',
    '/products/garage-dam-kit',
    '/products/doorway-flood-panel'
];

foreach ($products as $product) {
    $xml .= "  <url>\n";
    $xml .= "    <loc>{$baseUrl}{$product}</loc>\n";
    $xml .= "    <lastmod>{$lastmod}</lastmod>\n";
    $xml .= "    <changefreq>monthly</changefreq>\n";
    $xml .= "    <priority>0.9</priority>\n";
    $xml .= "  </url>\n";
    $urlCount++;
}

// Testimonials
$xml .= "  <url>\n";
$xml .= "    <loc>{$baseUrl}/testimonials</loc>\n";
$xml .= "    <lastmod>{$lastmod}</lastmod>\n";
$xml .= "    <changefreq>weekly</changefreq>\n";
$xml .= "    <priority>0.8</priority>\n";
$xml .= "  </url>\n";
$urlCount++;

// Blog posts
$blogPosts = Util::getBlogPosts();
foreach ($blogPosts as $post) {
    $xml .= "  <url>\n";
    $xml .= "    <loc>{$baseUrl}/blog/{$post['slug']}</loc>\n";
    $xml .= "    <lastmod>{$post['date']}</lastmod>\n";
    $xml .= "    <changefreq>monthly</changefreq>\n";
    $xml .= "    <priority>0.7</priority>\n";
    $xml .= "  </url>\n";
    $urlCount++;
}

// News articles
$newsArticles = Util::getNewsArticles();
foreach ($newsArticles as $article) {
    $xml .= "  <url>\n";
    $xml .= "    <loc>{$baseUrl}/news/{$article['slug']}</loc>\n";
    $xml .= "    <lastmod>{$article['date']}</lastmod>\n";
    $xml .= "    <changefreq>yearly</changefreq>\n";
    $xml .= "    <priority>0.6</priority>\n";
    $xml .= "  </url>\n";
    $urlCount++;
}

// FAQ pages
$faqDir = __DIR__ . '/../data/faqs/pages/';
if (is_dir($faqDir)) {
    $faqFiles = glob($faqDir . 'faq__*.json');
    foreach ($faqFiles as $faqFile) {
        $filename = basename($faqFile);
        $slug = str_replace(['faq__', '.json'], '', $filename);
        
        $xml .= "  <url>\n";
        $xml .= "    <loc>{$baseUrl}/faq/{$slug}</loc>\n";
        $xml .= "    <lastmod>{$lastmod}</lastmod>\n";
        $xml .= "    <changefreq>monthly</changefreq>\n";
        $xml .= "    <priority>0.8</priority>\n";
        $xml .= "  </url>\n";
        $urlCount++;
    }
}

// Matrix pages (city/service combinations)
$matrixFile = __DIR__ . '/../app/Data/matrix.csv';
if (file_exists($matrixFile)) {
    $matrix = array_map(fn($line) => str_getcsv($line, ',', '"', '\\'), file($matrixFile));
    $headers = array_shift($matrix);
    
    echo "Processing " . count($matrix) . " matrix pages...\n";
    
    foreach ($matrix as $row) {
        if (empty($row[0])) continue; // skip empty rows
        
        $rowData = array_combine($headers, $row);
        $urlPath = $rowData['url_path'] ?? '';
        
        if (empty($urlPath)) continue;
        
        // Get lastmod from CSV or use default
        $pageLastmod = !empty($rowData['lastmod']) ? $rowData['lastmod'] : $lastmod;
        
        $xml .= "  <url>\n";
        $xml .= "    <loc>{$baseUrl}{$urlPath}</loc>\n";
        $xml .= "    <lastmod>{$pageLastmod}</lastmod>\n";
        $xml .= "    <changefreq>weekly</changefreq>\n";
        $xml .= "    <priority>0.7</priority>\n";
        $xml .= "  </url>\n";
        $urlCount++;
    }
}

// Close XML
$xml .= '</urlset>';

// Write sitemap
$sitemapPath = __DIR__ . '/../public/sitemap.xml';
file_put_contents($sitemapPath, $xml);

echo "\n✅ Sitemap generated: $sitemapPath\n";
echo "   Total URLs: $urlCount\n";
echo "   Last modified: $lastmod\n\n";

// Also write a matrix-specific sitemap
$matrixXml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
$matrixXml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

if (file_exists($matrixFile)) {
    $matrix = array_map(fn($line) => str_getcsv($line, ',', '"', '\\'), file($matrixFile));
    $headers = array_shift($matrix);
    
    foreach ($matrix as $row) {
        if (empty($row[0])) continue;
        
        $rowData = array_combine($headers, $row);
        $urlPath = $rowData['url_path'] ?? '';
        if (empty($urlPath)) continue;
        
        $pageLastmod = !empty($rowData['lastmod']) ? $rowData['lastmod'] : $lastmod;
        
        $matrixXml .= "  <url>\n";
        $matrixXml .= "    <loc>{$baseUrl}{$urlPath}</loc>\n";
        $matrixXml .= "    <lastmod>{$pageLastmod}</lastmod>\n";
        $matrixXml .= "    <changefreq>weekly</changefreq>\n";
        $matrixXml .= "    <priority>0.7</priority>\n";
        $matrixXml .= "  </url>\n";
    }
}

$matrixXml .= '</urlset>';

$matrixSitemapPath = __DIR__ . '/../public/sitemap-matrix.xml';
file_put_contents($matrixSitemapPath, $matrixXml);

echo "✅ Matrix sitemap generated: $matrixSitemapPath\n";
echo "   Matrix URLs: " . (count($matrix ?? [])) . "\n\n";

echo "Done!\n";

