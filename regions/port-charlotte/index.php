<?php
require_once __DIR__."/../../includes/swfl-head.php";
require_once __DIR__."/../../includes/swfl-nav.php";
require_once __DIR__."/../../includes/swfl-footer.php";
require_once __DIR__."/../../lib/swfl-schema.php";

$r = array (
  'region' => 'Port Charlotte',
  'slug' => 'port-charlotte',
  'county' => 'Charlotte',
  'state' => 'FL',
  'notes' => 'Charlotte Harbor; canals',
  'surge_profile' => 'Back-bay surge; brackish',
  'service_focus' => 'Perimeter + backflow valves',
  'priority' => '1',
);
$title = $r['region']." Flood Barriers, Perimeter Systems & Pump Plans | Flood Barrier Pros";
$meta  = "Engineered flood protection in ".$r['region'].": door plugs, perimeter barriers, slab uplift mitigation, and pump sizing. County: ".$r['county'].".";

require_once __DIR__."/../../includes/swfl-head.php";
?>

<?php require_once __DIR__."/../../includes/swfl-nav.php"; regions_nav(array (
  0 => 
  array (
    'region' => 'Naples',
    'slug' => 'naples',
    'county' => 'Collier',
    'state' => 'FL',
    'notes' => 'Gulf-front & bayside; older slabs + luxury builds',
    'surge_profile' => '3–5 ft surge zones; wave setup in openings',
    'service_focus' => 'Perimeter barriers + garage/slab QA + pump plan',
    'priority' => '1',
  ),
  1 => 
  array (
    'region' => 'Marco Island',
    'slug' => 'marco-island',
    'county' => 'Collier',
    'state' => 'FL',
    'notes' => 'Bridges + canals; salt-corrosion risk',
    'surge_profile' => '3–6 ft; canal backflow + wind fetch',
    'service_focus' => 'Perimeter systems, marine-grade hardware',
    'priority' => '1',
  ),
  2 => 
  array (
    'region' => 'Bonita Springs',
    'slug' => 'bonita-springs',
    'county' => 'Lee',
    'state' => 'FL',
    'notes' => 'Imperial River + Gulf access',
    'surge_profile' => 'Riverine + surge mix',
    'service_focus' => 'Door plugs for single openings; perimeter near river',
    'priority' => '2',
  ),
  3 => 
  array (
    'region' => 'Estero',
    'slug' => 'estero',
    'county' => 'Lee',
    'state' => 'FL',
    'notes' => 'Low-lying pockets; new builds',
    'surge_profile' => 'Sheet flow + pond overflow',
    'service_focus' => 'Door plugs + drainage/pump upgrades',
    'priority' => '2',
  ),
  4 => 
  array (
    'region' => 'Fort Myers',
    'slug' => 'fort-myers',
    'county' => 'Lee',
    'state' => 'FL',
    'notes' => 'Downtown & riverfront; mixed ages',
    'surge_profile' => 'Caloosahatchee riverine + wind-push',
    'service_focus' => 'Perimeter for multi-openings; slab uplift mitigation',
    'priority' => '1',
  ),
  5 => 
  array (
    'region' => 'Cape Coral',
    'slug' => 'cape-coral',
    'county' => 'Lee',
    'state' => 'FL',
    'notes' => 'Canal grid; lock effects; salt spray',
    'surge_profile' => 'Backflow via canals + wind-driven rain',
    'service_focus' => 'Backflow valves + perimeter near canals',
    'priority' => '1',
  ),
  6 => 
  array (
    'region' => 'Lehigh Acres',
    'slug' => 'lehigh-acres',
    'county' => 'Lee',
    'state' => 'FL',
    'notes' => 'Inland; sheet flow; new slabs',
    'surge_profile' => 'Pond overflow; intense rainfall',
    'service_focus' => 'Threshold sealing + pump sizing',
    'priority' => '3',
  ),
  7 => 
  array (
    'region' => 'Sanibel',
    'slug' => 'sanibel',
    'county' => 'Lee',
    'state' => 'FL',
    'notes' => 'Barrier island; turtle regs; high corrosion',
    'surge_profile' => 'High surge + waves + debris',
    'service_focus' => 'Perimeter systems; height margin ≥1\'',
    'priority' => '1',
  ),
  8 => 
  array (
    'region' => 'Captiva',
    'slug' => 'captiva',
    'county' => 'Lee',
    'state' => 'FL',
    'notes' => 'Barrier island; luxury builds',
    'surge_profile' => 'Extreme surge/wave impacts',
    'service_focus' => 'Perimeter; storage/deployment plans',
    'priority' => '1',
  ),
  9 => 
  array (
    'region' => 'Fort Myers Beach',
    'slug' => 'fort-myers-beach',
    'county' => 'Lee',
    'state' => 'FL',
    'notes' => 'Rebuilds; mixed foundations',
    'surge_profile' => 'High surge; scouring',
    'service_focus' => 'Perimeter + elevation guidance',
    'priority' => '1',
  ),
  10 => 
  array (
    'region' => 'North Fort Myers',
    'slug' => 'north-fort-myers',
    'county' => 'Lee',
    'state' => 'FL',
    'notes' => 'River-adjacent; older slabs',
    'surge_profile' => 'Riverine surges; seepage under slabs',
    'service_focus' => 'Slab QA + joint sealing + pumps',
    'priority' => '2',
  ),
  11 => 
  array (
    'region' => 'Pine Island',
    'slug' => 'pine-island',
    'county' => 'Lee',
    'state' => 'FL',
    'notes' => 'Matlacha/Bokeelia/St. James',
    'surge_profile' => 'Open fetch; debris risk',
    'service_focus' => 'Perimeter + rigid panels',
    'priority' => '1',
  ),
  12 => 
  array (
    'region' => 'Matlacha',
    'slug' => 'matlacha',
    'county' => 'Lee',
    'state' => 'FL',
    'notes' => 'Low bridges; tidal squeeze',
    'surge_profile' => 'Fast-rising surge',
    'service_focus' => 'Rapid-deploy perimeter + pump-out',
    'priority' => '1',
  ),
  13 => 
  array (
    'region' => 'Bokeelia',
    'slug' => 'bokeelia',
    'county' => 'Lee',
    'state' => 'FL',
    'notes' => 'Northern tip exposure',
    'surge_profile' => 'Wind/wave setup',
    'service_focus' => 'Perimeter height audit',
    'priority' => '2',
  ),
  14 => 
  array (
    'region' => 'St. James City',
    'slug' => 'st-james-city',
    'county' => 'Lee',
    'state' => 'FL',
    'notes' => 'South exposure',
    'surge_profile' => 'Wave impacts',
    'service_focus' => 'Perimeter + anchoring QA',
    'priority' => '2',
  ),
  15 => 
  array (
    'region' => 'Port Charlotte',
    'slug' => 'port-charlotte',
    'county' => 'Charlotte',
    'state' => 'FL',
    'notes' => 'Charlotte Harbor; canals',
    'surge_profile' => 'Back-bay surge; brackish',
    'service_focus' => 'Perimeter + backflow valves',
    'priority' => '1',
  ),
  16 => 
  array (
    'region' => 'Punta Gorda',
    'slug' => 'punta-gorda',
    'county' => 'Charlotte',
    'state' => 'FL',
    'notes' => 'Harborfront rebuilds',
    'surge_profile' => 'Harbor surge + riverine',
    'service_focus' => 'Door plugs on single points; perimeter downtown',
    'priority' => '1',
  ),
  17 => 
  array (
    'region' => 'Rotonda West',
    'slug' => 'rotonda-west',
    'county' => 'Charlotte',
    'state' => 'FL',
    'notes' => 'Platted inland; ponds',
    'surge_profile' => 'Sheet flow; pond overtop',
    'service_focus' => 'Threshold sealing + pumps',
    'priority' => '3',
  ),
  18 => 
  array (
    'region' => 'Englewood',
    'slug' => 'englewood',
    'county' => 'Charlotte',
    'state' => 'FL',
    'notes' => 'Gulf + Lemon Bay',
    'surge_profile' => 'Barrier+bay surge',
    'service_focus' => 'Perimeter + corrosion plan',
    'priority' => '2',
  ),
  19 => 
  array (
    'region' => 'Golden Gate',
    'slug' => 'golden-gate',
    'county' => 'Collier',
    'state' => 'FL',
    'notes' => 'Drainage canals',
    'surge_profile' => 'Canal backflow',
    'service_focus' => 'Backflow valves + door plugs',
    'priority' => '3',
  ),
  20 => 
  array (
    'region' => 'Immokalee',
    'slug' => 'immokalee',
    'county' => 'Collier',
    'state' => 'FL',
    'notes' => 'Inland; heavy rain',
    'surge_profile' => 'Sheet flow',
    'service_focus' => 'Thresholds + pumps',
    'priority' => '3',
  ),
  21 => 
  array (
    'region' => 'Goodland',
    'slug' => 'goodland',
    'county' => 'Collier',
    'state' => 'FL',
    'notes' => 'Extreme low elevation',
    'surge_profile' => 'Frequent surge',
    'service_focus' => 'Perimeter + elevation counseling',
    'priority' => '1',
  ),
  22 => 
  array (
    'region' => 'North Naples',
    'slug' => 'north-naples',
    'county' => 'Collier',
    'state' => 'FL',
    'notes' => 'Gulf-front condos; HOAs',
    'surge_profile' => 'Garage openings; salt',
    'service_focus' => 'Rigid panels + pump rooms',
    'priority' => '2',
  ),
  23 => 
  array (
    'region' => 'Vineyards',
    'slug' => 'vineyards',
    'county' => 'Collier',
    'state' => 'FL',
    'notes' => 'Master-planned',
    'surge_profile' => 'Pond/road overflow',
    'service_focus' => 'Door plugs + HOA coordination',
    'priority' => '3',
  ),
  24 => 
  array (
    'region' => 'Ave Maria',
    'slug' => 'ave-maria',
    'county' => 'Collier',
    'state' => 'FL',
    'notes' => 'Inland new builds',
    'surge_profile' => 'Heavy rain; sheet flow',
    'service_focus' => 'Threshold QA + pump sizing',
    'priority' => '3',
  ),
  25 => 
  array (
    'region' => 'Labelle',
    'slug' => 'labelle',
    'county' => 'Hendry',
    'state' => 'FL',
    'notes' => 'Caloosahatchee inland',
    'surge_profile' => 'River rise',
    'service_focus' => 'Backflow + door sealing',
    'priority' => '3',
  ),
  26 => 
  array (
    'region' => 'Clewiston',
    'slug' => 'clewiston',
    'county' => 'Hendry',
    'state' => 'FL',
    'notes' => 'Lake Okeechobee prox',
    'surge_profile' => 'Lake surge wind setup',
    'service_focus' => 'Perimeter planning',
    'priority' => '3',
  ),
  27 => 
  array (
    'region' => 'Moore Haven',
    'slug' => 'moore-haven',
    'county' => 'Glades',
    'state' => 'FL',
    'notes' => 'River/lake junction',
    'surge_profile' => 'Backwater rise',
    'service_focus' => 'Backflow + perimeter',
    'priority' => '3',
  ),
  28 => 
  array (
    'region' => 'Everglades City',
    'slug' => 'everglades-city',
    'county' => 'Collier',
    'state' => 'FL',
    'notes' => 'Historic; very low',
    'surge_profile' => 'Frequent surge + debris',
    'service_focus' => 'Perimeter + rigid panels + elevation',
    'priority' => '1',
  ),
  29 => 
  array (
    'region' => 'Chokoloskee',
    'slug' => 'chokoloskee',
    'county' => 'Collier',
    'state' => 'FL',
    'notes' => 'Islet community',
    'surge_profile' => 'Extreme surge',
    'service_focus' => 'Perimeter + elevation',
    'priority' => '1',
  ),
  30 => 
  array (
    'region' => 'Tamiami',
    'slug' => 'tamiami',
    'county' => 'Collier',
    'state' => 'FL',
    'notes' => 'US-41 corridor',
    'surge_profile' => 'Roadway sheet flow',
    'service_focus' => 'Thresholds + trench drains',
    'priority' => '3',
  ),
)); ?>

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
