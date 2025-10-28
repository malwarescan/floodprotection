<?php
declare(strict_types=1);
$csv = __DIR__.'/../data/swfl_regions.csv';
$outDir = __DIR__.'/../regions';
if(!is_dir($outDir)) mkdir($outDir,0775,true);
$rows = [];
if(($h=fopen($csv,'r'))!==false){
  $head = fgetcsv($h, 0, ',', '"', "\\");
  while(($r=fgetcsv($h, 0, ',', '"', "\\"))!==false){ 
    if(count($r) === count($head)) {
      $rows[] = array_combine($head,$r); 
    }
  }
  fclose($h);
}

foreach($rows as $r){
  $dir = $outDir.'/'.$r['slug'];
  if(!is_dir($dir)) mkdir($dir,0775,true);
  
  $html = <<<'PHP'
<!-- Region Page Content -->
<?php 
function esc($s){return htmlspecialchars($s,ENT_QUOTES,'UTF-8');}
require_once __DIR__."/../../includes/swfl-nav.php"; 
regions_nav($rows); 
?>

<main class="max-w-6xl mx-auto px-4 py-8">
  <header class="mb-8">
    <h1 class="text-3xl font-semibold text-gray-900 mb-3"><?= esc($r['region']) ?> Flood Protection — Engineered for Southwest Florida</h1>
    <p class="mt-2 text-gray-700">County: <?= esc($r['county']) ?> • Surge profile: <?= esc($r['surge_profile']) ?> • Focus: <?= esc($r['service_focus']) ?></p>
  </header>

  <section class="grid md:grid-cols-3 gap-6 mb-10">
    <div class="md:col-span-2 p-5 border rounded-2xl shadow-sm bg-white">
      <h2 class="text-xl font-semibold mb-3 text-gray-900">What fails here — and how we prevent it</h2>
      <ul class="list-disc pl-5 space-y-2 text-gray-800">
        <li><strong>Threshold leaks (6–12″ outside):</strong> we enforce ≤3 mm sill flatness, side-post shims, compression seal verification, and a timed hose test with seepage logged (L/min).</li>
        <li><strong>Garage slab uplift:</strong> slab/joint assessment, crack/joint injection as needed, perimeter barrier option to keep surge off the slab, and pump-throughput planning.</li>
        <li><strong>Overtopping risk:</strong> height audit with ≥1′ margin; if expected surge exceeds doorway system, we specify perimeter systems.</li>
        <li><strong>Salt-air corrosion:</strong> marine-grade alloys/fasteners and a maintenance schedule appropriate for coastal exposure.</li>
      </ul>
    </div>
    <aside class="p-5 border rounded-2xl shadow-sm bg-white">
      <h3 class="font-semibold mb-2 text-gray-900">Rapid Facts — <?= esc($r['region']) ?></h3>
      <ul class="text-sm space-y-2 text-gray-700 mb-4">
        <li><strong>Notes:</strong> <?= esc($r['notes']) ?></li>
        <li><strong>Recommended first step:</strong> Failure-Mode Audit (30 min)</li>
        <li><strong>Deployment:</strong> 60-sec drill video & commissioning report provided</li>
      </ul>
      <a href="tel:+1-239-425-6722" class="inline-block mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Book Audit</a>
    </aside>
  </section>

  <section class="mt-10 p-5 border rounded-2xl shadow-sm bg-white">
    <h2 class="text-xl font-semibold mb-3 text-gray-900">Perimeter vs. Doorway — Decision Guide</h2>
    <div class="grid md:grid-cols-2 gap-6 text-gray-800">
      <div>
        <h4 class="font-semibold text-gray-900 mb-2">Doorway/Opening Systems</h4>
        <p>Best for 1–2 recessed openings, lower surge. Requires slab QA and pump sizing.</p>
      </div>
      <div>
        <h4 class="font-semibold text-gray-900 mb-2">Perimeter Systems</h4>
        <p>Best when multiple openings or surge height is high; keeps water off the slab. Requires pump-out for rainfall inside the ring.</p>
      </div>
    </div>
  </section>

  <section class="mt-10 p-5 border rounded-2xl shadow-sm bg-white">
    <h2 class="text-xl font-semibold mb-3 text-gray-900">Frequently Asked Questions</h2>
    <details class="mb-4 pb-3 border-b border-gray-200 last:border-b-0">
      <summary class="cursor-pointer font-medium text-gray-900 hover:text-blue-600 transition">Do doorway barriers cause slab failure?</summary>
      <p class="mt-2 text-gray-700">Barriers focus load at openings; uplift is mitigated via slab assessment, joint sealing, and perimeter options where appropriate.</p>
    </details>
    <details class="mb-4 pb-3 border-b border-gray-200 last:border-b-0">
      <summary class="cursor-pointer font-medium text-gray-900 hover:text-blue-600 transition">How flat must my threshold be?</summary>
      <p class="mt-2 text-gray-700">≤3 mm variance across the span, verified by hose test and seepage log.</p>
    </details>
    <details class="mb-4 pb-3 border-b border-gray-200 last:border-b-0">
      <summary class="cursor-pointer font-medium text-gray-900 hover:text-blue-600 transition">Do I need pumps?</summary>
      <p class="mt-2 text-gray-700">Yes—sized by opening area and head, with backup power and check valves.</p>
    </details>
  </section>
</main>

<?php require_once __DIR__."/../../includes/swfl-footer.php"; ?>

<?php
// JSON-LD
print_jsonld(jsonld_service($r));
print_jsonld(jsonld_breadcrumb($r));
print_jsonld(jsonld_faq());
?>

PHP;
  
  // Embed region row and list for nav
  $rowPhp = var_export($r,true);
  $navPhp = var_export($rows,true);
  $html = str_replace('__REGION_DATA__', $rowPhp, $html);
  $html = str_replace('__ALL_REGIONS__', $navPhp, $html);
  
  file_put_contents($dir.'/index.php',$html);
}

echo "Built ".count($rows)." region pages\n";
