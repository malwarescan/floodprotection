<section class="service-page">
    <div class="container">
        <header class="page-header">
            <h1><?= htmlspecialchars($serviceName) ?> Services in Florida</h1>
            <p class="page-subtitle">Professional <?= htmlspecialchars($serviceName) ?> solutions throughout Florida</p>
        </header>

        <div class="service-content">
            <div class="service-intro">
                <h2>Comprehensive <?= htmlspecialchars($serviceName) ?> Solutions</h2>
                <p>Rubicon Flood Protection specializes in <?= htmlspecialchars($serviceName) ?> services across Florida. Our experienced team provides custom solutions designed to protect your property from flood damage with the highest quality materials and professional installation.</p>
                
                <div class="service-features">
                    <h3>Why Choose Our <?= htmlspecialchars($serviceName) ?> Services?</h3>
                    <ul>
                        <li><strong>Expert Installation:</strong> Licensed professionals with years of experience</li>
                        <li><strong>Custom Solutions:</strong> Tailored to your specific property needs</li>
                        <li><strong>Quality Materials:</strong> Only the highest grade flood protection products</li>
                        <li><strong>Fast Response:</strong> Emergency installation available within 24-48 hours</li>
                        <li><strong>Warranty Coverage:</strong> Comprehensive warranties on all installations</li>
                        <li><strong>Florida Licensed:</strong> Fully licensed and insured for work throughout Florida</li>
                    </ul>
                </div>
            </div>

            <div class="cities-section">
                <h2>Service Areas</h2>
                <p>We provide <?= htmlspecialchars($serviceName) ?> services in the following Florida cities:</p>
                <div class="cities-grid">
                    <?php foreach ($cities as $city): ?>
                    <div class="city-card">
                        <h3><?= htmlspecialchars($city['cityName']) ?></h3>
                        <p>Professional <?= htmlspecialchars($serviceName) ?> services in <?= htmlspecialchars($city['cityName']) ?>.</p>
                        <a href="<?= htmlspecialchars($city['url']) ?>" class="btn btn-outline">View <?= htmlspecialchars($city['cityName']) ?> Services</a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="service-details">
                <h2>Our <?= htmlspecialchars($serviceName) ?> Process</h2>
                <div class="process-steps">
                    <div class="step">
                        <h3>1. Free Consultation</h3>
                        <p>We'll assess your property and discuss your specific flood protection needs.</p>
                    </div>
                    <div class="step">
                        <h3>2. Custom Design</h3>
                        <p>Our team will design a <?= htmlspecialchars($serviceName) ?> solution tailored to your property.</p>
                    </div>
                    <div class="step">
                        <h3>3. Professional Installation</h3>
                        <p>Our licensed technicians will install your flood protection system with precision.</p>
                    </div>
                    <div class="step">
                        <h3>4. Ongoing Support</h3>
                        <p>We provide maintenance and support to ensure your system continues to protect your property.</p>
                    </div>
                </div>
            </div>

            <div class="cta-section">
                <h2>Get Your Free <?= htmlspecialchars($serviceName) ?> Quote</h2>
                <p>Ready to protect your property with professional <?= htmlspecialchars($serviceName) ?> services? Contact us today for a free consultation and quote.</p>
                <div class="contact-info">
                    <p><strong>Phone:</strong> <a href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>"><?= htmlspecialchars(\App\Config::get('phone')) ?></a></p>
                    <p><strong>Service Area:</strong> Throughout Florida</p>
                </div>
                <a href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>" class="btn btn-primary btn-large">Call Now for Free Quote</a>
            </div>
        </div>
    </div>
</section>
