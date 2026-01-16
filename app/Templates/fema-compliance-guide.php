<?php
$canonical = \App\Config::get('app_url') . '/fema-compliance-guide';
?>

<section class="bg-white py-12 md:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-8">FEMA Compliance & Flood Protection Guide</h1>
        
        <div class="prose prose-lg max-w-none">
            <p class="text-sm text-gray-600 mb-6">Last Updated: <?= date('F j, Y') ?></p>
            
            <h2 class="text-2xl font-semibold mt-8 mb-4">Understanding FEMA Guidelines</h2>
            <p>The Federal Emergency Management Agency (FEMA) establishes guidelines for flood protection to reduce the risk of structural damage relative to the base flood elevation (BFE). Compliance with these guidelines is essential for ensuring safety, meeting insurance requirements, and obtaining building permits in flood-prone areas.</p>
            
            <h2 class="text-2xl font-semibold mt-8 mb-4">Dry Floodproofing vs. Wet Floodproofing</h2>
            <p>FEMA recognizes two primary methods for floodproofing structures:</p>
            <ul class="list-disc ml-6 space-y-2">
                <li><strong>Dry Floodproofing:</strong> Involves making the structure watertight below the flood protection level. This prevents water from entering and is typically used for non-residential buildings or specific residential applications where permitted. Our modular barriers are designed for dry floodproofing.</li>
                <li><strong>Wet Floodproofing:</strong> Allows floodwaters to enter and exit enclosed areas (like crawlspaces or garages) to equalize hydrostatic pressure. This reduces the risk of structural failure but requires flood-resistant materials and elevating essential utilities.</li>
            </ul>
            
            <h2 class="text-2xl font-semibold mt-8 mb-4">FEMA Technical Bulletin 3-93</h2>
            <p>This bulletin provides technical guidance on non-residential floodproofing permits and certifications. Key requirements include:</p>
            <ul class="list-disc ml-6 space-y-2">
                <li><strong>Design Certification:</strong> A registered design professional must certify that the floodproofing design will meet performance standards.</li>
                <li><strong>Structural Integrity:</strong> Walls and barriers must be capable of resisting hydrostatic and hydrodynamic loads.</li>
                <li><strong>Operations & Maintenance Plan:</strong> A documented plan must be in place to ensure barriers are deployed correctly before a flood event.</li>
            </ul>
            
            <h2 class="text-2xl font-semibold mt-8 mb-4">Flood Insurance Implications</h2>
            <p>Properly implemented flood mitigation measures can significantly reduce flood insurance premiums under the National Flood Insurance Program (NFIP). To qualify for discounts:</p>
            <ul class="list-disc ml-6 space-y-2">
                <li>Barriers must be FEMA-compliant and certified by an engineer.</li>
                <li>Documentation (Elevation Certificates and Floodproofing Certificates) must be submitted to your insurer.</li>
            </ul>
            
            <h2 class="text-2xl font-semibold mt-8 mb-4">Our Compliance Commitment</h2>
            <p>Flood Barrier Pros provides systems engineered to meet or exceed FEMA standards. Our products undergo rigorous testing to ensure they can withstand the pressures of flood events.</p>
            <p>We provide:</p>
            <ul class="list-disc ml-6 space-y-2">
                <li>Engineering submittal packages for permitting.</li>
                <li>Detailed installation and deployment guides.</li>
                <li>Assistance with floodproofing certification processes.</li>
            </ul>
            
            <h2 class="text-2xl font-semibold mt-8 mb-4">Need Assistance?</h2>
            <p>Navigating FEMA compliance can be complex. Contact our team for a consultation regarding your specific property and flood zone requirements.</p>
            <div class="bg-gray-50 p-4 rounded-lg mt-4">
                <p><strong>Flood Barrier Pros</strong><br>
                Email: info@floodbarrierpros.com<br>
                Phone: <?= \App\Config::get('phone') ?><br>
                Website: <a href="<?= \App\Config::get('app_url') ?>" class="text-blue-600 hover:underline">floodbarrierpros.com</a></p>
            </div>
        </div>
    </div>
</section>
