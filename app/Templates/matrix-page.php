<article class="py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <header class="mb-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4"><?= htmlspecialchars($h1) ?></h1>
            <?php if (isset($is_swfl) && $is_swfl && isset($swfl_content)): ?>
                <p class="text-xl text-gray-600">Hurricane & Storm Surge Protection (FEMA-Compliant) in <?= htmlspecialchars($city) ?>, <?= htmlspecialchars($county) ?></p>
            <?php else: ?>
                <p class="text-xl text-gray-600">Professional <?= htmlspecialchars($keyword) ?> services in <?= htmlspecialchars($city) ?>, <?= htmlspecialchars($county) ?></p>
            <?php endif; ?>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <?php if (isset($is_swfl) && $is_swfl && isset($swfl_content)): ?>
                    <!-- SWFL Optimized Content -->
                    
                    <!-- Intro Section -->
                    <section class="bg-white rounded-lg shadow-md p-6">
                        <p class="text-lg text-gray-700 mb-6"><?= htmlspecialchars($swfl_content['intro']) ?></p>
                        <p class="text-gray-600">
                            <a href="/products" class="text-primary hover:text-primary-600 font-semibold">Learn more about our flood protection services</a>
                        </p>
                    </section>
                    
                    <!-- Why Critical Section -->
                    <section class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4"><?= htmlspecialchars($swfl_content['h2s'][0] ?? 'Why Flood Barriers Are Critical in ' . $city . ', SWFL') ?></h2>
                        <p class="text-lg text-gray-700 mb-6"><?= htmlspecialchars($swfl_content['why_critical']) ?></p>
                    </section>
                    
                    <!-- Product Breakdown -->
                    <section class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4"><?= htmlspecialchars($swfl_content['h2s'][1] ?? 'Best Flood Barriers for SWFL Homes & Businesses') ?></h2>
                        <div class="space-y-6">
                            <?php foreach ($swfl_content['products'] as $product): ?>
                                <div class="border-l-4 border-primary pl-4 py-2">
                                    <h3 class="text-xl font-semibold text-gray-900 mb-2"><?= htmlspecialchars($product['name']) ?></h3>
                                    <p class="text-gray-700 mb-3"><?= htmlspecialchars($product['description']) ?></p>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm text-gray-600">
                                        <div><strong>Durability:</strong> <?= htmlspecialchars($product['durability']) ?></div>
                                        <div><strong>Surge Rating:</strong> <?= htmlspecialchars($product['surge_rating']) ?></div>
                                        <div><strong>Maintenance:</strong> <?= htmlspecialchars($product['maintenance']) ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                    
                    <!-- Installation & Permitting -->
                    <section class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4"><?= htmlspecialchars($swfl_content['h2s'][2] ?? 'Installation & Permitting in ' . $city) ?></h2>
                        <p class="text-lg text-gray-700 mb-6"><?= htmlspecialchars($swfl_content['installation']) ?></p>
                        <?php if (isset($swfl_content['internal_links']['upward'])): ?>
                            <p class="text-gray-600">
                                <?php foreach ($swfl_content['internal_links']['upward'] as $link): ?>
                                    <a href="<?= htmlspecialchars($link['url']) ?>" class="text-primary hover:text-primary-600 font-semibold mr-4"><?= htmlspecialchars($link['anchor']) ?></a>
                                <?php endforeach; ?>
                            </p>
                        <?php else: ?>
                            <p class="text-gray-600">
                                <a href="/products" class="text-primary hover:text-primary-600 font-semibold">View our installation services</a>
                            </p>
                        <?php endif; ?>
                    </section>
                    
                    <!-- Pricing Guide -->
                    <section class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4"><?= htmlspecialchars($swfl_content['h2s'][3] ?? 'Pricing Guide for Flood Barriers in ' . $city) ?></h2>
                        <div class="space-y-4">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h3 class="font-semibold text-gray-900 mb-2">Aluminum Panels</h3>
                                <p class="text-gray-700"><strong><?= htmlspecialchars($swfl_content['pricing']['panels']['range']) ?></strong></p>
                                <p class="text-sm text-gray-600 mt-1">Factors: <?= htmlspecialchars($swfl_content['pricing']['panels']['factors']) ?></p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h3 class="font-semibold text-gray-900 mb-2">Door/Entry Protection</h3>
                                <p class="text-gray-700"><strong><?= htmlspecialchars($swfl_content['pricing']['door_entry']['range']) ?></strong></p>
                                <p class="text-sm text-gray-600 mt-1">Factors: <?= htmlspecialchars($swfl_content['pricing']['door_entry']['factors']) ?></p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h3 class="font-semibold text-gray-900 mb-2">Commercial Openings</h3>
                                <p class="text-gray-700"><strong><?= htmlspecialchars($swfl_content['pricing']['commercial']['range']) ?></strong></p>
                                <p class="text-sm text-gray-600 mt-1">Factors: <?= htmlspecialchars($swfl_content['pricing']['commercial']['factors']) ?></p>
                            </div>
                        </div>
                    </section>
                    
                    <!-- Case Studies -->
                    <section class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4"><?= htmlspecialchars($swfl_content['h2s'][4] ?? 'Case Studies in ' . $city) ?></h2>
                        <div class="space-y-4">
                            <?php foreach ($swfl_content['case_studies'] as $study): ?>
                                <div class="border-l-4 border-accent pl-4 py-2">
                                    <h3 class="font-semibold text-gray-900 mb-1"><?= htmlspecialchars($study['location']) ?></h3>
                                    <p class="text-gray-700 text-sm mb-1"><strong>Scenario:</strong> <?= htmlspecialchars($study['scenario']) ?></p>
                                    <p class="text-gray-700 text-sm mb-1"><strong>Solution:</strong> <?= htmlspecialchars($study['solution']) ?></p>
                                    <p class="text-gray-700 text-sm"><strong>Result:</strong> <?= htmlspecialchars($study['result']) ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php if (isset($swfl_content['internal_links']['downward'])): ?>
                            <p class="text-gray-600 mt-4">
                                <?php foreach ($swfl_content['internal_links']['downward'] as $link): ?>
                                    <a href="<?= htmlspecialchars($link['url']) ?>" class="text-primary hover:text-primary-600 font-semibold mr-4"><?= htmlspecialchars($link['anchor']) ?></a>
                                <?php endforeach; ?>
                            </p>
                        <?php else: ?>
                            <p class="text-gray-600 mt-4">
                                <a href="/testimonials" class="text-primary hover:text-primary-600 font-semibold">View more case studies</a>
                            </p>
                        <?php endif; ?>
                    </section>
                    
                    <!-- Internal Linking Section -->
                    <?php if (isset($swfl_content['internal_links'])): ?>
                    <section class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Related Flood Protection Resources</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <?php if (isset($swfl_content['internal_links']['sideways'])): ?>
                                <?php foreach ($swfl_content['internal_links']['sideways'] as $link): ?>
                                    <a href="<?= htmlspecialchars($link['url']) ?>" class="text-primary hover:text-primary-600 font-semibold"><?= htmlspecialchars($link['anchor']) ?></a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </section>
                    <?php endif; ?>
                    
                    <!-- Maintenance Checklist -->
                    <section class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4"><?= htmlspecialchars($swfl_content['h2s'][5] ?? 'Maintenance & Storm Preparation Checklist') ?></h2>
                        <ol class="list-decimal list-inside space-y-3 text-gray-700">
                            <?php foreach ($swfl_content['maintenance_checklist'] as $item): ?>
                                <li><?= htmlspecialchars($item) ?></li>
                            <?php endforeach; ?>
                        </ol>
                    </section>
                    
                <?php else: ?>
                    <!-- Standard Matrix Content -->
                    <section class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4"><?= htmlspecialchars($keyword) ?> in <?= htmlspecialchars($city) ?></h2>
                        <p class="text-lg text-gray-700 mb-6">Flood Barrier Pros specializes in <?= htmlspecialchars($keyword) ?> for homes and businesses in <?= htmlspecialchars($city) ?>, <?= htmlspecialchars($county) ?>. Our experienced team provides custom solutions tailored to your property's specific needs.</p>
                    
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Our <?= htmlspecialchars($keyword) ?> Services Include:</h3>
                        <ul class="space-y-2">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-700">Custom-designed flood barriers</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-700">Quick-deploy flood panels</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-700">Door and window protection</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-700">Garage flood protection</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-700">Professional installation</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-700">Maintenance and support</span>
                            </li>
                        </ul>
                    </div>
                </section>

                <!-- Product Info -->
                <section class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4"><?= htmlspecialchars($product_name) ?></h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-primary/10 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Product Details</h3>
                            <div class="space-y-2 text-gray-700">
                                <p><strong>Brand:</strong> <?= htmlspecialchars($product_brand) ?></p>
                                <p><strong>SKU:</strong> <?= htmlspecialchars($product_sku) ?></p>
                                <p><strong>Starting at:</strong> $<?= number_format($product_price_min) ?> <?= htmlspecialchars($product_currency) ?></p>
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Description</h3>
                            <p class="text-gray-700">This comprehensive <?= htmlspecialchars($keyword) ?> kit is specifically designed for properties in <?= htmlspecialchars($city) ?>. It includes all necessary components for complete flood protection.</p>
                        </div>
                    </div>
                </section>

                <?php if (strtolower($city) === 'clearwater'): ?>
                <section class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Clearwater Beach Flood Protection</h2>
                    <p class="text-gray-700 mb-6">Clearwater Beach residents face unique flood challenges due to coastal proximity and storm surge risk. Our flood protection systems are specifically designed for beach communities with saltwater-resistant materials and hurricane-grade anchoring.</p>
                    
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Clearwater Beach Flood Protection FAQs</h3>
                    <div class="space-y-4">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <strong class="block text-gray-900 mb-2">Do you serve Clearwater Beach specifically?</strong>
                            <p class="text-gray-700">Yes, we provide full service to Clearwater Beach including beach-front properties. Our systems are rated for saltwater exposure and storm surge conditions.</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <strong class="block text-gray-900 mb-2">What's different about beach flood protection?</strong>
                            <p class="text-gray-700">Clearwater Beach requires corrosion-resistant materials (marine-grade aluminum, EPDM seals), stronger anchoring for wind loads, and systems rated for wave action in addition to standing water.</p>
                        </div>
                    </div>
                </section>
                <?php endif; ?>
                
                <?php if (!empty($resources)): ?>
                <section class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Additional Resources</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <?php 
                        $resourceUrls = explode(' | ', $resources);
                        foreach ($resourceUrls as $url): 
                            if (trim($url)):
                        ?>
                        <a href="<?= htmlspecialchars(trim($url)) ?>" target="_blank" rel="noopener" class="bg-gray-50 hover:bg-gray-100 rounded-lg p-4 text-center transition-colors">
                            <span class="text-gray-700 font-medium"><?= htmlspecialchars(parse_url(trim($url), PHP_URL_HOST)) ?></span>
                        </a>
                        <?php 
                            endif;
                        endforeach; 
                        ?>
                    </div>
                </section>
                <?php endif; ?>
                
                <section class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Related Flood Protection Resources</h2>
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <a href="/blog/best-flood-barriers-2025" class="text-blue-600 hover:text-blue-800 hover:underline">Best Flood Barriers for Homes in 2025</a>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <a href="/blog/fema-approved-flood-barriers" class="text-blue-600 hover:text-blue-800 hover:underline">FEMA-Approved Flood Barriers Guide</a>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <a href="/blog/portable-vs-permanent-flood-barriers" class="text-blue-600 hover:text-blue-800 hover:underline">Portable vs Permanent: Which to Choose?</a>
                        </li>
                    </ul>
                </section>
            </div>

            <!-- Sidebar -->
            <aside class="space-y-6">
                <div class="bg-primary rounded-lg shadow-md p-6">
                    <h3 class="text-2xl font-bold text-white mb-4">Get Your Free Quote</h3>
                    <p class="text-white/90 mb-6">Ready to protect your <?= htmlspecialchars($city) ?> property? Contact us today for a free, no-obligation quote.</p>
                    <div class="text-white/90 space-y-2 mb-6">
                        <p><strong>Phone:</strong> <a href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>" class="underline hover:text-white"><?= htmlspecialchars(\App\Config::get('phone')) ?></a></p>
                        <p><strong>Email:</strong> <a href="mailto:<?= htmlspecialchars(\App\Config::get('email')) ?>" class="underline hover:text-white"><?= htmlspecialchars(\App\Config::get('email')) ?></a></p>
                        <p><strong>Address:</strong> <?= htmlspecialchars(\App\Config::get('address')) ?>, <?= htmlspecialchars(\App\Config::get('city')) ?>, <?= htmlspecialchars(\App\Config::get('state')) ?> <?= htmlspecialchars(\App\Config::get('zip')) ?></p>
                    </div>
                    <a href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>" class="inline-block w-full text-center bg-white text-primary font-semibold py-3 px-6 rounded-lg hover:bg-gray-100 transition-colors">Call Now</a>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Nearby Cities</h3>
                    <ul class="space-y-2">
                        <?php 
                        $nearbyCities = \App\Util::getNearbyCities($city, 6);
                        foreach ($nearbyCities as $nearbyCity): 
                        ?>
                        <li><a href="<?= htmlspecialchars($nearbyCity['url']) ?>" class="text-blue-600 hover:text-blue-800 hover:underline"><?= htmlspecialchars($nearbyCity['name']) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <?php 
                $relatedServices = \App\Util::getRelatedServices($city, $keyword, 5);
                if (!empty($relatedServices)):
                ?>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Related Services in <?= htmlspecialchars($city) ?></h3>
                    <ul class="space-y-2">
                        <?php foreach ($relatedServices as $service): ?>
                        <li><a href="<?= htmlspecialchars($service['url']) ?>" class="text-blue-600 hover:text-blue-800 hover:underline"><?= htmlspecialchars($service['keyword']) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
            </aside>
        </div>
    </div>
