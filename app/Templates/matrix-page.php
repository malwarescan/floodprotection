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

                <?php if (strtolower($city) === 'clearwater'): ?>
                <section class="clearwater-beach">
                    <h2>Clearwater Beach Flood Protection</h2>
                    <p>Clearwater Beach residents face unique flood challenges due to coastal proximity and storm surge risk. Our flood protection systems are specifically designed for beach communities with saltwater-resistant materials and hurricane-grade anchoring.</p>
                    
                    <h3>Clearwater Beach Flood Protection FAQs</h3>
                    <div class="faq-item">
                        <strong>Do you serve Clearwater Beach specifically?</strong>
                        <p>Yes, we provide full service to Clearwater Beach including beach-front properties. Our systems are rated for saltwater exposure and storm surge conditions.</p>
                    </div>
                    <div class="faq-item">
                        <strong>What's different about beach flood protection?</strong>
                        <p>Clearwater Beach requires corrosion-resistant materials (marine-grade aluminum, EPDM seals), stronger anchoring for wind loads, and systems rated for wave action in addition to standing water.</p>
                    </div>
                </section>
                <?php endif; ?>
                
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
                
                <section class="related-content">
                    <h2>Related Flood Protection Resources</h2>
                    <ul>
                        <li><a href="/blog/best-flood-barriers-2025">Best Flood Barriers for Homes in 2025</a></li>
                        <li><a href="/blog/fema-approved-flood-barriers">FEMA-Approved Flood Barriers Guide</a></li>
                        <li><a href="/blog/portable-vs-permanent-flood-barriers">Portable vs Permanent: Which to Choose?</a></li>
                    </ul>
                </section>
            </div>

            <aside class="sidebar">
                <div class="contact-card">
                    <h3>Get Your Free Quote</h3>
                    <p>Ready to protect your <?= htmlspecialchars($city) ?> property? Contact us today for a free, no-obligation quote.</p>
                    <div class="contact-info">
                        <p><strong>Phone:</strong> <a href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>"><?= htmlspecialchars(\App\Config::get('phone')) ?></a></p>
                        <p><strong>Email:</strong> <a href="mailto:<?= htmlspecialchars(\App\Config::get('email')) ?>"><?= htmlspecialchars(\App\Config::get('email')) ?></a></p>
                        <p><strong>Address:</strong> <?= htmlspecialchars(\App\Config::get('address')) ?>, <?= htmlspecialchars(\App\Config::get('city')) ?>, <?= htmlspecialchars(\App\Config::get('state')) ?> <?= htmlspecialchars(\App\Config::get('zip')) ?></p>
                    </div>
                    <a href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>" class="btn btn-primary btn-block">Call Now</a>
                </div>

                <div class="service-areas">
                    <h3>Nearby Cities</h3>
                    <ul>
                        <?php 
                        $nearbyCities = \App\Util::getNearbyCities($city, 6);
                        foreach ($nearbyCities as $nearbyCity): 
                        ?>
                        <li><a href="<?= htmlspecialchars($nearbyCity['url']) ?>"><?= htmlspecialchars($nearbyCity['name']) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <?php 
                $relatedServices = \App\Util::getRelatedServices($city, $keyword, 5);
                if (!empty($relatedServices)):
                ?>
                <div class="related-services">
                    <h3>Related Services in <?= htmlspecialchars($city) ?></h3>
                    <ul>
                        <?php foreach ($relatedServices as $service): ?>
                        <li><a href="<?= htmlspecialchars($service['url']) ?>"><?= htmlspecialchars($service['keyword']) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
            </aside>
        </div>
    </div>
</article>
