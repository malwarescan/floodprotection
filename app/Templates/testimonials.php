<section class="hero">
    <div class="container">
        <h1>Customer Testimonials</h1>
        <p class="lead">Real homeowner reviews of our USA-made flood barriers and door/garage dams.</p>
        <form class="form" method="get" action="/testimonials" style="margin-top:12px; display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:12px;">
            <select class="select" name="sku">
                <option value="">All SKUs</option>
                <?php foreach ($skus as $s): ?>
                    <option value="<?= htmlspecialchars($s) ?>" <?= $filters['sku'] === $s ? 'selected' : '' ?>><?= htmlspecialchars($s) ?></option>
                <?php endforeach; ?>
            </select>
            <select class="select" name="city">
                <option value="">All Cities</option>
                <?php foreach ($cities as $c): ?>
                    <option value="<?= htmlspecialchars($c) ?>" <?= $filters['city'] === $c ? 'selected' : '' ?>><?= htmlspecialchars($c) ?></option>
                <?php endforeach; ?>
            </select>
            <select class="select" name="min_rating">
                <option value="0" <?= $filters['minRating'] == 0 ? 'selected' : '' ?>>All ratings</option>
                <option value="5" <?= $filters['minRating'] == 5 ? 'selected' : '' ?>>5 stars</option>
                <option value="4" <?= $filters['minRating'] == 4 ? 'selected' : '' ?>>4+ stars</option>
                <option value="3" <?= $filters['minRating'] == 3 ? 'selected' : '' ?>>3+ stars</option>
            </select>
            <input class="input" type="search" name="q" placeholder="Search comments…" value="<?= htmlspecialchars($filters['q'] ?? '') ?>"/>
            <button class="btn btn-primary" type="submit">Apply</button>
        </form>
    </div>
</section>

<div class="container section">
    <div class="grid3">
        <?php foreach ($reviews as $r): ?>
            <article id="<?= htmlspecialchars($r['review_id']) ?>" class="card">
                <h3 style="margin:0 0 6px"><?= htmlspecialchars($r['title']) ?></h3>
                <div style="display:flex; gap:8px; align-items:center; margin-bottom:8px">
                    <span aria-label="<?= (int)$r['rating'] ?> out of 5 stars">⭐️<?= str_repeat('⭐', (int)$r['rating'] - 1) ?></span>
                    <span class="badge"><?= htmlspecialchars($r['author']) ?></span>
                    <span style="color:#6b7280"><?= htmlspecialchars($r['date']) ?></span>
                </div>
                <p><?= htmlspecialchars($r['body']) ?></p>
                <div style="margin-top:8px; color:#6b7280; font-size:14px">
                    SKU: <a href="/testimonials/<?= urlencode($r['sku']) ?>"><?= htmlspecialchars($r['sku']) ?></a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>

    <?php if ($pages > 1): ?>
        <nav style="margin-top:16px; display:flex; gap:8px; align-items:center;">
            <?php for ($i = 1; $i <= $pages; $i++):
                $qs = $_GET;
                $qs['page'] = $i;
                $href = '/testimonials?' . http_build_query($qs);
                ?>
                <a class="btn <?= $i === $page ? 'btn-primary' : 'btn-secondary' ?>" href="<?= htmlspecialchars($href) ?>"><?= $i ?></a>
            <?php endfor; ?>
        </nav>
    <?php endif; ?>
</div>
