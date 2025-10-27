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
$allRegions = array (
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
);
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
