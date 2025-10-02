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
        return [
            '@type' => 'BreadcrumbList',
            'itemListElement' => array_map(function($nameUrl, $i) {
                return [
                    '@type' => 'ListItem',
                    'position' => $i + 1,
                    'name' => $nameUrl[0],
                    'item' => $nameUrl[1]
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
        return [
            '@type' => 'Product',
            'name' => $name,
            'brand' => $brand,
            'sku' => $sku,
            'offers' => [
                '@type' => 'AggregateOffer',
                'priceCurrency' => $currency,
                'lowPrice' => floatval($min),
                'highPrice' => floatval($max),
                'availability' => 'https://schema.org/InStock'
            ]
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
            $offers = [
                '@type' => 'AggregateOffer',
                'priceCurrency' => $currency,
                'lowPrice' => $lowPrice,
                'availability' => 'https://schema.org/InStock'
            ];
            
            if ($highPrice) {
                $offers['highPrice'] = $highPrice;
                $offers['offerCount'] = '3'; // Assuming 3 price tiers
            }
            
            $product['offers'] = $offers;
        }
        
        return $product;
    }
    
    public static function canonicalProduct($name, $sku, $description, $image = null, $lowPrice = null, $highPrice = null, $currency = 'USD', $material = null, $aggregateRating = null)
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
        
        if ($lowPrice) {
            $offers = [
                '@type' => 'AggregateOffer',
                'priceCurrency' => $currency,
                'lowPrice' => $lowPrice,
                'availability' => 'https://schema.org/InStock'
            ];
            
            if ($highPrice) {
                $offers['highPrice'] = $highPrice;
                $offers['offerCount'] = '3';
            }
            
            $product['offers'] = $offers;
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
    
    public static function organization($name, $url, $logo = null, $brand = null)
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
        
        return $org;
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
        
        // Create canonical product reference
        $product = self::canonicalProduct(
            $row['product_name'],
            $row['product_sku'],
            'Rapid-deploy modular flood barriers made from 6063 T-6 aluminum with EPDM sealing.',
            null, // image
            $row['product_price_min'],
            $row['product_price_max'],
            $row['product_currency'],
            '6063 T-6 Aluminum; EPDM rubber sealing'
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
