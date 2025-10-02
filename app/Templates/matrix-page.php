<article class="matrix-page">
    <div class="container">
        <header class="page-header">
            <h1><?= htmlspecialchars($h1) ?></h1>
            <p class="page-subtitle">Professional <?= htmlspecialchars($keyword) ?> services in <?= htmlspecialchars($city) ?>, <?= htmlspecialchars($county) ?></p>
        </header>

        <div class="content-grid">
            <div class="main-content">
                <section class="service-overview">
                    <h2><?= htmlspecialchars($keyword) ?> in <?= htmlspecialchars($city) ?></h2>
                    <p>Rubicon Flood Protection specializes in <?= htmlspecialchars($keyword) ?> for homes and businesses in <?= htmlspecialchars($city) ?>, <?= htmlspecialchars($county) ?>. Our experienced team provides custom solutions tailored to your property's specific needs.</p>
                    
                    <div class="service-features">
                        <h3>Our <?= htmlspecialchars($keyword) ?> Services Include:</h3>
                        <ul>
                            <li>Custom-designed flood barriers</li>
                            <li>Quick-deploy flood panels</li>
                            <li>Door and window protection</li>
                            <li>Garage flood protection</li>
                            <li>Professional installation</li>
                            <li>Maintenance and support</li>
                        </ul>
                    </div>
                </section>

                <section class="product-info">
                    <h2><?= htmlspecialchars($product_name) ?></h2>
                    <div class="product-details">
                        <div class="product-specs">
                            <p><strong>Brand:</strong> <?= htmlspecialchars($product_brand) ?></p>
                            <p><strong>SKU:</strong> <?= htmlspecialchars($product_sku) ?></p>
                            <p><strong>Starting at:</strong> $<?= number_format($product_price_min) ?> <?= htmlspecialchars($product_currency) ?></p>
                        </div>
                        <div class="product-description">
                            <p>This comprehensive <?= htmlspecialchars($keyword) ?> kit is specifically designed for properties in <?= htmlspecialchars($city) ?>. It includes all necessary components for complete flood protection.</p>
                        </div>
                    </div>
                </section>

                <?php if (!empty($resources)): ?>
                <section class="resources">
                    <h2>Additional Resources</h2>
                    <div class="resource-links">
                        <?php 
                        $resourceUrls = explode(' | ', $resources);
                        foreach ($resourceUrls as $url): 
                            if (trim($url)):
                        ?>
                        <a href="<?= htmlspecialchars(trim($url)) ?>" target="_blank" rel="noopener" class="resource-link">
                            <?= htmlspecialchars(parse_url(trim($url), PHP_URL_HOST)) ?>
                        </a>
                        <?php 
                            endif;
                        endforeach; 
                        ?>
                    </div>
                </section>
                <?php endif; ?>
            </div>

            <aside class="sidebar">
                <div class="contact-card">
                    <h3>Get Your Free Quote</h3>
                    <p>Ready to protect your <?= htmlspecialchars($city) ?> property? Contact us today for a free, no-obligation quote.</p>
                    <div class="contact-info">
                        <p><strong>Phone:</strong> <a href="tel:<?= htmlspecialchars($telephone) ?>"><?= htmlspecialchars($telephone) ?></a></p>
                        <p><strong>Address:</strong> <?= htmlspecialchars($address) ?>, <?= htmlspecialchars($city) ?>, FL <?= htmlspecialchars($zip) ?></p>
                    </div>
                    <a href="tel:<?= htmlspecialchars($telephone) ?>" class="btn btn-primary btn-block">Call Now</a>
                </div>

                <div class="service-areas">
                    <h3>We Also Serve</h3>
                    <ul>
                        <li><a href="/<?= \App\Util::slugify($keyword) ?>/miami-beach">Miami Beach</a></li>
                        <li><a href="/<?= \App\Util::slugify($keyword) ?>/fort-lauderdale">Fort Lauderdale</a></li>
                        <li><a href="/<?= \App\Util::slugify($keyword) ?>/west-palm-beach">West Palm Beach</a></li>
                        <li><a href="/<?= \App\Util::slugify($keyword) ?>/boca-raton">Boca Raton</a></li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</article>
