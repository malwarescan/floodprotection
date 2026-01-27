<?php

namespace App\Controllers;

use App\Config;
use App\Util;
use App\View;
use App\Schema;
use App\SWFLContent;
use App\QueryDrivenContent;

class PagesController
{
    public function home()
    {
        // FAQ data for homepage FAQ section
        $faqData = [
            [
                'question' => 'What does it mean if a house is in a flood zone?',
                'answer' => 'A flood zone means the property is located in an area that has a measurable risk of flooding based on historical data, elevation, and proximity to water sources. Flood zones are primarily used to assess insurance requirements and risk, not to predict that flooding will happen every year.'
            ],
            [
                'question' => 'Can a house be in a flood zone and never flood?',
                'answer' => 'Yes. Many homes are designated in flood zones due to regional mapping but may never experience flooding. Flood zones indicate probability over long time horizons, not certainty. Local drainage, elevation, and mitigation measures can significantly affect actual risk.'
            ],
            [
                'question' => 'How accurate are FEMA flood maps?',
                'answer' => 'FEMA flood maps are a starting point, not a perfect prediction. Some maps are outdated and may not reflect recent development, drainage changes, or climate patterns. Homes can be added to or removed from flood zones when maps are updated.'
            ],
            [
                'question' => 'Do homeowners in flood zones have to buy flood insurance?',
                'answer' => 'Flood insurance is typically required by lenders when a mortgage is federally backed and the home is in a high-risk flood zone. Homeowners without a mortgage may not be required to carry flood insurance but often choose to based on risk tolerance.'
            ],
            [
                'question' => 'Does flood insurance fully cover flood damage?',
                'answer' => 'Flood insurance has coverage limits and exclusions. It generally covers structural damage and some contents, but not all property types or losses. It also does not prevent damage, it only helps offset financial loss after flooding occurs.'
            ],
            [
                'question' => 'What can be done to protect a house in a flood zone?',
                'answer' => 'Flood risk can be reduced through physical mitigation such as flood barriers, drainage improvements, sealing entry points, and managing water flow around the structure. The appropriate solution depends on the type of flooding risk and the property layout.'
            ],
            [
                'question' => 'Are flood barriers effective for residential homes?',
                'answer' => 'When properly designed and installed, residential flood barriers can significantly reduce or prevent floodwater from entering a home. Effectiveness depends on correct placement, maintenance, and matching the solution to the flood type.'
            ],
            [
                'question' => 'Is flood mitigation worth the cost?',
                'answer' => 'For many homeowners, mitigation reduces long-term financial risk, stress, and insurance exposure. The value depends on flood frequency, severity, and whether the mitigation protects critical areas of the home.'
            ],
            [
                'question' => 'What should I do if I already own a house in a flood zone?',
                'answer' => 'Homeowners should assess their specific flood risk, understand insurance coverage, identify vulnerable entry points, and evaluate mitigation options. Taking action before flooding occurs is generally more effective and less costly.'
            ],
            [
                'question' => 'Is it a bad idea to buy a house in a flood zone?',
                'answer' => 'Buying a house in a flood zone is a risk decision, not automatically a mistake. Many buyers weigh location, price, insurance cost, mitigation options, and long-term plans when deciding if the risk is acceptable.'
            ]
        ];
        
        // Convert FAQ data to schema format
        $faqSchema = [];
        foreach ($faqData as $faq) {
            $faqSchema[] = [
                '@type' => 'Question',
                'name' => $faq['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq['answer']
                ]
            ];
        }
        
        $data = [
            'title' => 'Florida\'s #1 Rated Flood Barriers | FEMA-Compliant Home Protection',
            'description' => 'Protect your home with Florida\'s most trusted flood barriers. FEMA-approved, reusable aluminum panels & garage dams. Free statewide assessment.',
            'faqs' => $faqData,
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
                ),
                [
                    '@type' => 'FAQPage',
                    'mainEntity' => $faqSchema
                ]
            ])
        ];
        
        return View::renderPage('home', $data);
    }
    
    public function technology()
    {
        $canonical = \App\Util::normalizeCanonicalUrl(\App\Config::get('app_url') . '/about/technology/');
        
        $data = [
            'title' => 'Technology | ' . \App\Config::get('app_name'),
            'description' => 'This site uses an AI-assisted analysis and content system designed by Joel Maldonado. Entity home: https://nrlc.ai/en-us/about/joel-maldonado/',
            'canonical' => $canonical,
            'jsonld' => '<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "ProfilePage",
      "@id": "' . $canonical . '#profilepage",
      "url": "' . $canonical . '",
      "mainEntity": {
        "@id": "https://nrlc.ai/en-us/about/joel-maldonado/#person"
      }
    },
    {
      "@type": "Person",
      "@id": "https://nrlc.ai/en-us/about/joel-maldonado/#person",
      "name": "Joel David Maldonado",
      "url": "https://nrlc.ai/en-us/about/joel-maldonado/"
    },
    {
      "@type": "BreadcrumbList",
      "@id": "' . $canonical . '#breadcrumb",
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "Home",
          "item": "https://www.floodbarrierpros.com/"
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": "About",
          "item": "https://www.floodbarrierpros.com/about/"
        },
        {
          "@type": "ListItem",
          "position": 3,
          "name": "Technology",
          "item": "' . $canonical . '"
        }
      ]
    }
  ]
}
</script>'
        ];
        
        return View::renderPage('technology', $data);
    }
    
    
    public function matrix($keyword, $city)
    {
        // If this is a city route that got caught by the matrix route, redirect to city method
        if ($keyword === 'city') {
            return $this->city($city);
        }
        
        // Special handling for Cape Coral Residential Flood Panels page
        $citySlug = Util::slugify($city);
        $keywordSlug = Util::slugify($keyword);
        if ($citySlug === 'cape-coral' && $keywordSlug === 'residential-flood-panels') {
            return $this->capeCoralResidentialFloodPanels();
        }
        
        $row = Util::findMatrixRow($keyword, $city);
        
        if (!$row) {
            $this->notFound();
            return;
        }
        
        $citySlug = Util::slugify($row['city']);
        $isSWFL = SWFLContent::isSWFLCity($citySlug);
        $canonical = Config::get('app_url') . $row['url_path'];
        
        // Load FAQs for this URL
        require_once __DIR__ . '/../../lib/Faqs.php';
        $faqs = \Faqs::locate($canonical);
        
        // Use SWFL content generator for SWFL cities
        if ($isSWFL) {
            // Use query-driven content for headings and meta
            $keywordSlug = Util::slugify($row['keyword']);
            $pageTitle = QueryDrivenContent::getMetaTitle($citySlug, $keywordSlug);
            $metaDescription = QueryDrivenContent::getMetaDescription($citySlug, $keywordSlug);
            $h1 = QueryDrivenContent::getH1($citySlug, $keywordSlug);
            $h2s = QueryDrivenContent::getH2s($citySlug, $keywordSlug);
            
            // Generate SWFL-optimized content
            $swflContent = [
                'page_title' => $pageTitle,
                'h1' => $h1,
                'h2s' => $h2s,
                'intro' => SWFLContent::getIntro($citySlug),
                'why_critical' => SWFLContent::getWhyCritical($citySlug),
                'products' => SWFLContent::getProductBreakdown(),
                'installation' => SWFLContent::getInstallationPermitting($citySlug),
                'pricing' => SWFLContent::getPricingGuide($citySlug),
                'case_studies' => SWFLContent::getCaseStudies($citySlug),
                'maintenance_checklist' => SWFLContent::getMaintenanceChecklist(),
                'faqs' => SWFLContent::getFAQs($citySlug),
                'internal_links' => QueryDrivenContent::getInternalLinkTargets($citySlug, $keywordSlug)
            ];
            
            // Generate comprehensive SWFL schema with expanded types
            $swflSchema = SWFLContent::generateSchema($citySlug, $canonical, $metaDescription, $keywordSlug);
            
            // Merge with existing schema
            $schemaItems = [];
            $schemaItems[] = Schema::website(Config::get('app_url'));
            
            if (isset($swflSchema['@graph'])) {
                $schemaItems = array_merge($schemaItems, $swflSchema['@graph']);
            }
            
            $jsonld = Schema::graph($schemaItems);
            
            $data = [
                'title' => $swflContent['page_title'],
                'description' => $metaDescription,
                'h1' => $swflContent['h1'],
                'h2s' => $swflContent['h2s'],
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
                'faqs' => $swflContent['faqs'],
                'jsonld' => $jsonld,
                'swfl_content' => $swflContent,
                'is_swfl' => true
            ];
        } else {
            // Standard matrix page for non-SWFL cities
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
            
            // Optimization: Use dynamic high-intent titles
            $prodName = $row['product_name'] ?: 'Flood Barriers';
            $optTitle = "{$prodName} {$row['city']}, FL | Reusable Home Protection";
            $optDesc = "Protect your {$row['city']} home from flooding with FEMA-approved {$prodName}. Quick installation, reusable panels, and free risk assessment.";
            
            $data = [
                'title' => $optTitle,
                'description' => $optDesc,
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
                'jsonld' => $jsonld,
                'is_swfl' => false
            ];
        }
        
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
            'st-petersburg' => [
                'title' => 'St Petersburg FL Flood Barriers | #1 Rated | 24hr Install',
                'description' => 'St Petersburg\'s top flood barrier company. 5-star rated, FEMA-compliant, free quotes. Protect your home now! Call today.'
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
            $title = "Flood Prevention Services in {$cityName} | Flood Barrier Pros";
            $description = "Expert flood prevention services for {$cityName}. We install FEMA-compliant flood barriers, garage dams, and door panels. Schedule your free consultation.";
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
        // Health check endpoint - must be fast and simple
        // Don't load any heavy dependencies
        http_response_code(200);
        header('Content-Type: text/plain');
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
    
    public function capeCoralResidentialFloodPanels()
    {
        $canonical = Config::get('app_url') . '/residential-flood-panels/cape-coral';
        
        // FAQ data for FAQPage schema
        $faqData = [
            [
                'question' => 'How much do flood panels cost in Cape Coral?',
                'answer' => 'Residential flood panels in Cape Coral typically cost $899-$1,499 per opening, depending on size and configuration. Entry door panels start around $899, while larger garage opening systems range from $1,299-$1,999. Whole-home protection for a standard Cape Coral home ranges from $18,000-$42,000. All panels are reusable and may qualify for up to $10,000 in FEMA flood mitigation grants.'
            ],
            [
                'question' => 'Are flood panels FEMA compliant?',
                'answer' => 'Yes, our residential flood panels exceed FEMA Technical Bulletin 3 (TB-3) standards with third-party certification. They withstand hydrostatic pressure testing per ASTM E330 and provide watertight seals rated for flood heights up to 8 feet. FEMA-certified installations may qualify for insurance premium reductions of 5-45%.'
            ],
            [
                'question' => 'Do flood panels lower insurance?',
                'answer' => 'Yes, FEMA-compliant flood panels can reduce NFIP (National Flood Insurance Program) premiums by 5-35% at the property level, and up to 50% when combined with elevation improvements. Given Cape Coral\'s average flood insurance cost of $1,150 annually, homeowners can save $240-$320 per year, or $4,800-$12,800 over 20-40 years.'
            ],
            [
                'question' => 'How fast can panels be installed before a storm?',
                'answer' => 'Once tracks are pre-installed, flood panels deploy in 3-6 minutes per opening. For emergency situations, our Cape Coral installation team offers rapid deployment services with 24-48 hour notice before expected storm landfall. We recommend deploying barriers 24-48 hours before expected storm landfall to ensure adequate preparation time for Cape Coral homeowners.'
            ],
            [
                'question' => 'Do I need HOA approval for flood panels in Cape Coral?',
                'answer' => 'Yes, HOA approval is mandatory for visible exterior installations in Cape Coral. Our team coordinates with HOA boards to ensure compliance with architectural guidelines and obtains necessary approvals. Systems can be designed to be minimally visible when not in use, meeting most HOA aesthetic requirements.'
            ],
            [
                'question' => 'What flood zones require flood panels in Cape Coral?',
                'answer' => 'Cape Coral is primarily in Flood Zones AE and VE. Zone AE (base flood) requires protection from stillwater flooding, while Zone VE (coastal high hazard) requires structures to withstand wave action and surge. Both zones require FEMA-compliant barriers, but VE zones may need higher surge ratings and additional structural considerations.'
            ]
        ];
        
        // Convert FAQ data to schema format
        $faqSchema = [];
        foreach ($faqData as $faq) {
            $faqSchema[] = [
                '@type' => 'Question',
                'name' => $faq['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq['answer']
                ]
            ];
        }
        
        // Build structured data: LocalBusiness with Service, FAQPage
        $schemaBlocks = [
            Schema::website(Config::get('app_url')),
            // LocalBusiness with Service (as specified in QA)
            [
                '@type' => 'LocalBusiness',
                'name' => 'Flood Barrier Pros',
                'url' => $canonical,
                'areaServed' => [
                    'Cape Coral FL',
                    'Lee County FL'
                ],
                'serviceOffered' => [
                    '@type' => 'Service',
                    'name' => 'Residential Flood Panel Installation'
                ],
                'telephone' => Config::get('phone'),
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => Config::get('address'),
                    'addressLocality' => 'Cape Coral',
                    'addressRegion' => 'FL',
                    'postalCode' => Config::get('zip'),
                    'addressCountry' => 'US'
                ]
            ],
            // FAQPage
            [
                '@type' => 'FAQPage',
                'mainEntity' => $faqSchema
            ],
            // Breadcrumb
            Schema::breadcrumb([
                ['Home', Config::get('app_url')],
                ['Residential Flood Panels', Config::get('app_url') . '/residential-flood-panels'],
                ['Cape Coral', $canonical]
            ])
        ];
        
        $data = [
            'title' => 'Residential Flood Panels in Cape Coral | FEMA Compliant Protection',
            'description' => 'FEMA-compliant residential flood panels designed for Cape Coral homes in AE and VE flood zones. Request a free assessment and protect your property before storm season.',
            'canonical' => $canonical,
            'jsonld' => Schema::graph($schemaBlocks)
        ];
        
        return View::renderPage('cape-coral-residential-flood-panels', $data);
    }
    
    public function fortMyersResidentialFloodPanels()
    {
        $canonical = Config::get('app_url') . '/residential-flood-panels/fort-myers';
        
        // FAQ data for FAQPage schema - Fort Myers specific
        $faqData = [
            [
                'question' => 'How much do flood panels cost in Fort Myers?',
                'answer' => 'Residential flood panels in Fort Myers typically cost $899-$1,499 per opening, depending on size and configuration. Entry door panels start around $899, while larger garage opening systems range from $1,299-$1,999. Whole-home protection for a standard Fort Myers home ranges from $18,000-$42,000. All panels are reusable and may qualify for up to $10,000 in FEMA flood mitigation grants.'
            ],
            [
                'question' => 'Are flood panels FEMA compliant in Fort Myers?',
                'answer' => 'Yes, our residential flood panels exceed FEMA Technical Bulletin 3 (TB-3) standards with third-party certification. They withstand hydrostatic pressure testing per ASTM E330 and provide watertight seals rated for flood heights up to 8-12 feet, which is critical for Fort Myers properties facing Caloosahatchee River overflow and coastal storm surge. FEMA-certified installations may qualify for insurance premium reductions of 5-45%.'
            ],
            [
                'question' => 'Do flood panels protect against storm surge?',
                'answer' => 'Yes, FEMA-compliant flood panels provide effective protection against storm surge by creating watertight seals at doorways, garage openings, and ground-level windows. During Hurricane Ian (2022), Fort Myers experienced 8-12 foot surge heights, and flood panels prevented water intrusion in protected properties. Panels are rated for surge heights up to 8 feet and can be combined with elevation improvements for higher surge protection.'
            ],
            [
                'question' => 'How fast can flood panels be installed before a hurricane?',
                'answer' => 'Once tracks are pre-installed, flood panels deploy in 3-6 minutes per opening. For emergency situations, our Fort Myers installation team offers rapid deployment services with 24-48 hour notice before expected storm landfall. We recommend deploying barriers 24-48 hours before expected storm landfall to ensure adequate preparation time for Fort Myers homeowners facing Caloosahatchee River overflow and coastal surge risks.'
            ],
            [
                'question' => 'Do I need permits for flood panels in Fort Myers?',
                'answer' => 'Yes, permanent flood panel installations in Fort Myers require building permits from the City of Fort Myers Building Division. Our team handles all permitting, coordinates with Lee County building departments, and ensures compliance with Florida Building Code and FEMA requirements. Temporary deployment of pre-installed systems typically does not require permits, but we recommend checking with local authorities.'
            ],
            [
                'question' => 'What flood zones require flood panels in Fort Myers?',
                'answer' => 'Fort Myers is primarily in Flood Zones AE, VE, and A. Zone AE (base flood) requires protection from stillwater flooding, Zone VE (coastal high hazard) requires structures to withstand wave action and surge, and Zone A requires elevation certificates. Properties along the Caloosahatchee River and coastal areas face the highest risk and require FEMA-compliant barriers rated for surge heights of 8-12 feet.'
            ]
        ];
        
        // Convert FAQ data to schema format
        $faqSchema = [];
        foreach ($faqData as $faq) {
            $faqSchema[] = [
                '@type' => 'Question',
                'name' => $faq['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq['answer']
                ]
            ];
        }
        
        // Build structured data: LocalBusiness with Service, FAQPage
        // Fort Myers primary, Cape Coral secondary only
        $schemaBlocks = [
            Schema::website(Config::get('app_url')),
            // LocalBusiness with Service (Fort Myers primary)
            [
                '@type' => 'LocalBusiness',
                'name' => 'Flood Barrier Pros',
                'url' => $canonical,
                'areaServed' => [
                    'Fort Myers FL',
                    'Lee County FL',
                    'Cape Coral FL'  // Secondary service area only
                ],
                'serviceOffered' => [
                    '@type' => 'Service',
                    'name' => 'Residential Flood Panel Installation'
                ],
                'telephone' => Config::get('phone'),
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => Config::get('address'),
                    'addressLocality' => 'Fort Myers',
                    'addressRegion' => 'FL',
                    'postalCode' => Config::get('zip'),
                    'addressCountry' => 'US'
                ]
            ],
            // FAQPage
            [
                '@type' => 'FAQPage',
                'mainEntity' => $faqSchema
            ],
            // Breadcrumb
            Schema::breadcrumb([
                ['Home', Config::get('app_url')],
                ['Residential Flood Panels', Config::get('app_url') . '/residential-flood-panels'],
                ['Fort Myers', $canonical]
            ])
        ];
        
        $data = [
            'title' => 'Residential Flood Panels in Fort Myers | FEMA Compliant Protection',
            'description' => 'FEMA-compliant residential flood panels designed for Fort Myers homes facing storm surge and river overflow. Get a free assessment before hurricane season.',
            'canonical' => $canonical,
            'jsonld' => Schema::graph($schemaBlocks)
        ];
        
        return View::renderPage('fort-myers-residential-flood-panels', $data);
    }
    
    public function naplesResidentialFloodPanels()
    {
        $canonical = Config::get('app_url') . '/residential-flood-panels/naples';
        
        // FAQ data for FAQPage schema - Naples specific
        $faqData = [
            [
                'question' => 'How much do flood panels cost in Naples?',
                'answer' => 'Residential flood panels in Naples typically cost $899-$1,499 per opening, depending on size and configuration. Entry door panels start around $899, while larger garage opening systems range from $1,299-$1,999. Whole-home protection for a standard Naples home ranges from $18,000-$42,000. All panels are reusable and may qualify for up to $10,000 in FEMA flood mitigation grants.'
            ],
            [
                'question' => 'Are flood panels FEMA compliant in Naples?',
                'answer' => 'Yes, our residential flood panels exceed FEMA Technical Bulletin 3 (TB-3) standards with third-party certification. They withstand hydrostatic pressure testing per ASTM E330 and provide watertight seals rated for flood heights up to 10-15 feet, which is critical for Naples properties facing Gulf of Mexico storm surge and coastal flooding. FEMA-certified installations may qualify for insurance premium reductions of 5-45%.'
            ],
            [
                'question' => 'Do flood panels protect against coastal storm surge?',
                'answer' => 'Yes, FEMA-compliant flood panels provide effective protection against coastal storm surge by creating watertight seals at doorways, garage openings, and ground-level windows. During Hurricane Ian (2022), Naples experienced 10-15 foot surge heights, and flood panels prevented water intrusion in protected properties. Panels are rated for surge heights up to 8 feet and can be combined with elevation improvements for higher surge protection.'
            ],
            [
                'question' => 'How fast can flood panels be installed before a hurricane?',
                'answer' => 'Once tracks are pre-installed, flood panels deploy in 3-6 minutes per opening. For emergency situations, our Naples installation team offers rapid deployment services with 24-48 hour notice before expected storm landfall. We recommend deploying barriers 24-48 hours before expected storm landfall to ensure adequate preparation time for Naples homeowners facing Gulf of Mexico surge and coastal flooding risks.'
            ],
            [
                'question' => 'Do I need permits for flood panels in Naples?',
                'answer' => 'Yes, permanent flood panel installations in Naples require building permits from the City of Naples Building Division. Our team handles all permitting, coordinates with Collier County building departments, and ensures compliance with Florida Building Code and FEMA requirements. Temporary deployment of pre-installed systems typically does not require permits, but we recommend checking with local authorities.'
            ],
            [
                'question' => 'What flood zones require flood panels in Naples?',
                'answer' => 'Naples is primarily in Flood Zones VE, AE, and A. Zone VE (coastal high hazard) requires structures to withstand wave action and surge, Zone AE (base flood) requires protection from stillwater flooding, and Zone A requires elevation certificates. Properties along the Gulf of Mexico and Naples Bay face the highest risk and require FEMA-compliant barriers rated for surge heights of 10-15 feet.'
            ]
        ];
        
        // Convert FAQ data to schema format
        $faqSchema = [];
        foreach ($faqData as $faq) {
            $faqSchema[] = [
                '@type' => 'Question',
                'name' => $faq['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq['answer']
                ]
            ];
        }
        
        // Build structured data: LocalBusiness with Service, FAQPage
        // Naples primary, Collier County only
        $schemaBlocks = [
            Schema::website(Config::get('app_url')),
            // LocalBusiness with Service (Naples primary)
            [
                '@type' => 'LocalBusiness',
                'name' => 'Flood Barrier Pros',
                'url' => $canonical,
                'areaServed' => [
                    'Naples FL',
                    'Collier County FL'
                ],
                'serviceOffered' => [
                    '@type' => 'Service',
                    'name' => 'Residential Flood Panel Installation'
                ],
                'telephone' => Config::get('phone'),
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => Config::get('address'),
                    'addressLocality' => 'Naples',
                    'addressRegion' => 'FL',
                    'postalCode' => Config::get('zip'),
                    'addressCountry' => 'US'
                ]
            ],
            // FAQPage
            [
                '@type' => 'FAQPage',
                'mainEntity' => $faqSchema
            ],
            // Breadcrumb
            Schema::breadcrumb([
                ['Home', Config::get('app_url')],
                ['Residential Flood Panels', Config::get('app_url') . '/residential-flood-panels'],
                ['Naples', $canonical]
            ])
        ];
        
        $data = [
            'title' => 'Residential Flood Panels in Naples | FEMA Compliant Protection',
            'description' => 'FEMA compliant residential flood panels for Naples homes facing coastal flooding and storm surge. Request a free flood assessment before hurricane season.',
            'canonical' => $canonical,
            'jsonld' => Schema::graph($schemaBlocks)
        ];
        
        return View::renderPage('naples-residential-flood-panels', $data);
    }
    
    public function bonitaSpringsResidentialFloodPanels()
    {
        $canonical = Config::get('app_url') . '/residential-flood-panels/bonita-springs';
        
        // FAQ data for FAQPage schema - Bonita Springs specific
        $faqData = [
            [
                'question' => 'How much do flood panels cost in Bonita Springs?',
                'answer' => 'Residential flood panels in Bonita Springs typically cost $899-$1,499 per opening, depending on size and configuration. Entry door panels start around $899, while larger garage opening systems range from $1,299-$1,999. Whole-home protection for a standard Bonita Springs home ranges from $18,000-$42,000. All panels are reusable and may qualify for up to $10,000 in FEMA flood mitigation grants.'
            ],
            [
                'question' => 'Are flood panels FEMA compliant in Bonita Springs?',
                'answer' => 'Yes, our residential flood panels exceed FEMA Technical Bulletin 3 (TB-3) standards with third-party certification. They withstand hydrostatic pressure testing per ASTM E330 and provide watertight seals rated for flood heights up to 7-11 feet, which is critical for Bonita Springs properties facing Estero Bay storm surge and Imperial River overflow. FEMA-certified installations may qualify for insurance premium reductions of 5-45%.'
            ],
            [
                'question' => 'Do flood panels protect against coastal and river flooding?',
                'answer' => 'Yes, FEMA-compliant flood panels provide effective protection against both coastal storm surge from Estero Bay and river overflow from the Imperial River. During Hurricane Ian (2022), Bonita Springs experienced 7-11 foot surge heights, and flood panels prevented water intrusion in protected properties. Panels are rated for surge heights up to 8 feet and can be combined with elevation improvements for higher surge protection.'
            ],
            [
                'question' => 'How fast can flood panels be installed in Bonita Springs?',
                'answer' => 'Once tracks are pre-installed, flood panels deploy in 3-6 minutes per opening. For emergency situations, our Bonita Springs installation team offers rapid deployment services with 24-48 hour notice before expected storm landfall. We recommend deploying barriers 24-48 hours before expected storm landfall to ensure adequate preparation time for Bonita Springs homeowners facing Estero Bay surge and Imperial River overflow risks.'
            ],
            [
                'question' => 'Do I need permits for flood panels in Bonita Springs?',
                'answer' => 'Yes, permanent flood panel installations in Bonita Springs require building permits from the City of Bonita Springs Building Division. Our team handles all permitting, coordinates with Lee County building departments, and ensures compliance with Florida Building Code and FEMA requirements. Temporary deployment of pre-installed systems typically does not require permits, but we recommend checking with local authorities.'
            ],
            [
                'question' => 'What flood zones require flood panels in Bonita Springs?',
                'answer' => 'Bonita Springs is primarily in Flood Zones AE and VE. Zone AE (base flood) requires protection from stillwater flooding, while Zone VE (coastal high hazard) requires structures to withstand wave action and surge. Properties along Estero Bay and the Imperial River face the highest risk and require FEMA-compliant barriers rated for surge heights of 7-11 feet.'
            ]
        ];
        
        // Convert FAQ data to schema format
        $faqSchema = [];
        foreach ($faqData as $faq) {
            $faqSchema[] = [
                '@type' => 'Question',
                'name' => $faq['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq['answer']
                ]
            ];
        }
        
        // Build structured data: LocalBusiness with Service, FAQPage
        // Bonita Springs primary, Lee County only (NO Collier County, NO other cities)
        $schemaBlocks = [
            Schema::website(Config::get('app_url')),
            // LocalBusiness with Service (Bonita Springs primary)
            [
                '@type' => 'LocalBusiness',
                'name' => 'Flood Barrier Pros',
                'url' => $canonical,
                'areaServed' => [
                    'Bonita Springs FL',
                    'Lee County FL'
                ],
                'serviceOffered' => [
                    '@type' => 'Service',
                    'name' => 'Residential Flood Panel Installation'
                ],
                'telephone' => Config::get('phone'),
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => Config::get('address'),
                    'addressLocality' => 'Bonita Springs',
                    'addressRegion' => 'FL',
                    'postalCode' => Config::get('zip'),
                    'addressCountry' => 'US'
                ]
            ],
            // FAQPage
            [
                '@type' => 'FAQPage',
                'mainEntity' => $faqSchema
            ],
            // Breadcrumb
            Schema::breadcrumb([
                ['Home', Config::get('app_url')],
                ['Residential Flood Panels', Config::get('app_url') . '/residential-flood-panels'],
                ['Bonita Springs', $canonical]
            ])
        ];
        
        $data = [
            'title' => 'Residential Flood Panels in Bonita Springs | FEMA Compliant Protection',
            'description' => 'FEMA-compliant residential flood panels for Bonita Springs homes facing coastal and river flooding. Request a free flood assessment before hurricane season.',
            'canonical' => $canonical,
            'jsonld' => Schema::graph($schemaBlocks)
        ];
        
        return View::renderPage('bonita-springs-residential-flood-panels', $data);
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
    
    public function femaComplianceGuide()
    {
        $data = [
            'title' => 'FEMA Flood Compliance Guide | ' . Config::get('app_name'),
            'description' => 'Guide to FEMA compliance for flood protection, dry vs wet floodproofing, and flood insurance requirements. Expert advice from Flood Barrier Pros.',
            'canonical' => Config::get('app_url') . '/fema-compliance-guide',
            'jsonld' => Schema::graph([
                Schema::website(Config::get('app_url')),
                Schema::breadcrumb([
                    ['Home', Config::get('app_url')],
                    ['FEMA Compliance Guide', Config::get('app_url') . '/fema-compliance-guide']
                ])
            ])
        ];
        
        return View::renderPage('fema-compliance-guide', $data);
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
