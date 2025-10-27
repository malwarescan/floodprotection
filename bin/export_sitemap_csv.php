#!/usr/bin/env php
<?php
declare(strict_types=1);

/**
 * Lightweight CSV/TSV Sitemap Exporter
 * 
 * Extracts URLs from XML sitemaps and exports to CSV/TSV for AI/RAG crawlers.
 * Token-efficient format for budget-sensitive scraping.
 * 
 * Usage:
 *   php bin/export_sitemap_csv.php --format=csv
 *   php bin/export_sitemap_csv.php --format=tsv --gzip
 */

$opts = getopt('', [
  'format::',    // csv | tsv (default: csv)
  'gzip::',      // compress output (default: 0)
  'output::',    // output file path
]);

$ROOT = realpath(__DIR__.'/..') ?: dirname(__DIR__);
$fmt = strtolower($opts['format'] ?? 'csv');
$gzip = isset($opts['gzip']) && (string)$opts['gzip'] === '1';
$output = $opts['output'] ?? $ROOT.'/public/sitemap-optimized.'.$fmt;

if (!in_array($fmt, ['csv', 'tsv'])) {
  die("Error: format must be 'csv' or 'tsv'\n");
}

$sep = $fmt === 'tsv' ? "\t" : ",";
$cols = ['url', 'lastmod'];

echo "Extracting URLs from XML sitemaps...\n";

// Parse all XML sitemaps
$allUrls = [];
$sitemapDir = $ROOT.'/public/sitemaps/';

// Files to check (order matters - index first)
$sitemapFiles = [
  $sitemapDir.'sitemap-index.xml',
  $sitemapDir.'sitemap-static.xml',
  $sitemapDir.'sitemap-products.xml',
  $sitemapDir.'sitemap-faq.xml',
  $sitemapDir.'sitemap-reviews.xml',
  $sitemapDir.'sitemap-blog.xml',
];

// Extract URLs from XML
foreach ($sitemapFiles as $file) {
  if (!file_exists($file)) continue;
  
  $xml = @file_get_contents($file);
  if (!$xml) continue;
  
  $dom = new DOMDocument();
  if (!@$dom->loadXML($xml)) continue;
  
  $xpath = new DOMXPath($dom);
  
  // Extract urlset URLs
  $urlNodes = $xpath->query('//urlset/url');
  foreach ($urlNodes as $urlNode) {
    $loc = $xpath->evaluate('string(loc)', $urlNode);
    $lastmod = $xpath->evaluate('string(lastmod)', $urlNode);
    
    if ($loc) {
      $allUrls[] = [
        'url' => trim($loc),
        'lastmod' => trim($lastmod) ?: date('Y-m-d')
      ];
    }
  }
  
  // Extract sitemapindex URLs
  $sitemapNodes = $xpath->query('//sitemapindex/sitemap');
  foreach ($sitemapNodes as $sitemapNode) {
    $loc = $xpath->evaluate('string(loc)', $sitemapNode);
    $lastmod = $xpath->evaluate('string(lastmod)', $sitemapNode);
    
    if ($loc && strpos($loc, 'sitemap-index.xml') === false) {
      $allUrls[] = [
        'url' => trim($loc),
        'lastmod' => trim($lastmod) ?: date('Y-m-d')
      ];
    }
  }
}

if (empty($allUrls)) {
  die("Error: No URLs found in sitemaps\n");
}

echo "Found " . count($allUrls) . " URLs\n";

// Write CSV/TSV
$fh = $gzip 
  ? gzopen($output.'.gz', 'wb9')
  : fopen($output, 'wb');

if (!$fh) {
  die("Error: Cannot open output file\n");
}

// Write header
writeRow($fh, $cols, $sep, $gzip);

// Write URLs
foreach ($allUrls as $url) {
  writeRow($fh, [$url['url'], $url['lastmod']], $sep, $gzip);
}

if ($gzip) {
  gzclose($fh);
  echo "✓ Generated: $output.gz (" . filesize($output.'.gz') . " bytes)\n";
} else {
  fclose($fh);
  echo "✓ Generated: $output (" . filesize($output) . " bytes)\n";
}

function writeRow($handle, array $fields, string $sep, bool $isGz): void {
  $escaped = array_map(function($v) {
    return '"' . str_replace('"', '""', $v) . '"';
  }, $fields);
  
  $line = implode($sep, $escaped) . "\n";
  
  $isGz ? gzwrite($handle, $line) : fwrite($handle, $line);
}

echo "\nDone!\n";



