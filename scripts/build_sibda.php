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

// Load matrix.csv for cost/timing data enrichment
$matrixPath = __DIR__.'/../app/Data/matrix.csv';
$matrixData = [];
if (is_readable($matrixPath)) {
  $matrixFile = fopen($matrixPath, 'rb');
  if ($matrixFile) {
    $matrixHeader = fgetcsv($matrixFile, 0, ',', '"', '');
    while (($row = fgetcsv($matrixFile, 0, ',', '"', '\\')) !== false) {
      if (count($row) !== count($matrixHeader)) continue;
      $matrixRow = array_combine($matrixHeader, $row);
      $urlPath = trim($matrixRow['url_path'] ?? '');
      if ($urlPath) {
        $matrixData[$urlPath] = $matrixRow;
      }
    }
    fclose($matrixFile);
  }
}

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
while (($row = fgetcsv($in, 0, ',', '"', '\\')) !== false) {
  if (!count($row)) continue;

  $assoc = [];
  foreach ($row as $i => $val) {
    $key = $header[$i] ?? "col_$i";
    $assoc[trim((string)$key)] = trim((string)$val);
  }

  $url = $assoc['url'] ?? '';
  $lastmod = $assoc['lastmod'] ?? '';
  
  if ($url === '') continue;

  // Extract URL path to match with matrix.csv
  $urlPath = parse_url($url, PHP_URL_PATH) ?? '';
  $matrixRow = $matrixData[$urlPath] ?? null;

  $obj = [
    "@id"          => $url,
    "@type"        => $defaultType,
    "headline"     => "",
    "summary"      => "",
    "keywords"     => [],
    "lastModified" => normalizeDate($lastmod),
    "contentHash"  => substr(sha1($url), 0, 12)
  ];

  // Add cost and timing data if available from matrix.csv
  if ($matrixRow) {
    $priceMin = trim($matrixRow['product_price_min'] ?? '');
    $priceMax = trim($matrixRow['product_price_max'] ?? '');
    $currency = trim($matrixRow['product_currency'] ?? 'USD');
    
    if ($priceMin && $priceMax) {
      // Format cost values with $ symbol and thousand separators
      $min = (int)$priceMin;
      $max = (int)$priceMax;
      $obj["cost_range"] = "$" . number_format($min) . "-$" . number_format($max);
      
      // Calculate p50 and p90 estimates
      $p50 = (int)(($min + $max) / 2);
      $p90 = (int)($min + ($max - $min) * 0.9);
      $obj["cost_p50"] = "$" . number_format($p50);
      $obj["cost_p90"] = "$" . number_format($p90);
      
      // Add currency as separate field
      $obj["cost_currency"] = $currency;
    }
    
    // Add best season (before hurricane season in Florida)
    $obj["best_season"] = "April-May (before hurricane season)";
    
    // Add typical installation duration
    $obj["typical_duration"] = "1-2 days installation";
    
    // Add city/location context if available
    $city = trim($matrixRow['city'] ?? '');
    if ($city) {
      $obj["location"] = $city . ", FL";
    }
  }

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

