<section class="py-12 md:py-16 bg-white">
    <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
        <header class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4"><?= htmlspecialchars($serviceName) ?> Services in Florida</h1>
            <p class="text-lg text-gray-600">Professional <?= htmlspecialchars($serviceName) ?> solutions throughout Florida</p>
        </header>

        <div class="space-y-16">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">Comprehensive <?= htmlspecialchars($serviceName) ?> Solutions</h2>
                <p class="text-gray-700 leading-relaxed mb-8">Rubicon Flood Protection specializes in <?= htmlspecialchars($serviceName) ?> services across Florida. Our experienced team provides custom solutions designed to protect your property from flood damage with the highest quality materials and professional installation.</p>
                
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Why Choose Our <?= htmlspecialchars($serviceName) ?> Services?</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-accent mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700"><strong>Expert Installation:</strong> Licensed professionals with years of experience</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-accent mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700"><strong>Custom Solutions:</strong> Tailored to your specific property needs</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-accent mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700"><strong>Quality Materials:</strong> Only the highest grade flood protection products</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-accent mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700"><strong>Fast Response:</strong> Emergency installation available within 24-48 hours</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-accent mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700"><strong>Warranty Coverage:</strong> Comprehensive warranties on all installations</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-accent mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700"><strong>Florida Licensed:</strong> Fully licensed and insured for work throughout Florida</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4 text-center">Service Areas</h2>
                <p class="text-center text-gray-600 mb-8">We provide <?= htmlspecialchars($serviceName) ?> services in the following Florida cities:</p>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($cities as $city): ?>
                    <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2"><?= htmlspecialchars($city['cityName']) ?></h3>
                        <p class="text-gray-600 mb-4 text-sm">Professional <?= htmlspecialchars($serviceName) ?> services in <?= htmlspecialchars($city['cityName']) ?>.</p>
                        <a href="<?= htmlspecialchars($city['url']) ?>" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-primary border border-primary rounded-lg hover:bg-primary hover:text-white transition-colors">View <?= htmlspecialchars($city['cityName']) ?> Services</a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="max-w-4xl mx-auto">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-8 text-center">Our <?= htmlspecialchars($serviceName) ?> Process</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 w-10 h-10 bg-accent text-white rounded-full flex items-center justify-center font-bold">1</div>
                            <h3 class="ml-4 text-xl font-semibold text-gray-900">Free Consultation</h3>
                        </div>
                        <p class="text-gray-600">We'll assess your property and discuss your specific flood protection needs.</p>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 w-10 h-10 bg-accent text-white rounded-full flex items-center justify-center font-bold">2</div>
                            <h3 class="ml-4 text-xl font-semibold text-gray-900">Custom Design</h3>
                        </div>
                        <p class="text-gray-600">Our team will design a <?= htmlspecialchars($serviceName) ?> solution tailored to your property.</p>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 w-10 h-10 bg-accent text-white rounded-full flex items-center justify-center font-bold">3</div>
                            <h3 class="ml-4 text-xl font-semibold text-gray-900">Professional Installation</h3>
                        </div>
                        <p class="text-gray-600">Our licensed technicians will install your flood protection system with precision.</p>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 w-10 h-10 bg-accent text-white rounded-full flex items-center justify-center font-bold">4</div>
                            <h3 class="ml-4 text-xl font-semibold text-gray-900">Ongoing Support</h3>
                        </div>
                        <p class="text-gray-600">We provide maintenance and support to ensure your system continues to protect your property.</p>
                    </div>
                </div>
            </div>

            <?php if (!empty($faqs) && is_array($faqs)): ?>
            <div class="max-w-4xl mx-auto">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-8 text-center">Frequently Asked Questions</h2>
                <div class="space-y-6">
                    <?php foreach ($faqs as $index => $faq): ?>
                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                        <button type="button" class="w-full text-left px-6 py-4 flex items-start justify-between gap-4 focus:outline-none hover:bg-gray-50 transition-colors" onclick="this.nextElementSibling.classList.toggle('hidden'); this.querySelector('.faq-icon').classList.toggle('rotate-45');">
                            <span class="font-semibold text-lg text-gray-900 pr-4"><?= htmlspecialchars($faq['q']) ?></span>
                            <svg class="faq-icon shrink-0 w-6 h-6 text-gray-600 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </button>
                        <div class="hidden px-6 pb-4 text-gray-700 leading-relaxed">
                            <?= $faq['a'] ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <div class="bg-primary rounded-lg p-8 text-center">
                <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">Get Your Free <?= htmlspecialchars($serviceName) ?> Quote</h2>
                <p class="text-white/90 mb-6 max-w-2xl mx-auto">Ready to protect your property with professional <?= htmlspecialchars($serviceName) ?> services? Contact us today for a free consultation and quote.</p>
                <div class="text-white/90 mb-6 space-y-2">
                    <p><strong>Phone:</strong> <a href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>" class="underline hover:text-white"><?= htmlspecialchars(\App\Config::get('phone')) ?></a></p>
                    <p><strong>Service Area:</strong> Throughout Florida</p>
                </div>
                <a href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>" class="inline-flex items-center justify-center px-8 py-3 bg-accent text-white font-medium rounded-lg hover:bg-accent-600 transition-colors">Call Now for Free Quote</a>
            </div>
        </div>
    </div>
</section>
