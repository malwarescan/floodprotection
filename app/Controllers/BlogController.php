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
        $baseUrl = Config::get('app_url');
        
        // Build schema blocks
        $schemaBlocks = [
            Schema::website($baseUrl),
            Schema::breadcrumb([
                ['Home', $baseUrl],
                ['Blog', $baseUrl . '/blog'],
                [$post['title'], $url]
            ])
        ];
        
        // Use BlogPosting schema for all blog posts (not NewsArticle)
        // According to Google's 2025 updates, NewsArticle is only for actual journalism
        $schemaBlocks[] = Schema::blogPosting(
            $baseUrl,
            $post['title'],
            $post['description'],
            $post['date'],
            $url
        );
        
        // Parse FAQs from content and add FAQPage schema if present
        $faqs = self::parseFaqFromMarkdown($post['content']);
        if (!empty($faqs)) {
            $faqSchema = [
                '@type' => 'FAQPage',
                'mainEntity' => []
            ];
            foreach ($faqs as $faq) {
                $faqSchema['mainEntity'][] = [
                    '@type' => 'Question',
                    'name' => $faq['q'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => strip_tags($faq['a'])
                    ]
                ];
            }
            $schemaBlocks[] = $faqSchema;
        }
        
        $data = [
            'title' => $post['title'] . ' | ' . Config::get('app_name'),
            'description' => $post['description'],
            'post' => $post,
            'jsonld' => Schema::graph($schemaBlocks),
            'googleAnalyticsId' => Config::get('google_analytics_id', '')
        ];
        
        return View::renderPage('blog-post', $data);
    }
    
    private function parseFaqFromMarkdown($content)
    {
        $faqs = [];
        
        // Look for FAQ section
        if (strpos($content, '## Frequently Asked Questions') === false) {
            return $faqs;
        }
        
        // Extract FAQ section
        preg_match('/## Frequently Asked Questions\s*\n(.*?)(?=\n##|\z)/s', $content, $matches);
        
        if (empty($matches[1])) {
            return $faqs;
        }
        
        $faqSection = $matches[1];
        
        // Parse FAQ items - split on ### headers
        $faqItems = preg_split('/\n### /', $faqSection);
        
        foreach ($faqItems as $item) {
            // Skip if empty
            if (trim($item) === '') continue;
            
            // Split on first newline to get question and answer
            $parts = preg_split('/\n/', $item, 2);
            
            if (count($parts) < 2) continue;
            
            $question = trim($parts[0]);
            $answer = trim($parts[1]);
            
            // Remove ### from question if present (from first FAQ item)
            $question = preg_replace('/^###\s*/', '', $question);
            
            // Clean up answer - remove extra whitespace and newlines
            $answer = preg_replace('/\n+/', ' ', $answer);
            $answer = preg_replace('/\s+/', ' ', $answer);
            $answer = trim($answer);
            
            if (!empty($question) && !empty($answer)) {
                $faqs[] = [
                    'q' => $question,
                    'a' => $answer
                ];
            }
        }
        
        return $faqs;
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
