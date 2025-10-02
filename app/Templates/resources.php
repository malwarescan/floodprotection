<article class="resources-page">
    <div class="container">
        <header class="page-header">
            <h1><?= htmlspecialchars(ucwords(str_replace('-', ' ', $topic))) ?> Resources - <?= htmlspecialchars(ucwords($city)) ?></h1>
            <p class="page-subtitle">Frequently asked questions about <?= htmlspecialchars(str_replace('-', ' ', $topic)) ?> in <?= htmlspecialchars(ucwords($city)) ?></p>
        </header>

        <div class="faq-section">
            <h2>Frequently Asked Questions</h2>
            <div class="faq-list">
                <?php foreach ($faq as $index => $item): ?>
                <div class="faq-item">
                    <h3 class="faq-question"><?= htmlspecialchars($item['q']) ?></h3>
                    <div class="faq-answer">
                        <p><?= htmlspecialchars($item['a']) ?></p>
                        <?php if (!empty($item['source_url'])): ?>
                        <p class="faq-source">
                            <strong>Source:</strong> 
                            <a href="<?= htmlspecialchars($item['source_url']) ?>" target="_blank" rel="noopener">
                                <?= htmlspecialchars(parse_url($item['source_url'], PHP_URL_HOST)) ?>
                            </a>
                        </p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="additional-resources">
            <h2>Additional Resources</h2>
            <div class="resource-grid">
                <div class="resource-card">
                    <h3>FEMA Flood Maps</h3>
                    <p>Check your property's flood risk with official FEMA flood maps.</p>
                    <a href="https://www.fema.gov/flood-maps" target="_blank" rel="noopener" class="btn btn-outline">View Maps</a>
                </div>
                <div class="resource-card">
                    <h3>National Hurricane Center</h3>
                    <p>Stay informed about storm tracking and hurricane alerts.</p>
                    <a href="https://www.nhc.noaa.gov/" target="_blank" rel="noopener" class="btn btn-outline">Track Storms</a>
                </div>
                <div class="resource-card">
                    <h3>Florida Disaster</h3>
                    <p>Emergency preparedness resources from the state of Florida.</p>
                    <a href="https://www.floridadisaster.org/planprepare" target="_blank" rel="noopener" class="btn btn-outline">Prepare Now</a>
                </div>
            </div>
        </div>

        <div class="cta-section">
            <h2>Need Professional Help?</h2>
            <p>Our experts can answer your specific questions about <?= htmlspecialchars(str_replace('-', ' ', $topic)) ?> in <?= htmlspecialchars(ucwords($city)) ?>.</p>
            <a href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>" class="btn btn-primary">Call <?= htmlspecialchars(\App\Config::get('phone')) ?></a>
        </div>
    </div>
</article>
