<section class="news-index">
    <div class="container">
        <header class="page-header">
            <h1>Flood Protection News</h1>
            <p class="page-subtitle">Latest news and updates about flood protection, storm alerts, and emergency preparedness in Florida</p>
        </header>

        <div class="news-articles">
            <?php if (!empty($articles)): ?>
                <div class="articles-grid">
                    <?php foreach ($articles as $article): ?>
                        <article class="article-card">
                            <div class="article-meta">
                                <time datetime="<?= htmlspecialchars($article['date']) ?>"><?= \App\Util::formatDate($article['date'], 'F j, Y') ?></time>
                                <?php if (!empty($article['city'])): ?>
                                    <span class="article-location"><?= htmlspecialchars($article['city']) ?></span>
                                <?php endif; ?>
                            </div>
                            <h2><a href="/news/<?= htmlspecialchars($article['slug']) ?>"><?= htmlspecialchars($article['title']) ?></a></h2>
                            <p><?= htmlspecialchars($article['description']) ?></p>
                            <a href="/news/<?= htmlspecialchars($article['slug']) ?>" class="btn btn-outline">Read More</a>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="no-articles">
                    <p>No news articles available at the moment. Check back soon!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
