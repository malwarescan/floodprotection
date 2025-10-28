<!-- Regions Index Page Content -->
<?php 
require_once __DIR__."/../includes/swfl-nav.php"; 
regions_nav($regions); 
?>

<main class="max-w-6xl mx-auto px-4 py-8">
  <h1 class="text-3xl font-semibold mb-6 text-gray-900">Southwest Florida Regions We Serve</h1>
  <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-4">
    <?php foreach($regions as $r): ?>
      <a class="block border rounded-2xl p-4 hover:bg-gray-50 shadow-sm bg-white transition hover:shadow-md" href="/regions/<?= htmlspecialchars($r['slug']) ?>/">
        <div class="font-medium text-gray-900"><?= htmlspecialchars($r['region']) ?></div>
        <div class="text-sm text-gray-600 mt-1"><?= htmlspecialchars($r['county']) ?> County • <?= htmlspecialchars($r['surge_profile']) ?></div>
      </a>
    <?php endforeach; ?>
  </div>
</main>
