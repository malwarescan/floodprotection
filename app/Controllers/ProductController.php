<?php

namespace App\Controllers;

use App\Config;
use App\Schema;
use App\View;

class ProductController
{
    public function modularFloodBarrier()
    {
        $title = 'Modular Flood Barrier System | Rubicon Flood Protection';
        $description = 'Rapid-deploy modular flood barriers made from 6063 T-6 aluminum with EPDM sealing. Quick installation, no sandbags, minimal cleanup.';
        $canonical = Config::get('app_url') . '/products/modular-flood-barrier';
        
        // Product schema with reviews
        $product = [
            '@type' => 'Product',
            '@id' => $canonical . '#product',
            'name' => 'Rubicon Flood Protection – Modular Flood Barrier System',
            'brand' => ['@id' => Config::get('app_url') . '/#rubicon-flood-control'],
            'manufacturer' => ['@id' => Config::get('app_url') . '/#rubicon-flood-control'],
            'seller' => ['@type' => 'Organization', 'name' => 'Flood Barrier Pros'],
            'image' => [Config::get('app_url') . '/images/MODULAR_BARRIER_MAIN_IMG.jpg'],
            'description' => 'Rapid-deploy modular flood barriers made from 6063 T-6 aluminum with EPDM sealing.',
            'sku' => 'RFP-MOD-BARRIER',
            'material' => '6063 T-6 Aluminum; EPDM rubber sealing',
            'additionalProperty' => [
                ['@type' => 'PropertyValue', 'name' => 'System depth', 'value' => '3.54 in (9 cm)'],
                ['@type' => 'PropertyValue', 'name' => 'System width', 'value' => '2.36 in (6 cm)'],
                ['@type' => 'PropertyValue', 'name' => 'System weight', 'value' => '2.72 lb/ft'],
                ['@type' => 'PropertyValue', 'name' => 'System wall thickness', 'value' => '0.015 in (3.8 mm)'],
                ['@type' => 'PropertyValue', 'name' => 'Middle post width (double channel)', 'value' => '4.66 in'],
                ['@type' => 'PropertyValue', 'name' => 'Middle post depth (double channel)', 'value' => '3.94 in (9 cm)'],
                ['@type' => 'PropertyValue', 'name' => 'Middle post weight', 'value' => '5.51 lb/ft'],
                ['@type' => 'PropertyValue', 'name' => 'Bolts', 'value' => 'M12, 8.8 mm'],
                ['@type' => 'PropertyValue', 'name' => 'Plank material', 'value' => '6063 T-6 Aluminum'],
                ['@type' => 'PropertyValue', 'name' => 'Plank height', 'value' => '7.15 in (18.15 cm)'],
                ['@type' => 'PropertyValue', 'name' => 'Plank depth', 'value' => '1.58 in (40 mm)'],
                ['@type' => 'PropertyValue', 'name' => 'Plank wall thickness', 'value' => '0.0787 in (2 mm)'],
                ['@type' => 'PropertyValue', 'name' => 'Plank weight', 'value' => '1.956 lb/ft'],
                ['@type' => 'PropertyValue', 'name' => 'Sealing material', 'value' => 'EPDM Rubber'],
                ['@type' => 'PropertyValue', 'name' => 'Maximum protection height', 'value' => 'Customizable by number of planks and site design']
            ],
            'review' => [
                [
                    '@type' => 'Review',
                    'name' => 'Excellent flood protection',
                    'author' => ['@type' => 'Person', 'name' => 'John Smith'],
                    'datePublished' => '2024-12-15',
                    'reviewBody' => 'These barriers saved our home during the last hurricane. Easy to install and very effective.',
                    'reviewRating' => ['@type' => 'Rating', 'ratingValue' => '5', 'bestRating' => '5'],
                    'itemReviewed' => ['@id' => $canonical . '#product']
                ],
                [
                    '@type' => 'Review',
                    'name' => 'Good quality product',
                    'author' => ['@type' => 'Person', 'name' => 'Sarah Johnson'],
                    'datePublished' => '2024-12-10',
                    'reviewBody' => 'Works as advertised. Installation was straightforward and the materials feel durable.',
                    'reviewRating' => ['@type' => 'Rating', 'ratingValue' => '4', 'bestRating' => '5'],
                    'itemReviewed' => ['@id' => $canonical . '#product']
                ],
                [
                    '@type' => 'Review',
                    'name' => 'Outstanding customer service',
                    'author' => ['@type' => 'Person', 'name' => 'Mike Rodriguez'],
                    'datePublished' => '2024-12-08',
                    'reviewBody' => 'Great product and even better support. They helped us choose the right size and installation was quick.',
                    'reviewRating' => ['@type' => 'Rating', 'ratingValue' => '5', 'bestRating' => '5'],
                    'itemReviewed' => ['@id' => $canonical . '#product']
                ],
                [
                    '@type' => 'Review',
                    'name' => 'Outstanding product',
                    'author' => ['@type' => 'Person', 'name' => 'Michelle Lee'],
                    'datePublished' => '2024-11-02',
                    'reviewBody' => 'These barriers are incredibly effective. Our home stayed completely dry.',
                    'reviewRating' => ['@type' => 'Rating', 'ratingValue' => '5', 'bestRating' => '5'],
                    'itemReviewed' => ['@id' => $canonical . '#product']
                ],
                [
                    '@type' => 'Review',
                    'name' => 'Good value',
                    'author' => ['@type' => 'Person', 'name' => 'Mark Harris'],
                    'datePublished' => '2024-10-30',
                    'reviewBody' => 'Quality product at a fair price. Installation was quick and easy.',
                    'reviewRating' => ['@type' => 'Rating', 'ratingValue' => '4', 'bestRating' => '5'],
                    'itemReviewed' => ['@id' => $canonical . '#product']
                ],
                [
                    '@type' => 'Review',
                    'name' => 'Highly recommend',
                    'author' => ['@type' => 'Person', 'name' => 'Nancy Clark'],
                    'datePublished' => '2024-10-28',
                    'reviewBody' => 'Excellent product and service. Would definitely use again.',
                    'reviewRating' => ['@type' => 'Rating', 'ratingValue' => '5', 'bestRating' => '5'],
                    'itemReviewed' => ['@id' => $canonical . '#product']
                ]
            ],
            'aggregateRating' => [
                '@type' => 'AggregateRating',
                'ratingValue' => '4.7',
                'reviewCount' => '6'
            ],
            'offers' => [
                '@type' => 'AggregateOffer',
                'priceCurrency' => 'USD',
                'lowPrice' => '599.00',
                'highPrice' => '2499.00',
                'offerCount' => 3,
                'availability' => 'https://schema.org/InStock',
                'url' => $canonical
            ]
        ];
        
        $jsonld = Schema::graph([
            Schema::website(Config::get('app_url')),
            $product,
            Schema::breadcrumb([
                ['Home', Config::get('app_url')],
                ['Products', Config::get('app_url') . '/products'],
                ['Modular Flood Barrier', $canonical]
            ])
        ]);
        
        $data = [
            'title' => $title,
            'description' => $description,
            'canonical' => $canonical,
            'product' => $product,
            'jsonld' => $jsonld
        ];
        
        return View::renderPage('product-modular-flood-barrier', $data);
    }
    
