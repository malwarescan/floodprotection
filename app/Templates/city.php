<section class="city-page">
    <div class="container">
        <header class="page-header">
            <h1>Flood Protection Services in <?= htmlspecialchars($cityName) ?></h1>
            <p class="page-subtitle">Professional flood protection solutions for <?= htmlspecialchars($cityName) ?>, Florida</p>
        </header>

        <div class="city-content">
            <div class="city-intro">
                <h2>Protect Your <?= htmlspecialchars($cityName) ?> Property</h2>
                <p>Rubicon Flood Protection provides comprehensive flood protection services throughout <?= htmlspecialchars($cityName) ?>, Florida. Our experienced team specializes in custom flood barriers, panels, and dry floodproofing solutions designed to protect your property from rising water levels.</p>
                
                <div class="city-features">
                    <h3>Why Choose Us for <?= htmlspecialchars($cityName) ?> Flood Protection?</h3>
                    <ul>
                        <li><strong>Local Expertise:</strong> Deep knowledge of <?= htmlspecialchars($cityName) ?> flood patterns and requirements</li>
                        <li><strong>Fast Response:</strong> Emergency installation available within 24-48 hours</li>
                        <li><strong>Custom Solutions:</strong> Tailored protection systems for your specific property</li>
                        <li><strong>Florida Licensed:</strong> Fully licensed and insured for work in <?= htmlspecialchars($cityName) ?></li>
                        <li><strong>Quality Products:</strong> Only the highest quality materials with 20+ year warranties</li>
                    </ul>
                </div>
            </div>

            <div class="services-section">
                <h2>Our <?= htmlspecialchars($cityName) ?> Services</h2>
                <div class="services-grid">
                    <?php foreach ($services as $service): ?>
                    <div class="service-card">
                        <h3><?= htmlspecialchars($service['title']) ?></h3>
                        <p>Professional <?= htmlspecialchars($service['title']) ?> installation and maintenance in <?= htmlspecialchars($cityName) ?>.</p>
                        <a href="<?= htmlspecialchars($service['url']) ?>" class="btn btn-outline">Learn More</a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="coverage-info">
                <h2>Service Areas in <?= htmlspecialchars($cityName) ?></h2>
                <p>We provide flood protection services throughout <?= htmlspecialchars($cityName) ?> and surrounding areas, including:</p>
                <ul>
                    <li>Residential properties</li>
                    <li>Commercial buildings</li>
                    <li>Industrial facilities</li>
                    <li>Government buildings</li>
                    <li>Schools and hospitals</li>
                </ul>
            </div>

            <div class="cta-section">
                <h2>Get Your Free <?= htmlspecialchars($cityName) ?> Quote</h2>
                <p>Ready to protect your <?= htmlspecialchars($cityName) ?> property? Contact us today for a free, no-obligation consultation and quote.</p>
                <div class="contact-info">
                    <p><strong>Phone:</strong> <a href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>"><?= htmlspecialchars(\App\Config::get('phone')) ?></a></p>
                    <p><strong>Service Area:</strong> <?= htmlspecialchars($cityName) ?>, Florida</p>
                </div>
                <a href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>" class="btn btn-primary btn-large">Call Now for Free Quote</a>
            </div>
        </div>
    </div>
</section>
