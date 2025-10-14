<!-- Testimonials Page -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <!-- Title -->
    <div class="max-w-2xl mx-auto text-center mb-10 lg:mb-14">
        <h1 class="text-3xl font-bold md:text-4xl md:leading-tight text-primary">Customer Testimonials</h1>
        <p class="mt-3 text-gray-600">Real homeowner reviews of our USA-made flood barriers and door/garage dams.</p>
    </div>
    <!-- End Title -->

    <!-- Filters -->
    <div class="max-w-4xl mx-auto mb-10">
        <form method="get" action="/testimonials" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <select name="sku" class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none">
                <option value="">All SKUs</option>
                <?php foreach ($skus as $s): ?>
                    <option value="<?= htmlspecialchars($s) ?>" <?= $filters['sku'] === $s ? 'selected' : '' ?>><?= htmlspecialchars($s) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="city" class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none">
                <option value="">All Cities</option>
                <?php foreach ($cities as $c): ?>
                    <option value="<?= htmlspecialchars($c) ?>" <?= $filters['city'] === $c ? 'selected' : '' ?>><?= htmlspecialchars($c) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="min_rating" class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none">
                <option value="0" <?= $filters['minRating'] == 0 ? 'selected' : '' ?>>All ratings</option>
                <option value="5" <?= $filters['minRating'] == 5 ? 'selected' : '' ?>>5 stars</option>
                <option value="4" <?= $filters['minRating'] == 4 ? 'selected' : '' ?>>4+ stars</option>
                <option value="3" <?= $filters['minRating'] == 3 ? 'selected' : '' ?>>3+ stars</option>
            </select>
            <input type="search" name="q" placeholder="Search comments…" value="<?= htmlspecialchars($filters['q'] ?? '') ?>" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"/>
            <button type="submit" class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-primary text-white hover:bg-primary-600 focus:outline-none focus:bg-primary-600 disabled:opacity-50 disabled:pointer-events-none">Apply</button>
        </form>
    </div>
    <!-- End Filters -->

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
                <div class="mt-auto pt-4 border-t border-gray-200">
                    <div class="text-sm text-gray-500">
                        SKU: <a href="/testimonials/<?= urlencode($r['sku']) ?>" class="text-primary hover:text-primary-600 font-medium"><?= htmlspecialchars($r['sku']) ?></a>
                    </div>
                </div>
            </div>
            <!-- End Card -->
        <?php endforeach; ?>
    </div>
    <!-- End Testimonials Grid -->

    <!-- Pagination -->
    <?php if ($pages > 1): ?>
        <div class="mt-10 flex justify-center">
            <nav class="flex items-center gap-x-1">
                <?php for ($i = 1; $i <= $pages; $i++):
                    $qs = $_GET;
                    $qs['page'] = $i;
                    $href = '/testimonials?' . http_build_query($qs);
                    ?>
                    <a class="<?= $i === $page ? 'py-2 px-3 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-primary text-white hover:bg-primary-600 focus:outline-none focus:bg-primary-600' : 'py-2 px-3 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50 focus:outline-none focus:bg-gray-50' ?>" href="<?= htmlspecialchars($href) ?>"><?= $i ?></a>
                <?php endfor; ?>
            </nav>
        </div>
    <?php endif; ?>
    <!-- End Pagination -->
</div>
<!-- End Testimonials Page -->
