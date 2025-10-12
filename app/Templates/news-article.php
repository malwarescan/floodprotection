<article class="news-article">
    <div class="container">
        <header class="article-header">
            <h1><?= htmlspecialchars($article['title']) ?></h1>
            <div class="article-meta">
                <time datetime="<?= htmlspecialchars($article['date']) ?>"><?= \App\Util::formatDate($article['date'], 'F j, Y') ?></time>
                <?php if (!empty($article['city'])): ?>
                <span class="article-location"><?= htmlspecialchars($article['city']) ?></span>
                <?php endif; ?>
            </div>
        </header>

        <div class="article-content">
            <?= \App\Util::markdownToHtml($article['content']) ?>
        </div>

        <div class="article-navigation">
            <a href="/news" class="btn btn-outline">← Back to News</a>
        </div>
    </div>
</article>