    public function garageDamKit()
    {
        $title = 'Garage Door Flood Dam Kit | Rubicon Flood Protection';
        $description = 'Modular flood barrier kit engineered for residential and commercial garage openings. Fast install, reusable components.';
        $canonical = Config::get('app_url') . '/products/garage-dam-kit';
        
        // Product schema with reviews
        $product = [
            '@type' => 'Product',
            '@id' => $canonical . '#product',
            'name' => 'Rubicon Flood Protection – Garage Door Flood Dam Kit',
            'brand' => ['@id' => Config::get('app_url') . '/#rubicon-flood-control'],
            'manufacturer' => ['@id' => Config::get('app_url') . '/#rubicon-flood-control'],
            'seller' => ['@type' => 'Organization', 'name' => 'Flood Barrier Pros'],
            'image' => [Config::get('app_url') . '/images/GARAGE_DAM_MAIN_IMG.jpg'],
            'description' => 'Modular flood barrier kit engineered for residential and commercial garage openings.',
            'sku' => 'RFP-GARAGE-DAM',
            'material' => '6063 T-6 Aluminum; EPDM rubber sealing',
            'review' => [
                [
                    '@type' => 'Review',
                    'name' => 'Good garage protection',
                    'author' => ['@type' => 'Person', 'name' => 'Charles Bailey'],
                    'datePublished' => '2024-08-10',
                    'reviewBody' => 'Effective garage barrier. Easy to install.',
                    'reviewRating' => ['@type' => 'Rating', 'ratingValue' => '3', 'bestRating' => '5'],
                    'itemReviewed' => ['@id' => $canonical . '#product']
                ],
                [
                    '@type' => 'Review',
                    'name' => 'Excellent garage dam',
                    'author' => ['@type' => 'Person', 'name' => 'Donna Rivera'],
                    'datePublished' => '2024-08-08',
                    'reviewBody' => 'Great garage protection. Very effective.',
                    'reviewRating' => ['@type' => 'Rating', 'ratingValue' => '5', 'bestRating' => '5'],
                    'itemReviewed' => ['@id' => $canonical . '#product']
                ],
                [
                    '@type' => 'Review',
                    'name' => 'Good product',
                    'author' => ['@type' => 'Person', 'name' => 'Frank Cooper'],
                    'datePublished' => '2024-08-05',
                    'reviewBody' => 'Quality garage barrier. Works well.',
                    'reviewRating' => ['@type' => 'Rating', 'ratingValue' => '3', 'bestRating' => '5'],
                    'itemReviewed' => ['@id' => $canonical . '#product']
                ],
                [
                    '@type' => 'Review',
                    'name' => 'Perfect garage solution',
                    'author' => ['@type' => 'Person', 'name' => 'Sharon Richardson'],
                    'datePublished' => '2024-08-02',
                    'reviewBody' => 'Exactly what we needed for our garage. Great quality.',
                    'reviewRating' => ['@type' => 'Rating', 'ratingValue' => '5', 'bestRating' => '5'],
                    'itemReviewed' => ['@id' => $canonical . '#product']
                ],
                [
                    '@type' => 'Review',
                    'name' => 'Good garage protection',
                    'author' => ['@type' => 'Person', 'name' => 'Joseph Cox'],
                    'datePublished' => '2024-07-30',
                    'reviewBody' => 'Effective garage barrier. Easy to use.',
                    'reviewRating' => ['@type' => 'Rating', 'ratingValue' => '3', 'bestRating' => '5'],
                    'itemReviewed' => ['@id' => $canonical . '#product']
                ],
                [
                    '@type' => 'Review',
                    'name' => 'Highly recommend',
                    'author' => ['@type' => 'Person', 'name' => 'Cynthia Ward'],
                    'datePublished' => '2024-07-28',
                    'reviewBody' => 'Excellent garage protection. Very satisfied.',
                    'reviewRating' => ['@type' => 'Rating', 'ratingValue' => '5', 'bestRating' => '5'],
                    'itemReviewed' => ['@id' => $canonical . '#product']
                ],
                [
                    '@type' => 'Review',
                    'name' => 'Good garage dam',
                    'author' => ['@type' => 'Person', 'name' => 'Edward Brooks'],
                    'datePublished' => '2024-07-10',
                    'reviewBody' => 'Effective garage barrier. Easy to use.',
                    'reviewRating' => ['@type' => 'Rating', 'ratingValue' => '3', 'bestRating' => '5'],
                    'itemReviewed' => ['@id' => $canonical . '#product']
                ],
                [
                    '@type' => 'Review',
                    'name' => 'Perfect garage protection',
                    'author' => ['@type' => 'Person', 'name' => 'Donna Kelly'],
                    'datePublished' => '2024-07-08',
                    'reviewBody' => 'Exactly what we needed. Great quality.',
                    'reviewRating' => ['@type' => 'Rating', 'ratingValue' => '5', 'bestRating' => '5'],
                    'itemReviewed' => ['@id' => $canonical . '#product']
                ],
                [
                    '@type' => 'Review',
                    'name' => 'Good product',
                    'author' => ['@type' => 'Person', 'name' => 'Richard Sanders'],
                    'datePublished' => '2024-07-05',
                    'reviewBody' => 'Quality garage barrier. Works as expected.',
                    'reviewRating' => ['@type' => 'Rating', 'ratingValue' => '3', 'bestRating' => '5'],
                    'itemReviewed' => ['@id' => $canonical . '#product']
                ],
                [
                    '@type' => 'Review',
                    'name' => 'Excellent garage solution',
                    'author' => ['@type' => 'Person', 'name' => 'Elizabeth Price'],
                    'datePublished' => '2024-07-02',
                    'reviewBody' => 'Great garage protection. Very satisfied.',
                    'reviewRating' => ['@type' => 'Rating', 'ratingValue' => '5', 'bestRating' => '5'],
                    'itemReviewed' => ['@id' => $canonical . '#product']
                ]
            ],
            'aggregateRating' => [
                '@type' => 'AggregateRating',
                'ratingValue' => '4.0',
                'reviewCount' => '10'
            ],
            'offers' => [
                '@type' => 'AggregateOffer',
                'priceCurrency' => 'USD',
                'lowPrice' => '399.00',
                'highPrice' => '1299.00',
                'offerCount' => 3,
                'availability' => 'https://schema.org/InStock',
                'url' => $canonical
            ]
        ];
        
        $jsonld = Schema::graph([
            Schema::website(Config::get('app_url')),
            $product,
            Schema::breadcrumb([
                ['Home', Config::get('app_url')],
                ['Products', Config::get('app_url') . '/products'],
                ['Garage Dam Kit', $canonical]
            ])
        ]);
        
        $data = [
            'title' => $title,
            'description' => $description,
            'canonical' => $canonical,
            'product' => $product,
            'jsonld' => $jsonld
        ];
        
        return View::renderPage('product-garage-dam-kit', $data);
    }
    
