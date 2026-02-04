<!-- Location Page -->
<div class="max-w-[85rem] mx-auto px-4 py-10 sm:px-6 lg:px-8 lg:py-14 pb-24 lg:pb-14">
    <!-- Hero Section -->
    <div class="max-w-2xl mx-auto text-center mb-10 lg:mb-14">
        <h1 class="text-3xl font-bold md:text-4xl md:leading-tight text-primary mb-4">
            <?= htmlspecialchars($productData['name']) ?> – <?= htmlspecialchars($cityName) ?>, FL
        </h1>
        <p class="mt-3 text-lg text-gray-600">
            Professional <?= htmlspecialchars($productData['name']) ?> installation in <?= htmlspecialchars($cityName) ?>, Florida. Fast installation, quality materials, local expertise.
        </p>
        <div class="mt-7 flex flex-col sm:flex-row gap-3 justify-center">
            <a class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-primary text-primary hover:bg-primary hover:text-white focus:outline-none focus:bg-primary focus:text-white transition-colors" href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>">
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                Get Free Quote
            </a>
            <a class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-accent text-white hover:bg-accent-600 focus:outline-none focus:bg-accent-600 transition-colors" href="<?= htmlspecialchars($productData['product_url']) ?>">
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                View Product Details
            </a>
        </div>
    </div>
    <!-- End Hero Section -->

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Location Overview -->
            <section class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl md:text-3xl font-bold text-primary mb-4">
                    <?= htmlspecialchars($cityName) ?> Flood Protection
                </h2>
                <p class="text-lg text-gray-700 mb-6 leading-relaxed">
                    Protect your <?= htmlspecialchars($cityName) ?> property with our professional <?= htmlspecialchars($productData['name']) ?> installation services. Our experienced team provides custom solutions tailored to your specific needs.
                </p>
                
                <div class="mt-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Why Choose Us in <?= htmlspecialchars($cityName) ?>?</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-x-3">
                            <svg class="shrink-0 size-5 text-primary mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            <span class="text-gray-700">Local expertise in <?= htmlspecialchars($cityName) ?> flood patterns</span>
                        </li>
                        <li class="flex items-start gap-x-3">
                            <svg class="shrink-0 size-5 text-primary mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            <span class="text-gray-700">Fast installation within 24-48 hours</span>
                        </li>
                        <li class="flex items-start gap-x-3">
                            <svg class="shrink-0 size-5 text-primary mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            <span class="text-gray-700">Free on-site assessment and quote</span>
                        </li>
                        <li class="flex items-start gap-x-3">
                            <svg class="shrink-0 size-5 text-primary mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            <span class="text-gray-700">Quality materials with 20+ year warranty</span>
                        </li>
                        <li class="flex items-start gap-x-3">
                            <svg class="shrink-0 size-5 text-primary mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            <span class="text-gray-700">Licensed and insured professionals</span>
                        </li>
                    </ul>
                </div>
            </section>
            <!-- End Location Overview -->
        </div>
        <!-- End Main Content -->

        <!-- Sidebar -->
        <aside class="lg:col-span-1">
            <div class="sticky top-24">
                <!-- Product Card -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <img class="w-full rounded-xl mb-4" src="<?= htmlspecialchars($productData['image']) ?>" alt="<?= htmlspecialchars($altTag ?? $productData['name']) ?>" />
                    <h3 class="text-xl font-bold text-gray-900 mb-2">
                        <?= htmlspecialchars($productData['name']) ?>
                    </h3>
                    <p class="text-gray-700 mb-4 leading-relaxed">
                        <?= htmlspecialchars($productData['description']) ?>
                    </p>
                    <div class="space-y-2 mb-6 pb-6 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-500">SKU:</span>
                            <span class="text-sm text-gray-800 font-semibold"><?= htmlspecialchars($productData['sku']) ?></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-500">Starting at:</span>
                            <span class="text-lg font-bold text-primary">$<?= htmlspecialchars($productData['starting_price']) ?></span>
                        </div>
                    </div>
                    <a href="<?= htmlspecialchars($productData['product_url']) ?>" class="inline-flex items-center justify-center gap-x-2 w-full py-3 px-4 text-sm font-medium rounded-lg border border-primary text-primary hover:bg-primary hover:text-white transition-colors">
                        View Full Product Details
                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                    </a>
                </div>
                <!-- End Product Card -->

                <!-- CTA Card -->
                <div class="mt-6 bg-gradient-to-br from-primary-600 to-primary border border-primary-600 rounded-xl p-6">
                    <h3 class="text-white font-bold text-lg mb-2">Need Help?</h3>
                    <p class="text-white/90 text-sm mb-4">Get a free assessment for your <?= htmlspecialchars($cityName) ?> property.</p>
                    <div class="flex flex-col gap-2">
                        <a class="inline-flex justify-center items-center gap-x-2 bg-white text-primary hover:bg-gray-100 font-semibold rounded-lg px-4 py-3 transition-colors" href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>">
                            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            Call Us
                        </a>
                        <a class="inline-flex justify-center items-center gap-x-2 bg-accent text-white hover:bg-accent-600 font-semibold rounded-lg px-4 py-3 transition-colors" href="<?= \App\Config::getSmsLink('Hi, I\'m interested in ' . $productData['name'] . ' for ' . $cityName . '.') ?>">
                            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                            Text Us
                        </a>
                    </div>
                </div>
                <!-- End CTA Card -->
            </div>
        </aside>
        <!-- End Sidebar -->
    </div>

    <!-- Local Service Areas -->
    <section class="mt-12 pt-8 border-t border-gray-200">
        <div class="text-center mb-8">
            <h2 class="text-2xl md:text-3xl font-bold text-primary mb-2">
                We Also Serve These <?= htmlspecialchars($cityName) ?> Areas
            </h2>
            <p class="text-gray-600">Professional flood protection services throughout Southwest Florida</p>
        </div>
        <div class="flex flex-wrap justify-center gap-3">
            <?php
            $nearbyAreas = [
                'fort-myers' => 'Fort Myers',
                'cape-coral' => 'Cape Coral', 
                'naples' => 'Naples',
                'bonita-springs' => 'Bonita Springs',
                'estero' => 'Estero',
                'punta-gorda' => 'Punta Gorda',
                'port-charlotte' => 'Port Charlotte',
                'sarasota' => 'Sarasota',
                'bradenton' => 'Bradenton',
                'st-petersburg' => 'St. Petersburg',
                'clearwater' => 'Clearwater',
                'tampa' => 'Tampa',
                'miami' => 'Miami',
                'miami-beach' => 'Miami Beach',
                'key-west' => 'Key West',
                'key-largo' => 'Key Largo'
            ];
            
            foreach ($nearbyAreas as $slug => $name):
                if ($slug !== $city):
            ?>
            <a href="/fl/<?= htmlspecialchars($slug) ?>/<?= htmlspecialchars($product) ?>" class="inline-flex items-center gap-x-1.5 py-2 px-4 rounded-full text-sm font-medium bg-gray-100 text-gray-700 hover:bg-primary hover:text-white transition-colors">
                <svg class="size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                <?= htmlspecialchars($name) ?>
            </a>
            <?php 
                endif;
            endforeach; 
            ?>
        </div>
    </section>
    <!-- End Local Service Areas -->

    <!-- CTA Section -->
    <section class="mt-12 bg-gradient-to-br from-primary-600 to-primary rounded-xl p-8 md:p-12 text-center">
        <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">
            Ready to Protect Your <?= htmlspecialchars($cityName) ?> Property?
        </h2>
        <p class="text-white/90 text-lg mb-6 max-w-2xl mx-auto">
            Get your free quote for <?= htmlspecialchars($productData['name']) ?> installation in <?= htmlspecialchars($cityName) ?> today.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-6">
            <div class="flex items-center gap-x-2 text-white/90">
                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                <a href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>" class="text-white hover:text-white/80 font-semibold">
                    <?= htmlspecialchars(\App\Config::get('phone')) ?>
                </a>
            </div>
            <div class="flex items-center gap-x-2 text-white/90">
                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                <a href="mailto:<?= htmlspecialchars(\App\Config::get('email')) ?>" class="text-white hover:text-white/80 font-semibold">
                    <?= htmlspecialchars(\App\Config::get('email')) ?>
                </a>
            </div>
            <div class="flex items-center gap-x-2 text-white/90">
                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                <span class="text-white font-semibold"><?= htmlspecialchars($cityName) ?>, Florida</span>
            </div>
        </div>
        <a href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>" class="inline-flex items-center gap-x-2 py-4 px-8 text-lg font-semibold rounded-lg bg-white text-primary hover:bg-gray-100 transition-colors">
            <svg class="size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            Call Now for Free Quote
        </a>
    </section>
    <!-- End CTA Section -->

    <!-- Mobile sticky CTA -->
    <div class="fixed bottom-0 left-0 right-0 z-40 lg:hidden bg-primary border-t border-primary-600 shadow-lg pb-4">
        <div class="flex gap-2 p-3">
            <a href="<?= \App\Config::getPhoneLink() ?>" class="flex-1 py-3 px-4 text-center text-sm font-semibold rounded-lg bg-white text-primary hover:bg-gray-100 transition-colors inline-flex items-center justify-center gap-x-2">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                Call Now
            </a>
            <a href="<?= \App\Config::getSmsLink('Hi, I\'m interested in ' . ($productData['name'] ?? 'flood barriers') . ' for ' . ($cityName ?? '') . '.') ?>" class="flex-1 py-3 px-4 text-center text-sm font-semibold rounded-lg bg-accent text-white hover:bg-accent-600 transition-colors inline-flex items-center justify-center gap-x-2">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                Get Quote
            </a>
        </div>
    </div>
</div>
<!-- End Location Page -->
