<?php
/**
 * FAQ Page Template
 * Renders FAQ content with JSON-LD schema and internal linking
 */

require_once __DIR__.'/../../lib/Faqs.php';

// Extract slug from URL
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$slug = basename($path);

// Load FAQ content
$faqItems = Faqs::locate($canonical);

// Meta information
$pageTitle = $pageTitle ?? 'Flood Protection FAQs | ' . \App\Config::get('app_name');
$metaDescription = $metaDescription ?? 'Get answers to common questions about flood barriers, installation, and protection in Florida.';

// Prepare page data for schema
$pageData = [
    'faq' => $faqItems
];

// Map context for schema
require_once __DIR__.'/../../includes/ctx-mapper.php';
$ctx = map_ctx($canonical, $pageTitle, $metaDescription, [
    'url' => \App\Config::get('app_url'),
    'name' => \App\Config::get('app_name'),
    'logo' => \App\Config::get('app_url') . '/assets/images/logo/flood-barrier-pros-logo.png',
    'telephone' => \App\Config::get('phone'),
    'address' => [
        'streetAddress' => 'Florida',
        'addressLocality' => 'Florida',
        'addressRegion' => 'FL',
        'addressCountry' => 'US'
    ]
], $pageData);

// Include schema head
require_once __DIR__.'/../../includes/schema-head.php';

// Include FAQ head injection
require_once __DIR__.'/../../includes/faq-head-auto.php';
?>

<div class="max-w-[85rem] mx-auto px-4 py-10 sm:px-6 lg:px-8 lg:py-14">
    <!-- Header -->
    <div class="max-w-2xl mx-auto text-center mb-10 lg:mb-14">
        <h1 class="text-3xl font-bold md:text-4xl md:leading-tight text-primary"><?= htmlspecialchars($pageTitle) ?></h1>
        <p class="mt-3 text-gray-600"><?= htmlspecialchars($metaDescription) ?></p>
    </div>

    <?php if (!empty($faqItems)): ?>
        <!-- FAQ Content using new renderer -->
        <?php require_once __DIR__.'/../../includes/faq-render.php'; ?>
        <?php render_faq_section($ctx); ?>

        <!-- CTA Section -->
        <div class="max-w-2xl mx-auto text-center mt-12">
            <div class="bg-primary rounded-xl p-8">
                <h2 class="text-2xl font-bold text-white mb-4">Need More Help?</h2>
                <p class="text-white/90 mb-6">Get personalized answers from our flood protection experts.</p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a class="py-3 px-6 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-white text-primary hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition-colors" href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        Call Now
                    </a>
                    <a class="py-3 px-6 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-white text-white hover:bg-white hover:text-primary focus:outline-none focus:bg-white focus:text-primary transition-colors" href="<?= \App\Config::getSmsLink('I have questions about flood protection for my home.') ?>">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        Text Us
                    </a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- Empty State -->
        <div class="max-w-sm w-full mx-auto text-center">
            <svg class="w-12 h-12 mx-auto text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.879 7.519c-1.171-1.025-3.071-1.025-4.242 0-1.172 1.025-1.172 2.687 0 3.712 1.171 1.025 3.071 1.025 4.242 0M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
            <p class="mt-5 text-gray-600">No FAQ content available for this topic.</p>
        </div>
    <?php endif; ?>
</div>

