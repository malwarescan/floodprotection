<!-- Hero Section -->
<div class="max-w-[85rem] mx-auto px-4 py-10 sm:px-6 lg:px-8 lg:py-14">
    <div class="max-w-2xl mx-auto text-center mb-10 lg:mb-14">
        <h1 class="text-3xl font-bold md:text-4xl md:leading-tight text-primary">Modular Flood Barrier System</h1>
        <p class="mt-3 text-gray-600">Rapid-deploy modular flood barriers made from 6063 T-6 aluminum with EPDM sealing. Quick installation, no sandbags, minimal cleanup.</p>
        <div class="mt-7 flex flex-col sm:flex-row gap-3 justify-center">
            <a class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-primary text-primary hover:bg-primary hover:text-white focus:outline-none focus:bg-primary focus:text-white transition-colors" href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>">
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                Get Free Quote
            </a>
            <a class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-accent text-white hover:bg-accent-600 focus:outline-none focus:bg-accent-600 transition-colors" href="/testimonials">
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 10v12"/><path d="M15 5.88 14 10h5.83a2 2 0 0 1 1.92 2.56l-2.33 8A2 2 0 0 1 17.5 22H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2.76a2 2 0 0 0 1.79-1.11L12 2h0a3.13 3.13 0 0 1 3 3.88Z"/></svg>
                Read Reviews
            </a>
        </div>
    </div>
</div>

<!-- Product Overview -->
<div class="max-w-[85rem] mx-auto px-4 py-10 sm:px-6 lg:px-8 lg:py-14">
    <div class="grid lg:grid-cols-2 gap-8 lg:gap-12">
        <!-- Product Image -->
        <div class="lg:self-end">
            <img class="w-full rounded-xl" src="<?= htmlspecialchars($product['image'][0]) ?>" alt="Modular Flood Barrier System" />
        </div>
        <!-- End Product Image -->

        <!-- Product Details -->
        <div class="mt-5 lg:mt-0">
            <div class="space-y-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Product Specifications</h2>
                    <div class="mt-5 space-y-3">
                        <div class="flex items-center gap-x-3">
                            <span class="text-sm font-medium text-gray-500">SKU:</span>
                            <span class="text-sm text-gray-800"><?= htmlspecialchars($product['sku']) ?></span>
                        </div>
                        <div class="flex items-center gap-x-3">
                            <span class="text-sm font-medium text-gray-500">Material:</span>
                            <span class="text-sm text-gray-800"><?= htmlspecialchars($product['material']) ?></span>
                        </div>
                        <div class="flex items-center gap-x-3">
                            <span class="text-sm font-medium text-gray-500">System Depth:</span>
                            <span class="text-sm text-gray-800">3.54 in (9 cm)</span>
                        </div>
                        <div class="flex items-center gap-x-3">
                            <span class="text-sm font-medium text-gray-500">System Width:</span>
                            <span class="text-sm text-gray-800">2.36 in (6 cm)</span>
                        </div>
                        <div class="flex items-center gap-x-3">
                            <span class="text-sm font-medium text-gray-500">System Weight:</span>
                            <span class="text-sm text-gray-800">2.72 lb/ft</span>
                        </div>
                        <div class="flex items-center gap-x-3">
                            <span class="text-sm font-medium text-gray-500">Wall Thickness:</span>
                            <span class="text-sm text-gray-800">0.015 in (3.8 mm)</span>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-xl font-bold text-primary">Starting at $1,499</h3>
                    <p class="mt-2 text-gray-600">Custom pricing based on your specific requirements</p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <a class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-primary text-white hover:bg-primary-600 focus:outline-none focus:bg-primary-600 transition-colors" href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        Call for Quote
                    </a>
                    <a class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 text-gray-800 hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition-colors" href="mailto:<?= htmlspecialchars(\App\Config::get('email')) ?>">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        Email Us
                    </a>
                </div>
            </div>
        </div>
        <!-- End Product Details -->
    </div>
</div>

<!-- Features Section -->
<div class="max-w-[85rem] mx-auto px-4 py-10 sm:px-6 lg:px-8 lg:py-14">
    <div class="max-w-2xl mx-auto text-center mb-10 lg:mb-14">
        <h2 class="text-3xl font-bold md:text-4xl md:leading-tight text-primary">Why Choose Our Modular Flood Barrier System?</h2>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Feature Card -->
        <div class="flex flex-col bg-white border border-gray-200 rounded-xl p-4 md:p-6">
            <div class="flex justify-center items-center size-12 bg-primary/10 rounded-lg mb-4">
                <svg class="size-6 text-primary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="M19 9l-5 5-4-4-3 3"/></svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Rapid Deployment</h3>
            <p class="text-gray-600">Quick installation without the need for sandbags or heavy equipment. Deploy in minutes, not hours.</p>
        </div>
        <!-- End Feature Card -->

        <!-- Feature Card -->
        <div class="flex flex-col bg-white border border-gray-200 rounded-xl p-4 md:p-6">
            <div class="flex justify-center items-center size-12 bg-primary/10 rounded-lg mb-4">
                <svg class="size-6 text-primary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14,2 14,8 20,8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><polyline points="10,9 9,9 8,9"/></svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">6063 T-6 Aluminum</h3>
            <p class="text-gray-600">High-strength aluminum construction that won't rust or corrode, ensuring long-lasting protection.</p>
        </div>
        <!-- End Feature Card -->

        <!-- Feature Card -->
        <div class="flex flex-col bg-white border border-gray-200 rounded-xl p-4 md:p-6">
            <div class="flex justify-center items-center size-12 bg-primary/10 rounded-lg mb-4">
                <svg class="size-6 text-primary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">EPDM Sealing</h3>
            <p class="text-gray-600">Premium EPDM rubber sealing creates watertight barriers that keep floodwaters out effectively.</p>
        </div>
        <!-- End Feature Card -->

        <!-- Feature Card -->
        <div class="flex flex-col bg-white border border-gray-200 rounded-xl p-4 md:p-6">
            <div class="flex justify-center items-center size-12 bg-primary/10 rounded-lg mb-4">
                <svg class="size-6 text-primary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27,6.96 12,12.01 20.73,6.96"/><line x1="12" x2="12" y1="22.08" y2="12"/></svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Reusable Design</h3>
            <p class="text-gray-600">Clean up and store for future use. No waste, no mess, just reliable protection when you need it.</p>
        </div>
        <!-- End Feature Card -->
    </div>
