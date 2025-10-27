<article class="py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <header class="mb-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4"><?= htmlspecialchars($h1) ?></h1>
            <p class="text-xl text-gray-600">Professional <?= htmlspecialchars($keyword) ?> services in <?= htmlspecialchars($city) ?>, <?= htmlspecialchars($county) ?></p>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Service Overview -->
                <section class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4"><?= htmlspecialchars($keyword) ?> in <?= htmlspecialchars($city) ?></h2>
                    <p class="text-lg text-gray-700 mb-6">Rubicon Flood Protection specializes in <?= htmlspecialchars($keyword) ?> for homes and businesses in <?= htmlspecialchars($city) ?>, <?= htmlspecialchars($county) ?>. Our experienced team provides custom solutions tailored to your property's specific needs.</p>
                    
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

<?php if (!empty($faqs) && count($faqs) > 0): ?>
<!-- FAQ Section -->
<section class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-3xl font-bold text-gray-900 mb-6">Frequently Asked Questions</h2>
    <div class="space-y-4" itemscope itemtype="https://schema.org/FAQPage">
        <?php foreach ($faqs as $faq): ?>
        <div class="border-b border-gray-200 pb-4 last:border-b-0" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
            <h3 class="text-lg font-semibold text-gray-900 mb-2" itemprop="name"><?= htmlspecialchars($faq['q']) ?></h3>
            <div class="text-gray-700" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                <div itemprop="text"><?= $faq['a'] ?></div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>
