<section class="blog-index">
    <div class="container">
        <header class="page-header">
            <h1>Flood Protection Blog</h1>
            <p class="page-subtitle">Expert tips, guides, and news about flood protection in Florida</p>
        </header>

        <div class="blog-posts">
            <?php if (!empty($posts)): ?>
                <div class="posts-grid">
                    <?php foreach ($posts as $post): ?>
                        <article class="post-card">
                            <div class="post-meta">
                                <time datetime="<?= htmlspecialchars($post['date']) ?>"><?= \App\Util::formatDate($post['date'], 'F j, Y') ?></time>
                                <?php if (!empty($post['city'])): ?>
                                    <span class="post-location"><?= htmlspecialchars($post['city']) ?></span>
                                <?php endif; ?>
                            </div>
                            <h2><a href="/blog/<?= htmlspecialchars($post['slug']) ?>"><?= htmlspecialchars($post['title']) ?></a></h2>
                            <p><?= htmlspecialchars($post['description']) ?></p>
                            <a href="/blog/<?= htmlspecialchars($post['slug']) ?>" class="btn btn-outline">Read More</a>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="no-posts">
                    <p>No blog posts available at the moment. Check back soon!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
