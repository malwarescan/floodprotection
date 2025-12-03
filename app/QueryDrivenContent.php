<?php

namespace App;

/**
 * Query-Driven Content Generator
 * 
 * Uses actual GSC query data to generate content that matches
 * real user search behavior. All headings, anchors, and content
 * align with Queries.csv patterns.
 */
class QueryDrivenContent
{
    /**
     * Query patterns extracted from GSC data
     * These are the actual search queries users are using
     */
    private static $queryPatterns = [
        'flood panels' => [
            'intent' => 'transactional',
            'headings' => [
                '{{CITY}} Flood Panels & Flood Barriers',
                'Aluminum Flood Panel Installation in {{CITY}}',
                'Hurricane-Rated Flood Panels for {{CITY}} Homes'
            ],
            'anchors' => [
                'flood panels {{CITY}}',
                '{{CITY}} flood panels',
                'aluminum flood panels {{CITY}}'
            ],
            'alt_pattern' => '{{PRODUCT}} {{CITY}} flood protection | {{PRODUCT TYPE}} panels / barriers'
        ],
        'flood barriers' => [
            'intent' => 'commercial',
            'headings' => [
                '{{CITY}} Flood Barriers & Storm Surge Protection',
                'Commercial Flood Barriers in {{CITY}}',
                'Hurricane Flood Barriers for {{CITY}} Businesses'
            ],
            'anchors' => [
                'flood barriers {{CITY}}',
                '{{CITY}} flood barriers',
                'commercial flood barriers {{CITY}}'
            ],
            'alt_pattern' => 'flood barriers {{CITY}} | storm surge protection'
        ],
        'garage flood barriers' => [
            'intent' => 'transactional',
            'headings' => [
                'Garage Flood Barriers Installation in {{CITY}}',
                'Garage Door Flood Protection {{CITY}}',
                'Residential Garage Flood Barriers {{CITY}}'
            ],
            'anchors' => [
                'garage flood barriers {{CITY}}',
                'garage flood protection {{CITY}}',
                '{{CITY}} garage flood barriers'
            ],
            'alt_pattern' => 'garage flood barriers {{CITY}} | storm surge protection shield'
        ],
        'flood protection' => [
            'intent' => 'commercial',
            'headings' => [
                '{{CITY}} Flood Protection Systems',
                'Commercial Flood Protection Systems for {{CITY}} Businesses',
                'Storm Surge Protection in {{CITY}}'
            ],
            'anchors' => [
                '{{CITY}} flood protection',
                'flood protection {{CITY}}',
                'storm surge protection {{CITY}}'
            ],
            'alt_pattern' => 'flood protection {{CITY}} | hurricane protection systems'
        ],
        'aluminum flood plank barriers' => [
            'intent' => 'transactional',
            'headings' => [
                'Aluminum Flood Plank Barriers in {{CITY}}',
                'Aluminum Flood Panel Installation {{CITY}}',
                'Hurricane-Rated Aluminum Barriers {{CITY}}'
            ],
            'anchors' => [
                'aluminum flood panel installation',
                'aluminum flood barriers {{CITY}}',
                'aluminum panels {{CITY}}'
            ],
            'alt_pattern' => 'aluminum flood panels {{CITY}} | hurricane panel barriers'
        ]
    ];
    
    /**
     * Cities mentioned in Queries.csv that need pages
     */
    private static $queryCities = [
        'miami', 'sarasota', 'hillsborough', 'fort-myers', 'estero',
        'jensen-beach', 'marco-island', 'naples', 'cape-coral', 'pines',
        'bonita-springs', 'sanibel', 'pine-island', 'clearwater', 'tampa',
        'st-petersburg', 'orlando', 'jacksonville'
    ];
    
    /**
     * Generate H1 based on query patterns
     */
    public static function getH1($city, $keyword = 'flood barriers')
    {
        $cityName = ucwords(str_replace('-', ' ', $city));
        $pattern = self::getQueryPattern($keyword);
        
        if ($pattern && !empty($pattern['headings'])) {
            $heading = $pattern['headings'][0];
            return str_replace('{{CITY}}', $cityName, $heading);
        }
        
        // Fallback to query-matched format
        if (strpos($keyword, 'panels') !== false) {
            return "{$cityName} Flood Panels & Flood Barriers";
        } elseif (strpos($keyword, 'garage') !== false) {
            return "Garage Flood Barriers Installation in {$cityName}";
        } elseif (strpos($keyword, 'commercial') !== false || strpos($keyword, 'protection') !== false) {
            return "Commercial Flood Protection Systems for {$cityName} Businesses";
        }
        
        return "{$cityName} Flood Panels & Hurricane Barriers";
    }
    
