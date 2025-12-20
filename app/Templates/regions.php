<?php if (isset($regionData)): ?>
<!-- Single Region Page -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <header class="mb-8">
        <h1 class="text-3xl font-semibold text-gray-900 mb-3"><?= htmlspecialchars($regionData['region']) ?> Flood Protection — Engineered for Southwest Florida</h1>
        <p class="mt-2 text-gray-700">County: <?= htmlspecialchars($regionData['county']) ?> • Surge profile: <?= htmlspecialchars($regionData['surge_profile']) ?> • Focus: <?= htmlspecialchars($regionData['service_focus']) ?></p>
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
            <h3 class="font-semibold mb-2 text-gray-900">Rapid Facts — <?= htmlspecialchars($regionData['region']) ?></h3>
            <ul class="text-sm space-y-2 text-gray-700 mb-4">
                <li><strong>Notes:</strong> <?= htmlspecialchars($regionData['notes']) ?></li>
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

    <?php
    // Note: JSON-LD Schema is handled by the controller via $data['jsonld']
    // and output in the layout template to avoid duplication
    ?>
</div>
<?php else: ?>
<!-- Regions Index Page -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <h1 class="text-3xl font-semibold mb-6 text-gray-900">Southwest Florida Regions We Serve</h1>
    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-4">
        <?php if (isset($regionsList) && is_array($regionsList)): ?>
            <?php foreach($regionsList as $r): ?>
            <a class="block border rounded-2xl p-4 hover:bg-gray-50 shadow-sm bg-white transition hover:shadow-md" href="/regions/<?= htmlspecialchars($r['slug']) ?>/">
                <div class="font-medium text-gray-900"><?= htmlspecialchars($r['region']) ?></div>
                <div class="text-sm text-gray-600 mt-1"><?= htmlspecialchars($r['county']) ?> County • <?= htmlspecialchars($r['surge_profile']) ?></div>
            </a>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-gray-600">No regions data available.</p>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>