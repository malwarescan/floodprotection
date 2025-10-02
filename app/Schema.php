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
        $brand = Config::get('brand');
        $phone = Config::get('phone');
        $address = Config::get('address');
        $zip = Config::get('zip');
        
        $city = $row['city'];
        $county = $row['county'];
        $keyword = $row['keyword'];
        $lat = $row['lat'] ?: null;
        $lng = $row['lng'] ?: null;
        
        $areas = [
            ['@type' => 'City', 'name' => $city],
            ['@type' => 'AdministrativeArea', 'name' => $county]
        ];
        
        $schemas = [
            self::website($root),
            self::localBusiness($brand, $phone, $address, $city, 'FL', $zip, $lat, $lng, $areas),
            self::service($keyword, $city, $brand),
            self::product($row['product_name'], $row['product_brand'], $row['product_sku'], 
                         $row['product_price_min'], $row['product_price_max'], $row['product_currency']),
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
