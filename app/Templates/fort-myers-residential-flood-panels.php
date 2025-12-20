<?php
// Specialized template for Fort Myers Residential Flood Panels page
// Following META DIRECTIVE requirements - Fort Myers primary, Cape Coral secondary only
?>
<article class="py-0">
    <!-- Above the Fold - Hero Section -->
    <section class="bg-gradient-to-br from-primary to-primary-600 text-white py-12 md:py-16 px-4">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Residential Flood Panels for Fort Myers Homes</h1>
            <p class="text-xl md:text-2xl mb-6 max-w-3xl">
                FEMA-compliant flood panels designed for Fort Myers homeowners • Storm surge protection • Professional installation
            </p>
            <div class="flex flex-col sm:flex-row gap-4 mb-8">
                <a href="#free-assessment" class="bg-white text-blue-600 font-bold py-4 px-8 rounded-lg hover:bg-blue-50 transition-colors text-center">
                    Get a Free Flood Assessment
                </a>
                <a href="<?= \App\Config::getPhoneLink() ?>" class="bg-orange-600 text-white font-bold py-4 px-8 rounded-lg hover:bg-orange-700 transition-colors text-center">
                    Call Now: <?= htmlspecialchars(\App\Config::get('phone')) ?>
                </a>
            </div>
            <!-- Trust Signals -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>500+ Local Installs</span>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>FEMA Certified</span>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>20-Year Warranty</span>
                </div>
            </div>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Lead Section: Who, What, Why -->
        <section class="mb-12">
            <div class="prose prose-lg max-w-none">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Who This Is For</h2>
                <p class="text-lg text-gray-700 mb-6">
                    Homeowners in Fort Myers, Florida, seeking reliable flood protection for their residential properties. Whether you live in Flood Zones AE, VE, or A, along the Caloosahatchee River, or in coastal areas prone to storm surge, our residential flood panels provide FEMA-compliant protection designed specifically for Fort Myers homes. Properties facing Caloosahatchee River overflow and coastal surge require rapid-deploy solutions that can be activated before hurricanes and tropical storms.
                </p>
                
                <h2 class="text-3xl font-bold text-gray-900 mb-4">What Problem It Solves</h2>
                <p class="text-lg text-gray-700 mb-6">
                    Fort Myers faces significant flood risk from storm surge, Caloosahatchee River overflow, and coastal flooding during hurricanes. Traditional sandbags fail in up to 50% of flood events, leaving homes unprotected. Our residential flood panels create watertight seals at doorways, garage openings, and ground-level windows, preventing floodwater intrusion and protecting your property's interior from storm surge and river overflow.
                </p>
                
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Why Fort Myers Specifically</h2>
                <p class="text-lg text-gray-700 mb-6">
                    Fort Myers faces unique flood challenges due to its location along the Caloosahatchee River and proximity to Estero Bay. During Hurricane Ian (2022) and Irma (2017), surge heights reached 8-12 feet, causing extensive property damage throughout Fort Myers. Properties in Flood Zones AE, VE, and A require FEMA-compliant flood protection systems, and our panels are engineered to meet these requirements while being specifically designed for the rapid deployment needs of Fort Myers homeowners facing storm surge and river overflow.
                </p>
            </div>
            
            <!-- CTA after lead section -->
            <div class="bg-blue-50 border-l-4 border-blue-600 p-6 my-8">
                <p class="text-lg font-semibold text-gray-900 mb-4">Ready to protect your Fort Myers home?</p>
                <a href="#free-assessment" class="inline-block bg-blue-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors mr-4">
                    Get Free Assessment
                </a>
                <a href="<?= \App\Config::getPhoneLink() ?>" class="inline-block bg-white text-blue-600 font-bold py-3 px-6 rounded-lg border-2 border-blue-600 hover:bg-blue-50 transition-colors mt-4 md:mt-0">
                    Call <?= htmlspecialchars(\App\Config::get('phone')) ?>
                </a>
            </div>
        </section>

        <!-- Local Risk Paragraph -->
        <section class="bg-red-50 border-l-4 border-red-600 p-6 mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Fort Myers Flood Risk Profile</h2>
            <p class="text-gray-700 mb-4">
                <strong>Flood Zones:</strong> Fort Myers is primarily in Flood Zones AE, VE, and A, with AE zones requiring elevation certificates and VE zones requiring structures to withstand wave action and surge. Properties along the Caloosahatchee River and coastal areas face the highest risk, with surge heights reaching 8-12 feet during major storms.
            </p>
            <p class="text-gray-700 mb-4">
                <strong>Storm Surge:</strong> Historical data shows surge heights of 8-12 feet during major hurricanes in Fort Myers. The Caloosahatchee River can overflow during heavy rainfall and storm events, affecting properties throughout the city. Coastal areas face additional risk from Estero Bay surge.
            </p>
            <p class="text-gray-700">
                <strong>Recent Flooding History:</strong> Hurricane Ian (2022) caused widespread flooding throughout Fort Myers, with many homes experiencing significant water damage from both storm surge and Caloosahatchee River overflow. Hurricane Irma (2017) also resulted in extensive flooding, particularly in low-lying areas and properties near the river and coastal zones.
            </p>
        </section>

        <!-- Flood Panels vs Surge Protection Section -->
        <section class="mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Flood Panels vs. Storm Surge Protection: Why Panels Are Used in Southwest Florida</h2>
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <p class="text-gray-700 mb-4">
                    <strong>Understanding the Difference:</strong> Flood panels and storm surge protection are often used interchangeably, but they address slightly different threats. Flood panels create watertight barriers at openings (doors, windows, garages) to prevent water intrusion from rising floodwaters. Storm surge protection refers to broader systems that protect against coastal surge events, which can include both flood panels and perimeter barriers.
                </p>
                <p class="text-gray-700 mb-4">
                    <strong>Why Panels Are Essential in Fort Myers:</strong> In Fort Myers, residential flood panels are the primary defense because most flood damage occurs when water enters through openings rather than overtopping structures. During Hurricane Ian, many Fort Myers homes experienced water intrusion through doorways and garage openings from both storm surge and Caloosahatchee River overflow, even when the structure itself remained above water level. Flood panels provide targeted protection at these vulnerable entry points, creating watertight seals that prevent interior flooding.
                </p>
                <p class="text-gray-700">
                    <strong>Rapid Deployment Advantage:</strong> Unlike permanent barriers or elevation work, flood panels can be deployed in minutes when storm warnings are issued. This rapid deployment capability is critical in Fort Myers, where hurricane tracks can shift quickly and homeowners need protection that can be activated with 24-48 hours notice. Pre-installed track systems allow Fort Myers homeowners to deploy panels themselves, providing immediate protection without waiting for contractors.
                </p>
            </div>
            
            <!-- CTA after flood panels section -->
            <div class="text-center bg-gray-50 p-6 rounded-lg">
                <p class="text-lg font-semibold text-gray-900 mb-4">Learn how flood panels protect against storm surge</p>
                <a href="#free-assessment" class="inline-block bg-blue-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors">
                    Schedule Free Assessment
                </a>
            </div>
        </section>

        <!-- FEMA Compliance and Insurance Impact -->
        <section class="mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">How Flood Protection Impacts Insurance and FEMA Compliance</h2>
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">FEMA Technical Bulletin 3 Compliance</h3>
                <p class="text-gray-700 mb-4">
                    Our residential flood panels exceed FEMA Technical Bulletin 3 (TB-3) standards with third-party certification. They withstand hydrostatic pressure testing per ASTM E330 and provide watertight seals rated for flood heights up to 8-12 feet, which is critical for Fort Myers properties facing Caloosahatchee River overflow and coastal storm surge. All installations include FEMA compliance documentation for insurance purposes.
                </p>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Insurance Premium Reductions</h3>
                <p class="text-gray-700 mb-4">
                    Properties in Fort Myers Flood Zones AE, VE, and A must meet NFIP (National Flood Insurance Program) requirements. Our FEMA-certified installations help ensure compliance and may qualify for insurance premium reductions of 5-45%. Given Fort Myers' average flood insurance cost, homeowners can save $240-$320 per year, or $4,800-$12,800 over 20-40 years. This significantly offsets installation costs and provides long-term financial benefits.
                </p>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">FEMA Grant Eligibility</h3>
                <p class="text-gray-700">
                    FEMA-compliant flood panel installations may qualify for up to $10,000 in FEMA flood mitigation grants through programs like the Hazard Mitigation Grant Program (HMGP) and Flood Mitigation Assistance (FMA). We provide all necessary documentation and can assist with grant application processes for eligible Fort Myers homeowners.
                </p>
            </div>
            
            <!-- CTA after FEMA section -->
            <div class="text-center bg-gray-50 p-6 rounded-lg">
                <p class="text-lg font-semibold text-gray-900 mb-4">Learn how FEMA compliance can reduce your insurance costs</p>
                <a href="#free-assessment" class="inline-block bg-blue-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors">
                    Schedule Free Consultation
                </a>
            </div>
        </section>

        <!-- Installation Timelines Before Storms -->
        <section class="mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Installation Timelines Before Storms</h2>
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Pre-Storm Installation Planning</h3>
                <p class="text-gray-700 mb-4">
                    For Fort Myers homeowners, timing is critical when preparing for hurricane season. We recommend installing flood panel track systems during the off-season (typically November through May) to ensure rapid deployment capability when storms approach. Track installation takes 2-4 hours for a standard Fort Myers home, and once installed, panels can be deployed in 3-6 minutes per opening.
                </p>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Emergency Installation Services</h3>
                <p class="text-gray-700 mb-4">
                    When storm warnings are issued with 24-48 hours notice, our installation team offers emergency installation services for Fort Myers homeowners who haven't yet installed tracks. We prioritize Fort Myers properties and can complete full installations before landfall when conditions allow. However, we strongly recommend pre-season installation to avoid last-minute availability issues.
                </p>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Deployment Timeline</h3>
                <p class="text-gray-700">
                    Once tracks are installed, homeowners can deploy panels themselves in 3-6 minutes per opening. We provide deployment training and written instructions with every installation. For emergency situations, our team offers rapid deployment support, but self-deployment capability ensures protection even if contractors cannot reach your property before a storm.
                </p>
            </div>
            
            <!-- CTA after installation timeline section -->
            <div class="text-center bg-blue-50 p-6 rounded-lg">
                <p class="text-lg font-semibold text-gray-900 mb-4">Install before hurricane season for peace of mind</p>
                <a href="<?= \App\Config::getPhoneLink() ?>" class="inline-block bg-orange-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-orange-700 transition-colors">
                    Call <?= htmlspecialchars(\App\Config::get('phone')) ?> to Schedule
                </a>
            </div>
        </section>

        <!-- Fast Installation for Fort Myers Homes -->
        <section class="mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Fast Installation for Fort Myers Homes</h2>
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Pre-Installed Track Systems</h3>
                    <p class="text-gray-700 mb-4">
                        Once tracks are installed, flood panels deploy in 3-6 minutes per opening. Our local Fort Myers installation team can complete track installation for a standard home in 2-4 hours, ensuring rapid deployment capability when storms approach.
                    </p>
                    <ul class="list-disc list-inside text-gray-700 space-y-2">
                        <li>Track installation: 2-4 hours for standard homes</li>
                        <li>Panel deployment: 3-6 minutes per opening</li>
                        <li>Emergency deployment support available</li>
                    </ul>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Local Installation Team</h3>
                    <p class="text-gray-700 mb-4">
                        Our licensed contractors are based in Southwest Florida and understand Fort Myers' specific requirements, including permit processes, local building codes, and Caloosahatchee River flood considerations. We coordinate with Lee County officials to ensure full compliance for Fort Myers installations.
                    </p>
                    <ul class="list-disc list-inside text-gray-700 space-y-2">
                        <li>Licensed Florida contractors</li>
                        <li>Familiar with Fort Myers building requirements</li>
                        <li>Same-week installation available</li>
                    </ul>
                </div>
            </div>
            
            <!-- CTA after installation section -->
            <div class="text-center bg-blue-50 p-6 rounded-lg">
                <p class="text-lg font-semibold text-gray-900 mb-4">Get same-week installation in Fort Myers</p>
                <a href="<?= \App\Config::getPhoneLink() ?>" class="inline-block bg-blue-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors">
                    Call <?= htmlspecialchars(\App\Config::get('phone')) ?>
                </a>
            </div>
        </section>

        <!-- Panel Materials and Durability -->
        <section class="mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Panel Materials and Durability</h2>
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">6063 T-6 Aluminum Construction</h3>
                <p class="text-gray-700 mb-4">
                    Our residential flood panels use 6063 T-6 aluminum, specifically chosen for its corrosion resistance in Fort Myers' salt-air environment. This marine-grade alloy provides superior durability compared to standard aluminum, ensuring panels maintain structural integrity for 20+ years with proper maintenance.
                </p>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">EPDM Rubber Sealing</h3>
                <p class="text-gray-700 mb-4">
                    EPDM (Ethylene Propylene Diene Monomer) rubber gaskets create watertight compression seals that prevent water intrusion even under high hydrostatic pressure. These seals are rated for flood heights up to 8-12 feet and are specifically tested for saltwater exposure common in Fort Myers.
                </p>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Durability and Maintenance</h3>
                <p class="text-gray-700">
                    With proper maintenance, our residential flood panels have a service life of 20+ years. Annual inspections, cleaning of tracks and hardware, and proper storage after storms extend system longevity significantly. All panels come with a 20-year warranty covering material defects and structural integrity.
                </p>
            </div>
            
            <!-- CTA after materials section -->
            <div class="text-center bg-gray-50 p-6 rounded-lg">
                <p class="text-lg font-semibold text-gray-900 mb-4">See our durable flood panels in person</p>
                <a href="#free-assessment" class="inline-block bg-blue-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors">
                    Schedule Free Assessment
                </a>
            </div>
        </section>

        <!-- Permitting and Local Code Considerations -->
        <section class="mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Permitting and Local Code Considerations</h2>
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Lee County Building Codes</h3>
                <p class="text-gray-700 mb-4">
                    Flood barrier installation in Fort Myers requires compliance with Lee County building codes. Properties in Flood Zones AE, VE, and A must submit elevation certificates with permit applications. Lee County requires structural engineering approval for barrier systems exceeding 4 feet in height.
                </p>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">City of Fort Myers Requirements</h3>
                <p class="text-gray-700 mb-4">
                    The City of Fort Myers Building Division requires permits for permanent flood barrier installations. Our team handles all documentation including site plans, elevation certificates, and product specifications. We coordinate with city officials to ensure full compliance and expedite the permit process when possible.
                </p>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Permit Processing</h3>
                <p class="text-gray-700">
                    Permits typically process within 7-14 business days in Lee County. Our team handles all documentation including site plans, elevation certificates, and product specifications. We coordinate with county officials to ensure full compliance and expedite the permit process when possible.
                </p>
            </div>
            
            <!-- CTA after permitting section -->
            <div class="text-center bg-blue-50 p-6 rounded-lg">
                <p class="text-lg font-semibold text-gray-900 mb-4">We handle all permits and approvals</p>
                <a href="#free-assessment" class="inline-block bg-blue-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors">
                    Get Started Today
                </a>
            </div>
        </section>

        <!-- Regional Context Section - ONLY PLACE CAPE CORAL IS ALLOWED -->
        <section class="bg-blue-50 border-l-4 border-blue-600 p-6 mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Serving Fort Myers Homes Across Lee County</h2>
            <p class="text-gray-700 mb-4">
                Our residential flood panel installation services focus exclusively on Fort Myers homeowners. We coordinate with Lee County building departments, handle permits in Fort Myers, and understand the unique flood risks facing Fort Myers' coastal and river-side communities. Our installation team is based in Southwest Florida and serves Fort Myers with local knowledge and rapid response capability.
            </p>
            <p class="text-gray-700">
                For Fort Myers residents, we provide comprehensive service coverage throughout Lee County. Nearby Lee County communities such as Cape Coral may also benefit from our installation logistics and regional expertise, but our primary service focus remains on Fort Myers homeowners seeking residential flood protection solutions.
            </p>
            <p class="text-gray-700 mt-4">
                <strong>Check your official flood zone:</strong> Verify your property's flood risk using the <a href="https://www.cityftmyers.com/Departments/Building-Services" target="_blank" rel="noopener" class="text-blue-600 hover:underline">City of Fort Myers Building Services</a> and <a href="https://msc.fema.gov/portal/search" target="_blank" rel="noopener" class="text-blue-600 hover:underline">FEMA flood maps</a> to evaluate risk and insurance requirements.
            </p>
        </section>

        <!-- Homeowner Testimonials -->
        <section class="mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">What Fort Myers Homeowners Say</h2>
            <div class="grid md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            <?php for ($i = 0; $i < 5; $i++): ?>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-4 italic">"We installed flood panels before Hurricane Ian, and they saved our Fort Myers home. The installation was quick, and the panels deployed in minutes when we needed them. Zero water intrusion during the storm surge."</p>
                    <p class="text-sm font-semibold text-gray-900">— Robert M., Fort Myers Homeowner</p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            <?php for ($i = 0; $i < 5; $i++): ?>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-4 italic">"The team handled everything—permits, installation, everything. Our Fort Myers home is now protected from storm surge, and our flood insurance premium dropped by 30%. Highly recommend for Fort Myers homeowners."</p>
                    <p class="text-sm font-semibold text-gray-900">— Jennifer K., Fort Myers Homeowner</p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            <?php for ($i = 0; $i < 5; $i++): ?>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-4 italic">"Living near the Caloosahatchee River in Fort Myers, we needed surge protection. The flood panels are easy to deploy, and the peace of mind is worth every penny. Professional installation and excellent service."</p>
                    <p class="text-sm font-semibold text-gray-900">— Michael D., Fort Myers Homeowner</p>
                </div>
            </div>
        </section>

        <!-- Internal Linking Section -->
        <section class="mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Related Flood Protection Resources</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <a href="/blog/fema-approved-flood-barriers" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">FEMA Technical Compliance for Fort Myers Flood Panels</h3>
                    <p class="text-gray-600">Comprehensive guide to FEMA compliance and certification requirements for Fort Myers residential flood protection.</p>
                </a>
                <a href="/faq/insurance-premium-reduction" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Storm Surge Protection Fort Myers: Insurance Impact Guide</h3>
                    <p class="text-gray-600">Discover how FEMA-compliant flood panels can reduce your insurance costs for Fort Myers homeowners facing storm surge and river overflow.</p>
                </a>
                <a href="/residential-flood-panels/cape-coral" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Residential Flood Panels in Cape Coral</h3>
                    <p class="text-gray-600">Learn about residential flood panel solutions for nearby Cape Coral homeowners in Lee County.</p>
                </a>
                <a href="/products/modular-flood-barrier" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Fort Myers Flood Panel Installation Process</h3>
                    <p class="text-gray-600">Learn about the installation process and timeline for modular flood barrier systems in Fort Myers homes.</p>
                </a>
            </div>
        </section>

        <!-- Free Assessment Form -->
        <section id="free-assessment" class="mb-12">
            <div class="bg-gradient-to-br from-blue-600 to-blue-800 text-white rounded-lg shadow-xl p-8">
                <h2 class="text-3xl font-bold mb-4">Get Your Free Flood Assessment</h2>
                <p class="text-xl mb-6">Schedule a free, no-obligation assessment of your Fort Myers home's flood protection needs.</p>
                <form method="POST" action="/contact" class="max-w-2xl">
                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="name" class="block text-sm font-semibold mb-2">Name *</label>
                            <input type="text" id="name" name="name" required class="w-full px-4 py-2 rounded-lg text-gray-900">
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-semibold mb-2">Phone *</label>
                            <input type="tel" id="phone" name="phone" required class="w-full px-4 py-2 rounded-lg text-gray-900">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="address" class="block text-sm font-semibold mb-2">Address *</label>
                        <input type="text" id="address" name="address" required placeholder="Street address in Fort Myers" class="w-full px-4 py-2 rounded-lg text-gray-900">
                    </div>
                    <div class="mb-4">
                        <label for="flood_concern" class="block text-sm font-semibold mb-2">Flood Concern Type *</label>
                        <select id="flood_concern" name="flood_concern" required class="w-full px-4 py-2 rounded-lg text-gray-900">
                            <option value="">Select your primary concern</option>
                            <option value="storm-surge">Storm Surge Protection</option>
                            <option value="river-overflow">Caloosahatchee River Overflow</option>
                            <option value="insurance-compliance">Insurance Compliance</option>
                            <option value="hurricane-preparedness">Hurricane Preparedness</option>
                            <option value="general-protection">General Flood Protection</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-white text-blue-600 font-bold py-4 px-8 rounded-lg hover:bg-blue-50 transition-colors">
                        Request Free Assessment
                    </button>
                    <p class="text-sm mt-4 text-blue-100">By submitting this form, you agree to be contacted by Flood Barrier Pros. We respect your privacy and will never share your information.</p>
                </form>
            </div>
        </section>

        <!-- FAQ Section - Above Footer -->
        <section class="mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Frequently Asked Questions</h2>
            <div class="space-y-6">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">How much do flood panels cost in Fort Myers?</h3>
                    <p class="text-gray-700">
                        Residential flood panels in Fort Myers typically cost $899-$1,499 per opening, depending on size and configuration. Entry door panels start around $899, while larger garage opening systems range from $1,299-$1,999. Whole-home protection for a standard Fort Myers home ranges from $18,000-$42,000. All panels are reusable and may qualify for up to $10,000 in FEMA flood mitigation grants. Contact us for a free, detailed quote specific to your Fort Myers property.
                    </p>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Are flood panels FEMA compliant in Fort Myers?</h3>
                    <p class="text-gray-700">
                        Yes, our residential flood panels exceed FEMA Technical Bulletin 3 (TB-3) standards with third-party certification. They withstand hydrostatic pressure testing per ASTM E330 and provide watertight seals rated for flood heights up to 8-12 feet, which is critical for Fort Myers properties facing Caloosahatchee River overflow and coastal storm surge. FEMA-certified installations may qualify for insurance premium reductions of 5-45%. We provide all FEMA compliance documentation with every installation in Fort Myers.
                    </p>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Do flood panels protect against storm surge?</h3>
                    <p class="text-gray-700">
                        Yes, FEMA-compliant flood panels provide effective protection against storm surge by creating watertight seals at doorways, garage openings, and ground-level windows. During Hurricane Ian (2022), Fort Myers experienced 8-12 foot surge heights, and flood panels prevented water intrusion in protected properties. Panels are rated for surge heights up to 8 feet and can be combined with elevation improvements for higher surge protection.
                    </p>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">How fast can flood panels be installed before a hurricane?</h3>
                    <p class="text-gray-700">
                        Once tracks are pre-installed, flood panels deploy in 3-6 minutes per opening. For emergency situations, our Fort Myers installation team offers rapid deployment services with 24-48 hour notice before expected storm landfall. We recommend deploying barriers 24-48 hours before expected storm landfall to ensure adequate preparation time for Fort Myers homeowners facing Caloosahatchee River overflow and coastal surge risks.
                    </p>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Do I need permits for flood panels in Fort Myers?</h3>
                    <p class="text-gray-700">
                        Yes, permanent flood panel installations in Fort Myers require building permits from the City of Fort Myers Building Division. Our team handles all permitting, coordinates with Lee County building departments, and ensures compliance with Florida Building Code and FEMA requirements. Temporary deployment of pre-installed systems typically does not require permits, but we recommend checking with local authorities.
                    </p>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">What flood zones require flood panels in Fort Myers?</h3>
                    <p class="text-gray-700">
                        Fort Myers is primarily in Flood Zones AE, VE, and A. Zone AE (base flood) requires protection from stillwater flooding, Zone VE (coastal high hazard) requires structures to withstand wave action and surge, and Zone A requires elevation certificates. Properties along the Caloosahatchee River and coastal areas face the highest risk and require FEMA-compliant barriers rated for surge heights of 8-12 feet.
                    </p>
                </div>
            </div>
        </section>
    </div>
</article>

<!-- Sticky CTA for Mobile -->
<div class="fixed bottom-0 left-0 right-0 bg-orange-600 text-white p-4 shadow-lg z-50 md:hidden">
    <div class="flex gap-2">
        <a href="#free-assessment" class="flex-1 bg-white text-blue-600 font-bold py-3 px-4 rounded-lg text-center">
            Free Assessment
        </a>
        <a href="<?= \App\Config::getPhoneLink() ?>" class="flex-1 bg-orange-700 text-white font-bold py-3 px-4 rounded-lg text-center">
            Call Now
        </a>
    </div>
</div>

