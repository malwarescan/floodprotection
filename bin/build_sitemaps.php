#!/usr/bin/env php
<?php
declare(strict_types=1);

/**
 * Rubicon Sitemap Generator
 * 
 * Generates sectioned sitemaps for optimal crawl efficiency and AI indexing.
 * Creates sitemap-index.xml plus individual sitemaps for each content type.
 * 
 * Usage:
 *   php bin/build_sitemaps.php
 *   php bin/build_sitemaps.php --output=public/sitemaps/
 *   php bin/build_sitemaps.php --base=https://floodbarrierpros.com --force
 * 
 * Features:
 * - Sectioned sitemaps (static, products, faq, cities, reviews, blog)
 * - Automatic lastmod from file timestamps
 * - Sitemap index generation
 * - Robots.txt integration
 * - Size limits (max 10,000 URLs per sitemap)
 * - Gzip compression support
 */

$opts = getopt('', [
  'output::',     // output directory (default: public/sitemaps/)
  'base::',       // site base URL (default: from config)
  'force::',      // force regeneration even if files exist
  'gzip::',       // compress sitemaps with gzip (default: 1)
  'max-urls::',   // max URLs per sitemap (default: 10000)
]);

$ROOT = realpath(__DIR__.'/..') ?: dirname(__DIR__);
$OUTPUT_DIR = $opts['output'] ?? $ROOT.'/public/sitemaps';
$BASE_URL = $opts['base'] ?? 'https://floodbarrierpros.com';
$FORCE = isset($opts['force']);
$GZIP = !isset($opts['gzip']) || (string)$opts['gzip'] === '1';
$MAX_URLS = max(1000, (int)($opts['max-urls'] ?? 10000));

// Ensure output directory exists
if (!is_dir($OUTPUT_DIR)) {
  mkdir($OUTPUT_DIR, 0755, true);
}

// Load config for base URL if not provided
if (!isset($opts['base'])) {
  $configFile = $ROOT.'/app/Config.php';
  if (is_file($configFile)) {
    $config = include $configFile;
    if (isset($config['app_url'])) {
      $BASE_URL = rtrim($config['app_url'], '/');
    }
  }
}

$BASE_URL = rtrim($BASE_URL, '/');

echo "Rubicon Sitemap Generator\n";
echo "Base URL: $BASE_URL\n";
echo "Output: $OUTPUT_DIR\n";
echo "Max URLs per sitemap: $MAX_URLS\n";
echo "Gzip: " . ($GZIP ? 'enabled' : 'disabled') . "\n\n";

/**
 * Generate XML sitemap content
 */
function generateSitemapXml(array $urls, string $baseUrl): string {
  $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
  $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
  
  foreach ($urls as $url) {
    $loc = htmlspecialchars($url['url'], ENT_QUOTES, 'UTF-8');
    $lastmod = isset($url['lastmod']) ? $url['lastmod'] : date('Y-m-d');
    $changefreq = $url['changefreq'] ?? 'monthly';
    $priority = $url['priority'] ?? '0.5';
    
    $xml .= "  <url>\n";
    $xml .= "    <loc>$loc</loc>\n";
    $xml .= "    <lastmod>$lastmod</lastmod>\n";
    $xml .= "    <changefreq>$changefreq</changefreq>\n";
    $xml .= "    <priority>$priority</priority>\n";
    $xml .= "  </url>\n";
  }
  
  $xml .= '</urlset>';
  return $xml;
}

/**
 * Generate sitemap index XML
 */
function generateSitemapIndex(array $sitemaps, string $baseUrl): string {
  $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
  $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
  
  foreach ($sitemaps as $sitemap) {
    $loc = htmlspecialchars($sitemap['url'], ENT_QUOTES, 'UTF-8');
    $lastmod = $sitemap['lastmod'] ?? date('Y-m-d');
    
    $xml .= "  <sitemap>\n";
    $xml .= "    <loc>$loc</loc>\n";
    $xml .= "    <lastmod>$lastmod</lastmod>\n";
    $xml .= "  </sitemap>\n";
  }
  
  $xml .= '</sitemapindex>';
  return $xml;
}

/**
 * Write sitemap file with optional gzip compression
 */
function writeSitemap(string $filepath, string $content, bool $gzip = true): void {
  $content = $content . "\n";
  
  // Always write the uncompressed version
  file_put_contents($filepath, $content);
  echo "  ✓ Generated: " . basename($filepath) . " (" . number_format(strlen($content)) . " bytes)\n";
  
  // Also write gzipped version if requested
  if ($gzip) {
    $gzipPath = $filepath . '.gz';
    file_put_contents($gzipPath, gzencode($content, 9));
    echo "  ✓ Generated: " . basename($gzipPath) . " (" . number_format(strlen(gzencode($content, 9))) . " bytes)\n";
  }
}

/**
 * Get file modification time as ISO date
 */
function getFileLastmod(string $filepath): string {
  if (is_file($filepath)) {
    return date('Y-m-d', filemtime($filepath));
  }
  return date('Y-m-d');
}

