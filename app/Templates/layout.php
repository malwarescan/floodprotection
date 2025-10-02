<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title><?= htmlspecialchars($title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($description) ?>"/>
    <link rel="canonical" href="<?= htmlspecialchars($canonical) ?>"/>
    
    <!-- Open Graph -->
    <meta property="og:title" content="<?= htmlspecialchars($title) ?>"/>
    <meta property="og:description" content="<?= htmlspecialchars($description) ?>"/>
    <meta property="og:url" content="<?= htmlspecialchars($canonical) ?>"/>
    <meta property="og:type" content="website"/>
    <meta property="og:site_name" content="<?= htmlspecialchars(\App\Config::get('app_name')) ?>"/>
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:title" content="<?= htmlspecialchars($title) ?>"/>
    <meta name="twitter:description" content="<?= htmlspecialchars($description) ?>"/>
    
    <link rel="stylesheet" href="/assets/app.css"/>
    
    <?php if (!empty($jsonld)): ?>
    <script type="application/ld+json"><?= json_encode($jsonld, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) ?></script>
    <?php endif; ?>
</head>
<body>
    <header class="site-hdr">
        <div class="container site-hdr-inner">
            <a class="brand" href="/"><?= htmlspecialchars(\App\Config::get('app_name')) ?></a>
            <nav class="nav">
                <a href="/blog">Blog</a>
                <a href="/news">News</a>
                <a href="/testimonials">Testimonials</a>
                <a href="/resources/door-dams/miami">Resources</a>
            </nav>
            <a class="btn btn-primary" href="tel:<?= htmlspecialchars(\App\Config::get('phone')) ?>">
                Call <?= htmlspecialchars(\App\Config::get('phone')) ?>
            </a>
        </div>
    </header>
    
    <main class="main-content">
        <?= $content ?>
    </main>
    
    <footer class="site-ftr">
        <div class="container">
            <p>&copy; <?= date('Y') ?> <?= htmlspecialchars(\App\Config::get('app_name')) ?>. All rights reserved.</p>
            <p>Professional flood protection services throughout Florida.</p>
        </div>
    </footer>
    
    <!-- Organization Schema -->
    <script type="application/ld+json"><?= json_encode(\App\Schema::organizationGraph(), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) ?></script>
</body>
</html>
