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
        // Home page
        $this->addRoute('GET', '/', 'PagesController@home');
        
        // Resources pages: /resources/{topic-slug}/{city}
        $this->addRoute('GET', '/resources/{topic}/{city}', 'PagesController@resources');
        
        // City pages: /city/{city-slug}
        $this->addRoute('GET', '/city/{city}', 'PagesController@city');
        
        // Testimonials routes
        $this->addRoute('GET', '/testimonials', 'TestimonialsController@index');
        $this->addRoute('GET', '/testimonials/{sku}', 'TestimonialsController@showSku');
        
        // Service pages: /{keyword} (service taxonomy) - must be after sitemap routes
        $this->addServiceRoutes();
        
        // Matrix pages: /{keyword}/{city-slug} (must be last to avoid conflicts)
        $this->addRoute('GET', '/{keyword}/{city}', 'PagesController@matrix');
        
        // Blog routes
        $this->addRoute('GET', '/blog', 'BlogController@index');
        $this->addRoute('GET', '/blog/{slug}', 'BlogController@show');
        
        // News routes
        $this->addRoute('GET', '/news', 'NewsController@index');
        $this->addRoute('GET', '/news/{slug}', 'NewsController@show');
        
        // Sitemap routes
        $this->addRoute('GET', '/sitemap.xml', 'SitemapController@index');
        $this->addRoute('GET', '/sitemap-pages.xml', 'SitemapController@pages');
        $this->addRoute('GET', '/sitemap-blog.xml', 'SitemapController@blog');
        $this->addRoute('GET', '/sitemap-news.xml', 'SitemapController@news');
        $this->addRoute('GET', '/sitemap-services.xml', 'SitemapController@services');
        $this->addRoute('GET', '/sitemap-cities.xml', 'SitemapController@cities');
        
        // Feed routes
        $this->addRoute('GET', '/feed.xml', 'FeedController@rss');
        
        // Other routes
        $this->addRoute('GET', '/robots.txt', 'PagesController@robots');
        $this->addRoute('GET', '/favicon.ico', 'PagesController@favicon');
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
        return '#^' . $pattern . '$#';
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
