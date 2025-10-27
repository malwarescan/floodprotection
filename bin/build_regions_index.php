<?php
$csv = __DIR__.'/../data/swfl_regions.csv';
$outFile = __DIR__.'/../regions/index.php';
$rows=[]; 
if(($h=fopen($csv,'r'))!==false){ 
  $head=fgetcsv($h, 0, ',', '"', "\\"); 
  while(($r=fgetcsv($h, 0, ',', '"', "\\"))!==false){ 
    if(count($r) === count($head)) {
      $rows[]=array_combine($head,$r);
    }
  }
  fclose($h);
}

$html = <<<'PHP'
<?php
require_once __DIR__."/../includes/swfl-head.php";
require_once __DIR__."/../includes/swfl-nav.php";
require_once __DIR__."/../includes/swfl-footer.php";

$title="Southwest Florida Flood Protection Regions | Flood Barrier Pros";
$meta="Find engineered flood protection services across Southwest Florida: Collier, Lee, Charlotte, Hendry, Glades.";

require_once __DIR__."/../includes/swfl-head.php";
?>

<?php 
require_once __DIR__."/../includes/swfl-nav.php"; 
$allRegions = __ALL_REGIONS__;
regions_nav($allRegions); 
?>

<main class="max-w-6xl mx-auto px-4 py-8">
  <h1 class="text-3xl font-semibold mb-6 text-gray-900">Southwest Florida Regions We Serve</h1>
  <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-4">
    <?php foreach($allRegions as $r): ?>
      <a class="block border rounded-2xl p-4 hover:bg-gray-50 shadow-sm bg-white transition hover:shadow-md" href="/regions/<?= htmlspecialchars($r['slug']) ?>/">
        <div class="font-medium text-gray-900"><?= htmlspecialchars($r['region']) ?></div>
        <div class="text-sm text-gray-600 mt-1"><?= htmlspecialchars($r['county']) ?> County • <?= htmlspecialchars($r['surge_profile']) ?></div>
      </a>
    <?php endforeach; ?>
  </div>
</main>

<?php require_once __DIR__."/../includes/swfl-footer.php"; ?>

PHP;

$allRegionsPhp = var_export($rows, true);
$html = str_replace('__ALL_REGIONS__', $allRegionsPhp, $html);

file_put_contents($outFile, $html);
echo "Built regions/index.php\n";
