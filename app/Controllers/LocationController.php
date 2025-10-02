<?php

namespace App\Controllers;

use App\Config;
use App\Schema;
use App\View;

class LocationController
{
    public function show($city, $product)
    {
        // Map product slugs to product data
        $productData = $this->getProductData($product);
        
        if (!$productData) {
            $this->notFound();
            return;
        }
        
        $cityName = ucwords(str_replace('-', ' ', $city));
        $productName = $productData['name'];
        $title = "{$productName} – {$cityName}, FL | Flood Barrier Pros";
        $description = "Professional {$productName} installation in {$cityName}, Florida. Fast installation, quality materials, local expertise.";
        $canonical = Config::get('app_url') . "/fl/{$city}/{$product}";
        
        // WebPage schema
        $webPage = [
            '@type' => 'WebPage',
            'name' => "{$productName} – {$cityName}, FL",
            'url' => $canonical,
            'about' => ['@id' => $productData['product_id']]
        ];
        
        // LocalBusiness schema with offers
        $localBusiness = [
            '@type' => 'LocalBusiness',
            'name' => 'Flood Barrier Pros',
            'url' => Config::get('app_url'),
            'telephone' => Config::get('phone'),
            'image' => Config::get('app_url') . '/logo.png',
            'address' => [
                '@type' => 'PostalAddress',
                'addressRegion' => 'FL',
                'addressCountry' => 'US'
            ],
            'areaServed' => [
                ['@type' => 'City', 'name' => $cityName]
            ],
            'hasOfferCatalog' => [
                '@type' => 'OfferCatalog',
                'name' => 'Rubicon Flood Protection Systems',
                'itemListElement' => [[
                    '@type' => 'Offer',
                    'itemOffered' => ['@id' => $productData['product_id']],
                    'priceCurrency' => 'USD',
                    'priceSpecification' => [
                        '@type' => 'PriceSpecification',
                        'price' => $productData['starting_price']
                    ],
                    'availability' => 'https://schema.org/InStock',
                    'areaServed' => ['@type' => 'City', 'name' => $cityName]
                ]]
            ]
        ];
        
        $jsonld = Schema::graph([
            Schema::website(Config::get('app_url')),
            $webPage,
            $localBusiness,
            Schema::breadcrumb([
                ['Home', Config::get('app_url')],
                ['Products', Config::get('app_url') . '/products'],
                [$productName, $productData['product_url']],
                [$cityName, $canonical]
            ])
        ]);
        
        $data = [
            'title' => $title,
            'description' => $description,
            'canonical' => $canonical,
            'city' => $city,
            'cityName' => $cityName,
            'product' => $product,
            'productData' => $productData,
            'jsonld' => $jsonld
        ];
        
        return View::renderPage('location', $data);
    }
    
    private function getProductData($product)
    {
        $products = [
            'modular-flood-barrier' => [
                'name' => 'Modular Flood Barrier System',
                'sku' => 'RFP-MOD-BARRIER',
                'description' => 'Rapid-deploy modular flood barriers made from 6063 T-6 aluminum with EPDM sealing.',
                'starting_price' => '1499',
                'product_id' => Config::get('app_url') . '/products/modular-flood-barrier#product',
                'product_url' => Config::get('app_url') . '/products/modular-flood-barrier',
                'image' => Config::get('app_url') . '/images/MODULAR_BARRIER_MAIN_IMG.jpg'
            ],
            'garage-dam-kit' => [
                'name' => 'Garage Door Flood Dam Kit',
                'sku' => 'RFP-GARAGE-DAM',
                'description' => 'Modular flood barrier kit engineered for residential and commercial garage openings.',
                'starting_price' => '1299',
                'product_id' => Config::get('app_url') . '/products/garage-dam-kit#product',
                'product_url' => Config::get('app_url') . '/products/garage-dam-kit',
                'image' => Config::get('app_url') . '/images/GARAGE_DAM_MAIN_IMG.jpg'
            ],
            'doorway-flood-panel' => [
                'name' => 'Doorway Flood Panel',
                'sku' => 'RFP-DOOR-PANEL',
                'description' => 'Reusable, quick-install flood panel system for doors and entries.',
                'starting_price' => '899',
                'product_id' => Config::get('app_url') . '/products/doorway-flood-panel#product',
                'product_url' => Config::get('app_url') . '/products/doorway-flood-panel',
                'image' => Config::get('app_url') . '/images/DOOR_PANEL_MAIN_IMG.jpg'
            ]
        ];
        
        return $products[$product] ?? null;
    }
    
    private function notFound()
    {
        http_response_code(404);
        echo View::renderPage('404', [
            'title' => 'Page Not Found - ' . Config::get('app_name'),
            'description' => 'The page you are looking for could not be found.'
        ]);
    }
}
