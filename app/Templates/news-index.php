<!-- News Index -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <!-- Title -->
    <div class="max-w-2xl mx-auto text-center mb-10 lg:mb-14">
        <h1 class="text-3xl font-bold md:text-4xl md:leading-tight text-primary">Flood Protection News</h1>
        <p class="mt-3 text-gray-600">Latest news and updates about flood protection, storm alerts, and emergency preparedness in Florida</p>
    </div>
    <!-- End Title -->

    <?php if (!empty($articles)): ?>
        <!-- Grid -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($articles as $article): ?>
                <!-- Card -->
                <a class="group flex flex-col h-full border border-gray-200 hover:border-transparent hover:shadow-lg focus:outline-none focus:border-transparent focus:shadow-lg transition duration-300 rounded-xl p-5" href="/news/<?= htmlspecialchars($article['slug']) ?>">
                    <div class="aspect-w-16 aspect-h-11">
                        <img class="w-full object-cover rounded-xl" src="<?= htmlspecialchars($article['image'] ?? '/assets/images/blog/flood-protection-blog.jpg') ?>" alt="<?= htmlspecialchars($article['title']) ?>">
                    </div>
                    <div class="my-6">
                        <div class="flex items-center gap-x-3 mb-3">
                            <time class="text-xs text-gray-500" datetime="<?= htmlspecialchars($article['date']) ?>">
                                <?= \App\Util::formatDate($article['date'], 'M j, Y') ?>
                            </time>
                            <?php if (!empty($article['city'])): ?>
                                <span class="inline-flex items-center gap-x-1.5 py-1 px-2 rounded-full text-xs font-medium bg-primary/10 text-primary">
                                    <svg class="size-2.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                    </svg>
                                    <?= htmlspecialchars($article['city']) ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 group-hover:text-primary">
                            <?= htmlspecialchars($article['title']) ?>
                        </h3>
                        <p class="mt-3 text-gray-600">
                            <?= htmlspecialchars($article['description']) ?>
                        </p>
                    </div>
                    <div class="mt-auto flex items-center gap-x-3">
                        <span class="text-sm font-medium text-primary group-hover:text-primary-600">
                            Read more
                            <svg class="inline-block size-4 transition-transform group-hover:translate-x-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                        </span>
                    </div>
                </a>
                <!-- End Card -->
            <?php endforeach; ?>
        </div>
        <!-- End Grid -->
    <?php else: ?>
        <!-- Empty State -->
        <div class="max-w-sm w-full mx-auto text-center">
            <svg class="w-12 h-12 mx-auto text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
            <p class="mt-5 text-gray-600">No news articles available at the moment. Check back soon!</p>
        </div>
        <!-- End Empty State -->
    <?php endif; ?>
</div>
<!-- End News Index -->
