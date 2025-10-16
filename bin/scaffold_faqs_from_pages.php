<?php
/**
 * Usage:
 *   php /bin/scaffold_faqs_from_pages.php /absolute/path/to/pages.csv https://floodbarrierpros.com
 * - Reads a CSV with a "Top pages" column.
 * - Creates empty JSON files in /data/faqs/... per URL (never overwrites non-empty files).
 * - No public emission until you fill them with Q&A objects.
 */
if ($argc < 3) {
    fwrite(STDERR, "Usage: php ".basename(__FILE__)." PAGES_CSV SITE_ORIGIN\n");
    exit(1);
}
$csv = $argv[1];
$origin = rtrim($argv[2], '/');

if (!is_file($csv)) {
    fwrite(STDERR, "CSV not found: $csv\n");
    exit(1);
}
$fp = fopen($csv, 'r');
$headers = fgetcsv($fp);
if ($headers === false) exit(0);
$idx = array_search('Top pages', $headers);
if ($idx === false) {
    fwrite(STDERR, "Column 'Top pages' not found\n");
    exit(1);
}

@mkdir(__DIR__.'/../data/faqs/products', 0777, true);
@mkdir(__DIR__.'/../data/faqs/city/home-flood-barriers', 0777, true);
@mkdir(__DIR__.'/../data/faqs/city/residential-flood-panels', 0777, true);
@mkdir(__DIR__.'/../data/faqs/pages', 0777, true);

$count = 0;
while (($row = fgetcsv($fp)) !== false) {
    $url = $row[$idx] ?? '';
    if (strpos($url, $origin) !== 0) continue;
    $path = parse_url($url, PHP_URL_PATH) ?? '/';

    if (preg_match('#^/products/([^/]+)/?$#i', $path, $m)) {
        $slug = strtolower($m[1]);
        $file = __DIR__.'/../data/faqs/products/'.$slug.'.json';
    } elseif (preg_match('#^/(home-flood-barriers|residential-flood-panels)/([^/]+)/?$#i', $path, $m)) {
        $type = strtolower($m[1]); $city = strtolower($m[2]);
        $file = __DIR__."/../data/faqs/city/{$type}/{$city}.json";
    } else {
        $slug = trim(str_replace(['/','\\'], '__', trim($path, '/')), '_');
        if ($slug === '') $slug = 'home';
        $file = __DIR__.'/../data/faqs/pages/'.$slug.'.json';
    }

    if (!file_exists($file) || filesize($file) === 0) {
        file_put_contents($file, "[]");
        $count++;
    }
}
fclose($fp);
fwrite(STDOUT, "Scaffolded $count FAQ files.\n");
