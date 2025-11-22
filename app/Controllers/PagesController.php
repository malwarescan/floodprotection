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
            'title' => 'Flood Barriers & Protection Systems | ' . Config::get('app_name'),
            'description' => 'FEMA-aligned flood barriers for Florida homes & businesses. Quick installation, reusable panels, free assessment. Serving Miami, Tampa, Orlando.',
            'jsonld' => Schema::graph([
                Schema::website(Config::get('app_url')),
                Schema::organization(
                    'Flood Barrier Pros',
                    Config::get('app_url'),
                    Config::get('app_url') . '/logo.png',
                    'Rubicon Flood Protection',
                    Config::get('phone'),
                    Config::get('email'),
                    [
                        'https://www.facebook.com/61574735757374/'
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
        
        // Load FAQs for this URL
        require_once __DIR__ . '/../../lib/Faqs.php';
        $canonical = Config::get('app_url') . $row['url_path'];
        $faqs = \Faqs::locate($canonical);
        
        // Always generate fresh schema with fixed offers/offerCount
        $schemaItems = [];
        $schemaItems[] = Schema::website(Config::get('app_url'));
        $jsonld = Schema::generateMatrixSchema($row);
        
        // Add FAQ schema if we have FAQs
        if (!empty($faqs)) {
            $schemaItems[] = Schema::faq($faqs);
        }
        
        // Merge the matrix schema with FAQ schema
        if (isset($jsonld['@graph']) && is_array($jsonld['@graph'])) {
            $schemaItems = array_merge($schemaItems, $jsonld['@graph']);
            $jsonld = Schema::graph($schemaItems);
        }
        
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
            'telephone' => Config::get('phone'),
            'address' => Config::get('address'),
            'zip' => Config::get('zip'),
            'city' => $row['city'],
            'county' => $row['county'],
            'keyword' => $row['keyword'],
            'resources' => $row['resources'],
            'faqs' => $faqs,
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
        
        // CTR-optimized meta for specific cities (GSC shows 0% CTR - needs lift)
        $cityMetaMap = [
            'sanford' => [
                'title' => \App\SEO::titleSanford(),
                'description' => \App\SEO::descSanford()
            ],
            'south-miami' => [
                'title' => 'Flood Barriers South Miami FL | Local Installation',
                'description' => 'Flood barrier installation in South Miami, FL. Local experts, FEMA-aligned systems, free assessment. Serving South Miami area.'
            ],
            'pinellas-park' => [
                'title' => 'Flood Barriers Pinellas Park FL | Local Installation',
                'description' => 'Flood barrier installation in Pinellas Park, FL. Local experts, FEMA-aligned systems, free assessment. Serving Pinellas Park area.'
            ],
            'clearwater' => [
                'title' => 'Flood Barriers Clearwater FL | Local Installation',
                'description' => 'Flood barrier installation in Clearwater, FL. Local experts, FEMA-aligned systems, free assessment. Serving Clearwater area.'
            ],
            'st-pete-beach' => [
                'title' => 'Flood Barriers St Pete Beach FL | Local Installation',
                'description' => 'Flood barrier installation in St Pete Beach, FL. Local experts, FEMA-aligned systems, free assessment. Serving St Pete Beach area.'
            ],
            'north-miami' => [
                'title' => 'Flood Barriers North Miami FL | Local Installation',
                'description' => 'Flood barrier installation in North Miami, FL. Local experts, FEMA-aligned systems, free assessment. Serving North Miami area.'
            ]
        ];
        
        $citySlug = strtolower($city);
        if (isset($cityMetaMap[$citySlug])) {
            $title = $cityMetaMap[$citySlug]['title'];
            $description = $cityMetaMap[$citySlug]['description'];
        } else {
            $title = "Flood Barriers in {$cityName} | {$cityName} Flood Protection";
            $description = "Flood barriers & panels for {$cityName}, FL. Custom installation, FEMA-aligned, free assessment. Quick installation & local service.";
        }
        
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
        $canonical = Config::get('app_url') . '/' . $keyword;
        
        // Load FAQs
        require_once __DIR__ . '/../../lib/Faqs.php';
        $faqs = \Faqs::locate($canonical);
        
        // Enhanced SEO with EEAATT keywords
        $keywordVariations = [
            'home-flood-barriers' => [
                'title' => "Home Flood Barriers in Florida | FEMA-Approved Installation | Flood Barrier Pros",
                'description' => "Expert home flood barriers installation throughout Florida. FEMA-approved flood panels for doors, windows, and garages. Free assessment, insurance discounts, $899-$1,499 starting price."
            ],
            'residential-flood-panels' => [
                'title' => "Residential Flood Panels in Florida | Custom Installation | FEMA-Certified",
                'description' => "Professional residential flood panels for Florida homes. FEMA-certified, reusable panels for maximum flood protection. Expert installation, insurance premium reductions available."
            ]
        ];
        
        $seo = $keywordVariations[$keyword] ?? [
            'title' => "{$serviceName} Services in Florida | Professional Installation & FEMA-Approved",
            'description' => "Expert {$serviceName} installation throughout Florida. FEMA-approved, code-compliant, insurance-qualified flood barriers. Free assessment, fast installation, warranty coverage."
        ];
        
        $schemaBlocks = [
            Schema::website(Config::get('app_url')),
            [
                '@type' => 'Service',
                'name' => "{$serviceName} Services",
                'description' => $seo['description'],
                'provider' => [
                    '@type' => 'Organization',
                    'name' => Config::get('brand')
                ],
                'areaServed' => ['@type' => 'State', 'name' => 'Florida'],
                'serviceType' => 'Flood Protection',
                'availableChannel' => [
                    '@type' => 'ServiceChannel',
                    'serviceUrl' => $canonical,
                    'servicePhone' => Config::get('phone')
                ]
            ],
            Schema::breadcrumb([
                ['Home', Config::get('app_url')],
                [$serviceName, Config::get('app_url') . '/' . $keyword]
            ])
        ];
        
        // Add FAQ schema if FAQs exist
        if (!empty($faqs)) {
            $schemaBlocks[] = Schema::faq($faqs);
        }
        
        $data = [
            'title' => $seo['title'],
            'description' => $seo['description'],
            'canonical' => $canonical,
            'keyword' => $keyword,
            'serviceName' => $serviceName,
            'cities' => $cities,
            'faqs' => $faqs,
            'jsonld' => Schema::graph($schemaBlocks)
        ];
        
        return View::renderPage('service', $data);
    }
    
    public function naplesFloodBarriers()
    {
        $canonical = Config::get('app_url') . '/fl/naples/flood-barriers';
        
        // Load FAQs
        require_once __DIR__ . '/../../lib/Faqs.php';
        $faqs = \Faqs::locate($canonical);
        
        // Enhanced SEO for Naples
        $title = "Flood Barriers & Floodproofing in Naples, FL | Permitted & Engineered";
        $description = "Naples flood barriers & floodproofing services. Permit-ready submittals, engineer-sealed options, 48-hour Collier County site surveys. Waterfront & HOA-compliant solutions.";
        
        // Naples-specific schema
        $schemaBlocks = [
            Schema::website(Config::get('app_url')),
            [
                '@type' => 'LocalBusiness',
                '@id' => $canonical . '#org',
                'name' => Config::get('brand'),
                'url' => Config::get('app_url'),
                'telephone' => Config::get('phone'),
                'areaServed' => [
                    ['@type' => 'AdministrativeArea', 'name' => 'Collier County FL']
                ],
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressLocality' => 'Naples',
                    'addressRegion' => 'FL',
                    'addressCountry' => 'US'
                ]
            ],
            [
                '@type' => 'Service',
                '@id' => $canonical . '#service',
                'serviceType' => 'Flood Barrier Installation',
                'provider' => ['@id' => $canonical . '#org'],
                'areaServed' => [
                    ['@type' => 'City', 'name' => 'Naples FL']
                ],
                'hasOfferCatalog' => [
                    '@type' => 'OfferCatalog',
                    'name' => 'Flood Protection Options',
                    'itemListElement' => [
                        [
                            '@type' => 'Offer',
                            'itemOffered' => [
                                '@type' => 'Service',
                                'name' => 'Aluminum Flood Plank Systems'
                            ]
                        ],
                        [
                            '@type' => 'Offer',
                            'itemOffered' => [
                                '@type' => 'Service',
                                'name' => 'Self-Deploying Water Dams'
                            ]
                        ],
                        [
                            '@type' => 'Offer',
                            'itemOffered' => [
                                '@type' => 'Service',
                                'name' => 'Water-Filled Diversion Tubes'
                            ]
                        ]
                    ]
                ]
            ],
            Schema::breadcrumb([
                ['Home', Config::get('app_url')],
                ['Florida', Config::get('app_url') . '/fl/'],
                ['Naples Flood Barriers', $canonical]
            ])
        ];
        
        // Add FAQ schema if FAQs exist
        if (!empty($faqs)) {
            $schemaBlocks[] = Schema::faq($faqs);
        }
        
        $data = [
            'title' => $title,
            'description' => $description,
            'canonical' => $canonical,
            'faqs' => $faqs,
            'jsonld' => Schema::graph($schemaBlocks)
        ];
        
        return View::renderPage('naples-page', $data);
    }
    
    public function robots()
    {
        header('Content-Type: text/plain');
        $baseUrl = Config::get('app_url');
        echo "User-agent: *\n";
        echo "Allow: /\n";
        echo "\n";
        echo "Disallow: /admin/\n";
        echo "Disallow: /private/\n";
        echo "\n";
        echo "# Sitemaps (canonical www URLs)\n";
        echo "Sitemap: {$baseUrl}/sitemaps/sitemap-index.xml\n";
        echo "Sitemap: {$baseUrl}/sitemaps/sitemap-index.xml.gz\n";
        echo "Sitemap: {$baseUrl}/sitemaps/sitemap-static.xml\n";
        echo "Sitemap: {$baseUrl}/sitemaps/sitemap-static.xml.gz\n";
        echo "Sitemap: {$baseUrl}/sitemaps/sitemap-products.xml\n";
        echo "Sitemap: {$baseUrl}/sitemaps/sitemap-products.xml.gz\n";
        echo "Sitemap: {$baseUrl}/sitemaps/sitemap-faq.xml\n";
        echo "Sitemap: {$baseUrl}/sitemaps/sitemap-faq.xml.gz\n";
        echo "Sitemap: {$baseUrl}/sitemaps/sitemap-reviews.xml\n";
        echo "Sitemap: {$baseUrl}/sitemaps/sitemap-reviews.xml.gz\n";
        echo "Sitemap: {$baseUrl}/sitemaps/sitemap-blog.xml\n";
        echo "Sitemap: {$baseUrl}/sitemaps/sitemap-blog.xml.gz\n";
        exit;
    }
    
    public function favicon()
    {
        $this->serveStaticFile('favicon.ico', 'image/x-icon');
    }
    
    public function faviconSvg()
    {
        $this->serveStaticFile('favicon.svg', 'image/svg+xml');
    }
    
    public function favicon16x16()
    {
        $this->serveStaticFile('favicon-16x16.png', 'image/png');
    }
    
    public function favicon32x32()
    {
        $this->serveStaticFile('favicon-32x32.png', 'image/png');
    }
    
    public function favicon192()
    {
        $this->serveStaticFile('favicon-192.png', 'image/png');
    }
    
    public function appleTouchIcon()
    {
        $this->serveStaticFile('apple-touch-icon.png', 'image/png');
    }
    
    public function siteWebmanifest()
    {
        $this->serveStaticFile('site.webmanifest', 'application/manifest+json');
    }
    
    private function serveStaticFile($filename, $contentType)
    {
        $filePath = __DIR__ . '/../../public/' . $filename;
        
        if (!file_exists($filePath)) {
            http_response_code(404);
            exit;
        }
        
        // Set content type
        header('Content-Type: ' . $contentType);
        
        // Set caching headers (1 year)
        header('Cache-Control: public, max-age=31536000, immutable');
        header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');
        
        // Send file
        readfile($filePath);
        exit;
    }
    
    public function health()
    {
        http_response_code(200);
        echo 'OK';
        exit;
    }
    
    public function gscAuditGateway()
    {
        $filePath = __DIR__ . '/../../public/data/gsc-audit-gateway.html';
        
        if (!file_exists($filePath)) {
            $this->notFound();
            return;
        }
        
        header('Content-Type: text/html; charset=utf-8');
        readfile($filePath);
        exit;
    }
    
    public function returnPolicy()
    {
        $data = [
            'title' => 'Return Policy | ' . Config::get('app_name'),
            'description' => 'Return policy for Flood Barrier Pros: Full refund on defective products within 30 days. All non-defective sales are final.',
            'canonical' => Config::get('app_url') . '/return-policy',
            'jsonld' => Schema::graph([
                Schema::website(Config::get('app_url')),
                Schema::breadcrumb([
                    ['Home', '/'],
                    ['Return Policy', '/return-policy']
                ])
            ])
        ];
        
        return View::renderPage('return-policy', $data);
    }
    
    public function privacyPolicy()
    {
        $data = [
            'title' => 'Privacy Policy | ' . Config::get('app_name'),
            'description' => 'Flood Barrier Pros privacy policy. Learn how we collect, use, and protect your personal information.',
            'canonical' => Config::get('app_url') . '/privacy-policy',
            'jsonld' => Schema::graph([
                Schema::website(Config::get('app_url')),
                Schema::breadcrumb([
                    ['Home', '/'],
                    ['Privacy Policy', '/privacy-policy']
                ])
            ])
        ];
        
        return View::renderPage('privacy-policy', $data);
    }
    
    public function termsOfService()
    {
        $data = [
            'title' => 'Terms of Service | ' . Config::get('app_name'),
            'description' => 'Terms of service for Flood Barrier Pros. Read our terms and conditions for using our flood protection services.',
            'canonical' => Config::get('app_url') . '/terms-of-service',
            'jsonld' => Schema::graph([
                Schema::website(Config::get('app_url')),
                Schema::breadcrumb([
                    ['Home', '/'],
                    ['Terms of Service', '/terms-of-service']
                ])
            ])
        ];
        
        return View::renderPage('terms-of-service', $data);
    }
    
    public function regionsIndex()
    {
        // Load regions from CSV
        $csv = __DIR__ . '/../../data/swfl_regions.csv';
        $regions = [];
        
        if (file_exists($csv)) {
            $handle = fopen($csv, 'r');
            if ($handle !== false) {
                $head = fgetcsv($handle, 0, ',', '"', "\\");
                while (($row = fgetcsv($handle, 0, ',', '"', "\\")) !== false) {
                    if (count($row) === count($head)) {
                        $regions[] = array_combine($head, $row);
                    }
                }
                fclose($handle);
            }
        }
        
        // Debug: Ensure data is passed correctly
        $data = [
            'title' => 'Southwest Florida Flood Protection Regions | Flood Barrier Pros',
            'description' => 'Find engineered flood protection services across Southwest Florida: Collier, Lee, Charlotte, Hendry, Glades.',
            'canonical' => Config::get('app_url') . '/regions',
            'regionsList' => $regions,
            'jsonld' => Schema::graph([
                Schema::website(Config::get('app_url')),
                Schema::breadcrumb([
                    ['Home', Config::get('app_url')],
                    ['Regions', Config::get('app_url') . '/regions']
                ])
            ])
        ];
        
        // Return rendered page
        return View::renderPage('regions', $data);
    }
    
    public function showRegion($slug)
    {
        // Load regions data
        require_once __DIR__ . '/../../lib/swfl-schema.php';
        $csv = __DIR__ . '/../../data/swfl_regions.csv';
        $rows = [];
        
        if (file_exists($csv)) {
            $handle = fopen($csv, 'r');
            if ($handle !== false) {
                $head = fgetcsv($handle, 0, ',', '"', "\\");
                while (($row = fgetcsv($handle, 0, ',', '"', "\\")) !== false) {
                    if (count($row) === count($head)) {
                        $rows[] = array_combine($head, $row);
                    }
                }
                fclose($handle);
            }
        }
        
        // Find the region
        $r = null;
        foreach ($rows as $row) {
            if ($row['slug'] === $slug) {
                $r = $row;
                break;
            }
        }
        
        if (!$r) {
            $this->notFound();
            return;
        }
        
        // Build schema
        $schemaBlocks = [
            Schema::website(Config::get('app_url')),
            jsonld_service($r),
            jsonld_breadcrumb($r),
            jsonld_faq()
        ];
        
        $data = [
            'title' => $r['region']." Flood Barriers, Perimeter Systems & Pump Plans | Flood Barrier Pros",
            'description' => "Engineered flood protection in ".$r['region'].": door plugs, perimeter barriers, slab uplift mitigation, and pump sizing. County: ".$r['county'].".",
            'canonical' => Config::get('app_url') . '/regions/' . $slug,
            'regionData' => $r,
            'jsonld' => Schema::graph($schemaBlocks)
        ];
        
        return View::renderPage('regions', $data);
    }
    
    public function resourcesIndex()
    {
        // Load all unique topics from resources
        $resourcesData = Util::getCsvData('resources.csv');
        $topics = [];
        
        foreach ($resourcesData as $row) {
            $topic = $row['topic'] ?? '';
            if ($topic && !isset($topics[$topic])) {
                $topics[$topic] = [
                    'slug' => Util::slugify($topic),
                    'name' => ucwords(str_replace('-', ' ', $topic)),
                    'count' => 0
                ];
            }
            if ($topic) {
                $topics[$topic]['count']++;
            }
        }
        
        $data = [
            'title' => 'Flood Protection Resources & Guides | ' . Config::get('app_name'),
            'description' => 'Expert resources and guides for flood protection: door dams, flood barriers, installation tips, and more. Find answers to common questions.',
            'canonical' => Config::get('app_url') . '/resources',
            'topics' => array_values($topics),
            'jsonld' => Schema::graph([
                Schema::website(Config::get('app_url')),
                Schema::breadcrumb([
                    ['Home', Config::get('app_url')],
                    ['Resources', Config::get('app_url') . '/resources']
                ])
            ])
        ];
        
        return View::renderPage('resources-index', $data);
    }
    
    public function contact()
    {
        $data = [
            'title' => 'Contact Us | ' . Config::get('app_name'),
            'description' => 'Get in touch with Flood Barrier Pros for flood protection solutions. Free assessments, expert installation, and professional service throughout Florida.',
            'canonical' => Config::get('app_url') . '/contact',
            'jsonld' => Schema::graph([
                Schema::website(Config::get('app_url')),
                Schema::organization(
                    'Flood Barrier Pros',
                    Config::get('app_url'),
                    Config::get('app_url') . '/logo.png',
                    'Rubicon Flood Protection',
                    Config::get('phone'),
                    Config::get('email'),
                    []
                ),
                Schema::breadcrumb([
                    ['Home', Config::get('app_url')],
                    ['Contact', Config::get('app_url') . '/contact']
                ])
            ])
        ];
        
        return View::renderPage('contact', $data);
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
