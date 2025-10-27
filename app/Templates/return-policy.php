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
                <h2 class="text-2xl font-semibold text-gray-800">Defective Product Return Policy</h2>
                <p class="text-gray-600 mt-3">
                    At Flood Barrier Pros, we stand behind the quality of our products. If you receive a defective product or a product damaged in transit, we will replace it or provide a full refund. All defective or damaged products must be reported within 30 days of delivery.
                </p>
            </section>

            <section>
                <h2 class="text-2xl font-semibold text-gray-800">Eligibility for Returns</h2>
                <ul class="list-disc list-inside space-y-2 text-gray-600 mt-3">
                    <li>Products that arrived defective or damaged</li>
                    <li>Products damaged during transit</li>
                    <li>Manufacturing defects discovered within 30 days of delivery</li>
                    <li>Missing components or incorrect parts</li>
                    <li>Products that do not meet advertised specifications</li>
                </ul>
                <p class="text-gray-600 mt-4 italic">
                    <strong>Note:</strong> We do not accept returns on non-defective products. All sales on properly functioning products are final.
                </p>
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
                    All return shipping costs are covered by Flood Barrier Pros for defective items or items damaged in transit. We provide a prepaid return label upon approval of your return claim. Custom orders that are defective will have return shipping covered.
                </p>
            </section>

            <section>
                <h2 class="text-2xl font-semibold text-gray-800">Refund Processing</h2>
                <p class="text-gray-600 mt-3">
                    Once we receive and inspect your returned item, we will process your refund within 5-7 business days. Refunds will be issued to the original payment method. Please allow 2-3 additional business days for the refund to appear in your account depending on your financial institution.
                </p>
            </section>

            <section>
                <h2 class="text-2xl font-semibold text-gray-800">All Sales Final on Non-Defective Products</h2>
                <p class="text-gray-600 mt-3">
                    We do not accept returns on properly functioning, non-defective products. All sales are final. This includes:
                </p>
                <ul class="list-disc list-inside space-y-2 text-gray-600 mt-3">
                    <li>Products that are in working condition as advertised</li>
                    <li>Products that have been installed or used</li>
                    <li>Change of mind or buyer's remorse returns</li>
                    <li>Size exchanges on functioning products</li>
                    <li>Custom or bespoke products (unless defective)</li>
                    <li>Products that have been modified or altered by the customer</li>
                </ul>
            </section>

            <section>
                <h2 class="text-2xl font-semibold text-gray-800">Exchanges for Defective Items</h2>
                <p class="text-gray-600 mt-3">
                    For defective products, we offer exchanges for the same or similar product within the 30-day window. Replacement items are subject to availability. If a replacement is not available, we will provide a full refund.
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

