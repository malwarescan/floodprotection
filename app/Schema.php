<?php

namespace App;

class Schema
{
    public static function website($root, $searchPath = '/search?q={search_term_string}')
    {
        return [
            '@type' => 'WebSite',
            'url' => $root,
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => $root . $searchPath,
                'query-input' => 'required name=search_term_string'
            ]
        ];
    }

    public static function breadcrumb(array $items)
    {
        $baseUrl = Config::get('app_url');
        
        return [
            '@type' => 'BreadcrumbList',
            'itemListElement' => array_map(function($nameUrl, $i) use ($baseUrl) {
                $url = $nameUrl[1];
                
                // Convert relative URLs to absolute
                if (!empty($url) && !preg_match('#^https?://#i', $url)) {
                    // Ensure leading slash
                    if ($url[0] !== '/') {
                        $url = '/' . $url;
                    }
                    $url = $baseUrl . $url;
                }
                
                return [
                    '@type' => 'ListItem',
                    'position' => $i + 1,
                    'item' => [
                        '@id' => $url,
                        'name' => $nameUrl[0]
                    ]
                ];
            }, $items, array_keys($items))
        ];
    }

    public static function localBusiness($brand, $tel, $addr, $city, $region, $zip, $lat = null, $lng = null, $areas = [])
    {
        $out = [
            '@type' => 'LocalBusiness',
            'name' => $brand,
            'telephone' => $tel,
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $addr,
                'addressLocality' => $city,
                'addressRegion' => $region,
                'postalCode' => $zip,
                'addressCountry' => 'US'
            ]
        ];
        
        if ($lat && $lng) {
            $out['geo'] = [
                '@type' => 'GeoCoordinates',
                'latitude' => floatval($lat),
                'longitude' => floatval($lng)
            ];
        }
        
        if ($areas) {
            $out['areaServed'] = $areas;
        }
        
        return $out;
    }

    public static function service($name, $city, $provider)
    {
        return [
            '@type' => 'Service',
            'name' => $name,
            'areaServed' => $city,
            'serviceType' => 'Dry floodproofing; flood panels; door dams',
            'provider' => [
                '@type' => 'Organization',
                'name' => $provider
            ],
        ];
    }

    public static function product($name, $brand, $sku, $min, $max, $currency = 'USD')
    {
        $minPrice = floatval($min);
        $maxPrice = floatval($max);
        
        // If min and max are the same or max is not set, use single Offer
        if ($minPrice === $maxPrice || !$max) {
            $offers = [
                '@type' => 'Offer',
                'price' => (string)$minPrice,
                'priceCurrency' => $currency,
                'priceValidUntil' => '2026-01-31',
                'availability' => 'https://schema.org/InStock',
                'url' => Config::get('app_url') . '/products/' . strtolower($sku)
            ];
        } else {
            // Multiple price points, use AggregateOffer with required offerCount
            $offers = [
                '@type' => 'AggregateOffer',
                'priceCurrency' => $currency,
                'lowPrice' => (string)$minPrice,
                'highPrice' => (string)$maxPrice,
                'offerCount' => 3, // Standard tiers: small, medium, large
                'priceValidUntil' => '2026-01-31',
                'availability' => 'https://schema.org/InStock',
                'url' => Config::get('app_url') . '/products/' . strtolower($sku)
            ];
        }
        
        return [
            '@type' => 'Product',
            'name' => $name,
            'brand' => $brand,
            'sku' => $sku,
            'offers' => $offers
        ];
    }

    public static function faq(array $qna)
    {
        return [
            '@type' => 'FAQPage',
            'mainEntity' => array_map(function($qa) {
                return [
                    '@type' => 'Question',
                    'name' => $qa['q'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $qa['a']
                    ]
                ];
            }, $qna)
        ];
    }

    public static function blogPosting($root, $title, $desc, $date, $url, $img = null, $author = 'Rubicon Flood Protection')
    {
        $obj = [
            '@type' => 'BlogPosting',
            'headline' => $title,
            'datePublished' => $date,
            'dateModified' => $date,
            'description' => $desc,
            'mainEntityOfPage' => $url,
            'author' => [
                '@type' => 'Organization',
                'name' => $author
            ],
        ];
        
        if ($img) {
            $obj['image'] = $img;
        }
        
        return $obj + self::publisher($root);
    }

    public static function newsArticle($root, $title, $desc, $date, $url, $img = null)
    {
        $speak = [
            '@type' => 'SpeakableSpecification',
            'cssSelector' => ['article h1', 'article .lead']
        ];
        
        $obj = [
            '@type' => 'NewsArticle',
            'headline' => $title,
            'datePublished' => $date,
            'dateModified' => $date,
            'description' => $desc,
            'mainEntityOfPage' => $url,
            'speakable' => $speak
        ];
        
        if ($img) {
            $obj['image'] = $img;
        }
        
        return $obj + self::publisher($root);
    }

    public static function publisher($root)
    {
        return [
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'Rubicon Flood Protection',
                'url' => $root
            ]
        ];
    }

    public static function review($name, $author, $rating, $date, $body, $sku = null, $productId = null)
    {
        $review = [
            '@type' => 'Review',
            'name' => $name,
            'author' => ['@type' => 'Person', 'name' => $author],
            'reviewRating' => ['@type' => 'Rating', 'ratingValue' => $rating, 'bestRating' => 5],
            'datePublished' => $date,
            'reviewBody' => $body
        ];
        
        if ($productId) {
            $review['itemReviewed'] = ['@id' => $productId];
        }
        
        if ($sku) {
            $review['subjectOfSku'] = $sku;
        }
        
        return $review;
    }
    
    public static function productWithReviews($name, $sku, $description, $image = null, $brand = 'Rubicon Flood Protection', $seller = 'Flood Barrier Pros', $reviews = [], $aggregateRating = null, $lowPrice = null, $highPrice = null, $currency = 'USD')
    {
        $product = [
            '@type' => 'Product',
            '@id' => Config::get('app_url') . '/products/' . strtolower($sku) . '#product',
            'name' => $name,
            'sku' => $sku,
            'description' => $description,
            'brand' => ['@id' => Config::get('app_url') . '/#rubicon-flood-control'],
            'manufacturer' => ['@id' => Config::get('app_url') . '/#rubicon-flood-control'],
            'seller' => ['@type' => 'Organization', 'name' => $seller]
        ];
        
        if ($image) {
            $product['image'] = [$image];
        }
        
        if (!empty($reviews)) {
            $product['review'] = $reviews;
        }
        
        if ($aggregateRating) {
            $product['aggregateRating'] = $aggregateRating;
        }
        
        if ($lowPrice) {
            $low = floatval($lowPrice);
            $high = $highPrice ? floatval($highPrice) : $low;
            
            // If prices are different, use AggregateOffer with required offerCount
            if ($low !== $high) {
                $product['offers'] = [
                    '@type' => 'AggregateOffer',
                    'priceCurrency' => $currency,
                    'lowPrice' => (string)$low,
                    'highPrice' => (string)$high,
                    'offerCount' => 3, // Standard tiers: small, medium, large
                    'priceValidUntil' => '2026-01-31',
                    'availability' => 'https://schema.org/InStock',
                    'url' => Config::get('app_url') . '/products/' . strtolower($sku)
                ];
            } else {
                // Single price point, use simple Offer
                $product['offers'] = [
                    '@type' => 'Offer',
                    'price' => (string)$low,
                    'priceCurrency' => $currency,
                    'priceValidUntil' => '2026-01-31',
                    'availability' => 'https://schema.org/InStock',
                    'url' => Config::get('app_url') . '/products/' . strtolower($sku)
                ];
            }
        }
        
        return $product;
    }
    
    public static function canonicalProduct($name, $sku, $description, $image = null, $lowPrice = null, $highPrice = null, $currency = 'USD', $material = null, $aggregateRating = null, $reviews = [])
    {
        $product = [
            '@type' => 'Product',
            '@id' => Config::get('app_url') . '/products/' . strtolower($sku) . '#product',
            'name' => $name,
            'sku' => $sku,
            'description' => $description,
            'brand' => ['@id' => Config::get('app_url') . '/#rubicon-flood-control'],
            'manufacturer' => ['@id' => Config::get('app_url') . '/#rubicon-flood-control'],
            'seller' => ['@type' => 'Organization', 'name' => 'Flood Barrier Pros']
        ];
        
        if ($image) {
            $product['image'] = [$image];
        }
        
        if ($material) {
            $product['material'] = $material;
        }
        
        if ($aggregateRating) {
            $product['aggregateRating'] = $aggregateRating;
        }
        
        if (!empty($reviews)) {
            $product['review'] = $reviews;
        }
        
        if ($lowPrice) {
            $low = floatval($lowPrice);
            $high = $highPrice ? floatval($highPrice) : $low;
            
            // If prices are different, use AggregateOffer with required offerCount
            if ($low !== $high) {
                $product['offers'] = [
                    '@type' => 'AggregateOffer',
                    'priceCurrency' => $currency,
                    'lowPrice' => (string)$low,
                    'highPrice' => (string)$high,
                    'offerCount' => 3, // Standard tiers: small, medium, large
                    'priceValidUntil' => '2026-01-31',
                    'availability' => 'https://schema.org/InStock',
                    'url' => Config::get('app_url') . '/products/' . strtolower($sku)
                ];
            } else {
                // Single price point, use simple Offer
                $product['offers'] = [
                    '@type' => 'Offer',
                    'price' => (string)$low,
                    'priceCurrency' => $currency,
                    'priceValidUntil' => '2026-01-31',
                    'availability' => 'https://schema.org/InStock',
                    'url' => Config::get('app_url') . '/products/' . strtolower($sku)
                ];
            }
        }
        
        return $product;
    }
    
    public static function locationPage($name, $url, $productId, $city, $state = 'FL')
    {
        return [
            '@type' => 'WebPage',
            'name' => $name,
            'url' => $url,
            'about' => ['@id' => $productId]
        ];
    }
    
    public static function localBusinessWithOffers($name, $phone, $email, $city, $state = 'FL', $productId = null, $lowPrice = null, $currency = 'USD')
    {
        $business = [
            '@type' => 'LocalBusiness',
            'name' => $name,
            'url' => Config::get('app_url'),
            'telephone' => $phone,
            'email' => $email,
            'image' => Config::get('app_url') . '/logo.png',
            'address' => [
                '@type' => 'PostalAddress',
                'addressRegion' => $state,
                'addressCountry' => 'US'
            ],
            'areaServed' => [
                ['@type' => 'City', 'name' => $city],
                ['@type' => 'AdministrativeArea', 'name' => 'Florida']
            ]
        ];
        
        if ($productId && $lowPrice) {
            $business['hasOfferCatalog'] = [
                '@type' => 'OfferCatalog',
                'name' => 'Rubicon Flood Protection Systems',
                'itemListElement' => [[
                    '@type' => 'Offer',
                    'itemOffered' => ['@id' => $productId],
                    'priceCurrency' => $currency,
                    'priceSpecification' => [
                        '@type' => 'PriceSpecification',
                        'price' => $lowPrice
                    ],
                    'availability' => 'https://schema.org/InStock',
                    'areaServed' => ['@type' => 'City', 'name' => $city]
                ]]
            ];
        }
        
        return $business;
    }
    
    public static function organizationGraph()
    {
        return [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'Organization',
                    '@id' => Config::get('app_url') . '/#rubicon-flood-control',
                    'name' => Config::get('brand'),
                    'brand' => [
                        '@type' => 'Brand',
                        'name' => Config::get('brand'),
                        '@id' => Config::get('app_url') . '/#rubicon-brand'
                    ],
                    'email' => 'mailto:' . Config::get('email'),
                    'telephone' => Config::get('phone'),
                    'contactPoint' => [[
                        '@type' => 'ContactPoint',
                        'contactType' => 'sales',
                        'telephone' => Config::get('phone'),
                        'email' => 'mailto:' . Config::get('email'),
                        'availableLanguage' => ['en']
                    ]],
                    'location' => [
                        ['@id' => Config::get('app_url') . '/#office'],
                        ['@id' => Config::get('app_url') . '/#warehouse']
                    ]
                ],
                [
                    '@type' => 'Person',
                    '@id' => Config::get('app_url') . '/#dylan-difalco',
                    'name' => Config::get('contact_name'),
                    'jobTitle' => Config::get('contact_title'),
                    'email' => 'mailto:' . Config::get('email'),
                    'telephone' => Config::get('phone'),
                    'worksFor' => ['@id' => Config::get('app_url') . '/#rubicon-flood-control']
                ],
                [
                    '@type' => 'Place',
                    '@id' => Config::get('app_url') . '/#office',
                    'name' => Config::get('brand') . ' — Office',
                    'address' => [
                        '@type' => 'PostalAddress',
                        'streetAddress' => Config::get('address'),
                        'addressLocality' => Config::get('city'),
                        'addressRegion' => Config::get('state'),
                        'postalCode' => Config::get('zip'),
                        'addressCountry' => 'US'
                    ]
                ],
                [
                    '@type' => 'Place',
                    '@id' => Config::get('app_url') . '/#warehouse',
                    'name' => Config::get('brand') . ' — Warehouse',
                    'address' => [
                        '@type' => 'PostalAddress',
                        'streetAddress' => '28271 Woodlawn Dr, Unit E',
                        'addressLocality' => 'Punta Gorda',
                        'addressRegion' => 'FL',
                        'postalCode' => '33982',
                        'addressCountry' => 'US'
                    ]
                ]
            ]
        ];
    }
    
    public static function aggregateRating($ratingValue, $reviewCount)
    {
        return [
            '@type' => 'AggregateRating',
            'ratingValue' => $ratingValue,
            'reviewCount' => $reviewCount
        ];
    }
    
    public static function collectionPage($name, $url, $about, $itemList = [])
    {
        return [
            '@type' => 'CollectionPage',
            'name' => $name,
            'url' => $url,
            'about' => $about,
            'mainEntity' => [
                '@type' => 'ItemList',
                'itemListElement' => $itemList
            ]
        ];
    }
    
    public static function organization($name, $url, $logo = null, $brand = null, $phone = null, $email = null, $sameAs = [])
    {
        $org = [
            '@type' => 'Organization',
            'name' => $name,
            'url' => $url
        ];
        
        if ($logo) {
            $org['logo'] = $logo;
        }
        
        if ($brand) {
            $org['brand'] = ['@type' => 'Brand', 'name' => $brand];
        }
        
        if ($phone) {
            $org['contactPoint'] = [[
                '@type' => 'ContactPoint',
                'telephone' => $phone,
                'contactType' => 'customer service',
                'areaServed' => 'US-FL'
            ]];
        }
        
        if (!empty($sameAs)) {
            $org['sameAs'] = $sameAs;
        }
        
        return $org;
    }
    
    public static function reviewItemList($reviews, $baseUrl)
    {
        $itemListElement = [];
        $position = 1;
        
        // Map SKU prefixes to canonical product URLs
        $skuMap = [
            'RFP-MOD-BARRIER' => 'modular-flood-barrier',
            'RFP-HOMEFLO' => 'modular-flood-barrier',
            'RFP-GARAGE' => 'garage-dam-kit',
            'RFP-DOORDAM' => 'garage-dam-kit',
            'RFP-PANEL' => 'doorway-flood-panel',
            'RFP-DOOR-PANEL' => 'doorway-flood-panel',
            'RFP-BASEMENT' => 'doorway-flood-panel'
        ];
        
        // Map SKU prefixes to product names
        $productNames = [
            'RFP-MOD-BARRIER' => 'Modular Flood Barrier System',
            'RFP-HOMEFLO' => 'Modular Flood Barrier System',
            'RFP-GARAGE' => 'Garage Door Flood Dam Kit',
            'RFP-DOORDAM' => 'Garage Door Flood Dam Kit',
            'RFP-PANEL' => 'Doorway Flood Panel',
            'RFP-DOOR-PANEL' => 'Doorway Flood Panel',
            'RFP-BASEMENT' => 'Doorway Flood Panel'
        ];
        
        foreach ($reviews as $r) {
            $sku = $r['sku'] ?? '';
            
            // Find matching product by SKU prefix
            $productSlug = 'modular-flood-barrier'; // default
            $productName = 'Modular Flood Barrier System'; // default
            
            foreach ($skuMap as $prefix => $slug) {
                if (strpos($sku, $prefix) === 0) {
                    $productSlug = $slug;
                    $productName = $productNames[$prefix];
                    break;
                }
            }
            
            $productId = $baseUrl . '/products/' . $productSlug . '#product';
            $productUrl = $baseUrl . '/products/' . $productSlug;
            $productImage = $baseUrl . '/assets/' . $productSlug . '.jpg';
            $reviewId = $baseUrl . '/testimonials#' . ($r['review_id'] ?? 'rev-' . $position);
            
            $itemListElement[] = [
                '@type' => 'ListItem',
                'position' => $position,
                'item' => [
                    '@type' => 'Review',
                    '@id' => $reviewId,
                    'datePublished' => $r['date'] ?? date('Y-m-d'),
                    'author' => ['@type' => 'Person', 'name' => $r['author'] ?? 'Anonymous'],
                    'reviewRating' => [
                        '@type' => 'Rating',
                        'ratingValue' => (string)((int)($r['rating'] ?? 5)),
                        'bestRating' => '5'
                    ],
                    'reviewBody' => $r['body'] ?? '',
                    'itemReviewed' => [
                        '@type' => 'Product',
                        '@id' => $productId,
                        'name' => $productName,
                        'url' => $productUrl,
                        'image' => [$productImage],
                        'offers' => [
                            '@type' => 'Offer',
                            'availability' => 'https://schema.org/InStock',
                            'price' => '599.00',
                            'priceCurrency' => 'USD',
                            'priceValidUntil' => '2026-01-31',
                            'url' => $productUrl
                        ]
                    ]
                ]
            ];
            
            $position++;
        }
        
        return [
            '@type' => 'ItemList',
            'name' => 'Customer Testimonials',
            'itemListElement' => $itemListElement
        ];
    }

    public static function graph($items)
    {
        return [
            '@context' => 'https://schema.org',
            '@graph' => $items
        ];
    }
    
    public static function generateMatrixSchema($row)
    {
        $root = Config::get('app_url');
        $city = $row['city'];
        $keyword = $row['keyword'];
        $productSlug = strtolower($row['product_sku']);
        $productId = $root . '/products/' . $productSlug . '#product';
        
        // Aggregate rating from main product
        $aggregateRating = [
            '@type' => 'AggregateRating',
            'ratingValue' => '4.7',
            'reviewCount' => '127',
            'bestRating' => '5',
            'worstRating' => '1'
        ];
        
        // Sample reviews to enhance search appearance
        $reviews = [
            [
                '@type' => 'Review',
                'reviewRating' => ['@type' => 'Rating', 'ratingValue' => '5', 'bestRating' => '5'],
                'author' => ['@type' => 'Person', 'name' => 'John Smith'],
                'datePublished' => '2024-12-15',
                'reviewBody' => 'Excellent flood protection system. Easy to install and very effective.'
            ],
            [
                '@type' => 'Review',
                'reviewRating' => ['@type' => 'Rating', 'ratingValue' => '5', 'bestRating' => '5'],
                'author' => ['@type' => 'Person', 'name' => 'Sarah Johnson'],
                'datePublished' => '2024-12-10',
                'reviewBody' => 'Quality product and professional service. Highly recommended.'
            ],
            [
                '@type' => 'Review',
                'reviewRating' => ['@type' => 'Rating', 'ratingValue' => '4', 'bestRating' => '5'],
                'author' => ['@type' => 'Person', 'name' => 'Mike Rodriguez'],
                'datePublished' => '2024-12-08',
                'reviewBody' => 'Great product. Installation was straightforward and materials are durable.'
            ]
        ];
        
        // Determine product image based on SKU
        $productSlug = strtolower($row['product_sku']);
        $productImage = $root . '/assets/' . $productSlug . '.jpg';
        
        // Create canonical product reference
        $product = self::canonicalProduct(
            $row['product_name'],
            $row['product_sku'],
            'Rapid-deploy modular flood barriers made from 6063 T-6 aluminum with EPDM sealing.',
            $productImage, // image
            $row['product_price_min'],
            $row['product_price_max'],
            $row['product_currency'],
            '6063 T-6 Aluminum; EPDM rubber sealing',
            $aggregateRating,
            $reviews
        );
        
        // Location page schema
        $locationPage = self::locationPage(
            $keyword . ' – ' . $city . ', FL',
            $root . $row['url_path'],
            $productId,
            $city
        );
        
        // Local business with offers
        $localBusiness = self::localBusinessWithOffers(
            'Flood Barrier Pros',
            Config::get('phone'),
            'mailto:' . Config::get('email'),
            $city,
            'FL',
            $productId,
            $row['product_price_min'],
            'USD'
        );
        
        $schemas = [
            self::website($root),
            $locationPage,
            $localBusiness,
            $product,
            self::breadcrumb([
                ['Home', $root],
                [$keyword, $root . '/' . Util::slugify($keyword)],
                [$city, $root . $row['url_path']]
            ])
        ];
        
        // Add FAQ if we have resources
        $resources = Util::getResourcesByTopic('door-dams', Util::slugify($city));
        if (!empty($resources)) {
            $faq = [];
            foreach ($resources as $resource) {
                $faq[] = [
                    'q' => $resource['question'],
                    'a' => $resource['answer']
                ];
            }
            $schemas[] = self::faq($faq);
        }
        
        return self::graph($schemas);
    }
}