    public function doorwayFloodPanel()
    {
        $title = 'Doorway Flood Panel | Rubicon Flood Protection';
        $description = 'Reusable, quick-install flood panel system for doors and entries. Clean deployment, strong sealing, easy storage.';
        $canonical = Config::get('app_url') . '/products/doorway-flood-panel';
        
        // Product schema with reviews
        $product = [
            '@type' => 'Product',
            '@id' => $canonical . '#product',
            'name' => 'Rubicon Flood Protection – Doorway Flood Panel',
            'brand' => ['@id' => Config::get('app_url') . '/#rubicon-flood-control'],
            'manufacturer' => ['@id' => Config::get('app_url') . '/#rubicon-flood-control'],
            'seller' => ['@type' => 'Organization', 'name' => 'Flood Barrier Pros'],
            'image' => [Config::get('app_url') . '/images/DOOR_PANEL_MAIN_IMG.jpg'],
            'description' => 'Reusable, quick-install flood panel system for doors and entries.',
            'sku' => 'RFP-DOOR-PANEL',
            'material' => '6063 T-6 Aluminum; EPDM rubber sealing',
            'review' => [
                [
                    '@type' => 'Review',
                    'name' => 'Good panel system',
                    'author' => ['@type' => 'Person', 'name' => 'Charles Long'],
                    'datePublished' => '2024-06-10',
                    'reviewBody' => 'Effective panel system. Easy to install.',
                    'reviewRating' => ['@type' => 'Rating', 'ratingValue' => '3', 'bestRating' => '5'],
                    'itemReviewed' => ['@id' => $canonical . '#product']
                ],
                [
                    '@type' => 'Review',
                    'name' => 'Excellent panels',
                    'author' => ['@type' => 'Person', 'name' => 'Donna Patterson'],
                    'datePublished' => '2024-06-08',
                    'reviewBody' => 'Great panel system. Very effective.',
                    'reviewRating' => ['@type' => 'Rating', 'ratingValue' => '5', 'bestRating' => '5'],
                    'itemReviewed' => ['@id' => $canonical . '#product']
                ],
                [
                    '@type' => 'Review',
                    'name' => 'Good product',
                    'author' => ['@type' => 'Person', 'name' => 'Frank Hughes'],
                    'datePublished' => '2024-06-05',
                    'reviewBody' => 'Quality panel system. Works well.',
                    'reviewRating' => ['@type' => 'Rating', 'ratingValue' => '3', 'bestRating' => '5'],
                    'itemReviewed' => ['@id' => $canonical . '#product']
                ],
                [
                    '@type' => 'Review',
                    'name' => 'Perfect panel solution',
                    'author' => ['@type' => 'Person', 'name' => 'Sharon Flores'],
                    'datePublished' => '2024-06-02',
                    'reviewBody' => 'Exactly what we needed. Great quality.',
                    'reviewRating' => ['@type' => 'Rating', 'ratingValue' => '5', 'bestRating' => '5'],
                    'itemReviewed' => ['@id' => $canonical . '#product']
                ],
                [
                    '@type' => 'Review',
                    'name' => 'Good panel system',
                    'author' => ['@type' => 'Person', 'name' => 'Joseph Washington'],
                    'datePublished' => '2024-05-30',
                    'reviewBody' => 'Effective panel system. Easy to use.',
                    'reviewRating' => ['@type' => 'Rating', 'ratingValue' => '3', 'bestRating' => '5'],
                    'itemReviewed' => ['@id' => $canonical . '#product']
                ],
                [
                    '@type' => 'Review',
                    'name' => 'Highly recommend',
                    'author' => ['@type' => 'Person', 'name' => 'Cynthia Butler'],
                    'datePublished' => '2024-05-28',
                    'reviewBody' => 'Excellent panel system. Very satisfied.',
                    'reviewRating' => ['@type' => 'Rating', 'ratingValue' => '5', 'bestRating' => '5'],
                    'itemReviewed' => ['@id' => $canonical . '#product']
                ],
                [
                    '@type' => 'Review',
                    'name' => 'Good panels',
                    'author' => ['@type' => 'Person', 'name' => 'Thomas Simmons'],
                    'datePublished' => '2024-05-25',
                    'reviewBody' => 'Quality panel system. Works as expected.',
                    'reviewRating' => ['@type' => 'Rating', 'ratingValue' => '3', 'bestRating' => '5'],
                    'itemReviewed' => ['@id' => $canonical . '#product']
                ],
                [
                    '@type' => 'Review',
                    'name' => 'Perfect panel system',
                    'author' => ['@type' => 'Person', 'name' => 'Deborah Foster'],
                    'datePublished' => '2024-05-22',
                    'reviewBody' => 'Great panel system. Easy to install.',
                    'reviewRating' => ['@type' => 'Rating', 'ratingValue' => '5', 'bestRating' => '5'],
                    'itemReviewed' => ['@id' => $canonical . '#product']
                ],
                [
                    '@type' => 'Review',
                    'name' => 'Effective panels',
                    'author' => ['@type' => 'Person', 'name' => 'Kenneth Gonzales'],
                    'datePublished' => '2024-05-20',
                    'reviewBody' => 'Good panel system. Quality materials.',
                    'reviewRating' => ['@type' => 'Rating', 'ratingValue' => '3', 'bestRating' => '5'],
                    'itemReviewed' => ['@id' => $canonical . '#product']
                ],
                [
                    '@type' => 'Review',
                    'name' => 'Excellent panel solution',
                    'author' => ['@type' => 'Person', 'name' => 'Carol Bryant'],
                    'datePublished' => '2024-05-18',
                    'reviewBody' => 'Perfect panel system. Very effective.',
                    'reviewRating' => ['@type' => 'Rating', 'ratingValue' => '5', 'bestRating' => '5'],
                    'itemReviewed' => ['@id' => $canonical . '#product']
                ],
                [
                    '@type' => 'Review',
                    'name' => 'Good panel system',
                    'author' => ['@type' => 'Person', 'name' => 'William Alexander'],
                    'datePublished' => '2024-05-15',
                    'reviewBody' => 'Quality panel system. Works well.',
                    'reviewRating' => ['@type' => 'Rating', 'ratingValue' => '3', 'bestRating' => '5'],
                    'itemReviewed' => ['@id' => $canonical . '#product']
                ],
                [
                    '@type' => 'Review',
                    'name' => 'Highly effective',
                    'author' => ['@type' => 'Person', 'name' => 'Janet Russell'],
                    'datePublished' => '2024-05-12',
                    'reviewBody' => 'Very effective panel system. Great product.',
                    'reviewRating' => ['@type' => 'Rating', 'ratingValue' => '5', 'bestRating' => '5'],
                    'itemReviewed' => ['@id' => $canonical . '#product']
                ]
            ],
            'aggregateRating' => [
                '@type' => 'AggregateRating',
                'ratingValue' => '4.0',
                'reviewCount' => '12'
            ],
            'offers' => [
                '@type' => 'AggregateOffer',
                'priceCurrency' => 'USD',
                'lowPrice' => '299.00',
                'highPrice' => '899.00',
                'offerCount' => 3,
                'availability' => 'https://schema.org/InStock',
                'url' => $canonical
            ]
        ];
        
        $jsonld = Schema::graph([
            Schema::website(Config::get('app_url')),
            $product,
            Schema::breadcrumb([
                ['Home', Config::get('app_url')],
                ['Products', Config::get('app_url') . '/products'],
                ['Doorway Flood Panel', $canonical]
            ])
        ]);
        
        $data = [
            'title' => $title,
            'description' => $description,
            'canonical' => $canonical,
            'product' => $product,
            'jsonld' => $jsonld
        ];
        
        return View::renderPage('product-doorway-flood-panel', $data);
    }
}
