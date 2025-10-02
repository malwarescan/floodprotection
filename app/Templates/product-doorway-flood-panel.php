<section class="hero">
    <div class="container">
        <h1>Doorway Flood Panel</h1>
        <p class="lead">Reusable, quick-install flood panel system for doors and entries. Clean deployment, strong sealing, easy storage.</p>
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
                <img src="<?= htmlspecialchars($product['image'][0]) ?>" alt="Doorway Flood Panel" />
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
                        <strong>Application:</strong> Doorways & Entries
                    </div>
                    <div class="spec-item">
                        <strong>Installation:</strong> Quick & Easy
                    </div>
                    <div class="spec-item">
                        <strong>Reusability:</strong> Yes
                    </div>
                    <div class="spec-item">
                        <strong>Warranty:</strong> 20+ Years
                    </div>
                </div>
                
                <div class="pricing">
                    <h3>Starting at $899</h3>
                    <p>Custom pricing based on doorway size and requirements</p>
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
        <h2>Why Choose Our Doorway Flood Panel?</h2>
        <div class="features-grid">
            <div class="feature-card">
                <h3>Doorway-Specific Design</h3>
                <p>Engineered for doorways and entries with proper sealing and easy installation.</p>
            </div>
            <div class="feature-card">
                <h3>Quick Installation</h3>
                <p>Fast setup that doesn't require permanent modifications to your door frames.</p>
            </div>
            <div class="feature-card">
                <h3>Strong Sealing</h3>
                <p>Creates watertight seals that keep floodwaters out effectively.</p>
            </div>
            <div class="feature-card">
                <h3>Easy Storage</h3>
                <p>Compact design for easy storage when not in use. Clean deployment every time.</p>
            </div>
        </div>
    </div>
</section>

<section id="customer-reviews" class="reviews-section">
    <div class="container">
        <h2>Customer Reviews</h2>
        <div class="rating-summary">
            <p>Average rating: 4.0 (12 reviews)</p>
        </div>
        
        <div class="reviews-grid">
            <article class="review-card">
                <h3>Good panel system</h3>
                <p><strong>Charles Long</strong> · 2024-06-10 · ★★★☆☆</p>
                <p>Effective panel system. Easy to install.</p>
            </article>
            <article class="review-card">
                <h3>Excellent panels</h3>
                <p><strong>Donna Patterson</strong> · 2024-06-08 · ★★★★★</p>
                <p>Great panel system. Very effective.</p>
            </article>
            <article class="review-card">
                <h3>Good product</h3>
                <p><strong>Frank Hughes</strong> · 2024-06-05 · ★★★☆☆</p>
                <p>Quality panel system. Works well.</p>
            </article>
            <article class="review-card">
                <h3>Perfect panel solution</h3>
                <p><strong>Sharon Flores</strong> · 2024-06-02 · ★★★★★</p>
                <p>Exactly what we needed. Great quality.</p>
            </article>
            <article class="review-card">
                <h3>Good panel system</h3>
                <p><strong>Joseph Washington</strong> · 2024-05-30 · ★★★☆☆</p>
                <p>Effective panel system. Easy to use.</p>
            </article>
            <article class="review-card">
                <h3>Highly recommend</h3>
                <p><strong>Cynthia Butler</strong> · 2024-05-28 · ★★★★★</p>
                <p>Excellent panel system. Very satisfied.</p>
            </article>
            <article class="review-card">
                <h3>Good panels</h3>
                <p><strong>Thomas Simmons</strong> · 2024-05-25 · ★★★☆☆</p>
                <p>Quality panel system. Works as expected.</p>
            </article>
            <article class="review-card">
                <h3>Perfect panel system</h3>
                <p><strong>Deborah Foster</strong> · 2024-05-22 · ★★★★★</p>
                <p>Great panel system. Easy to install.</p>
            </article>
            <article class="review-card">
                <h3>Effective panels</h3>
                <p><strong>Kenneth Gonzales</strong> · 2024-05-20 · ★★★☆☆</p>
                <p>Good panel system. Quality materials.</p>
            </article>
            <article class="review-card">
                <h3>Excellent panel solution</h3>
                <p><strong>Carol Bryant</strong> · 2024-05-18 · ★★★★★</p>
                <p>Perfect panel system. Very effective.</p>
            </article>
            <article class="review-card">
                <h3>Good panel system</h3>
                <p><strong>William Alexander</strong> · 2024-05-15 · ★★★☆☆</p>
                <p>Quality panel system. Works well.</p>
            </article>
            <article class="review-card">
                <h3>Highly effective</h3>
                <p><strong>Janet Russell</strong> · 2024-05-12 · ★★★★★</p>
                <p>Very effective panel system. Great product.</p>
            </article>
        </div>
    </div>
</section>

<section class="cta">
    <div class="container">
        <h2>Ready to Protect Your Doorways?</h2>
        <p>Get your free quote for doorway flood panel installation today.</p>
        <div class="contact-info">
            <p><strong>Phone:</strong> <a href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>"><?= htmlspecialchars(\App\Config::get('phone')) ?></a></p>
            <p><strong>Email:</strong> <a href="mailto:<?= htmlspecialchars(\App\Config::get('email')) ?>"><?= htmlspecialchars(\App\Config::get('email')) ?></a></p>
        </div>
        <a href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>" class="btn btn-primary btn-large">Call Now for Free Quote</a>
    </div>
</section>
