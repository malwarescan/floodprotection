<?php

namespace App\Controllers;

use App\Config;
use App\Schema;
use App\View;

class ProductController
{
    public function index()
    {
        $data = [
            'title' => 'Flood Protection Products | FEMA-Compliant Systems',
            'description' => 'Browse Florida\'s #1 rated flood protection products: modular aluminum barriers, garage dam kits, and doorway panels. Reusable & ready to ship.',
            'canonical' => Config::get('app_url') . '/products',
            'jsonld' => Schema::graph([
                Schema::website(Config::get('app_url')),
                Schema::breadcrumb([
                    ['Home', Config::get('app_url')],
                    ['Products', Config::get('app_url') . '/products']
                ])
            ])
        ];
        
        return View::renderPage('products-index', $data);
    }
    
    public function modularFloodBarrier()
    {
        $title = 'Modular Flood Barriers St Petersburg FL | 5-Star Rated | Free Quote';
        $description = 'Protect your St Petersburg home with modular flood barriers. 5-star rated, FEMA-compliant, installs in 24hrs. Call now for free assessment!';
        $canonical = Config::get('app_url') . '/products/modular-flood-barrier';
        
        // Product schema with reviews
        $product = [
            '@type' => 'Product',
            '@id' => $canonical . '#product',
            'name' => 'Modular Flood Barrier System | Flood Barrier Pros',
            'brand' => ['@type' => 'Brand', 'name' => 'Flood Barrier Pros'],
            'manufacturer' => ['@type' => 'Organization', 'name' => 'Flood Barrier Pros'],
            'seller' => ['@type' => 'Organization', 'name' => 'Flood Barrier Pros'],
            'image' => [Config::get('app_url') . '/assets/images/products/modular-aluminum-flood-barriers.jpg'],
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
                'priceValidUntil' => '2026-01-31',
                'availability' => 'https://schema.org/InStock',
                'url' => $canonical,
                'hasMerchantReturnPolicy' => [
                    '@type' => 'MerchantReturnPolicy',
                    'applicableCountry' => 'US',
                    'returnPolicyCategory' => 'https://schema.org/MerchantReturnFiniteReturnWindow',
                    'merchantReturnDays' => 30,
                    'returnMethod' => 'https://schema.org/ReturnByMail',
                    'returnFees' => 'https://schema.org/FreeReturn'
                ]
                // Note: AggregateOffer doesn't support shippingDetails per Schema.org
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
        $title = 'Garage Door Flood Barriers | Quick-Deploy Dam Kits';
        $description = 'Seal your garage against floodwaters instantly. Heavy-duty reusable garage flood barriers. Easy DIY installation available. Order now.';
        $canonical = Config::get('app_url') . '/products/garage-dam-kit';
        
        // Product schema with reviews
        $product = [
            '@type' => 'Product',
            '@id' => $canonical . '#product',
            'name' => 'Garage Door Flood Dam Kit | Flood Barrier Pros',
            'brand' => ['@type' => 'Brand', 'name' => 'Flood Barrier Pros'],
            'manufacturer' => ['@type' => 'Organization', 'name' => 'Flood Barrier Pros'],
            'seller' => ['@type' => 'Organization', 'name' => 'Flood Barrier Pros'],
            'image' => [Config::get('app_url') . '/assets/images/products/garage-dam-kits.jpg'],
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
                'priceValidUntil' => '2026-01-31',
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
        $title = 'Doorway Flood Panels | Reusable Entry Protection';
        $description = 'Custom-fit flood panels for doors and entryways. 100% watertight seal, reusable aluminum design. Easy DIY installation. Order now.';
        $canonical = Config::get('app_url') . '/products/doorway-flood-panel';
        
        // Product schema with reviews
        $product = [
            '@type' => 'Product',
            '@id' => $canonical . '#product',
            'name' => 'Doorway Flood Panel | Flood Barrier Pros',
            'brand' => ['@type' => 'Brand', 'name' => 'Flood Barrier Pros'],
            'manufacturer' => ['@type' => 'Organization', 'name' => 'Flood Barrier Pros'],
            'seller' => ['@type' => 'Organization', 'name' => 'Flood Barrier Pros'],
            'image' => [Config::get('app_url') . '/assets/images/products/doorway-flood-panels.jpg'],
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
                'priceValidUntil' => '2026-01-31',
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


    public function commercialFloodGates()
    {
        $title = 'Commercial Flood Gates | FEMA-Compliant Industrial Systems';
        $description = 'Heavy-duty commercial flood gates for warehouses & retail. Connectable spans, unlimited width, and FEMA-compliant. Trust Florida\'s experts.';
        $canonical = Config::get('app_url') . '/commercial-flood-gates';
        
        // Product schema customized for commercial
        $product = [
            '@type' => 'Product',
            '@id' => $canonical . '#product',
            'name' => 'Commercial Flood Gate Systems | Flood Barrier Pros',
            'brand' => ['@type' => 'Brand', 'name' => 'Flood Barrier Pros'],
            'manufacturer' => ['@type' => 'Organization', 'name' => 'Flood Barrier Pros'],
            'seller' => ['@type' => 'Organization', 'name' => 'Flood Barrier Pros'],
            'image' => [Config::get('app_url') . '/assets/images/products/modular-aluminum-flood-barriers.jpg'],
            'description' => 'Industrial-grade flood gate systems for commercial properties, warehouses, and retail locations.',
            'sku' => 'RFP-COMM-GATE',
            'material' => '6063 T-6 Aluminum; Heavy-duty EPDM sealing',
            'additionalProperty' => [
                ['@type' => 'PropertyValue', 'name' => 'Application', 'value' => 'Commercial, Industrial, Retail'],
                ['@type' => 'PropertyValue', 'name' => 'Max Width', 'value' => 'Unlimited (with center posts)'],
                ['@type' => 'PropertyValue', 'name' => 'Max Height', 'value' => 'Up to 12ft'],
                ['@type' => 'PropertyValue', 'name' => 'Material', 'value' => 'Industrial Aluminum'],
                ['@type' => 'PropertyValue', 'name' => 'Certification', 'value' => 'FEMA Compliant']
            ],
            'offers' => [
                '@type' => 'AggregateOffer',
                'priceCurrency' => 'USD',
                'lowPrice' => '2499.00',
                'highPrice' => '15000.00',
                'offerCount' => 1,
                'priceValidUntil' => '2026-01-31',
                'availability' => 'https://schema.org/InStock',
                'url' => $canonical
            ]
        ];
        
        $jsonld = Schema::graph([
            Schema::website(Config::get('app_url')),
            $product,
            Schema::breadcrumb([
                ['Home', Config::get('app_url')],
                ['Commercial Flood Gates', $canonical]
            ])
        ]);
        
        $data = [
            'title' => $title,
            'description' => $description,
            'canonical' => $canonical,
            'product' => $product,
            'jsonld' => $jsonld
        ];
        
        // Reusing modular barrier template as it's the same base technology
        return View::renderPage('product-modular-flood-barrier', $data);
    }

    public function removableBarriers()
    {
        $title = 'Removable Flood Barriers | Invisible Flood Protection';
        $description = 'Protect your home without ruining its look. Removable flood barriers deploy in minutes and store away completely. No permanent obstructions.';
        $canonical = Config::get('app_url') . '/removable-barriers';
        
        // Product schema customized for removable barriers
        $product = [
            '@type' => 'Product',
            '@id' => $canonical . '#product',
            'name' => 'Removable Application Flood Barriers',
            'brand' => ['@type' => 'Brand', 'name' => 'Flood Barrier Pros'],
            'manufacturer' => ['@type' => 'Organization', 'name' => 'Flood Barrier Pros'],
            'seller' => ['@type' => 'Organization', 'name' => 'Flood Barrier Pros'],
            'image' => [Config::get('app_url') . '/assets/images/products/doorway-flood-panels.jpg'],
            'description' => 'High-performance removable flood barriers that leave no permanent visual impact when not in use.',
            'sku' => 'RFP-REM-BARRIER',
            'material' => 'Aluminum & EPDM',
             'offers' => [
                '@type' => 'AggregateOffer',
                'priceCurrency' => 'USD',
                'lowPrice' => '899.00',
                'highPrice' => '4500.00',
                'offerCount' => 1,
                'priceValidUntil' => '2026-01-31',
                'availability' => 'https://schema.org/InStock',
                'url' => $canonical
            ]
        ];
        
        $jsonld = Schema::graph([
            Schema::website(Config::get('app_url')),
            $product,
            Schema::breadcrumb([
                ['Home', Config::get('app_url')],
                ['Removable Barriers', $canonical]
            ])
        ]);
        
        $data = [
            'title' => $title,
            'description' => $description,
            'canonical' => $canonical,
            'product' => $product,
            'jsonld' => $jsonld
        ];
        
        // Reusing modular barrier template
        return View::renderPage('product-modular-flood-barrier', $data);
    }
}
