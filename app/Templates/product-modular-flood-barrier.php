<section class="hero">
    <div class="container">
        <h1>Modular Flood Barrier System</h1>
        <p class="lead">Rapid-deploy modular flood barriers made from 6063 T-6 aluminum with EPDM sealing. Quick installation, no sandbags, minimal cleanup.</p>
        <div class="cta-stack">
            <a class="btn btn-primary" href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>">Get Free Quote</a>
            <a class="btn btn-secondary" href="/testimonials">Read Reviews</a>
        </div>
    </div>
</section>

<section class="product-overview">
    <div class="container">
        <div class="product-grid">
            <div class="product-image">
                <img src="<?= htmlspecialchars($product['image'][0]) ?>" alt="Modular Flood Barrier System" />
            </div>
            <div class="product-details">
                <h2>Product Specifications</h2>
                <div class="specs-grid">
                    <div class="spec-item">
                        <strong>SKU:</strong> <?= htmlspecialchars($product['sku']) ?>
                    </div>
                    <div class="spec-item">
                        <strong>Material:</strong> <?= htmlspecialchars($product['material']) ?>
                    </div>
                    <div class="spec-item">
                        <strong>System Depth:</strong> 3.54 in (9 cm)
                    </div>
                    <div class="spec-item">
                        <strong>System Width:</strong> 2.36 in (6 cm)
                    </div>
                    <div class="spec-item">
                        <strong>System Weight:</strong> 2.72 lb/ft
                    </div>
                    <div class="spec-item">
                        <strong>Wall Thickness:</strong> 0.015 in (3.8 mm)
                    </div>
                </div>
                
                <div class="pricing">
                    <h3>Starting at $1,499</h3>
                    <p>Custom pricing based on your specific requirements</p>
                </div>
                
                <div class="product-actions">
                    <a class="btn btn-primary btn-large" href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>">Call for Quote</a>
                    <a class="btn btn-secondary" href="mailto:<?= htmlspecialchars(\App\Config::get('email')) ?>">Email Us</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="product-features">
    <div class="container">
        <h2>Why Choose Our Modular Flood Barrier System?</h2>
        <div class="features-grid">
            <div class="feature-card">
                <h3>Rapid Deployment</h3>
                <p>Quick installation without the need for sandbags or heavy equipment. Deploy in minutes, not hours.</p>
            </div>
            <div class="feature-card">
                <h3>6063 T-6 Aluminum</h3>
                <p>High-strength aluminum construction that won't rust or corrode, ensuring long-lasting protection.</p>
            </div>
            <div class="feature-card">
                <h3>EPDM Sealing</h3>
                <p>Premium EPDM rubber sealing creates watertight barriers that keep floodwaters out effectively.</p>
            </div>
            <div class="feature-card">
                <h3>Reusable Design</h3>
                <p>Clean up and store for future use. No waste, no mess, just reliable protection when you need it.</p>
            </div>
        </div>
    </div>
</section>

<section id="customer-reviews" class="reviews-section">
    <div class="container">
        <h2>Customer Reviews</h2>
        <div class="rating-summary">
            <p>Average rating: 4.7 (6 reviews)</p>
        </div>
        
        <div class="reviews-grid">
            <article class="review-card">
                <h3>Excellent flood protection</h3>
                <p><strong>John Smith</strong> · 2024-12-15 · ★★★★★</p>
                <p>These barriers saved our home during the last hurricane. Easy to install and very effective.</p>
            </article>

            <article class="review-card">
                <h3>Good quality product</h3>
                <p><strong>Sarah Johnson</strong> · 2024-12-10 · ★★★★☆</p>
                <p>Works as advertised. Installation was straightforward and the materials feel durable.</p>
            </article>

            <article class="review-card">
                <h3>Outstanding customer service</h3>
                <p><strong>Mike Rodriguez</strong> · 2024-12-08 · ★★★★★</p>
                <p>Great product and even better support. They helped us choose the right size and installation was quick.</p>
            </article>

            <article class="review-card">
                <h3>Outstanding product</h3>
                <p><strong>Michelle Lee</strong> · 2024-11-02 · ★★★★★</p>
                <p>These barriers are incredibly effective. Our home stayed completely dry.</p>
            </article>

            <article class="review-card">
                <h3>Good value</h3>
                <p><strong>Mark Harris</strong> · 2024-10-30 · ★★★★☆</p>
                <p>Quality product at a fair price. Installation was quick and easy.</p>
            </article>

            <article class="review-card">
                <h3>Highly recommend</h3>
                <p><strong>Nancy Clark</strong> · 2024-10-28 · ★★★★★</p>
                <p>Excellent product and service. Would definitely use again.</p>
            </article>
        </div>
    </div>
</section>

<section class="cta">
    <div class="container">
        <h2>Ready to Protect Your Property?</h2>
        <p>Get your free quote for modular flood barrier installation today.</p>
        <div class="contact-info">
            <p><strong>Phone:</strong> <a href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>"><?= htmlspecialchars(\App\Config::get('phone')) ?></a></p>
            <p><strong>Email:</strong> <a href="mailto:<?= htmlspecialchars(\App\Config::get('email')) ?>"><?= htmlspecialchars(\App\Config::get('email')) ?></a></p>
        </div>
        <a href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>" class="btn btn-primary btn-large">Call Now for Free Quote</a>
    </div>
</section>
