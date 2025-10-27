<?php
$canonical = Config::get('app_url') . '/terms-of-service';
?>

<section class="bg-white py-12 md:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-8">Terms of Service</h1>
        
        <div class="prose prose-lg max-w-none">
            <p class="text-sm text-gray-600 mb-6">Last Updated: <?= date('F j, Y') ?></p>
            
            <h2 class="text-2xl font-semibold mt-8 mb-4">1. Agreement to Terms</h2>
            <p>By accessing or using the Flood Barrier Pros website (floodbarrierpros.com) or our services, you agree to be bound by these Terms of Service ("Terms"). If you do not agree to these Terms, please do not use our website or services.</p>
            
            <h2 class="text-2xl font-semibold mt-8 mb-4">2. Services</h2>
            <p>Flood Barrier Pros provides flood protection products and services, including consultation, installation, and maintenance of flood barriers and related systems in Southwest Florida. Our services include:</p>
            <ul class="list-disc ml-6 space-y-2">
                <li>Flood barrier assessment and consultation</li>
                <li>Flood barrier system installation</li>
                <li>Custom flood barrier design and fabrication</li>
                <li>Maintenance and repair services</li>
                <li>Flood risk assessment</li>
            </ul>
            
            <h2 class="text-2xl font-semibold mt-8 mb-4">3. Eligibility</h2>
            <p>You must be at least 18 years old and have the legal capacity to enter into contracts in your jurisdiction to use our services. By using our services, you represent and warrant that you meet these requirements.</p>
            
            <h2 class="text-2xl font-semibold mt-8 mb-4">4. Service Agreements</h2>
            <p>All services provided by Flood Barrier Pros are subject to a separate written service agreement that will specify, among other things:</p>
            <ul class="list-disc ml-6 space-y-2">
                <li>Scope of work and services to be performed</li>
                <li>Price and payment terms</li>
                <li>Timeline and deadlines</li>
                <li>Warranty and guarantee terms</li>
                <li>Terms and conditions specific to the service</li>
            </ul>
            
            <h2 class="text-2xl font-semibold mt-8 mb-4">5. Intellectual Property</h2>
            <p>All content on this website, including text, graphics, logos, images, and software, is the property of Flood Barrier Pros or its licensors and is protected by copyright, trademark, and other intellectual property laws. You may not reproduce, distribute, or create derivative works from our content without our express written permission.</p>
            
            <h2 class="text-2xl font-semibold mt-8 mb-4">6. User Conduct</h2>
            <p>You agree not to:</p>
            <ul class="list-disc ml-6 space-y-2">
                <li>Use our website or services for any illegal or unauthorized purpose</li>
                <li>Violate any applicable laws or regulations</li>
                <li>Infringe upon the rights of others</li>
                <li>Transmit any viruses, malware, or harmful code</li>
                <li>Attempt to gain unauthorized access to our systems</li>
                <li>Interfere with or disrupt the operation of our website or services</li>
            </ul>
            
            <h2 class="text-2xl font-semibold mt-8 mb-4">7. Disclaimer of Warranties</h2>
            <p>Our website and services are provided "as is" and "as available" without warranties of any kind, either express or implied, including but not limited to warranties of merchantability, fitness for a particular purpose, or non-infringement. While we strive to provide accurate information, we do not guarantee that our website will be error-free, secure, or continuously available.</p>
            
            <h2 class="text-2xl font-semibold mt-8 mb-4">8. Limitation of Liability</h2>
            <p>To the maximum extent permitted by law, Flood Barrier Pros and its affiliates shall not be liable for any indirect, incidental, special, consequential, or punitive damages, including but not limited to loss of profits, data, or use, arising out of or related to your use of our website or services, even if we have been advised of the possibility of such damages.</p>
            
            <h2 class="text-2xl font-semibold mt-8 mb-4">9. Indemnification</h2>
            <p>You agree to indemnify, defend, and hold harmless Flood Barrier Pros and its officers, directors, employees, and agents from any claims, damages, losses, liabilities, and expenses (including attorney's fees) arising out of or related to your use of our website or services, violation of these Terms, or infringement of any rights of another party.</p>
            
            <h2 class="text-2xl font-semibold mt-8 mb-4">10. Modifications to Services</h2>
            <p>We reserve the right to modify, suspend, or discontinue any part of our website or services at any time, with or without notice. We will not be liable to you or any third party for any modification, suspension, or discontinuation of our services.</p>
            
            <h2 class="text-2xl font-semibold mt-8 mb-4">11. Termination</h2>
            <p>We may terminate or suspend your access to our website or services at any time, for any reason, including breach of these Terms, without prior notice or liability. Upon termination, your right to use the website and services will immediately cease.</p>
            
            <h2 class="text-2xl font-semibold mt-8 mb-4">12. Governing Law</h2>
            <p>These Terms shall be governed by and construed in accordance with the laws of the State of Florida, without regard to its conflict of law provisions. Any disputes arising out of or related to these Terms or our services shall be resolved in the courts of Pinellas County, Florida.</p>
            
            <h2 class="text-2xl font-semibold mt-8 mb-4">13. Changes to Terms</h2>
            <p>We reserve the right to modify these Terms at any time. We will notify you of any material changes by posting the updated Terms on this page and updating the "Last Updated" date. Your continued use of our website or services after such modifications constitutes your acceptance of the updated Terms.</p>
            
            <h2 class="text-2xl font-semibold mt-8 mb-4">14. Contact Information</h2>
            <p>If you have any questions about these Terms of Service, please contact us:</p>
            <div class="bg-gray-50 p-4 rounded-lg mt-4">
                <p><strong>Flood Barrier Pros</strong><br>
                Email: info@floodbarrierpros.com<br>
                Phone: <?= Config::get('phone') ?><br>
                Website: <a href="<?= Config::get('app_url') ?>" class="text-blue-600 hover:underline">floodbarrierpros.com</a></p>
            </div>
            
            <h2 class="text-2xl font-semibold mt-8 mb-4">15. Severability</h2>
            <p>If any provision of these Terms is found to be unenforceable or invalid, that provision shall be limited or eliminated to the minimum extent necessary, and the remaining provisions shall remain in full force and effect.</p>
        </div>
    </div>
</section>
