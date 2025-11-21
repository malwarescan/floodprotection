<section class="py-12 md:py-16 bg-white">
    <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
        <header class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Contact Flood Barrier Pros</h1>
            <p class="text-lg text-gray-600">Get in touch for free assessments, expert installation, and professional flood protection solutions</p>
        </header>

        <div class="grid md:grid-cols-2 gap-8 mb-12">
            <!-- Contact Information -->
            <div class="bg-white border border-gray-200 rounded-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Get In Touch</h2>
                
                <div class="space-y-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">Phone</h3>
                            <a href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>" class="text-primary hover:text-primary-600">
                                <?= htmlspecialchars(\App\Config::get('phone')) ?>
                            </a>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">Email</h3>
                            <a href="mailto:<?= htmlspecialchars(\App\Config::get('email')) ?>" class="text-primary hover:text-primary-600">
                                <?= htmlspecialchars(\App\Config::get('email')) ?>
                            </a>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">Address</h3>
                            <p class="text-gray-600">
                                <?= htmlspecialchars(\App\Config::get('address')) ?><br>
                                <?= htmlspecialchars(\App\Config::get('city')) ?>, <?= htmlspecialchars(\App\Config::get('state')) ?> <?= htmlspecialchars(\App\Config::get('zip')) ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Service Hours</h3>
                    <p class="text-gray-600">Monday - Friday: 8:00 AM - 6:00 PM<br>
                    Saturday: 9:00 AM - 4:00 PM<br>
                    Sunday: Emergency service available</p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="space-y-6">
                <div class="bg-primary rounded-lg p-8 text-white">
                    <h2 class="text-2xl font-bold mb-4">Free Assessment</h2>
                    <p class="mb-6">Schedule a free on-site assessment of your property's flood protection needs.</p>
                    <a href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>" class="inline-flex items-center justify-center w-full px-6 py-3 bg-accent text-white font-medium rounded-lg hover:bg-accent-600 transition-colors">
                        Schedule Assessment
                    </a>
                </div>

                <div class="bg-gray-50 rounded-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Service Areas</h2>
                    <p class="text-gray-600 mb-4">We provide flood protection services throughout Florida:</p>
                    <ul class="text-gray-600 space-y-2">
                        <li>• Miami-Dade County</li>
                        <li>• Broward County</li>
                        <li>• Palm Beach County</li>
                        <li>• Lee County</li>
                        <li>• Collier County</li>
                        <li>• And 62+ more counties</li>
                    </ul>
                </div>

                <div class="bg-white border border-gray-200 rounded-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Why Choose Us?</h2>
                    <ul class="space-y-3 text-gray-600">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-accent mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Florida licensed and insured</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-accent mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>FEMA-aligned products</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-accent mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Same-week installation available</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-accent mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Free consultations</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