</div>

<!-- Reviews Section -->
<div class="max-w-[85rem] mx-auto px-4 py-10 sm:px-6 lg:px-8 lg:py-14">
    <div class="max-w-2xl mx-auto text-center mb-10 lg:mb-14">
        <h2 class="text-3xl font-bold md:text-4xl md:leading-tight text-primary">Customer Reviews</h2>
        <p class="mt-3 text-gray-600">Average rating: 4.7 (6 reviews)</p>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Review Card -->
        <article class="flex flex-col bg-white border border-gray-200 rounded-xl p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Excellent flood protection</h3>
            <p class="text-sm text-gray-600 mb-3"><strong>John Smith</strong> · 2024-12-15 · ★★★★★</p>
            <p class="text-gray-600">These barriers saved our home during the last hurricane. Easy to install and very effective.</p>
        </article>
        <!-- End Review Card -->

        <!-- Review Card -->
        <article class="flex flex-col bg-white border border-gray-200 rounded-xl p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Good quality product</h3>
            <p class="text-sm text-gray-600 mb-3"><strong>Sarah Johnson</strong> · 2024-12-10 · ★★★★☆</p>
            <p class="text-gray-600">Works as advertised. Installation was straightforward and the materials feel durable.</p>
        </article>
        <!-- End Review Card -->

        <!-- Review Card -->
        <article class="flex flex-col bg-white border border-gray-200 rounded-xl p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Outstanding customer service</h3>
            <p class="text-sm text-gray-600 mb-3"><strong>Mike Rodriguez</strong> · 2024-12-08 · ★★★★★</p>
            <p class="text-gray-600">Great product and even better support. They helped us choose the right size and installation was quick.</p>
        </article>
        <!-- End Review Card -->

        <!-- Review Card -->
        <article class="flex flex-col bg-white border border-gray-200 rounded-xl p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Outstanding product</h3>
            <p class="text-sm text-gray-600 mb-3"><strong>Michelle Lee</strong> · 2024-11-02 · ★★★★★</p>
            <p class="text-gray-600">These barriers are incredibly effective. Our home stayed completely dry.</p>
        </article>
        <!-- End Review Card -->

        <!-- Review Card -->
        <article class="flex flex-col bg-white border border-gray-200 rounded-xl p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Good value</h3>
            <p class="text-sm text-gray-600 mb-3"><strong>Mark Harris</strong> · 2024-10-30 · ★★★★☆</p>
            <p class="text-gray-600">Quality product at a fair price. Installation was quick and easy.</p>
        </article>
        <!-- End Review Card -->

        <!-- Review Card -->
        <article class="flex flex-col bg-white border border-gray-200 rounded-xl p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Highly recommend</h3>
            <p class="text-sm text-gray-600 mb-3"><strong>Nancy Clark</strong> · 2024-10-28 · ★★★★★</p>
            <p class="text-gray-600">Excellent product and service. Would definitely use again.</p>
        </article>
        <!-- End Review Card -->
    </div>
</div>

<!-- CTA Section -->
<div class="max-w-[85rem] mx-auto px-4 py-10 sm:px-6 lg:px-8 lg:py-14">
    <div class="max-w-2xl mx-auto text-center">
        <h2 class="text-3xl font-bold md:text-4xl md:leading-tight text-primary">Ready to Protect Your Property?</h2>
        <p class="mt-3 text-gray-600">Get your free quote for modular flood barrier installation today.</p>
        
        <div class="mt-8 space-y-4">
            <div class="flex items-center justify-center gap-x-3">
                <span class="text-sm font-medium text-gray-500">Phone:</span>
                <a class="text-sm text-primary hover:text-primary-600 transition-colors" href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>"><?= htmlspecialchars(\App\Config::get('phone')) ?></a>
            </div>
            <div class="flex items-center justify-center gap-x-3">
                <span class="text-sm font-medium text-gray-500">Email:</span>
                <a class="text-sm text-primary hover:text-primary-600 transition-colors" href="mailto:<?= htmlspecialchars(\App\Config::get('email')) ?>"><?= htmlspecialchars(\App\Config::get('email')) ?></a>
            </div>
        </div>

        <div class="mt-8">
            <a class="py-3 px-6 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-primary text-white hover:bg-primary-600 focus:outline-none focus:bg-primary-600 transition-colors" href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>">
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                Call Now for Free Quote
            </a>
        </div>
    </div>
</div>
