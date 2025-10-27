#!/usr/bin/env php
<?php
declare(strict_types=1);

/**
 * SIBDA Builder - CSV to NDJSON
 * Converts CSV sitemap to AI-ready NDJSON manifest
 */

$configFile = __DIR__.'/../config/dln.sibda.yml';

// Simple YAML parser (avoid composer dependency)
function parseYaml($file) {
  $content = file_get_contents($file);
  $config = [];
  foreach (explode("\n", $content) as $line) {
    if (preg_match('/^(\w+):\s*(.+)$/', $line, $m)) {
      $config[$m[1]] = trim($m[2], '" ');
    }
  }
  return $config;
}

$config = file_exists($configFile) ? parseYaml($configFile) : [];

$csvPath = $config['csv_in'] ?? __DIR__.'/../public/sitemaps/sitemap-optimized.csv';
$outPath = $config['ndjson_out'] ?? __DIR__.'/../public/sitemaps/sitemap-ai.ndjson';
$maxUrls = (int)($config['max_urls'] ?? 0);
$hasHeader = true;
$defaultType = $config['default_type'] ?? 'WebPage';

if (!is_readable($csvPath)) {
  fwrite(STDERR, "CSV not readable: $csvPath\n");
  exit(1);
}

$in  = fopen($csvPath, 'rb');
$out = fopen($outPath, 'wb');
if (!$in || !$out) {
  fwrite(STDERR, "Cannot open input or output.\n");
  exit(1);
}

// Parse CSV
$header = [];
if ($hasHeader) {
  $raw = fgetcsv($in, 0, ',', '"', '');
  if (is_array($raw)) {
    foreach ($raw as $i => $h) {
      $header[$i] = trim((string)$h);
    }
  }
}

$count = 0;
while (($row = fgetcsv($in, 0, ',')) !== false) {
  if (!count($row)) continue;

  $assoc = [];
  foreach ($row as $i => $val) {
    $key = $header[$i] ?? "col_$i";
    $assoc[trim((string)$key)] = trim((string)$val);
  }

  $url = $assoc['url'] ?? '';
  $lastmod = $assoc['lastmod'] ?? '';
  
  if ($url === '') continue;

  $obj = [
    "@id"          => $url,
    "@type"        => $defaultType,
    "headline"     => "",
    "summary"      => "",
    "keywords"     => [],
    "lastModified" => normalizeDate($lastmod),
    "contentHash"  => substr(sha1($url), 0, 12)
  ];

  fwrite($out, json_encode($obj, JSON_UNESCAPED_UNICODE) . "\n");
  $count++;
  
  if ($maxUrls > 0 && $count >= $maxUrls) break;
}

fclose($in);
fclose($out);

echo "WROTE: $outPath ($count rows)\n";

function normalizeDate(string $s): string {
  $s = trim($s);
  if ($s === '') return date('Y-m-d');
  $t = strtotime($s);
  return $t ? date('Y-m-d', $t) : date('Y-m-d');
}

