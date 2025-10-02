<article class="blog-post">
    <div class="container">
        <header class="post-header">
            <h1><?= htmlspecialchars($post['title']) ?></h1>
            <div class="post-meta">
                <time datetime="<?= htmlspecialchars($post['date']) ?>"><?= \App\Util::formatDate($post['date'], 'F j, Y') ?></time>
                <?php if (!empty($post['city'])): ?>
                <span class="post-location"><?= htmlspecialchars($post['city']) ?></span>
                <?php endif; ?>
            </div>
        </header>

        <div class="post-content">
            <?= $post['content'] ?>
        </div>

        <?php if (!empty($post['tags'])): ?>
        <div class="post-tags">
            <h3>Tags</h3>
            <div class="tag-list">
                <?php foreach ($post['tags'] as $tag): ?>
                <span class="tag"><?= htmlspecialchars($tag) ?></span>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="post-navigation">
            <a href="/blog" class="btn btn-outline">← Back to Blog</a>
        </div>
    </div>
</article>
