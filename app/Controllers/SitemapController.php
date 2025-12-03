<?php

namespace App\Controllers;

use App\Config;
use App\Util;
use App\View;

class SitemapController
{
    public function index()
    {
        $root = Config::get('app_url');
        $lastmod = date('Y-m-d');
        
        $sitemaps = [
            [
                'loc' => $root . '/sitemap-pages.xml',
                'lastmod' => $lastmod
            ],
            [
                'loc' => $root . '/sitemap-products.xml',
                'lastmod' => $lastmod
            ],
            [
                'loc' => $root . '/sitemap-blog.xml',
                'lastmod' => $lastmod
            ],
            [
                'loc' => $root . '/sitemap-news.xml',
                'lastmod' => $lastmod
            ],
            [
                'loc' => $root . '/sitemap-services.xml',
                'lastmod' => $lastmod
            ],
            [
                'loc' => $root . '/sitemap-cities.xml',
                'lastmod' => $lastmod
            ]
        ];
        
        View::renderXml(View::renderSitemap($sitemaps, true));
    }
    
    /**
     * Serve generated sitemap files
     */
    private function serveSitemapFile(string $filename, bool $gzip = false): void
    {
        $filepath = __DIR__ . '/../../public/sitemaps/' . $filename;
        
        if (!file_exists($filepath)) {
            http_response_code(404);
            echo 'Sitemap not found';
            return;
        }
        
        $mimeType = $gzip ? 'application/gzip' : 'application/xml';
        header('Content-Type: ' . $mimeType);
        header('Content-Length: ' . filesize($filepath));
        header('X-Robots-Tag: noindex, nofollow'); // Prevent indexing of sitemap files
        
        if ($gzip) {
            header('Content-Encoding: gzip');
        }
        
        readfile($filepath);
    }
    
    public function sitemapIndex()
    {
        $this->serveSitemapFile('sitemap-index.xml');
    }
    
    public function sitemapIndexGz()
    {
        $this->serveSitemapFile('sitemap-index.xml.gz', true);
    }
    
    public function sitemapStatic()
    {
        $this->serveSitemapFile('sitemap-static.xml');
    }
    
    public function sitemapStaticGz()
    {
        $this->serveSitemapFile('sitemap-static.xml.gz', true);
    }
    
    public function sitemapProducts()
    {
        $this->serveSitemapFile('sitemap-products.xml');
    }
    
    public function sitemapProductsGz()
    {
        $this->serveSitemapFile('sitemap-products.xml.gz', true);
    }
    
    public function sitemapFaq()
    {
        $this->serveSitemapFile('sitemap-faq.xml');
    }
    
    public function sitemapFaqGz()
    {
        $this->serveSitemapFile('sitemap-faq.xml.gz', true);
    }
    
    public function sitemapReviews()
    {
        $this->serveSitemapFile('sitemap-reviews.xml');
    }
    
    public function sitemapReviewsGz()
    {
        $this->serveSitemapFile('sitemap-reviews.xml.gz', true);
    }
    
    public function sitemapBlog()
    {
        $this->serveSitemapFile('sitemap-blog.xml');
    }
    
    public function sitemapBlogGz()
    {
        $this->serveSitemapFile('sitemap-blog.xml.gz', true);
    }
    
    public function sitemapRegions()
    {
        $this->serveSitemapFile('sitemap-regions.xml');
    }
    
    public function sitemapAiNdjson()
    {
        $filepath = __DIR__ . '/../../public/sitemaps/sitemap-ai.ndjson';
        
        if (!file_exists($filepath)) {
            http_response_code(404);
            echo 'Sitemap not found';
            return;
        }
        
        header('Content-Type: application/x-ndjson');
        header('Content-Length: ' . filesize($filepath));
        header('X-Robots-Tag: noindex, nofollow'); // Prevent indexing of sitemap files
        
        readfile($filepath);
    }
    
    public function pages()
    {
        $root = Config::get('app_url');
        $urls = [
            [
                'url' => $root,
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'daily',
                'priority' => '1.0'
            ]
        ];
        
        // Add matrix pages
        $matrixUrls = Util::getSitemapUrls();
        $urls = array_merge($urls, $matrixUrls);
        
        // Add testimonials index
        $urls[] = [
            'url' => $root . '/testimonials',
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'weekly',
            'priority' => '0.8'
        ];
        
        
        // Add testimonials SKU pages
        $reviews = Util::getCsvData('reviews.csv');
        $skus = array_values(array_unique(array_map(fn($r) => $r['sku'], $reviews)));
        foreach ($skus as $sku) {
            $urls[] = [
                'url' => $root . '/testimonials/' . rawurlencode($sku),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.7'
            ];
        }
        
        // Add FAQ pages
        $faqDir = __DIR__ . '/../../data/faqs/pages/';
        if (is_dir($faqDir)) {
            $faqFiles = glob($faqDir . 'faq__*.json');
            foreach ($faqFiles as $faqFile) {
                $filename = basename($faqFile);
                $slug = str_replace(['faq__', '.json'], '', $filename);
                
                $urls[] = [
                    'url' => $root . '/faq/' . $slug,
                    'lastmod' => date('Y-m-d'),
                    'changefreq' => 'monthly',
                    'priority' => '0.8'
                ];
            }
        }
        
        View::renderXml(View::renderSitemap($urls));
    }
    
