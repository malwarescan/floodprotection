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
        
        // Normalize canonical URL to always use www version
        // Strip query parameters for canonical (pagination, filters, etc. should not be in canonical)
        $requestUri = $_SERVER['REQUEST_URI'] ?? '/';
        $requestPath = parse_url($requestUri, PHP_URL_PATH);
        // Remove trailing slash for consistency (except root and Technology page)
        if ($requestPath !== '/' && $requestPath !== '/about/technology/' && substr($requestPath, -1) === '/') {
            $requestPath = rtrim($requestPath, '/');
        }
        $canonical = Util::normalizeCanonicalUrl(Config::get('app_url') . $requestPath);
        
        $defaultData = [
            'title' => Config::get('app_name'),
            'description' => 'Professional flood protection services in Florida',
            'canonical' => $canonical,
            'jsonld' => [],
            'url' => $canonical
        ];
        
        $data = array_merge($defaultData, $data);
        
        // I. Canonical Integrity: Ensure canonical is ALWAYS self-referencing
        // CRITICAL: Canonical must match the actual URL being accessed (www version)
        // This prevents "Duplicate, Google chose different canonical than user" errors
        // Always use the current request path, normalized to www, as the canonical
        $currentUrl = Config::get('app_url') . $requestPath;
        $selfReferencingCanonical = Util::normalizeCanonicalUrl($currentUrl);
        
        // Override any canonical set by controllers to ensure self-referencing
        // EXCEPTION: For pages with explicit canonical requirements (e.g., Technology page),
        // respect the controller's canonical if it was explicitly set
        if (!isset($data['canonical']) || $data['canonical'] === $canonical) {
            // No explicit canonical set by controller, use self-referencing
            $data['canonical'] = $selfReferencingCanonical;
            $data['url'] = $selfReferencingCanonical;
        }
        // If controller set an explicit canonical, keep it (e.g., Technology page with trailing slash)
        
        // IV. Structured Data: Ensure all schema URLs match canonical
        if (!empty($data['jsonld'])) {
            $data['jsonld'] = self::normalizeSchemaUrls($data['jsonld'], $data['canonical']);
        }
        
        // Ensure product schema URLs match canonical
        if (!empty($data['product']) && is_array($data['product'])) {
            if (isset($data['product']['url'])) {
                $data['product']['url'] = $data['canonical'];
            }
            if (isset($data['product']['@id'])) {
                $data['product']['@id'] = $data['canonical'] . '#product';
            }
        }
        
        $data['content'] = $content;
        
        // SEO Kernel Validation (only in development/staging)
        if (Config::get('app_env') !== 'production' || getenv('ENABLE_SEO_KERNEL') === 'true') {
            $html = self::render('layout', $data);
            $schema = is_array($data['jsonld']) ? $data['jsonld'] : [];
            if (is_array($data['jsonld']) && isset($data['jsonld']['@graph'])) {
                $schema = $data['jsonld']['@graph'];
            }
            
            $validation = SEOKernel::validatePage($data, $html, $schema);
            
            if (!$validation['valid'] && getenv('ENFORCE_SEO_KERNEL') === 'true') {
                SEOKernel::enforceDeploymentBlock($data, $html, $schema);
            }
            
            return $html;
        }
        
        return self::render('layout', $data);
    }
    
    /**
     * Normalize all URLs in schema to match canonical
     */
    private static function normalizeSchemaUrls($schema, $canonical)
    {
        if (is_array($schema)) {
            if (isset($schema['@graph']) && is_array($schema['@graph'])) {
                foreach ($schema['@graph'] as &$item) {
                    if (isset($item['url'])) {
                        $item['url'] = $canonical;
                    }
                    if (isset($item['@id']) && strpos($item['@id'], '#') === false) {
                        $item['@id'] = $canonical . (isset($item['@type']) ? '#' . strtolower($item['@type']) : '');
                    }
                }
            } else {
                foreach ($schema as &$item) {
                    if (is_array($item)) {
                        if (isset($item['url'])) {
                            $item['url'] = $canonical;
                        }
                        if (isset($item['@id']) && strpos($item['@id'], '#') === false) {
                            $item['@id'] = $canonical . (isset($item['@type']) ? '#' . strtolower($item['@type']) : '');
                        }
                    }
                }
            }
        }
        
        return $schema;
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
                    $xml .= "<news:name>Flood Barrier Pros</news:name>\n";
                    $xml .= "<news:language>en</news:language>\n";
                    $xml .= "</news:publication>\n";
                    // Convert date to W3C format for Google News
                    $pubDate = $url['news']['date'];
                    if (strlen($pubDate) === 10) {
                        $pubDate .= 'T00:00:00+00:00';
                    }
                    $xml .= "<news:publication_date>" . htmlspecialchars($pubDate) . "</news:publication_date>\n";
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