/**
 * Load URLs from data directory
 */
function loadDataUrls(string $dataDir, string $baseUrl, string $urlPrefix = '', string $changefreq = 'monthly', string $priority = '0.5'): array {
  $urls = [];
  
  if (!is_dir($dataDir)) {
    return $urls;
  }
  
  $iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($dataDir, RecursiveDirectoryIterator::SKIP_DOTS)
  );
  
  foreach ($iterator as $file) {
    if ($file->isFile() && preg_match('/\.(json|md)$/i', $file->getFilename())) {
      $relativePath = str_replace($dataDir, '', $file->getPathname());
      $relativePath = ltrim($relativePath, '/\\');
      
      // Convert file path to URL slug
      $slug = preg_replace('/\.(json|md)$/i', '', $relativePath);
      $slug = str_replace(['\\', '/'], '/', $slug);
      
      // Handle FAQ files
      if (strpos($slug, 'faq__') === 0) {
        $slug = 'faq/' . substr($slug, 5); // Remove 'faq__' prefix
      }
      
      $url = $baseUrl . $urlPrefix . '/' . $slug;
      $lastmod = getFileLastmod($file->getPathname());
      
      $urls[] = [
        'url' => $url,
        'lastmod' => $lastmod,
        'changefreq' => $changefreq,
        'priority' => $priority
      ];
    }
  }
  
  return $urls;
}

/**
 * Load blog URLs
 */
function loadBlogUrls(string $blogDir, string $baseUrl): array {
  $urls = [];
  
  if (!is_dir($blogDir)) {
    return $urls;
  }
  
  $files = glob($blogDir . '/*.md');
  foreach ($files as $file) {
    $filename = basename($file, '.md');
    $url = $baseUrl . '/blog/' . $filename;
    $lastmod = getFileLastmod($file);
    
    $urls[] = [
      'url' => $url,
      'lastmod' => $lastmod,
      'changefreq' => 'weekly',
      'priority' => '0.7'
    ];
  }
  
  return $urls;
}

/**
 * Load news URLs
 */
function loadNewsUrls(string $newsDir, string $baseUrl): array {
  $urls = [];
  
  if (!is_dir($newsDir)) {
    return $urls;
  }
  
  $files = glob($newsDir . '/*.md');
  foreach ($files as $file) {
    $filename = basename($file, '.md');
    $url = $baseUrl . '/news/' . $filename;
    $lastmod = getFileLastmod($file);
    
    $urls[] = [
      'url' => $url,
      'lastmod' => $lastmod,
      'changefreq' => 'weekly',
      'priority' => '0.6'
    ];
  }
  
  return $urls;
}

// Generate sitemaps
$sitemaps = [];
$allUrls = [];

// 1. Static Pages Sitemap
echo "Generating sitemap-static.xml...\n";
$staticUrls = [
  ['url' => $BASE_URL . '/', 'lastmod' => date('Y-m-d'), 'changefreq' => 'daily', 'priority' => '1.0'],
  ['url' => $BASE_URL . '/products', 'lastmod' => date('Y-m-d'), 'changefreq' => 'weekly', 'priority' => '0.8'],
  ['url' => $BASE_URL . '/testimonials', 'lastmod' => date('Y-m-d'), 'changefreq' => 'monthly', 'priority' => '0.7'],
  ['url' => $BASE_URL . '/blog', 'lastmod' => date('Y-m-d'), 'changefreq' => 'weekly', 'priority' => '0.7'],
  ['url' => $BASE_URL . '/resources', 'lastmod' => date('Y-m-d'), 'changefreq' => 'monthly', 'priority' => '0.6'],
];

$staticXml = generateSitemapXml($staticUrls, $BASE_URL);
writeSitemap($OUTPUT_DIR . '/sitemap-static.xml', $staticXml, $GZIP);
$sitemaps[] = [
  'url' => $BASE_URL . '/sitemaps/sitemap-static.xml',
  'lastmod' => date('Y-m-d')
];

// 2. Products Sitemap
echo "Generating sitemap-products.xml...\n";
$productUrls = [
  ['url' => $BASE_URL . '/products/doorway-flood-panel', 'lastmod' => date('Y-m-d'), 'changefreq' => 'weekly', 'priority' => '0.9'],
  ['url' => $BASE_URL . '/products/modular-flood-barrier', 'lastmod' => date('Y-m-d'), 'changefreq' => 'weekly', 'priority' => '0.9'],
  ['url' => $BASE_URL . '/products/garage-dam-kit', 'lastmod' => date('Y-m-d'), 'changefreq' => 'weekly', 'priority' => '0.9'],
];

$productsXml = generateSitemapXml($productUrls, $BASE_URL);
writeSitemap($OUTPUT_DIR . '/sitemap-products.xml', $productsXml, $GZIP);
$sitemaps[] = [
  'url' => $BASE_URL . '/sitemaps/sitemap-products.xml',
  'lastmod' => date('Y-m-d')
];