    /**
     * Generate H2 headings based on query patterns
     */
    public static function getH2s($city, $keyword = 'flood barriers')
    {
        $cityName = ucwords(str_replace('-', ' ', $city));
        $pattern = self::getQueryPattern($keyword);
        
        $h2s = [];
        
        // Always include these core sections
        $h2s[] = "Why Flood Barriers Are Critical in {$cityName}, SWFL";
        
        // Query-matched product section
        if (strpos($keyword, 'panels') !== false) {
            $h2s[] = "Aluminum Flood Panels for {$cityName} Homes & Businesses";
        } elseif (strpos($keyword, 'garage') !== false) {
            $h2s[] = "Garage Flood Barriers Installation in {$cityName}";
        } elseif (strpos($keyword, 'commercial') !== false) {
            $h2s[] = "Commercial Flood Protection Systems for {$cityName} Businesses";
        } else {
            $h2s[] = "Best Flood Barriers for SWFL Homes & Businesses";
        }
        
        $h2s[] = "Installation & Permitting in {$cityName}";
        $h2s[] = "Pricing Guide for Flood Barriers in {$cityName}";
        $h2s[] = "Case Studies in {$cityName}";
        $h2s[] = "Maintenance & Storm Preparation Checklist";
        
        return $h2s;
    }
    
    /**
     * Generate query-matched anchor text
     */
    public static function getAnchorText($city, $type = 'default')
    {
        $cityName = strtolower(str_replace(' ', '-', $city));
        $cityDisplay = ucwords(str_replace('-', ' ', $city));
        
        $anchors = [
            'default' => "flood panels {$cityDisplay}",
            'panels' => "flood panels {$cityDisplay}",
            'barriers' => "flood barriers {$cityDisplay}",
            'garage' => "garage flood barriers {$cityDisplay}",
            'commercial' => "commercial flood protection systems {$cityDisplay}",
            'protection' => "{$cityDisplay} flood protection",
            'installation' => "flood barrier installation {$cityDisplay}",
            'pricing' => "flood barrier pricing {$cityDisplay}"
        ];
        
        return $anchors[$type] ?? $anchors['default'];
    }
    
    /**
     * Generate alt tag following query pattern
     */
    public static function getAltTag($product, $city, $productType = 'panels')
    {
        $cityName = ucwords(str_replace('-', ' ', $city));
        $productName = ucwords(str_replace('-', ' ', $product));
        
        // Match query language in alt tags
        if (strpos($product, 'panel') !== false) {
            return "{$productName} {$cityName} flood protection | aluminum hurricane panel barriers";
        } elseif (strpos($product, 'garage') !== false) {
            return "Garage flood barriers {$cityName} | storm surge protection shield";
        } elseif (strpos($product, 'barrier') !== false) {
            return "Flood barriers {$cityName} | storm surge protection systems";
        }
        
        return "{$productName} {$cityName} flood protection | {$productType} panels / barriers";
    }
    
    /**
     * Generate meta title matching query language
     */
    public static function getMetaTitle($city, $keyword = 'flood barriers')
    {
        $cityName = ucwords(str_replace('-', ' ', $city));
        
        if (strpos($keyword, 'panels') !== false) {
            return "Flood Panels & Barriers in {$cityName} | Storm Surge & Hurricane Protection";
        } elseif (strpos($keyword, 'garage') !== false) {
            return "Garage Flood Barriers in {$cityName} | Hurricane Protection Systems";
        } elseif (strpos($keyword, 'commercial') !== false || strpos($keyword, 'protection') !== false) {
            return "Commercial Flood Protection in {$cityName} | FEMA-Compliant Systems";
        }
        
        return "Flood Panels & Barriers in {$cityName} | Storm Surge & Hurricane Protection";
    }
    