</article>

                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <aside class="space-y-6">
                <div class="bg-primary rounded-lg shadow-md p-6">
                    <h3 class="text-2xl font-bold text-white mb-4">Get Your Free Quote</h3>
                    <p class="text-white/90 mb-6">Ready to protect your <?= htmlspecialchars($city) ?> property? Contact us today for a free, no-obligation quote.</p>
                    <div class="text-white/90 space-y-2 mb-6">
                        <p><strong>Phone:</strong> <a href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>" class="underline hover:text-white"><?= htmlspecialchars(\App\Config::get('phone')) ?></a></p>
                        <p><strong>Email:</strong> <a href="mailto:<?= htmlspecialchars(\App\Config::get('email')) ?>" class="underline hover:text-white"><?= htmlspecialchars(\App\Config::get('email')) ?></a></p>
                        <p><strong>Address:</strong> <?= htmlspecialchars(\App\Config::get('address')) ?>, <?= htmlspecialchars(\App\Config::get('city')) ?>, <?= htmlspecialchars(\App\Config::get('state')) ?> <?= htmlspecialchars(\App\Config::get('zip')) ?></p>
                    </div>
                    <a href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>" class="inline-block w-full text-center bg-white text-primary font-semibold py-3 px-6 rounded-lg hover:bg-gray-100 transition-colors">Call Now</a>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Nearby Cities</h3>
                    <ul class="space-y-2">
                        <?php 
                        $nearbyCities = \App\Util::getNearbyCities($city, 6);
                        foreach ($nearbyCities as $nearbyCity): 
                        ?>
                        <li><a href="<?= htmlspecialchars($nearbyCity['url']) ?>" class="text-blue-600 hover:text-blue-800 hover:underline"><?= htmlspecialchars($nearbyCity['name']) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <?php 
                $relatedServices = \App\Util::getRelatedServices($city, $keyword, 5);
                if (!empty($relatedServices)):
                ?>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Related Services in <?= htmlspecialchars($city) ?></h3>
                    <ul class="space-y-2">
                        <?php foreach ($relatedServices as $service): ?>
                        <li><a href="<?= htmlspecialchars($service['url']) ?>" class="text-blue-600 hover:text-blue-800 hover:underline"><?= htmlspecialchars($service['keyword']) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
            </aside>
        </div>
    </div>
