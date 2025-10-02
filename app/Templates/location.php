<section class="hero">
    <div class="container">
        <h1><?= htmlspecialchars($productData['name']) ?> – <?= htmlspecialchars($cityName) ?>, FL</h1>
        <p class="lead">Professional <?= htmlspecialchars($productData['name']) ?> installation in <?= htmlspecialchars($cityName) ?>, Florida. Fast installation, quality materials, local expertise.</p>
        <div class="cta-stack">
            <a class="btn btn-primary" href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>">Get Free Quote</a>
            <a class="btn btn-secondary" href="<?= htmlspecialchars($productData['product_url']) ?>">View Product Details</a>
        </div>
    </div>
</section>

<section class="location-overview">
    <div class="container">
        <div class="location-grid">
            <div class="location-info">
                <h2><?= htmlspecialchars($cityName) ?> Flood Protection</h2>
                <p>Protect your <?= htmlspecialchars($cityName) ?> property with our professional <?= htmlspecialchars($productData['name']) ?> installation services. Our experienced team provides custom solutions tailored to your specific needs.</p>
                
                <div class="location-features">
                    <h3>Why Choose Us in <?= htmlspecialchars($cityName) ?>?</h3>
                    <ul>
                        <li>Local expertise in <?= htmlspecialchars($cityName) ?> flood patterns</li>
                        <li>Fast installation within 24-48 hours</li>
                        <li>Free on-site assessment and quote</li>
                        <li>Quality materials with 20+ year warranty</li>
                        <li>Licensed and insured professionals</li>
                    </ul>
                </div>
            </div>
            
            <div class="product-reference">
                <div class="product-card">
                    <img src="<?= htmlspecialchars($productData['image']) ?>" alt="<?= htmlspecialchars($productData['name']) ?>" />
                    <h3><?= htmlspecialchars($productData['name']) ?></h3>
                    <p><?= htmlspecialchars($productData['description']) ?></p>
                    <div class="product-specs">
                        <p><strong>SKU:</strong> <?= htmlspecialchars($productData['sku']) ?></p>
                        <p><strong>Starting at:</strong> $<?= htmlspecialchars($productData['starting_price']) ?></p>
                    </div>
                    <a href="<?= htmlspecialchars($productData['product_url']) ?>" class="btn btn-outline">View Full Product Details</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="local-service-areas">
    <div class="container">
        <h2>We Also Serve These <?= htmlspecialchars($cityName) ?> Areas</h2>
        <div class="areas-grid">
            <?php
            $nearbyAreas = [
                'fort-myers' => 'Fort Myers',
                'cape-coral' => 'Cape Coral', 
                'naples' => 'Naples',
                'bonita-springs' => 'Bonita Springs',
                'estero' => 'Estero',
                'punta-gorda' => 'Punta Gorda',
                'port-charlotte' => 'Port Charlotte',
                'sarasota' => 'Sarasota',
                'bradenton' => 'Bradenton',
                'st-petersburg' => 'St. Petersburg',
                'clearwater' => 'Clearwater',
                'tampa' => 'Tampa'
            ];
            
            foreach ($nearbyAreas as $slug => $name):
                if ($slug !== $city):
            ?>
            <a href="/fl/<?= htmlspecialchars($slug) ?>/<?= htmlspecialchars($product) ?>" class="area-link">
                <?= htmlspecialchars($name) ?>
            </a>
            <?php 
                endif;
            endforeach; 
            ?>
        </div>
    </div>
</section>

<section class="cta">
    <div class="container">
        <h2>Ready to Protect Your <?= htmlspecialchars($cityName) ?> Property?</h2>
        <p>Get your free quote for <?= htmlspecialchars($productData['name']) ?> installation in <?= htmlspecialchars($cityName) ?> today.</p>
        <div class="contact-info">
            <p><strong>Phone:</strong> <a href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>"><?= htmlspecialchars(\App\Config::get('phone')) ?></a></p>
            <p><strong>Email:</strong> <a href="mailto:<?= htmlspecialchars(\App\Config::get('email')) ?>"><?= htmlspecialchars(\App\Config::get('email')) ?></a></p>
            <p><strong>Service Area:</strong> <?= htmlspecialchars($cityName) ?>, Florida</p>
        </div>
        <a href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>" class="btn btn-primary btn-large">Call Now for Free Quote</a>
    </div>
</section>