    public function products()
    {
        $root = Config::get('app_url');
        $urls = [];
        
        // Add canonical product pages
        $productPages = [
            'modular-flood-barrier',
            'garage-dam-kit', 
            'doorway-flood-panel'
        ];
        
        foreach ($productPages as $product) {
            $urls[] = [
                'url' => $root . '/products/' . $product,
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.9'
            ];
        }
        
        // Add location pages
        $cities = [
            'fort-myers', 'cape-coral', 'naples', 'bonita-springs', 'estero',
            'punta-gorda', 'port-charlotte', 'sarasota', 'bradenton',
            'st-petersburg', 'clearwater', 'tampa'
        ];
        
        foreach ($cities as $city) {
            foreach ($productPages as $product) {
                $urls[] = [
                    'url' => $root . '/fl/' . $city . '/' . $product,
                    'lastmod' => date('Y-m-d'),
                    'changefreq' => 'monthly',
                    'priority' => '0.8'
                ];
            }
        }
        
        View::renderXml(View::renderSitemap($urls));
    }
    
    public function blog()
    {
        $root = Config::get('app_url');
        $posts = Util::getBlogPosts();
        $urls = [];
        
        foreach ($posts as $post) {
            $urls[] = [
                'url' => $root . '/blog/' . $post['slug'],
                'lastmod' => $post['date'],
                'changefreq' => 'monthly',
                'priority' => '0.8'
            ];
        }
        
        View::renderXml(View::renderSitemap($urls));
    }
    
    public function news()
    {
        $root = Config::get('app_url');
        $urls = [];
        
        // Include markdown-based news articles
        $articles = Util::getNewsArticles();
        foreach ($articles as $article) {
            $urls[] = [
                'url' => $root . '/news/' . $article['slug'],
                'lastmod' => $article['date'],
                'changefreq' => 'daily',
                'priority' => '0.9',
                'news' => [
                    'date' => $article['date'],
                    'title' => $article['title']
                ]
            ];
        }
        
        // Include programmatic news articles (all 20 cities)
        // These are now markdown files, so they're already included above via Util::getNewsArticles()
        // But we'll add them explicitly with correct URLs if they exist as markdown files
        $cities = [
            'fort-myers', 'cape-coral', 'naples', 'bonita-springs', 'estero',
            'sanibel', 'pine-island', 'marco-island', 'sarasota', 'tampa',
            'st-petersburg', 'clearwater', 'bradenton', 'venice',
            'port-charlotte', 'punta-gorda', 'miami', 'miami-beach',
            'key-west', 'key-largo'
        ];
        
        $today = date('Y-m-d');
        $newsPath = Config::getDataPath('news');
        
        foreach ($cities as $city) {
            // Check if markdown file exists (format: YYYY-MM-DD-flood-barriers-{city}.md)
            $slug = $today . '-flood-barriers-' . $city;
            $markdownFile = $newsPath . '/' . $slug . '.md';
            
            // Only add if markdown file exists (to avoid duplicates)
            if (file_exists($markdownFile)) {
                $cityName = ucwords(str_replace('-', ' ', $city));
                $title = "New Data Warns {$cityName} Homeowners: Sandbags Fail in 50% of Flood Events — Engineered Flood Panels Now Recommended Across Southwest Florida";
                
                // Check if already added via Util::getNewsArticles() above
                $alreadyAdded = false;
                foreach ($urls as $existingUrl) {
                    if (strpos($existingUrl['url'], $slug) !== false) {
                        $alreadyAdded = true;
                        break;
                    }
                }
                
                if (!$alreadyAdded) {
                    $urls[] = [
                        'url' => $root . '/news/' . $slug,
                        'lastmod' => $today,
                        'changefreq' => 'daily',
                        'priority' => '0.9',
                        'news' => [
                            'date' => $today,
                            'title' => $title
                        ]
                    ];
                }
            }
        }
        
        // Render Google News XML sitemap
        View::renderXml(View::renderSitemap($urls));
    }
    
    public function services()
    {
        $root = Config::get('app_url');
        $data = Util::getCsvData('matrix.csv');
        
        // Get unique keywords
        $keywords = array_unique(array_column($data, 'keyword'));
        $urls = [];
        
        foreach ($keywords as $keyword) {
            $urls[] = [
                'url' => $root . '/' . Util::slugify($keyword),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ];
        }
        
        View::renderXml(View::renderSitemap($urls));
    }
    
    public function cities()
    {
        $root = Config::get('app_url');
        $data = Util::getCsvData('matrix.csv');
        
        // Get unique cities
        $cities = array_unique(array_column($data, 'city'));
        $urls = [];
        
        foreach ($cities as $city) {
            $urls[] = [
                'url' => $root . '/city/' . Util::slugify($city),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.6'
            ];
        }
        
        View::renderXml(View::renderSitemap($urls));
    }
}
