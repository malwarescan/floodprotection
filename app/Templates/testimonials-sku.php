<section class="hero">
    <div class="container">
        <h1><?= htmlspecialchars($productName) ?> — Customer Testimonials</h1>
        <p class="lead">Average rating <?= htmlspecialchars($avg) ?>/5 from <?= htmlspecialchars($count) ?> reviews.</p>
        <p class="pricing">Starting at $1,499 USD</p>
        <div class="cta-stack">
            <a class="btn btn-primary" href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>">Get a Free Quote</a>
            <a class="btn btn-secondary" href="/testimonials">All testimonials</a>
        </div>
    </div>
</section>

<div class="container section grid3">
    <?php foreach ($reviews as $r): ?>
        <article id="<?= htmlspecialchars($r['review_id']) ?>" class="card">
            <h3 style="margin:0 0 6px"><?= htmlspecialchars($r['title']) ?></h3>
            <div style="display:flex; gap:8px; align-items:center; margin-bottom:8px">
                <span aria-label="<?= (int)$r['rating'] ?> out of 5 stars">⭐️<?= str_repeat('⭐', (int)$r['rating'] - 1) ?></span>
                <span class="badge"><?= htmlspecialchars($r['author']) ?></span>
                <span style="color:#6b7280"><?= htmlspecialchars($r['date']) ?></span>
            </div>
            <p><?= htmlspecialchars($r['body']) ?></p>
        </article>
    <?php endforeach; ?>
</div>
