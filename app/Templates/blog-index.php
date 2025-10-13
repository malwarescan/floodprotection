<!-- Blog Index -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <!-- Title -->
    <div class="max-w-2xl mx-auto text-center mb-10 lg:mb-14">
        <h1 class="text-3xl font-bold md:text-4xl md:leading-tight text-primary">Flood Protection Blog</h1>
        <p class="mt-3 text-gray-600">Expert tips, guides, and news about flood protection in Florida</p>
    </div>
    <!-- End Title -->

    <?php if (!empty($posts)): ?>
        <!-- Grid -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($posts as $post): ?>
                <!-- Card -->
                <a class="group flex flex-col h-full border border-gray-200 hover:border-transparent hover:shadow-lg focus:outline-none focus:border-transparent focus:shadow-lg transition duration-300 rounded-xl p-5" href="/blog/<?= htmlspecialchars($post['slug']) ?>">
                    <div class="aspect-w-16 aspect-h-11">
                        <img class="w-full object-cover rounded-xl" src="https://images.unsplash.com/photo-1633356122544-f134324a6cee?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=560&q=80" alt="<?= htmlspecialchars($post['title']) ?>">
                    </div>
                    <div class="my-6">
                        <div class="flex items-center gap-x-3 mb-3">
                            <time class="text-xs text-gray-500" datetime="<?= htmlspecialchars($post['date']) ?>">
                                <?= \App\Util::formatDate($post['date'], 'M j, Y') ?>
                            </time>
                            <?php if (!empty($post['city'])): ?>
                                <span class="inline-flex items-center gap-x-1.5 py-1 px-2 rounded-full text-xs font-medium bg-primary/10 text-primary">
                                    <svg class="size-2.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                    </svg>
                                    <?= htmlspecialchars($post['city']) ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 group-hover:text-primary">
                            <?= htmlspecialchars($post['title']) ?>
                        </h3>
                        <p class="mt-3 text-gray-600">
                            <?= htmlspecialchars($post['description']) ?>
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
            <p class="mt-5 text-gray-600">No blog posts available at the moment. Check back soon!</p>
        </div>
        <!-- End Empty State -->
    <?php endif; ?>
</div>
<!-- End Blog Index -->
