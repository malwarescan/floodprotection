<section class="hero">
    <div class="container">
        <h1>Garage Door Flood Dam Kit</h1>
        <p class="lead">Modular flood barrier kit engineered for residential and commercial garage openings. Fast install, reusable components.</p>
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
                <img src="<?= htmlspecialchars($product['image'][0]) ?>" alt="Garage Door Flood Dam Kit" />
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
                        <strong>Application:</strong> Garage Doors
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
                    <h3>Starting at $1,299</h3>
                    <p>Custom pricing based on garage size and requirements</p>
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
        <h2>Why Choose Our Garage Dam Kit?</h2>
        <div class="features-grid">
            <div class="feature-card">
                <h3>Garage-Specific Design</h3>
                <p>Engineered specifically for garage openings with proper sealing and support for heavy doors.</p>
            </div>
            <div class="feature-card">
                <h3>Quick Installation</h3>
                <p>Fast setup that doesn't require permanent modifications to your garage structure.</p>
            </div>
            <div class="feature-card">
                <h3>Commercial Grade</h3>
                <p>Suitable for both residential and commercial garage applications with heavy-duty construction.</p>
            </div>
            <div class="feature-card">
                <h3>Reusable Components</h3>
                <p>Store and reuse season after season. No waste, just reliable protection when needed.</p>
            </div>
        </div>
    </div>
</section>

<section id="customer-reviews" class="reviews-section">
    <div class="container">
        <h2>Customer Reviews</h2>
        <div class="rating-summary">
            <p>Average rating: 4.0 (10 reviews)</p>
        </div>
        
        <div class="reviews-grid">
            <article class="review-card">
                <h3>Good garage protection</h3>
                <p><strong>Charles Bailey</strong> · 2024-08-10 · ★★★☆☆</p>
                <p>Effective garage barrier. Easy to install.</p>
            </article>
            <article class="review-card">
                <h3>Excellent garage dam</h3>
                <p><strong>Donna Rivera</strong> · 2024-08-08 · ★★★★★</p>
                <p>Great garage protection. Very effective.</p>
            </article>
            <article class="review-card">
                <h3>Good product</h3>
                <p><strong>Frank Cooper</strong> · 2024-08-05 · ★★★☆☆</p>
                <p>Quality garage barrier. Works well.</p>
            </article>
            <article class="review-card">
                <h3>Perfect garage solution</h3>
                <p><strong>Sharon Richardson</strong> · 2024-08-02 · ★★★★★</p>
                <p>Exactly what we needed for our garage. Great quality.</p>
            </article>
            <article class="review-card">
                <h3>Good garage protection</h3>
                <p><strong>Joseph Cox</strong> · 2024-07-30 · ★★★☆☆</p>
                <p>Effective garage barrier. Easy to use.</p>
            </article>
            <article class="review-card">
                <h3>Highly recommend</h3>
                <p><strong>Cynthia Ward</strong> · 2024-07-28 · ★★★★★</p>
                <p>Excellent garage protection. Very satisfied.</p>
            </article>
            <article class="review-card">
                <h3>Good garage dam</h3>
                <p><strong>Edward Brooks</strong> · 2024-07-10 · ★★★☆☆</p>
                <p>Effective garage barrier. Easy to use.</p>
            </article>
            <article class="review-card">
                <h3>Perfect garage protection</h3>
                <p><strong>Donna Kelly</strong> · 2024-07-08 · ★★★★★</p>
                <p>Exactly what we needed. Great quality.</p>
            </article>
            <article class="review-card">
                <h3>Good product</h3>
                <p><strong>Richard Sanders</strong> · 2024-07-05 · ★★★☆☆</p>
                <p>Quality garage barrier. Works as expected.</p>
            </article>
            <article class="review-card">
                <h3>Excellent garage solution</h3>
                <p><strong>Elizabeth Price</strong> · 2024-07-02 · ★★★★★</p>
                <p>Great garage protection. Very satisfied.</p>
            </article>
        </div>
    </div>
</section>

<section class="cta">
    <div class="container">
        <h2>Ready to Protect Your Garage?</h2>
        <p>Get your free quote for garage dam kit installation today.</p>
        <div class="contact-info">
            <p><strong>Phone:</strong> <a href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>"><?= htmlspecialchars(\App\Config::get('phone')) ?></a></p>
            <p><strong>Email:</strong> <a href="mailto:<?= htmlspecialchars(\App\Config::get('email')) ?>"><?= htmlspecialchars(\App\Config::get('email')) ?></a></p>
        </div>
        <a href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>" class="btn btn-primary btn-large">Call Now for Free Quote</a>
    </div>
</section>
