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
