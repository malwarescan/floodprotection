<?php
$canonical = Config::get('app_url') . '/privacy-policy';
?>

<section class="bg-white py-12 md:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-8">Privacy Policy</h1>
        
        <div class="prose prose-lg max-w-none">
            <p class="text-sm text-gray-600 mb-6">Last Updated: <?= date('F j, Y') ?></p>
            
            <h2 class="text-2xl font-semibold mt-8 mb-4">1. Introduction</h2>
            <p>Flood Barrier Pros ("we," "our," or "us") respects your privacy and is committed to protecting your personal information. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website, floodbarrierpros.com, or use our services.</p>
            
            <h2 class="text-2xl font-semibold mt-8 mb-4">2. Information We Collect</h2>
            <h3 class="text-xl font-semibold mt-6 mb-3">Personal Information</h3>
            <p>We may collect personal information that you voluntarily provide to us when you:</p>
            <ul class="list-disc ml-6 space-y-2">
                <li>Request a quote or consultation</li>
                <li>Contact us via phone, email, or contact form</li>
                <li>Subscribe to our newsletter</li>
                <li>Leave a review or testimonial</li>
            </ul>
            <p class="mt-4">This information may include:</p>
            <ul class="list-disc ml-6 space-y-2">
                <li>Name, email address, phone number</li>
                <li>Physical address (for service location assessment)</li>
                <li>Property details (size, type, flood risk level)</li>
                <li>Any other information you choose to provide</li>
            </ul>
            
            <h3 class="text-xl font-semibold mt-6 mb-3">Automatically Collected Information</h3>
            <p>We may collect certain information automatically when you visit our website, including:</p>
            <ul class="list-disc ml-6 space-y-2">
                <li>IP address and browser type</li>
                <li>Pages viewed, time spent on pages, and referring website</li>
                <li>Device information (operating system, screen resolution)</li>
                <li>Cookies and similar tracking technologies</li>
            </ul>
            
            <h2 class="text-2xl font-semibold mt-8 mb-4">3. How We Use Your Information</h2>
            <p>We use the information we collect to:</p>
            <ul class="list-disc ml-6 space-y-2">
                <li>Provide and improve our flood protection services</li>
                <li>Respond to your inquiries and provide customer support</li>
                <li>Send you information about our products and services (with your consent)</li>
                <li>Process transactions and manage accounts</li>
                <li>Analyze website usage and improve user experience</li>
                <li>Comply with legal obligations</li>
                <li>Prevent fraudulent activity and protect our business</li>
            </ul>
            
            <h2 class="text-2xl font-semibold mt-8 mb-4">4. Information Sharing</h2>
            <p>We do not sell your personal information. We may share your information only in the following circumstances:</p>
            <ul class="list-disc ml-6 space-y-2">
                <li><strong>Service Providers:</strong> With third-party vendors who perform services on our behalf (e.g., payment processing, website hosting)</li>
                <li><strong>Legal Requirements:</strong> When required by law or to protect our rights</li>
                <li><strong>Business Transfers:</strong> In connection with a merger, acquisition, or sale of assets</li>
                <li><strong>With Your Consent:</strong> When you have explicitly authorized us to share your information</li>
            </ul>
            
            <h2 class="text-2xl font-semibold mt-8 mb-4">5. Cookies and Tracking Technologies</h2>
            <p>We use cookies and similar technologies to enhance your browsing experience, analyze site traffic, and understand user preferences. You can control cookies through your browser settings, though this may limit some website functionality.</p>
            
            <h2 class="text-2xl font-semibold mt-8 mb-4">6. Data Security</h2>
            <p>We implement appropriate technical and organizational measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction. However, no method of transmission over the Internet is 100% secure, and we cannot guarantee absolute security.</p>
            
            <h2 class="text-2xl font-semibold mt-8 mb-4">7. Your Rights</h2>
            <p>Depending on your location, you may have certain rights regarding your personal information, including:</p>
            <ul class="list-disc ml-6 space-y-2">
                <li>Access to your personal information</li>
                <li>Correction of inaccurate data</li>
                <li>Deletion of your personal information</li>
                <li>Opt-out of marketing communications</li>
                <li>Data portability</li>
            </ul>
            <p class="mt-4">To exercise these rights, please contact us using the information provided in Section 9.</p>
            
            <h2 class="text-2xl font-semibold mt-8 mb-4">8. Children's Privacy</h2>
            <p>Our website and services are not intended for children under 13 years of age. We do not knowingly collect personal information from children under 13. If you believe we have collected information from a child, please contact us immediately.</p>
            
            <h2 class="text-2xl font-semibold mt-8 mb-4">9. Contact Us</h2>
            <p>If you have questions about this Privacy Policy or wish to exercise your rights, please contact us:</p>
            <div class="bg-gray-50 p-4 rounded-lg mt-4">
                <p><strong>Flood Barrier Pros</strong><br>
                Email: info@floodbarrierpros.com<br>
                Phone: <?= Config::get('phone') ?><br>
                Website: <a href="<?= Config::get('app_url') ?>" class="text-blue-600 hover:underline">floodbarrierpros.com</a></p>
            </div>
            
            <h2 class="text-2xl font-semibold mt-8 mb-4">10. Changes to This Policy</h2>
            <p>We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page and updating the "Last Updated" date. You are advised to review this Privacy Policy periodically for any changes.</p>
        </div>
    </div>
</section>
