<?php

namespace App;

class Router
{
    private $routes = [];
    
    public function __construct()
    {
        $this->registerRoutes();
    }
    
    private function registerRoutes()
    {
        // Favicon routes - must be at the top to avoid conflicts
        $this->addRoute('GET', '/favicon.ico', 'PagesController@favicon');
        $this->addRoute('GET', '/favicon.svg', 'PagesController@faviconSvg');
        $this->addRoute('GET', '/favicon-16x16.png', 'PagesController@favicon16x16');
        $this->addRoute('GET', '/favicon-32x32.png', 'PagesController@favicon32x32');
        $this->addRoute('GET', '/favicon-192.png', 'PagesController@favicon192');
        $this->addRoute('GET', '/apple-touch-icon.png', 'PagesController@appleTouchIcon');
        $this->addRoute('GET', '/site.webmanifest', 'PagesController@siteWebmanifest');
        
        // Home page
        $this->addRoute('GET', '/', 'PagesController@home');
        
        // Policy pages
        $this->addRoute('GET', '/return-policy', 'PagesController@returnPolicy');
        $this->addRoute('GET', '/privacy-policy', 'PagesController@privacyPolicy');
        $this->addRoute('GET', '/terms-of-service', 'PagesController@termsOfService');
        $this->addRoute('GET', '/contact', 'PagesController@contact');
        
        // Resources pages: /resources and /resources/{topic-slug}/{city}
        $this->addRoute('GET', '/resources', 'PagesController@resourcesIndex');
        $this->addRoute('GET', '/resources/{topic}/{city}', 'PagesController@resources');
        
        // City pages: /city/{city-slug}
        $this->addRoute('GET', '/city/{city}', 'PagesController@city');
        
        // Testimonials routes
        $this->addRoute('GET', '/testimonials', 'TestimonialsController@index');
        $this->addRoute('GET', '/testimonials/{sku}', 'TestimonialsController@showSku');
        
        // Products listing and canonical product pages
        $this->addRoute('GET', '/products', 'ProductController@index');
        $this->addRoute('GET', '/products/modular-flood-barrier', 'ProductController@modularFloodBarrier');
        $this->addRoute('GET', '/products/garage-dam-kit', 'ProductController@garageDamKit');
        $this->addRoute('GET', '/products/doorway-flood-panel', 'ProductController@doorwayFloodPanel');
        
        // Location pages: /fl/{city}/{product-slug}
        $this->addRoute('GET', '/fl/{city}/{product}', 'LocationController@show');
        
        // Blog routes (must be before matrix routes to avoid conflicts)
        $this->addRoute('GET', '/blog', 'BlogController@index');
        $this->addRoute('GET', '/blog/{slug}', 'BlogController@show');
        
        // News routes (must be before matrix routes to avoid conflicts)
        $this->addRoute('GET', '/news', 'NewsController@index');
        $this->addRoute('GET', '/news/{slug}', 'NewsController@show');
        
        // FAQ routes (must be before service routes to avoid conflicts)
        $this->addRoute('GET', '/faq/{slug}', 'FaqController@show');
        
        // Naples-specific high-value landing page
        $this->addRoute('GET', '/fl/naples/flood-barriers', 'PagesController@naplesFloodBarriers');
        
        // Regions pages: /regions and /regions/{slug} - must be before matrix routes
        $this->addRoute('GET', '/regions', 'PagesController@regionsIndex');
        $this->addRoute('GET', '/regions/{slug}', 'PagesController@showRegion');
        
        // Service pages: /{keyword} (service taxonomy) - must be after FAQ routes
        $this->addServiceRoutes();
        
        // Matrix pages: /{keyword}/{city-slug} (must be last to avoid conflicts)
        $this->addRoute('GET', '/{keyword}/{city}', 'PagesController@matrix');
        
        // Sitemap routes (legacy)
        $this->addRoute('GET', '/sitemap.xml', 'SitemapController@index');
        $this->addRoute('GET', '/sitemap-pages.xml', 'SitemapController@pages');
        $this->addRoute('GET', '/sitemap-products.xml', 'SitemapController@products');
        $this->addRoute('GET', '/sitemap-blog.xml', 'SitemapController@blog');
        $this->addRoute('GET', '/sitemap-news.xml', 'SitemapController@news');
        $this->addRoute('GET', '/sitemap-services.xml', 'SitemapController@services');
        $this->addRoute('GET', '/sitemap-cities.xml', 'SitemapController@cities');
        
        // New sectioned sitemap routes
        $this->addRoute('GET', '/sitemaps/sitemap-index.xml', 'SitemapController@sitemapIndex');
        $this->addRoute('GET', '/sitemaps/sitemap-index.xml.gz', 'SitemapController@sitemapIndexGz');
        $this->addRoute('GET', '/sitemaps/sitemap-static.xml', 'SitemapController@sitemapStatic');
        $this->addRoute('GET', '/sitemaps/sitemap-static.xml.gz', 'SitemapController@sitemapStaticGz');
        $this->addRoute('GET', '/sitemaps/sitemap-products.xml', 'SitemapController@sitemapProducts');
        $this->addRoute('GET', '/sitemaps/sitemap-products.xml.gz', 'SitemapController@sitemapProductsGz');
        $this->addRoute('GET', '/sitemaps/sitemap-faq.xml', 'SitemapController@sitemapFaq');
        $this->addRoute('GET', '/sitemaps/sitemap-faq.xml.gz', 'SitemapController@sitemapFaqGz');
        $this->addRoute('GET', '/sitemaps/sitemap-reviews.xml', 'SitemapController@sitemapReviews');
        $this->addRoute('GET', '/sitemaps/sitemap-reviews.xml.gz', 'SitemapController@sitemapReviewsGz');
        $this->addRoute('GET', '/sitemaps/sitemap-blog.xml', 'SitemapController@sitemapBlog');
        $this->addRoute('GET', '/sitemaps/sitemap-blog.xml.gz', 'SitemapController@sitemapBlogGz');
        
        // Feed routes
        $this->addRoute('GET', '/feed.xml', 'FeedController@rss');
        
        // Other routes
        $this->addRoute('GET', '/robots.txt', 'PagesController@robots');
        $this->addRoute('GET', '/healthz', 'PagesController@health');
    }
    