// 3. FAQ Sitemap
echo "Generating sitemap-faq.xml...\n";
$faqUrls = loadDataUrls($ROOT . '/data/faqs/pages', $BASE_URL, '', 'weekly', '0.8');
$faqXml = generateSitemapXml($faqUrls, $BASE_URL);
writeSitemap($OUTPUT_DIR . '/sitemap-faq.xml', $faqXml, $GZIP);
$sitemaps[] = [
  'url' => $BASE_URL . '/sitemaps/sitemap-faq.xml',
  'lastmod' => date('Y-m-d')
];

// 4. City Sitemaps
echo "Generating city sitemaps...\n";

// Home Flood Barriers
$cityHomeUrls = loadDataUrls($ROOT . '/data/faqs/city/home-flood-barriers', $BASE_URL, '', 'weekly', '0.7');
if (!empty($cityHomeUrls)) {
  $cityHomeXml = generateSitemapXml($cityHomeUrls, $BASE_URL);
  writeSitemap($OUTPUT_DIR . '/sitemap-city-home-flood-barriers.xml', $cityHomeXml, $GZIP);
  $sitemaps[] = [
    'url' => $BASE_URL . '/sitemaps/sitemap-city-home-flood-barriers.xml',
    'lastmod' => date('Y-m-d')
  ];
}

// Residential Flood Panels
$cityResidentialUrls = loadDataUrls($ROOT . '/data/faqs/city/residential-flood-panels', $BASE_URL, '', 'weekly', '0.7');
if (!empty($cityResidentialUrls)) {
  $cityResidentialXml = generateSitemapXml($cityResidentialUrls, $BASE_URL);
  writeSitemap($OUTPUT_DIR . '/sitemap-city-residential-flood-panels.xml', $cityResidentialXml, $GZIP);
  $sitemaps[] = [
    'url' => $BASE_URL . '/sitemaps/sitemap-city-residential-flood-panels.xml',
    'lastmod' => date('Y-m-d')
  ];
}

// 5. Reviews Sitemap
echo "Generating sitemap-reviews.xml...\n";
$reviewUrls = loadDataUrls($ROOT . '/data/reviews/products', $BASE_URL, '/testimonials', 'monthly', '0.6');
$reviewsXml = generateSitemapXml($reviewUrls, $BASE_URL);
writeSitemap($OUTPUT_DIR . '/sitemap-reviews.xml', $reviewsXml, $GZIP);
$sitemaps[] = [
  'url' => $BASE_URL . '/sitemaps/sitemap-reviews.xml',
  'lastmod' => date('Y-m-d')
];

// 6. Blog Sitemap
echo "Generating sitemap-blog.xml...\n";
$blogUrls = loadBlogUrls($ROOT . '/app/Data/blog', $BASE_URL);
$newsUrls = loadNewsUrls($ROOT . '/app/Data/news', $BASE_URL);
$allBlogUrls = array_merge($blogUrls, $newsUrls);

if (!empty($allBlogUrls)) {
  $blogXml = generateSitemapXml($allBlogUrls, $BASE_URL);
  writeSitemap($OUTPUT_DIR . '/sitemap-blog.xml', $blogXml, $GZIP);
  $sitemaps[] = [
    'url' => $BASE_URL . '/sitemaps/sitemap-blog.xml',
    'lastmod' => date('Y-m-d')
  ];
}

// Generate sitemap index
echo "Generating sitemap-index.xml...\n";
$indexXml = generateSitemapIndex($sitemaps, $BASE_URL);
writeSitemap($OUTPUT_DIR . '/sitemap-index.xml', $indexXml, $GZIP);

// Update robots.txt
echo "Updating robots.txt...\n";
$robotsPath = $ROOT . '/public/robots.txt';
$robotsContent = "User-agent: *\n";
$robotsContent .= "Allow: /\n";
$robotsContent .= "Disallow: /admin/\n";
$robotsContent .= "Disallow: /private/\n\n";

// Add sitemap references
$robotsContent .= "# Sitemaps\n";
$robotsContent .= "Sitemap: $BASE_URL/sitemaps/sitemap-index.xml\n";
$robotsContent .= "Sitemap: $BASE_URL/sitemaps/sitemap-faq.xml\n";
$robotsContent .= "Sitemap: $BASE_URL/sitemaps/sitemap-products.xml\n";

file_put_contents($robotsPath, $robotsContent);
echo "  ✓ Updated: robots.txt\n";

// Summary
echo "\n";
echo "Sitemap generation complete!\n";
echo "Generated " . count($sitemaps) . " sitemaps:\n";
foreach ($sitemaps as $sitemap) {
  echo "  • " . basename($sitemap['url']) . "\n";
}
echo "\n";
echo "Next steps:\n";
echo "1. Submit sitemap-index.xml to Google Search Console\n";
echo "2. Monitor indexation in GSC for each section\n";
echo "3. Set up cron job for automatic regeneration\n";
echo "   Example: 0 2 * * * php $ROOT/bin/build_sitemaps.php\n";
echo "\n";
