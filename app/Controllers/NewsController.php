<?php

namespace App\Controllers;

use App\Config;
use App\Util;
use App\View;
use App\Schema;

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
            ])
        ];
        
        return View::renderPage('news-article', $data);
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
