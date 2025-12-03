<?php

namespace App\Controllers;

use App\Config;
use App\Util;
use App\View;
use App\Schema;
use App\NewsArticleGenerator;

class NewsController
{
    public function index()
    {
        $articles = Util::getNewsArticles(10);
        
        $data = [
            'title' => 'Flood Protection News | Storm Alerts & Updates',
            'description' => 'Latest flood protection news & storm alerts for Florida. Emergency preparedness, FEMA updates, weather alerts.',
            'articles' => $articles,
            'jsonld' => Schema::graph([
                Schema::website(Config::get('app_url')),
                Schema::breadcrumb([
                    ['Home', Config::get('app_url')],
                    ['News', Config::get('app_url') . '/news']
                ])
            ])
        ];
        
        return View::renderPage('news-index', $data);
    }
    
    public function show($slug)
    {
        $articles = Util::getNewsArticles();
        $article = null;
        
        foreach ($articles as $a) {
            if ($a['slug'] === $slug) {
                $article = $a;
                break;
            }
        }
        
        if (!$article) {
            $this->notFound();
            return;
        }
        
        $url = Config::get('app_url') . '/news/' . $slug;
        
        $data = [
            'title' => $article['title'] . ' | ' . Config::get('app_name'),
            'description' => $article['description'],
            'article' => $article,
            'jsonld' => Schema::graph([
                Schema::website(Config::get('app_url')),
                Schema::newsArticle(
                    Config::get('app_url'),
                    $article['title'],
                    $article['description'],
                    $article['date'],
                    $url
                ),
                Schema::breadcrumb([
                    ['Home', Config::get('app_url')],
                    ['News', Config::get('app_url') . '/news'],
                    [$article['title'], $url]
                ])
            ]),
            'googleAnalyticsId' => Config::get('google_analytics_id', '')
        ];
        
        return View::renderPage('news-article', $data);
    }
    
    public function programmatic($city)
    {
        // Validate city slug format
        if (empty($city) || !preg_match('/^[a-z0-9-]+$/', $city)) {
            $this->notFound();
            return;
        }
        
        $article = NewsArticleGenerator::generateArticle($city);
        
        if (!$article || empty($article['title'])) {
            $this->notFound();
            return;
        }
        
        $url = $article['canonical'];
        
        // Generate breadcrumb
        $breadcrumb = Schema::breadcrumb([
            ['Home', Config::get('app_url')],
            ['News', Config::get('app_url') . '/news'],
            [$article['city'] . ' Flood Protection News', $url]
        ]);
        
        // Combine article schema with breadcrumb
        // The article schema is already a complete NewsArticle object, so we just add it to the graph
        $jsonld = Schema::graph([
            Schema::website(Config::get('app_url')),
            $article['schema'],
            $breadcrumb
        ]);
        
        $data = [
            'title' => $article['meta_title'],
            'description' => $article['meta_description'],
            'canonical' => $article['canonical'],
            'article' => $article,
            'jsonld' => $jsonld,
            'is_programmatic' => true
        ];
        
        return View::renderPage('news-article-programmatic', $data);
    }
    
    private function notFound()
    {
        http_response_code(404);
        echo View::renderPage('404', [
            'title' => 'News Article Not Found - ' . Config::get('app_name'),
            'description' => 'The news article you are looking for could not be found.'
        ]);
        exit;
    }
}
