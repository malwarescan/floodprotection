<section class="py-12 md:py-16 bg-white">
    <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
        <header class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Flood Protection Resources & Guides</h1>
            <p class="text-lg text-gray-600">Expert answers to common questions about flood barriers, installation, and protection</p>
        </header>

        <?php if (!empty($topics) && is_array($topics)): ?>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            <?php foreach ($topics as $topic): ?>
            <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
                <h2 class="text-xl font-semibold text-gray-900 mb-2"><?= htmlspecialchars($topic['name']) ?></h2>
                <p class="text-gray-600 text-sm mb-4"><?= $topic['count'] ?> resource<?= $topic['count'] !== 1 ? 's' : '' ?> available</p>
                <a href="/resources/<?= htmlspecialchars($topic['slug']) ?>" class="inline-flex items-center text-primary hover:text-primary-600 font-medium">
                    Browse Resources
                    <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="text-center py-12">
            <p class="text-gray-600">Resources are being added. Check back soon!</p>
        </div>
        <?php endif; ?>

        <div class="bg-gray-50 rounded-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 text-center">Can't Find What You're Looking For?</h2>
            <p class="text-gray-600 text-center mb-6">Our flood protection experts are here to help. Get personalized answers to your questions.</p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>" class="inline-flex items-center justify-center px-8 py-3 bg-primary text-white font-medium rounded-lg hover:bg-primary-600 transition-colors">
                    Call <?= htmlspecialchars(\App\Config::get('phone')) ?>
                </a>
                <a href="/contact" class="inline-flex items-center justify-center px-8 py-3 border-2 border-primary text-primary font-medium rounded-lg hover:bg-primary hover:text-white transition-colors">
                    Contact Us
                </a>
            </div>
        </div>
    </div>
</section>