    private function addRoute($method, $pattern, $handler, $keyword = null)
    {
        $this->routes[] = [
            'method' => $method,
            'pattern' => $pattern,
            'handler' => $handler,
            'keyword' => $keyword
        ];
    }
    
    private function addServiceRoutes()
    {
        // Load matrix data to get unique keywords for service routes
        $matrixData = \App\Util::getCsvData('matrix.csv');
        $keywords = [];
        
        foreach ($matrixData as $row) {
            $keyword = \App\Util::slugify($row['keyword']);
            if (!in_array($keyword, $keywords)) {
                $keywords[] = $keyword;
                $this->addRoute('GET', '/' . $keyword, 'PagesController@service', $keyword);
            }
        }
    }
    
    
    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Handle redirects before normal routing
        $redirect = $this->handleRedirects($uri);
        if ($redirect) {
            header('Location: ' . $redirect, true, 301);
            exit;
        }
        
        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }
            
            $pattern = $this->convertPatternToRegex($route['pattern']);
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Remove full match
                
                list($controller, $action) = explode('@', $route['handler']);
                $controllerClass = "App\\Controllers\\{$controller}";
                
                if (class_exists($controllerClass)) {
                    $controllerInstance = new $controllerClass();
                    if (method_exists($controllerInstance, $action)) {
                        // If this is a service route with a keyword, pass the keyword directly
                        if (isset($route['keyword']) && $route['keyword']) {
                            return $controllerInstance->$action($route['keyword']);
                        }
                        
                        switch (count($matches)) {
                            case 0:
                                return $controllerInstance->$action();
                            case 1:
                                return $controllerInstance->$action($matches[0]);
                            case 2:
                                return $controllerInstance->$action($matches[0], isset($matches[1]) ? $matches[1] : null);
                            default:
                                // For more than 2 parameters, just call with the first two
                                return $controllerInstance->$action($matches[0], isset($matches[1]) ? $matches[1] : null);
                        }
                    }
                }
            }
        }
        
        $this->notFound();
    }
    
    private function convertPatternToRegex($pattern)
    {
        // Convert {param} to named capture groups
        $pattern = preg_replace('/\{([^}]+)\}/', '(?P<$1>[^/]+)', $pattern);
        // Make trailing slash optional
        return '#^' . $pattern . '/?$#';
    }
    
    private function handleRedirects($uri)
    {
        // Remove trailing slash for consistency (except root)
        if ($uri !== '/' && substr($uri, -1) === '/') {
            return rtrim($uri, '/');
        }
        
        // Fix malformed URLs with double underscores (e.g., /fl__naples__flood-barriers -> /fl/naples/flood-barriers)
        if (strpos($uri, '__') !== false) {
            // Replace double underscores with single dashes, then convert to proper path
            $fixed = str_replace('__', '-', $uri);
            // Convert pattern like /fl-naples-flood-barriers to /fl/naples/flood-barriers
            if (preg_match('#^/fl-([^-]+)-(.+)$#', $fixed, $matches)) {
                return '/fl/' . $matches[1] . '/' . $matches[2];
            }
            // Fallback: just replace double underscores with slashes
            return str_replace('__', '/', $uri);
        }
        
        // Redirect old product SKU URLs to canonical product pages or location pages
        if (preg_match('#^/products/rfp-(.+)$#', $uri, $matches)) {
            $sku = strtolower($matches[1]);
            
            // Map SKU prefixes to canonical products
            $productMap = [
                'mod-barrier' => '/products/modular-flood-barrier',
                'homeflo' => '/products/modular-flood-barrier',
                'home-flo' => '/products/modular-flood-barrier',
                'garage' => '/products/garage-dam-kit',
                'doordam' => '/products/garage-dam-kit',
                'panel' => '/products/doorway-flood-panel',
                'basement' => '/products/doorway-flood-panel',
                'door-panel' => '/products/doorway-flood-panel',
                'resident' => '/products/modular-flood-barrier',
                'flood-pr' => '/products/modular-flood-barrier',
                'portable' => '/products/modular-flood-barrier'
            ];
            
            // Try to extract city from SKU
            $cityMap = [
                'miami' => 'miami', 'tampa' => 'tampa', 'orlando' => 'orlando',
                'jax' => 'jacksonville', 'naples' => 'naples', 'fortmyers' => 'fort-myers',
                'pensacola' => 'pensacola', 'keywest' => 'key-west', 'key-we' => 'key-west',
                'starke' => 'starke', 'jensen' => 'jensen-beach', 'fort-p' => 'fort-pierce',
                'fernandina' => 'fernandina-beach', 'mirama' => 'miramar', 'flagle' => 'flagler-beach',
                'wesley' => 'wesley-chapel', 'maccle' => 'macclenny', 'auburn' => 'auburn',
                'cross' => 'cross-city', 'bunnel' => 'bunnell', 'mount' => 'mount-dora',
                'madiso' => 'madison', 'crysta' => 'crystal-river', 'tamara' => 'tamarac',
                'blount' => 'blountstown', 'west-p' => 'west-palm-beach', 'deland' => 'deland',
                'the-vi' => 'the-villages', 'largo' => 'largo'
            ];
            
            // Determine product type
            $productSlug = 'modular-flood-barrier'; // default
            foreach ($productMap as $prefix => $canonical) {
                if (strpos($sku, $prefix) === 0 || strpos($sku, '-' . $prefix) !== false) {
                    $productSlug = basename($canonical);
                    break;
                }
            }
            
            // Try to extract city
            $city = null;
            foreach ($cityMap as $key => $cityName) {
                if (strpos($sku, $key) !== false) {
                    $city = $cityName;
                    break;
                }
            }
            
            // If we found a city, redirect to location page, otherwise canonical product
            if ($city) {
                return "/fl/{$city}/{$productSlug}";
            } else {
                return "/products/{$productSlug}";
            }
        }
        
        // Redirect testimonials with product names to testimonials index
        if (preg_match('#^/testimonials/(doorway-flood-panel|modular-flood-barrier|garage-dam-kit)$#', $uri, $matches)) {
            return '/testimonials';
        }
        
        // Redirect /door-flood-dams/{city} to /resources/door-dams/{city}
        if (preg_match('#^/door-flood-dams/(.+)$#', $uri, $matches)) {
            return '/resources/door-dams/' . $matches[1];
        }
        
        // Redirect /resources/door-dams (without city) to /resources
        if ($uri === '/resources/door-dams') {
            return '/resources';
        }
        
        return null;
    }
    
    private function notFound()
    {
        http_response_code(404);
        echo View::renderPage('404', [
            'title' => 'Page Not Found - ' . Config::get('app_name'),
            'description' => 'The page you are looking for could not be found.'
        ]);
        exit;
    }
}
