<?php

namespace App\Controllers;

use App\Config;
use App\Util;
use App\View;
use App\Schema;

class BlogController
{
    public function index()
    {
        $posts = Util::getBlogPosts(10);
        
        $data = [
            'title' => 'Flood Protection Blog | Tips & Guides',
            'description' => 'Flood protection guides & tips for Florida. Expert advice on barriers, panels, storm preparedness. Practical strategies.',
            'posts' => $posts,
            'jsonld' => Schema::graph([
                Schema::website(Config::get('app_url')),
                Schema::breadcrumb([
                    ['Home', Config::get('app_url')],
                    ['Blog', Config::get('app_url') . '/blog']
                ])
            ])
        ];
        
        return View::renderPage('blog-index', $data);
    }
    
    public function show($slug)
    {
        $posts = Util::getBlogPosts();
        $post = null;
        
        foreach ($posts as $p) {
            if ($p['slug'] === $slug) {
                $post = $p;
                break;
            }
        }
        
        if (!$post) {
            $this->notFound();
            return;
        }
        
        $url = Config::get('app_url') . '/blog/' . $slug;
        
        $data = [
            'title' => $post['title'] . ' | ' . Config::get('app_name'),
            'description' => $post['description'],
            'post' => $post,
            'jsonld' => Schema::graph([
                Schema::website(Config::get('app_url')),
                Schema::blogPosting(
                    Config::get('app_url'),
                    $post['title'],
                    $post['description'],
                    $post['date'],
                    $url
                ),
                Schema::breadcrumb([
                    ['Home', Config::get('app_url')],
                    ['Blog', Config::get('app_url') . '/blog'],
                    [$post['title'], $url]
                ])
            ])
        ];
        
        return View::renderPage('blog-post', $data);
    }
    
    private function notFound()
    {
        http_response_code(404);
        echo View::renderPage('404', [
            'title' => 'Blog Post Not Found - ' . Config::get('app_name'),
            'description' => 'The blog post you are looking for could not be found.'
        ]);
        exit;
    }
}
