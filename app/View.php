<?php

namespace App;

class View
{
    public static function render($template, $data = [])
    {
        $templatePath = Config::getTemplatesPath($template . '.php');
        
        if (!file_exists($templatePath)) {
            throw new \Exception("Template not found: {$template}");
        }
        
        extract($data);
        ob_start();
        include $templatePath;
        return ob_get_clean();
    }
    
    public static function renderPage($template, $data = [])
    {
        $content = self::render($template, $data);
        
        $defaultData = [
            'title' => Config::get('app_name'),
            'description' => 'Professional flood protection services in Florida',
            'canonical' => Config::get('app_url') . ($_SERVER['REQUEST_URI'] ?? '/'),
            'jsonld' => []
        ];
        
        $data = array_merge($defaultData, $data);
        $data['content'] = $content;
        
        return self::render('layout', $data);
    }
    
    public static function renderXml($content, $contentType = 'application/xml')
    {
        header('Content-Type: ' . $contentType . '; charset=utf-8');
        echo $content;
        exit;
    }
    
    public static function renderRss($posts, $title = 'Rubicon Flood Protection Blog')
    {
        $root = Config::get('app_url');
        $buildDate = date('r');
        
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">' . "\n";
        $xml .= '<channel>' . "\n";
        $xml .= "<title>{$title}</title>\n";
        $xml .= "<link>{$root}</link>\n";
        $xml .= "<description>Latest flood protection news and tips from Rubicon Flood Protection</description>\n";
        $xml .= "<language>en-us</language>\n";
        $xml .= "<lastBuildDate>{$buildDate}</lastBuildDate>\n";
        $xml .= "<atom:link href=\"{$root}/feed.xml\" rel=\"self\" type=\"application/rss+xml\"/>\n";
        
        foreach ($posts as $post) {
            $url = $root . '/blog/' . $post['slug'];
            $pubDate = date('r', strtotime($post['date']));
            
            $xml .= "<item>\n";
            $xml .= "<title>" . htmlspecialchars($post['title']) . "</title>\n";
            $xml .= "<link>{$url}</link>\n";
            $xml .= "<description>" . htmlspecialchars($post['description']) . "</description>\n";
            $xml .= "<pubDate>{$pubDate}</pubDate>\n";
            $xml .= "<guid isPermaLink=\"true\">{$url}</guid>\n";
            $xml .= "</item>\n";
        }
        
        $xml .= "</channel>\n";
        $xml .= "</rss>";
        
        return $xml;
    }
    
    public static function renderSitemap($urls, $isIndex = false)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        
        if ($isIndex) {
            $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
            foreach ($urls as $url) {
                $xml .= "<sitemap>\n";
                $xml .= "<loc>" . htmlspecialchars($url['loc']) . "</loc>\n";
                $xml .= "<lastmod>" . htmlspecialchars($url['lastmod']) . "</lastmod>\n";
                $xml .= "</sitemap>\n";
            }
            $xml .= "</sitemapindex>";
        } else {
            $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"';
            if (isset($urls[0]['news'])) {
                $xml .= ' xmlns:news="http://www.google.com/schemas/sitemap-news/0.9"';
            }
            $xml .= '>' . "\n";
            
            foreach ($urls as $url) {
                $xml .= "<url>\n";
                $xml .= "<loc>" . htmlspecialchars($url['url']) . "</loc>\n";
                $xml .= "<lastmod>" . htmlspecialchars($url['lastmod']) . "</lastmod>\n";
                $xml .= "<changefreq>" . htmlspecialchars($url['changefreq']) . "</changefreq>\n";
                $xml .= "<priority>" . htmlspecialchars($url['priority']) . "</priority>\n";
                
                if (isset($url['news'])) {
                    $xml .= "<news:news>\n";
                    $xml .= "<news:publication>\n";
                    $xml .= "<news:name>Rubicon Flood Protection</news:name>\n";
                    $xml .= "<news:language>en</news:language>\n";
                    $xml .= "</news:publication>\n";
                    $xml .= "<news:publication_date>" . htmlspecialchars($url['news']['date']) . "</news:publication_date>\n";
                    $xml .= "<news:title>" . htmlspecialchars($url['news']['title']) . "</news:title>\n";
                    $xml .= "</news:news>\n";
                }
                
                $xml .= "</url>\n";
            }
            $xml .= "</urlset>";
        }
        
        return $xml;
    }
}