    /**
     * Generate meta description matching query intent
     */
    public static function getMetaDescription($city, $keyword = 'flood barriers')
    {
        $cityName = ucwords(str_replace('-', ' ', $city));
        
        if (strpos($keyword, 'panels') !== false) {
            return "{$cityName} flood panels, garage flood barriers, and hurricane-rated protection. FEMA-compliant installation. Local pricing available. Free assessment.";
        } elseif (strpos($keyword, 'garage') !== false) {
            return "Garage flood barriers installation in {$cityName}. Storm surge protection, FEMA-compliant systems. Quick deployment, professional installation.";
        } elseif (strpos($keyword, 'commercial') !== false) {
            return "Commercial flood protection systems for {$cityName} businesses. Hurricane-rated barriers, FEMA compliance, rapid deployment. Free quote.";
        }
        
        return "{$cityName} flood panels, garage flood barriers, and hurricane-rated protection. FEMA-compliant installation. Local pricing available.";
    }
    
    /**
     * Get internal link targets based on query patterns
     */
    public static function getInternalLinkTargets($city, $keyword)
    {
        $cityName = strtolower(str_replace(' ', '-', $city));
        
        return [
            'upward' => [
                ['url' => '/products', 'anchor' => 'Flood Barrier Products', 'type' => 'hub'],
                ['url' => '/products/modular-flood-barrier', 'anchor' => 'Modular Flood Barriers', 'type' => 'product'],
                ['url' => '/products/garage-dam-kit', 'anchor' => 'Garage Flood Barriers', 'type' => 'product'],
                ['url' => '/products/doorway-flood-panel', 'anchor' => 'Flood Panels', 'type' => 'product']
            ],
            'sideways' => [
                ['url' => "/home-flood-barriers/{$cityName}", 'anchor' => self::getAnchorText($city, 'barriers'), 'type' => 'city'],
                ['url' => "/fl/{$cityName}/modular-flood-barrier", 'anchor' => self::getAnchorText($city, 'panels'), 'type' => 'location']
            ],
            'downward' => [
                ['url' => '/testimonials', 'anchor' => 'Case Studies', 'type' => 'testimonials'],
                ['url' => '/blog', 'anchor' => 'Flood Protection Guide', 'type' => 'blog']
            ]
        ];
    }
    
    /**
     * Get query pattern for keyword
     */
    private static function getQueryPattern($keyword)
    {
        $keyword = strtolower($keyword);
        
        foreach (self::$queryPatterns as $pattern => $data) {
            if (strpos($keyword, $pattern) !== false) {
                return $data;
            }
        }
        
        return null;
    }
    
    /**
     * Check if city is in query list
     */
    public static function isQueryCity($city)
    {
        $citySlug = strtolower(str_replace(' ', '-', $city));
        return in_array($citySlug, self::$queryCities);
    }
    
    /**
     * Get all query cities
     */
    public static function getQueryCities()
    {
        return self::$queryCities;
    }
    
    /**
     * Generate forbidden anchor text list
     */
    public static function getForbiddenAnchors()
    {
        return [
            'learn more',
            'click here',
            'our service',
            'details',
            'read more',
            'here',
            'this page',
            'more info'
        ];
    }
    
    /**
     * Validate anchor text against query patterns
     */
    public static function validateAnchorText($anchor, $city, $keyword)
    {
        $forbidden = self::getForbiddenAnchors();
        
        // Check if anchor contains forbidden phrases
        foreach ($forbidden as $forbiddenText) {
            if (stripos($anchor, $forbiddenText) !== false) {
                return false;
            }
        }
        
        // Check if anchor matches query pattern
        $pattern = self::getQueryPattern($keyword);
        if ($pattern) {
            $cityName = ucwords(str_replace('-', ' ', $city));
            foreach ($pattern['anchors'] as $validAnchor) {
                $validAnchor = str_replace('{{CITY}}', $cityName, $validAnchor);
                if (stripos($anchor, $validAnchor) !== false) {
                    return true;
                }
            }
        }
        
        // Check if anchor contains city and product keywords
        $cityName = strtolower(str_replace('-', ' ', $city));
        $keywordLower = strtolower($keyword);
        
        return stripos($anchor, $cityName) !== false && 
               (stripos($anchor, 'flood') !== false || stripos($anchor, $keywordLower) !== false);
    }
}

