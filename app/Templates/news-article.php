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

        <!-- Google Subscribe with Google (for news articles) -->
        <?php if (isset($isNewsArticle) && $isNewsArticle): ?>
        <script async type="application/javascript"
                src="https://news.google.com/swg/js/v1/swg-basic.js"></script>
        <script>
          (self.SWG_BASIC = self.SWG_BASIC || []).push( basicSubscriptions => {
            basicSubscriptions.init({
              type: "NewsArticle",
              isPartOfType: ["Product"],
              isPartOfProductId: "CAowuYvCDA:openaccess",
              clientOptions: { theme: "light", lang: "en" },
            });
          });
        </script>
        
        <!-- Google Contributions Widget -->
        <div class="swg-contribution-button" data-theme="light" data-lang="en"></div>
        <?php endif; ?>

        <div class="article-navigation">
            <a href="/news" class="btn btn-outline">← Back to News</a>
        </div>
    </div>
</article>
