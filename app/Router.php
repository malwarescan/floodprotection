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
        
        // Resources pages: /resources/{topic-slug}/{city}
        $this->addRoute('GET', '/resources/{topic}/{city}', 'PagesController@resources');
        
        // City pages: /city/{city-slug}
        $this->addRoute('GET', '/city/{city}', 'PagesController@city');
        
        // Testimonials routes
        $this->addRoute('GET', '/testimonials', 'TestimonialsController@index');
        $this->addRoute('GET', '/testimonials/{sku}', 'TestimonialsController@showSku');
        
        // Canonical product pages
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
