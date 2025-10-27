<article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Header -->
        <header class="bg-gradient-to-r from-blue-600 to-blue-800 text-white p-8 md:p-12">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4 leading-tight">
                <?= htmlspecialchars($post['title']) ?>
            </h1>
            <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center text-blue-100">
                <time datetime="<?= htmlspecialchars($post['date']) ?>" class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <?= \App\Util::formatDate($post['date'], 'F j, Y') ?>
                </time>
                <?php if (!empty($post['city'])): ?>
                <span class="flex items-center text-blue-100">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <?= htmlspecialchars($post['city']) ?>
                </span>
                <?php endif; ?>
            </div>
        </header>

        <!-- Content -->
        <div class="p-8 md:p-12">
            <div class="prose prose-lg max-w-none">
                <?= \App\Util::markdownToHtml($post['content']) ?>
            </div>

            <?php if (!empty($post['tags'])): ?>
            <div class="mt-12 pt-8 border-t border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Tags</h3>
                <div class="flex flex-wrap gap-2">
                    <?php foreach ($post['tags'] as $tag): ?>
                    <span class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-full text-sm font-medium hover:bg-blue-100 transition">
                        <?= htmlspecialchars($tag) ?>
                    </span>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Navigation -->
        <div class="px-8 md:px-12 pb-8 md:pb-12">
            <a href="/blog" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Blog
            </a>
        </div>
    </div>
</article>
