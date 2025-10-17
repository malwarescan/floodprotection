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
        $articles = Util::getNewsArticles();
        $urls = [];
        
        // Only include articles from last 48 hours for Google News
        $cutoff = date('Y-m-d H:i:s', strtotime('-48 hours'));
        
        foreach ($articles as $article) {
            if (strtotime($article['date']) >= strtotime($cutoff)) {
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
        }
        
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
