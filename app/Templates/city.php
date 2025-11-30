<article class="py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <header class="mb-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Flood Protection Services in <?= htmlspecialchars($cityName) ?></h1>
            <p class="text-xl text-gray-600">Professional flood protection solutions for <?= htmlspecialchars($cityName) ?>, Florida</p>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- City Introduction -->
                <section class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Protect Your <?= htmlspecialchars($cityName) ?> Property</h2>
                    <p class="text-lg text-gray-700 mb-6">Rubicon Flood Protection provides comprehensive flood protection services throughout <?= htmlspecialchars($cityName) ?>, Florida. Our experienced team specializes in custom flood barriers, panels, and dry floodproofing solutions designed to protect your property from rising water levels.</p>
                    
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Why Choose Us for <?= htmlspecialchars($cityName) ?> Flood Protection?</h3>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-700"><strong>Local Expertise:</strong> Deep knowledge of <?= htmlspecialchars($cityName) ?> flood patterns and requirements</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-700"><strong>Fast Response:</strong> Emergency installation available within 24-48 hours</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-700"><strong>Custom Solutions:</strong> Tailored protection systems for your specific property</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-700"><strong>Florida Licensed:</strong> Fully licensed and insured for work in <?= htmlspecialchars($cityName) ?></span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-700"><strong>Quality Products:</strong> Only the highest quality materials with 20+ year warranties</span>
                            </li>
                        </ul>
                    </div>
                </section>

                <!-- Services Section -->
                <section class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Our <?= htmlspecialchars($cityName) ?> Services</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php foreach ($services as $service): ?>
                        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200 hover:border-primary transition-colors">
                            <h3 class="text-xl font-semibold text-gray-900 mb-3"><?= htmlspecialchars($service['title']) ?></h3>
                            <p class="text-gray-700 mb-4">Professional <?= htmlspecialchars($service['title']) ?> installation and maintenance in <?= htmlspecialchars($cityName) ?>.</p>
                            <a href="<?= htmlspecialchars($service['url']) ?>" class="inline-flex items-center gap-x-2 text-sm font-medium text-primary hover:text-primary-600 transition-colors">
                                Learn More
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </section>

                <!-- Service Areas -->
                <section class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Service Areas in <?= htmlspecialchars($cityName) ?></h2>
                    <p class="text-gray-700 mb-6">We provide flood protection services throughout <?= htmlspecialchars($cityName) ?> and surrounding areas, including:</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <ul class="space-y-2">
                            <li class="flex items-center text-gray-700">
                                <svg class="w-5 h-5 text-primary mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Residential properties
                            </li>
                            <li class="flex items-center text-gray-700">
                                <svg class="w-5 h-5 text-primary mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Commercial buildings
                            </li>
                            <li class="flex items-center text-gray-700">
                                <svg class="w-5 h-5 text-primary mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Industrial facilities
                            </li>
                        </ul>
                        <ul class="space-y-2">
                            <li class="flex items-center text-gray-700">
                                <svg class="w-5 h-5 text-primary mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Government buildings
                            </li>
                            <li class="flex items-center text-gray-700">
                                <svg class="w-5 h-5 text-primary mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Schools and hospitals
                            </li>
                        </ul>
                    </div>
                </section>
            </div>

            <!-- Sidebar -->
            <aside class="space-y-6">
                <!-- CTA Card -->
                <div class="bg-primary rounded-lg shadow-md p-6">
                    <h3 class="text-2xl font-bold text-white mb-4">Get Your Free <?= htmlspecialchars($cityName) ?> Quote</h3>
                    <p class="text-white/90 mb-6">Ready to protect your <?= htmlspecialchars($cityName) ?> property? Contact us today for a free, no-obligation consultation and quote.</p>
                    <div class="text-white/90 space-y-2 mb-6">
                        <p><strong>Phone:</strong> <a href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>" class="underline hover:text-white transition-colors"><?= htmlspecialchars(\App\Config::get('phone')) ?></a></p>
                        <p><strong>Service Area:</strong> <?= htmlspecialchars($cityName) ?>, Florida</p>
                    </div>
                    <a href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>" class="inline-block w-full text-center bg-white text-primary font-semibold py-3 px-6 rounded-lg hover:bg-gray-100 transition-colors">Call Now for Free Quote</a>
                </div>

                <!-- Nearby Cities -->
                <?php 
                $nearbyCities = \App\Util::getNearbyCities($city, 6);
                if (!empty($nearbyCities)):
                ?>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Nearby Cities</h3>
                    <ul class="space-y-2">
                        <?php foreach ($nearbyCities as $nearbyCity): ?>
                        <li>
                            <a href="<?= htmlspecialchars($nearbyCity['url']) ?>" class="text-blue-600 hover:text-blue-800 hover:underline transition-colors">
                                <?= htmlspecialchars($nearbyCity['name']) ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
            </aside>
        </div>
    </div>
</article>
