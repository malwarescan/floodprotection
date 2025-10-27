<!-- Blog Post -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <!-- Breadcrumb -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a class="inline-flex items-center text-sm text-gray-700 hover:text-primary" href="/">
                    Home
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <a class="ms-1 text-sm text-gray-700 hover:text-primary md:ms-2" href="/blog">Blog</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">Article</span>
                </div>
            </li>
        </ol>
    </nav>
    <!-- End Breadcrumb -->

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <article class="lg:col-span-2">
            <!-- Post Header -->
            <header class="mb-8">
                <h1 class="text-3xl font-bold md:text-4xl md:leading-tight text-primary mb-4">
                    <?= htmlspecialchars($post['title']) ?>
                </h1>
                <div class="flex flex-wrap items-center gap-3 text-sm text-gray-600">
                    <div class="flex items-center gap-x-2">
                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2v4m8-4v4m-9 4h10M5 4h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"/></svg>
                        <time datetime="<?= htmlspecialchars($post['date']) ?>">
                            <?= \App\Util::formatDate($post['date'], 'F j, Y') ?>
                        </time>
                    </div>
                    <?php if (!empty($post['city'])): ?>
                    <div class="flex items-center gap-x-2">
                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <?= htmlspecialchars($post['city']) ?>
                    </div>
                    <?php endif; ?>
                </div>
            </header>
            <!-- End Post Header -->

            <!-- Post Content -->
            <div class="text-gray-800 leading-relaxed space-y-6 [&>h1]:text-3xl [&>h1]:md:text-4xl [&>h1]:font-bold [&>h1]:text-primary [&>h1]:mt-12 [&>h1]:mb-6 [&>h1]:first:mt-0 [&>h2]:text-2xl [&>h2]:md:text-3xl [&>h2]:font-bold [&>h2]:text-primary [&>h2]:mt-10 [&>h2]:mb-4 [&>h3]:text-xl [&>h3]:md:text-2xl [&>h3]:font-bold [&>h3]:text-primary [&>h3]:mt-8 [&>h3]:mb-3 [&>p]:mb-4 [&>p]:text-gray-700 [&>p]:leading-relaxed [&>ul]:list-disc [&>ul]:ml-6 [&>ul]:mb-4 [&>ul]:space-y-2 [&>ol]:list-decimal [&>ol]:ml-6 [&>ol]:mb-4 [&>ol]:space-y-2 [&>li]:text-gray-700 [&>a]:text-primary [&>a]:font-semibold [&>a]:underline [&>a]:hover:text-primary-600 [&>strong]:font-bold [&>strong]:text-gray-900 [&>em]:italic [&>code]:bg-gray-100 [&>code]:text-primary [&>code]:px-2 [&>code]:py-1 [&>code]:rounded [&>code]:text-sm [&>pre]:bg-gray-100 [&>pre]:p-4 [&>pre]:rounded-lg [&>pre]:overflow-x-auto [&>pre]:mb-4 [&>pre>code]:bg-transparent [&>pre>code]:p-0 [&>blockquote]:border-l-4 [&>blockquote]:border-primary [&>blockquote]:pl-4 [&>blockquote]:italic [&>blockquote]:text-gray-600 [&>blockquote]:my-4 [&>table]:w-full [&>table]:border-collapse [&>table]:mb-4 [&>table>thead]:bg-gray-50 [&>table>thead>tr>th]:px-4 [&>table>thead>tr>th]:py-3 [&>table>thead>tr>th]:text-left [&>table>thead>tr>th]:font-semibold [&>table>thead>tr>th]:text-primary [&>table>thead>tr>th]:border-b [&>table>thead>tr>th]:border-gray-200 [&>table>tbody>tr>td]:px-4 [&>table>tbody>tr>td]:py-3 [&>table>tbody>tr>td]:border-b [&>table>tbody>tr>td]:border-gray-200 [&>table>tbody>tr:hover]:bg-gray-50 [&>hr]:my-8 [&>hr]:border-gray-300">
                <?= \App\Util::markdownToHtml($post['content']) ?>
            </div>
            <!-- End Post Content -->

            <?php if (!empty($post['tags'])): ?>
            <!-- Tags -->
            <div class="mt-12 pt-8 border-t border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Tags</h3>
                <div class="flex flex-wrap gap-2">
                    <?php foreach ($post['tags'] as $tag): ?>
                    <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-primary/10 text-primary hover:bg-primary hover:text-white transition-colors">
                        <?= htmlspecialchars($tag) ?>
                    </span>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- End Tags -->
            <?php endif; ?>
            
        </article>
        <!-- End Main Content -->

        <!-- Sidebar -->
        <aside class="lg:col-span-1">
            <!-- Back to Blog -->
            <div class="sticky top-24">
                <a class="inline-flex items-center gap-x-2 text-sm text-gray-600 hover:text-primary border border-gray-200 hover:border-primary transition-colors rounded-lg px-4 py-3" href="/blog">
                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                    Back to Blog
                </a>

                <!-- CTA Card -->
                <div class="mt-8 bg-gradient-to-br from-primary-600 to-primary border border-primary-600 rounded-xl p-6">
                    <h3 class="text-white font-bold text-lg mb-2">Need Help?</h3>
                    <p class="text-white/90 text-sm mb-4">Get a free assessment for your property.</p>
                    <div class="flex flex-col gap-2">
                        <a class="inline-flex justify-center items-center gap-x-2 bg-white text-primary hover:bg-gray-100 font-semibold rounded-lg px-4 py-3 transition-colors" href="<?= \App\Config::getPhoneLink() ?>">
                            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            Call Us
                        </a>
                        <a class="inline-flex justify-center items-center gap-x-2 bg-accent text-white hover:bg-accent-600 font-semibold rounded-lg px-4 py-3 transition-colors" href="<?= \App\Config::getSmsLink('Hi, I\'m interested in flood barriers.') ?>">
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
</div>
<!-- End Blog Post -->
