<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title><?= htmlspecialchars($title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($description) ?>"/>
    <link rel="canonical" href="<?= htmlspecialchars($canonical) ?>"/>
    
    <!-- Open Graph -->
    <meta property="og:title" content="<?= htmlspecialchars($title) ?>"/>
    <meta property="og:description" content="<?= htmlspecialchars($description) ?>"/>
    <meta property="og:url" content="<?= htmlspecialchars($canonical) ?>"/>
    <meta property="og:type" content="website"/>
    <meta property="og:site_name" content="<?= htmlspecialchars(\App\Config::get('app_name')) ?>"/>
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:title" content="<?= htmlspecialchars($title) ?>"/>
    <meta name="twitter:description" content="<?= htmlspecialchars($description) ?>"/>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Preline UI CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/preline@2.0.3/dist/preline.min.css">
    
    <!-- Custom Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eef2f8',
                            600: '#153E75',
                            DEFAULT: '#1B365D'
                        },
                        accent: {
                            600: '#d84f23',
                            DEFAULT: '#F05A28'
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Custom CSS overrides -->
    <link rel="stylesheet" href="/assets/app.css"/>
    
    <?php if (!empty($jsonld)): ?>
    <script type="application/ld+json"><?= json_encode($jsonld, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) ?></script>
    <?php endif; ?>
</head>
<body class="bg-gray-50">
    <!-- Preline Header -->
    <header class="sticky top-0 inset-x-0 flex flex-wrap md:justify-start md:flex-nowrap z-50 w-full bg-white border-b border-gray-200">
        <nav class="relative max-w-[85rem] w-full mx-auto md:flex md:items-center md:justify-between md:gap-3 py-2 px-4 sm:px-6 lg:px-8">
            <!-- Logo -->
            <div class="flex justify-between items-center gap-x-1">
                <a class="flex-none font-bold text-xl text-primary focus:outline-none focus:opacity-80" href="/" aria-label="<?= htmlspecialchars(\App\Config::get('app_name')) ?>">
                    <?= htmlspecialchars(\App\Config::get('app_name')) ?>
                </a>
                
                <!-- Mobile Menu Button -->
                <button type="button" class="hs-collapse-toggle md:hidden relative size-9 flex justify-center items-center font-medium text-[12px] rounded-lg border border-gray-200 text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none" id="hs-header-base-collapse" aria-expanded="false" aria-controls="hs-header-base" aria-label="Toggle navigation" data-hs-collapse="#hs-header-base">
                    <svg class="hs-collapse-open:hidden size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" x2="21" y1="6" y2="6"/><line x1="3" x2="21" y1="12" y2="12"/><line x1="3" x2="21" y1="18" y2="18"/></svg>
                    <svg class="hs-collapse-open:block shrink-0 hidden size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
            </div>
            
            <!-- Navigation -->
            <div id="hs-header-base" class="hs-collapse hidden overflow-hidden transition-all duration-300 basis-full grow md:block" aria-labelledby="hs-header-base-collapse">
                <div class="overflow-hidden overflow-y-auto max-h-[75vh] [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300">
                    <div class="py-2 md:py-0 flex flex-col md:flex-row md:items-center gap-0.5 md:gap-1">
                        <a class="p-2 flex items-center text-sm text-gray-800 hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100" href="/blog">Blog</a>
                        <a class="p-2 flex items-center text-sm text-gray-800 hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100" href="/news">News</a>
                        <a class="p-2 flex items-center text-sm text-gray-800 hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100" href="/testimonials">Testimonials</a>
                        <a class="p-2 flex items-center text-sm text-gray-800 hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100" href="/resources/door-dams/miami">Resources</a>
                        
                        <!-- CTA Buttons -->
                        <div class="flex flex-wrap items-center gap-2 mt-2 md:mt-0 md:ps-2 md:ms-auto">
                            <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-primary text-primary hover:bg-primary hover:text-white focus:outline-none focus:bg-primary focus:text-white disabled:opacity-50 disabled:pointer-events-none" href="<?= \App\Config::getPhoneLink() ?>">
                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                Call
                            </a>
                            <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-accent text-white hover:bg-accent-600 focus:outline-none focus:bg-accent-600 disabled:opacity-50 disabled:pointer-events-none" href="<?= \App\Config::getSmsLink('Hi, I\'m interested in flood barriers for my home.') ?>">
                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                Text Us
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    
    <main class="w-full">
        <?= $content ?>
    </main>
    
    <!-- Preline Footer -->
    <footer class="mt-auto w-full bg-white border-t border-gray-200">
        <div class="max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
            <!-- Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 items-center gap-5">
                <div>
                    <a class="flex-none font-bold text-xl text-primary focus:outline-none focus:opacity-80" href="/" aria-label="<?= htmlspecialchars(\App\Config::get('app_name')) ?>">
                        <?= htmlspecialchars(\App\Config::get('app_name')) ?>
                    </a>
                </div>
                
                <ul class="text-center">
                    <li class="inline-block relative pe-8 last:pe-0 last-of-type:before:hidden before:absolute before:top-1/2 before:end-3 before:-translate-y-1/2 before:content-['/'] before:text-gray-300">
                        <a class="inline-flex gap-x-2 text-sm text-gray-500 hover:text-gray-800 focus:outline-none focus:text-gray-800" href="/blog">Blog</a>
                    </li>
                    <li class="inline-block relative pe-8 last:pe-0 last-of-type:before:hidden before:absolute before:top-1/2 before:end-3 before:-translate-y-1/2 before:content-['/'] before:text-gray-300">
                        <a class="inline-flex gap-x-2 text-sm text-gray-500 hover:text-gray-800 focus:outline-none focus:text-gray-800" href="/news">News</a>
                    </li>
                    <li class="inline-block relative pe-8 last:pe-0 last-of-type:before:hidden before:absolute before:top-1/2 before:end-3 before:-translate-y-1/2 before:content-['/'] before:text-gray-300">
                        <a class="inline-flex gap-x-2 text-sm text-gray-500 hover:text-gray-800 focus:outline-none focus:text-gray-800" href="/testimonials">Testimonials</a>
                    </li>
                </ul>
                
                <div class="md:text-end space-x-2">
                    <a class="size-8 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-500 hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none" href="<?= \App\Config::getPhoneLink() ?>">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    </a>
                </div>
            </div>
            
            <div class="mt-5 sm:mt-12 grid gap-y-2 sm:gap-y-0 sm:flex sm:justify-between sm:items-center">
                <div class="flex justify-between items-center">
                    <p class="text-sm text-gray-500">&copy; <?= date('Y') ?> <?= htmlspecialchars(\App\Config::get('app_name')) ?>. All rights reserved.</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Professional flood protection services throughout Florida.</p>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Organization Schema -->
    <script type="application/ld+json"><?= json_encode(\App\Schema::organizationGraph(), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) ?></script>
    
    <!-- Preline JS -->
    <script src="https://cdn.jsdelivr.net/npm/preline@2.0.3/dist/preline.min.js"></script>
</body>
</html>
