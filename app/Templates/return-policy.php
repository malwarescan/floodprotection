<!-- Return Policy Page -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <!-- Title -->
    <div class="max-w-2xl mx-auto text-center mb-10 lg:mb-14">
        <h1 class="text-3xl font-bold md:text-4xl md:leading-tight text-primary">Return Policy</h1>
        <p class="mt-3 text-gray-600">Our commitment to your satisfaction with Flood Barrier Pros products.</p>
    </div>
    <!-- End Title -->

    <!-- Content -->
    <div class="max-w-3xl mx-auto prose prose-gray">
        <div class="space-y-6">
            <section>
                <h2 class="text-2xl font-semibold text-gray-800">30-Day Return Policy</h2>
                <p class="text-gray-600 mt-3">
                    At Flood Barrier Pros, we stand behind the quality of our products. If you're not completely satisfied with your purchase, you may return it within 30 days of delivery for a full refund or exchange.
                </p>
            </section>

            <section>
                <h2 class="text-2xl font-semibold text-gray-800">Eligibility Requirements</h2>
                <ul class="list-disc list-inside space-y-2 text-gray-600 mt-3">
                    <li>Items must be unused and in their original packaging</li>
                    <li>Items must be in new, undamaged condition</li>
                    <li>All original components and accessories must be included</li>
                    <li>Return must be initiated within 30 days of delivery date</li>
                    <li>For custom or custom-sized products, returns are subject to manufacturer approval</li>
                </ul>
            </section>

            <section>
                <h2 class="text-2xl font-semibold text-gray-800">How to Return</h2>
                <ol class="list-decimal list-inside space-y-2 text-gray-600 mt-3">
                    <li>Contact us at <a href="mailto:<?= \App\Config::get('email') ?>" class="text-primary hover:text-primary-600"><?= \App\Config::get('email') ?></a> or call <?= \App\Config::get('phone') ?> to initiate a return</li>
                    <li>Provide your order number and reason for return</li>
                    <li>Receive return authorization and shipping instructions</li>
                    <li>Pack the item securely in its original packaging</li>
                    <li>Ship the item using the provided return label or approved carrier</li>
                </ol>
            </section>

            <section>
                <h2 class="text-2xl font-semibold text-gray-800">Return Shipping</h2>
                <p class="text-gray-600 mt-3">
                    Return shipping fees are covered by the customer for standard returns. We provide a prepaid return label for defective items or items damaged in transit. Custom orders may incur additional return shipping costs.
                </p>
            </section>

            <section>
                <h2 class="text-2xl font-semibold text-gray-800">Refund Processing</h2>
                <p class="text-gray-600 mt-3">
                    Once we receive and inspect your returned item, we will process your refund within 5-7 business days. Refunds will be issued to the original payment method. Please allow 2-3 additional business days for the refund to appear in your account depending on your financial institution.
                </p>
            </section>

            <section>
                <h2 class="text-2xl font-semibold text-gray-800">Non-Returnable Items</h2>
                <ul class="list-disc list-inside space-y-2 text-gray-600 mt-3">
                    <li>Products that have been installed, modified, or damaged by customer</li>
                    <li>Products that show signs of misuse or abuse</li>
                    <li>Products missing original packaging or components</li>
                    <li>Custom orders (unless defective or damaged)</li>
                    <li>Products purchased from authorized dealers (subject to dealer policy)</li>
                </ul>
            </section>

            <section>
                <h2 class="text-2xl font-semibold text-gray-800">Exchanges</h2>
                <p class="text-gray-600 mt-3">
                    We offer exchanges for different sizes or models of the same product type within the 30-day return window. Exchange items are subject to availability. Additional charges may apply for higher-value replacement items.
                </p>
            </section>

            <section>
                <h2 class="text-2xl font-semibold text-gray-800">Warranty Information</h2>
                <p class="text-gray-600 mt-3">
                    Our flood barrier systems come with a manufacturer's warranty covering defects in materials and workmanship. Warranty claims should be directed to our customer service team at <?= \App\Config::get('phone') ?> or <a href="mailto:<?= \App\Config::get('email') ?>" class="text-primary hover:text-primary-600"><?= \App\Config::get('email') ?></a>.
                </p>
            </section>

            <section>
                <h2 class="text-2xl font-semibold text-gray-800">Contact Us</h2>
                <p class="text-gray-600 mt-3">
                    If you have any questions about our return policy or need assistance with a return, please contact our customer service team:
                </p>
                <div class="bg-gray-50 p-4 rounded-lg mt-4">
                    <p class="text-gray-700">
                        <strong>Email:</strong> <a href="mailto:<?= \App\Config::get('email') ?>" class="text-primary hover:text-primary-600"><?= \App\Config::get('email') ?></a><br>
                        <strong>Phone:</strong> <a href="<?= \App\Config::getPhoneLink() ?>" class="text-primary hover:text-primary-600"><?= \App\Config::get('phone') ?></a><br>
                        <strong>Hours:</strong> Monday-Friday, 8:00 AM - 6:00 PM EST
                    </p>
                </div>
            </section>

            <section>
                <h2 class="text-2xl font-semibold text-gray-800">Questions?</h2>
                <p class="text-gray-600 mt-3">
                    Our customer service team is here to help. If you have any questions about our return policy or need assistance, please don't hesitate to reach out to us.
                </p>
            </section>

            <section class="text-sm text-gray-500 mt-8">
                <p>Last updated: <?= date('F j, Y') ?></p>
            </section>
        </div>
    </div>
</div>
<!-- End Return Policy Page -->