</article>

<?php if (!empty($faqs) && count($faqs) > 0): ?>
<!-- FAQ Section -->
<section class="bg-white rounded-lg shadow-md p-6 max-w-7xl mx-auto my-8">
    <h2 class="text-3xl font-bold text-gray-900 mb-6">Frequently Asked Questions</h2>
    <div class="space-y-4" itemscope itemtype="https://schema.org/FAQPage">
        <?php 
        // Handle both SWFL FAQ format and standard FAQ format
        $faqList = $faqs;
        if (isset($is_swfl) && $is_swfl && isset($swfl_content['faqs'])) {
            $faqList = $swfl_content['faqs'];
        }
        foreach ($faqList as $faq): 
            $question = is_array($faq) ? ($faq['question'] ?? $faq['q'] ?? '') : ($faq['q'] ?? '');
            $answer = is_array($faq) ? ($faq['answer'] ?? $faq['a'] ?? '') : ($faq['a'] ?? '');
        ?>
        <div class="border-b border-gray-200 pb-4 last:border-b-0" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
            <h3 class="text-lg font-semibold text-gray-900 mb-2" itemprop="name"><?= htmlspecialchars($question) ?></h3>
            <div class="text-gray-700" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                <div itemprop="text"><?= nl2br(htmlspecialchars($answer)) ?></div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>
