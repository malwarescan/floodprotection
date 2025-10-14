<!-- Product Testimonials Page -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <!-- Title -->
    <div class="max-w-2xl mx-auto text-center mb-10 lg:mb-14">
        <h1 class="text-3xl font-bold md:text-4xl md:leading-tight text-primary"><?= htmlspecialchars($productName) ?> — Customer Testimonials</h1>
        <p class="mt-3 text-gray-600">Average rating <?= htmlspecialchars($avg) ?>/5 from <?= htmlspecialchars($count) ?> reviews.</p>
        <p class="mt-2 text-lg font-semibold text-accent">Starting at $1,499 USD</p>
        
        <!-- CTA Buttons -->
        <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
            <a href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>" class="py-3 px-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-primary text-white hover:bg-primary-600 focus:outline-none focus:bg-primary-600 disabled:opacity-50 disabled:pointer-events-none">
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                Get a Free Quote
            </a>
            <a href="/testimonials" class="py-3 px-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none">
                All testimonials
            </a>
        </div>
    </div>
    <!-- End Title -->

    <!-- Testimonials Grid -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($reviews as $r): ?>
            <!-- Card -->
            <div id="<?= htmlspecialchars($r['review_id']) ?>" class="group flex flex-col h-full bg-white border border-gray-200 hover:border-transparent hover:shadow-lg focus:outline-none focus:border-transparent focus:shadow-lg transition duration-300 rounded-xl p-6">
                <div class="my-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-3"><?= htmlspecialchars($r['title']) ?></h3>
                    <div class="flex items-center gap-x-3 mb-3">
                        <div class="flex items-center" aria-label="<?= (int)$r['rating'] ?> out of 5 stars">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <svg class="size-4 <?= $i <= (int)$r['rating'] ? 'text-yellow-400' : 'text-gray-300' ?>" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                </svg>
                            <?php endfor; ?>
                        </div>
                        <span class="inline-flex items-center gap-x-1.5 py-1 px-2 rounded-full text-xs font-medium bg-primary/10 text-primary">
                            <?= htmlspecialchars($r['author']) ?>
                        </span>
                        <span class="text-xs text-gray-500"><?= htmlspecialchars($r['date']) ?></span>
                    </div>
                    <p class="text-gray-600"><?= htmlspecialchars($r['body']) ?></p>
                </div>
            </div>
            <!-- End Card -->
        <?php endforeach; ?>
    </div>
    <!-- End Testimonials Grid -->
</div>
<!-- End Product Testimonials Page -->
