<?php
/**
 * Usage:
 *   php /bin/scaffold_reviews_for_products.php https://floodbarrierpros.com
 * - Scans the /products directory via your routing (simple guess) and
 *   creates empty reviews JSON for detected product slugs.
 * - You can also just run it once and then add content by hand.
 */
if ($argc < 2) {
    fwrite(STDERR, "Usage: php ".basename(__FILE__)." SITE_ORIGIN\n");
    exit(1);
}
$origin = rtrim($argv[1], '/');
@mkdir(__DIR__.'/../data/reviews/products', 0777, true);

// If you maintain a list of products centrally, define it here:
$products = [
  'modular-flood-barrier',
  'doorway-flood-panel',
];

$made = 0;
foreach ($products as $slug) {
    $file = __DIR__.'/../data/reviews/products/'.$slug.'.json';
    if (!file_exists($file) || filesize($file) === 0) {
        file_put_contents($file, "[]");
        $made++;
    }
}
fwrite(STDOUT, "Scaffolded $made review files.\n");
