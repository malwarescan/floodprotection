<?php

namespace App\Controllers;

use App\Config;
use App\Util;
use App\View;
use App\Schema;

class PagesController
{
    public function home()
    {
        $data = [
            'title' => 'Florida Flood Protection Services | ' . Config::get('app_name'),
            'description' => 'Professional flood protection services throughout Florida. Custom barriers, panels, and dry floodproofing solutions. Free quotes, fast installation.',
            'jsonld' => Schema::graph([
                Schema::website(Config::get('app_url')),
                Schema::localBusiness(
                    Config::get('brand'),
                    Config::get('phone'),
                    Config::get('address'),
                    'Miami',
                    'FL',
                    Config::get('zip'),
                    null,
                    null,
                    [
                        ['@type' => 'State', 'name' => 'Florida']
                    ]
                )
            ])
        ];
        
        return View::renderPage('home', $data);
    }
    
    public function matrix($keyword, $city)
    {
        // If this is a city route that got caught by the matrix route, redirect to city method
        if ($keyword === 'city') {
            return $this->city($city);
        }
        
        $row = Util::findMatrixRow($keyword, $city);
        
        if (!$row) {
            $this->notFound();
            return;
        }
        
        // Generate schema if not provided
        $jsonld = $row['jsonld'] ? json_decode($row['jsonld'], true) : Schema::generateMatrixSchema($row);
        
        $data = [
            'title' => $row['title'],
            'description' => $row['meta_description'],
            'h1' => $row['h1'],
            'product_name' => $row['product_name'],
            'product_brand' => $row['product_brand'],
            'product_sku' => $row['product_sku'],
            'product_price_min' => $row['product_price_min'],
            'product_price_max' => $row['product_price_max'],
            'product_currency' => $row['product_currency'],
            'telephone' => $row['telephone'],
            'address' => $row['address'],
            'zip' => $row['zip'],
            'city' => $row['city'],
            'county' => $row['county'],
            'keyword' => $row['keyword'],
            'resources' => $row['resources'],
            'jsonld' => $jsonld
        ];
        
        return View::renderPage('matrix-page', $data);
    }
    
    public function resources($topic, $city)
    {
        $resources = Util::getResourcesByTopic($topic, $city);
        
        if (empty($resources)) {
            $this->notFound();
            return;
        }
        
        $faq = [];
        foreach ($resources as $resource) {
            $faq[] = [
                'q' => $resource['question'],
                'a' => $resource['answer'],
                'source_url' => $resource['source_url']
            ];
        }
        
        $title = ucwords(str_replace('-', ' ', $topic)) . ' Resources - ' . ucwords($city) . ' | ' . Config::get('app_name');
        $description = "Frequently asked questions about " . str_replace('-', ' ', $topic) . " in " . ucwords($city) . ". Expert answers from flood protection professionals.";
        
        $data = [
            'title' => $title,
            'description' => $description,
            'topic' => $topic,
            'city' => $city,
            'resources' => $resources,
            'faq' => $faq,
            'jsonld' => Schema::graph([
                Schema::website(Config::get('app_url')),
                Schema::faq($faq),
                Schema::breadcrumb([
                    ['Home', Config::get('app_url')],
                    ['Resources', Config::get('app_url') . '/resources'],
                    [ucwords(str_replace('-', ' ', $topic)), Config::get('app_url') . '/resources/' . $topic],
                    [ucwords($city), Config::get('app_url') . '/resources/' . $topic . '/' . $city]
                ])
            ])
        ];
        
        return View::renderPage('resources', $data);
    }
    
    public function city($city)
    {
        // Get all services for this city from matrix data
        $matrixData = Util::getCsvData('matrix.csv');
        $cityServices = [];
        
        foreach ($matrixData as $row) {
            if (Util::slugify($row['city']) === $city) {
                $cityServices[] = $row;
            }
        }
        
        if (empty($cityServices)) {
            $this->notFound();
            return;
        }
        
        // Get unique services for this city
        $services = [];
        $serviceKeywords = [];
        foreach ($cityServices as $row) {
            if (!in_array($row['keyword'], $serviceKeywords)) {
                $services[] = [
                    'keyword' => $row['keyword'],
                    'url' => '/' . Util::slugify($row['keyword']) . '/' . $city,
                    'title' => $row['keyword']
                ];
                $serviceKeywords[] = $row['keyword'];
            }
        }
        
        $cityName = ucwords(str_replace('-', ' ', $city));
        $title = "Flood Protection Services in {$cityName} | " . Config::get('app_name');
        $description = "Professional flood protection services in {$cityName}, Florida. Custom barriers, panels, and dry floodproofing solutions. Free quotes, fast installation.";
        
        $data = [
            'title' => $title,
            'description' => $description,
            'city' => $city,
            'cityName' => $cityName,
            'services' => $services,
            'jsonld' => Schema::graph([
                Schema::website(Config::get('app_url')),
                Schema::localBusiness(
                    Config::get('brand'),
                    Config::get('phone'),
                    Config::get('address'),
                    $cityName,
                    'FL',
                    Config::get('zip'),
                    null,
                    null,
                    [
                        ['@type' => 'City', 'name' => $cityName],
                        ['@type' => 'State', 'name' => 'Florida']
                    ]
                ),
                Schema::breadcrumb([
                    ['Home', Config::get('app_url')],
                    [$cityName, Config::get('app_url') . '/city/' . $city]
                ])
            ])
        ];
        
        return View::renderPage('city', $data);
    }
    
    public function service($keyword)
    {
        // Get all cities for this service from matrix data
        $matrixData = Util::getCsvData('matrix.csv');
        $serviceCities = [];
        
        foreach ($matrixData as $row) {
            if (Util::slugify($row['keyword']) === $keyword) {
                $serviceCities[] = $row;
            }
        }
        
        if (empty($serviceCities)) {
            $this->notFound();
            return;
        }
        
        // Get unique cities for this service
        $cities = [];
        $citySlugs = [];
        foreach ($serviceCities as $row) {
            $citySlug = Util::slugify($row['city']);
            if (!in_array($citySlug, $citySlugs)) {
                $cities[] = [
                    'city' => $citySlug,
                    'cityName' => $row['city'],
                    'url' => '/' . $keyword . '/' . $citySlug
                ];
                $citySlugs[] = $citySlug;
            }
        }
        
        $serviceName = ucwords(str_replace('-', ' ', $keyword));
        $title = "{$serviceName} Services in Florida | " . Config::get('app_name');
        $description = "Professional {$serviceName} services throughout Florida. Custom solutions for residential and commercial properties. Free quotes, fast installation.";
        
        $data = [
            'title' => $title,
            'description' => $description,
            'keyword' => $keyword,
            'serviceName' => $serviceName,
            'cities' => $cities,
            'jsonld' => Schema::graph([
                Schema::website(Config::get('app_url')),
                Schema::service($serviceName, "Florida", Config::get('brand')),
                Schema::breadcrumb([
                    ['Home', Config::get('app_url')],
                    [$serviceName, Config::get('app_url') . '/' . $keyword]
                ])
            ])
        ];
        
        return View::renderPage('service', $data);
    }
    
    public function robots()
    {
        header('Content-Type: text/plain');
        echo "User-agent: *\n";
        echo "Allow: /\n";
        echo "Sitemap: " . Config::get('app_url') . "/sitemap.xml\n";
        exit;
    }
    
    public function favicon()
    {
        // Return a simple 204 No Content for favicon requests
        http_response_code(204);
        exit;
    }
    
    public function health()
    {
        http_response_code(200);
        echo 'OK';
        exit;
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
