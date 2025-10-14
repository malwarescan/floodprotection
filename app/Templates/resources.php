<!-- Resources Page -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <!-- Title -->
    <div class="max-w-2xl mx-auto text-center mb-10 lg:mb-14">
        <h1 class="text-3xl font-bold md:text-4xl md:leading-tight text-primary"><?= htmlspecialchars(ucwords(str_replace('-', ' ', $topic))) ?> Resources - <?= htmlspecialchars(ucwords($city)) ?></h1>
        <p class="mt-3 text-gray-600">Frequently asked questions about <?= htmlspecialchars(str_replace('-', ' ', $topic)) ?> in <?= htmlspecialchars(ucwords($city)) ?></p>
    </div>
    <!-- End Title -->

    <!-- FAQ Section -->
    <div class="max-w-4xl mx-auto mb-16">
        <h2 class="text-2xl font-bold text-gray-800 mb-8">Frequently Asked Questions</h2>
        <div class="space-y-6">
            <?php foreach ($faq as $index => $item): ?>
            <div class="bg-white border border-gray-200 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-3"><?= htmlspecialchars($item['q']) ?></h3>
                <div class="text-gray-600">
                    <p class="mb-3"><?= htmlspecialchars($item['a']) ?></p>
                    <?php if (!empty($item['source_url'])): ?>
                    <p class="text-sm text-gray-500">
                        <strong>Source:</strong> 
                        <a href="<?= htmlspecialchars($item['source_url']) ?>" target="_blank" rel="noopener" class="text-primary hover:text-primary-600 font-medium">
                            <?= htmlspecialchars(parse_url($item['source_url'], PHP_URL_HOST)) ?>
                        </a>
                    </p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- End FAQ Section -->

    <!-- Additional Resources -->
    <div class="max-w-4xl mx-auto mb-16">
        <h2 class="text-2xl font-bold text-gray-800 mb-8">Additional Resources</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="group flex flex-col h-full bg-white border border-gray-200 hover:border-transparent hover:shadow-lg focus:outline-none focus:border-transparent focus:shadow-lg transition duration-300 rounded-xl p-6">
                <div class="my-6">
                    <h3 class="text-xl font-semibold text-gray-800 group-hover:text-primary mb-3">FEMA Flood Maps</h3>
                    <p class="text-gray-600">Check your property's flood risk with official FEMA flood maps.</p>
                </div>
                <div class="mt-auto">
                    <a href="https://www.fema.gov/flood-maps" target="_blank" rel="noopener" class="inline-flex items-center gap-x-2 text-sm font-medium text-primary hover:text-primary-600">
                        View Maps
                        <svg class="inline-block size-4 transition-transform group-hover:translate-x-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                    </a>
                </div>
            </div>
            
            <div class="group flex flex-col h-full bg-white border border-gray-200 hover:border-transparent hover:shadow-lg focus:outline-none focus:border-transparent focus:shadow-lg transition duration-300 rounded-xl p-6">
                <div class="my-6">
                    <h3 class="text-xl font-semibold text-gray-800 group-hover:text-primary mb-3">National Hurricane Center</h3>
                    <p class="text-gray-600">Stay informed about storm tracking and hurricane alerts.</p>
                </div>
                <div class="mt-auto">
                    <a href="https://www.nhc.noaa.gov/" target="_blank" rel="noopener" class="inline-flex items-center gap-x-2 text-sm font-medium text-primary hover:text-primary-600">
                        Track Storms
                        <svg class="inline-block size-4 transition-transform group-hover:translate-x-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                    </a>
                </div>
            </div>
            
            <div class="group flex flex-col h-full bg-white border border-gray-200 hover:border-transparent hover:shadow-lg focus:outline-none focus:border-transparent focus:shadow-lg transition duration-300 rounded-xl p-6">
                <div class="my-6">
                    <h3 class="text-xl font-semibold text-gray-800 group-hover:text-primary mb-3">Florida Disaster</h3>
                    <p class="text-gray-600">Emergency preparedness resources from the state of Florida.</p>
                </div>
                <div class="mt-auto">
                    <a href="https://www.floridadisaster.org/planprepare" target="_blank" rel="noopener" class="inline-flex items-center gap-x-2 text-sm font-medium text-primary hover:text-primary-600">
                        Prepare Now
                        <svg class="inline-block size-4 transition-transform group-hover:translate-x-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- End Additional Resources -->

    <!-- CTA Section -->
    <div class="max-w-4xl mx-auto text-center">
        <div class="bg-primary rounded-xl p-8 md:p-12">
            <h2 class="text-2xl font-bold text-white mb-4">Need Professional Help?</h2>
            <p class="text-primary-50 mb-6">Our experts can answer your specific questions about <?= htmlspecialchars(str_replace('-', ' ', $topic)) ?> in <?= htmlspecialchars(ucwords($city)) ?>.</p>
            <a href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>" class="inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-white text-white hover:bg-white hover:text-primary focus:outline-none focus:bg-white focus:text-primary transition-colors py-3 px-6">
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                Call <?= htmlspecialchars(\App\Config::get('phone')) ?>
            </a>
        </div>
    </div>
    <!-- End CTA Section -->
</div>
<!-- End Resources Page -->
