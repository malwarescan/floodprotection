<?php

namespace App;

use App\Config;

class NewsArticleGenerator
{
    private static $localLandmarks = [
        'fort-myers' => 'Caloosahatchee River',
        'cape-coral' => 'Cape Coral Canal System',
        'naples' => 'Naples Bay',
        'bonita-springs' => 'Estero Bay',
        'estero' => 'Estero Bay',
        'sanibel' => 'Sanibel Causeway',
        'pine-island' => 'Pine Island Sound',
        'marco-island' => 'Marco Island Beach',
        'sarasota' => 'Sarasota Bay',
        'tampa' => 'Tampa Bay',
        'st-petersburg' => 'Tampa Bay',
        'clearwater' => 'Clearwater Beach',
        'bradenton' => 'Manatee River',
        'venice' => 'Venice Beach',
        'port-charlotte' => 'Charlotte Harbor',
        'punta-gorda' => 'Charlotte Harbor',
        'miami' => 'Biscayne Bay',
        'miami-beach' => 'South Beach',
        'key-west' => 'Key West Harbor',
        'key-largo' => 'Florida Bay'
    ];
    
    private static $recentStorms = [
        'fort-myers' => 'Hurricane Ian (2022)',
        'cape-coral' => 'Hurricane Ian (2022)',
        'naples' => 'Hurricane Ian (2022)',
        'bonita-springs' => 'Hurricane Ian (2022)',
        'estero' => 'Hurricane Ian (2022)',
        'sanibel' => 'Hurricane Ian (2022)',
        'pine-island' => 'Hurricane Ian (2022)',
        'marco-island' => 'Hurricane Ian (2022)',
        'sarasota' => 'Hurricane Irma (2017)',
        'tampa' => 'Hurricane Irma (2017)',
        'st-petersburg' => 'Hurricane Irma (2017)',
        'clearwater' => 'Hurricane Irma (2017)',
        'bradenton' => 'Hurricane Irma (2017)',
        'venice' => 'Hurricane Irma (2017)',
        'port-charlotte' => 'Hurricane Charley (2004)',
        'punta-gorda' => 'Hurricane Charley (2004)',
        'miami' => 'Hurricane Irma (2017)',
        'miami-beach' => 'Hurricane Irma (2017)',
        'key-west' => 'Hurricane Irma (2017)',
        'key-largo' => 'Hurricane Irma (2017)'
    ];
    
    private static $localInstallers = [
        'fort-myers' => 'Flood Barrier Pros, Zip Flood Control, DriTech, All In One Service',
        'cape-coral' => 'Flood Barrier Pros, Water Gate Systems, Viking, Roman Roofing',
        'naples' => 'Flood Barrier Pros, Zip Flood Control, DriTech',
        'bonita-springs' => 'Flood Barrier Pros, All In One Service, Water Gate Systems',
        'estero' => 'Flood Barrier Pros, Zip Flood Control, DriTech',
        'sanibel' => 'Flood Barrier Pros, Water Gate Systems',
        'pine-island' => 'Flood Barrier Pros, All In One Service',
        'marco-island' => 'Flood Barrier Pros, Zip Flood Control',
        'sarasota' => 'Flood Barrier Pros, DriTech, Water Gate Systems, Viking',
        'tampa' => 'Flood Barrier Pros, Zip Flood Control, DriTech, Roman Roofing',
        'st-petersburg' => 'Flood Barrier Pros, Water Gate Systems, Viking',
        'clearwater' => 'Flood Barrier Pros, DriTech, All In One Service',
        'bradenton' => 'Flood Barrier Pros, Zip Flood Control, Water Gate Systems',
        'venice' => 'Flood Barrier Pros, DriTech, Viking',
        'port-charlotte' => 'Flood Barrier Pros, All In One Service, Water Gate Systems',
        'punta-gorda' => 'Flood Barrier Pros, Zip Flood Control, DriTech',
        'miami' => 'Flood Barrier Pros, Zip Flood Control, DriTech, Water Gate Systems',
        'miami-beach' => 'Flood Barrier Pros, Zip Flood Control, DriTech',
        'key-west' => 'Flood Barrier Pros, Water Gate Systems',
        'key-largo' => 'Flood Barrier Pros, Zip Flood Control, DriTech'
    ];
    
    private static $averageInsurance = [
        'fort-myers' => '1,200',
        'cape-coral' => '1,150',
        'naples' => '1,400',
        'bonita-springs' => '1,300',
        'estero' => '1,200',
        'sanibel' => '1,800',
        'pine-island' => '1,500',
        'marco-island' => '1,600',
        'sarasota' => '1,100',
        'tampa' => '1,000',
        'st-petersburg' => '1,050',
        'clearwater' => '1,100',
        'bradenton' => '1,050',
        'venice' => '1,200',
        'port-charlotte' => '1,100',
        'punta-gorda' => '1,150',
        'miami' => '1,300',
        'miami-beach' => '1,500',
        'key-west' => '1,700',
        'key-largo' => '1,400'
    ];
    
    private static $counties = [
        'fort-myers' => 'Lee County',
        'cape-coral' => 'Lee County',
        'naples' => 'Collier County',
        'bonita-springs' => 'Lee County',
        'estero' => 'Lee County',
        'sanibel' => 'Lee County',
        'pine-island' => 'Lee County',
        'marco-island' => 'Collier County',
        'sarasota' => 'Sarasota County',
        'tampa' => 'Hillsborough County',
        'st-petersburg' => 'Pinellas County',
        'clearwater' => 'Pinellas County',
        'bradenton' => 'Manatee County',
        'venice' => 'Sarasota County',
        'port-charlotte' => 'Charlotte County',
        'punta-gorda' => 'Charlotte County',
        'miami' => 'Miami-Dade County',
        'miami-beach' => 'Miami-Dade County',
        'key-west' => 'Monroe County',
        'key-largo' => 'Monroe County'
    ];
    
    public static function generateArticle($citySlug)
    {
        $city = ucwords(str_replace('-', ' ', $citySlug));
        $cityDisplay = $city;
        $county = self::$counties[$citySlug] ?? 'Southwest Florida';
        $landmark = self::$localLandmarks[$citySlug] ?? 'local waterways';
        $recentStorm = self::$recentStorms[$citySlug] ?? 'recent hurricanes';
        $installers = self::$localInstallers[$citySlug] ?? 'Flood Barrier Pros, Zip Flood Control, DriTech';
        $insurance = self::$averageInsurance[$citySlug] ?? '1,200';
        
        $currentDate = date('F Y');
        $today = date('Y-m-d');
        
        // Generate title
        $title = "New Data Warns {$cityDisplay} Homeowners: Sandbags Fail in 50% of Flood Events — Engineered Flood Panels Now Recommended Across Southwest Florida";
        
        // Generate subtitle
        $subtitle = "A new technical report shows why traditional sandbags underperform during storm surge, wave impact, and flash flooding—prompting emergency managers and insurers across {$cityDisplay} to push residents toward aluminum flood panel systems.";
        
        // Generate content sections
        $content = self::generateContent($cityDisplay, $county, $landmark, $recentStorm, $installers, $insurance, $currentDate);
        
        // Get random news image for this article (consistent per city)
        $imageUrl = self::getRandomNewsImage(Config::get('app_url'), $citySlug);
        
        // Generate schema (will use the random image)
        $schema = self::generateSchema($cityDisplay, $citySlug, $title, $today);
        
        // Generate internal links
        $internalLinks = self::generateInternalLinks($citySlug, $cityDisplay);
        
        return [
            'title' => $title,
            'subtitle' => $subtitle,
            'content' => $content,
            'schema' => $schema,
            'internal_links' => $internalLinks,
            'city' => $cityDisplay,
            'city_slug' => $citySlug,
            'county' => $county,
            'date' => $today,
            'dateline' => "{$cityDisplay}, Florida — {$currentDate}",
            'meta_title' => $title . ' | ' . Config::get('app_name'),
            'meta_description' => $subtitle,
            'canonical' => Config::get('app_url') . '/news/flood-barriers-' . $citySlug,
            'image' => $imageUrl
        ];
    }
    
    private static function generateContent($city, $county, $landmark, $recentStorm, $installers, $insurance, $currentDate)
    {
        $sections = [];
        
        // Opening paragraph
        $sections[] = [
            'type' => 'paragraph',
            'content' => "Homes across {$city} remain vulnerable as new research reveals that traditional sandbags—long considered the default flood defense—fail to stop water in up to 50% of flood events, especially during storm surge like that seen in {$recentStorm}."
        ];
        
        $sections[] = [
            'type' => 'paragraph',
            'content' => "This comes as building officials across {$county} warn homeowners that modern engineered aluminum flood panel systems deliver 95–99% watertight protection, deploy up to 10× faster, and are increasingly required to comply with Florida Building Code and ASCE 24 standards."
        ];
        
        // Why Sandbags Underperform
        $sections[] = [
            'type' => 'heading',
            'level' => 2,
            'content' => "Why Sandbags Underperform in {$city}"
        ];
        
        $sections[] = [
            'type' => 'paragraph',
            'content' => "New laboratory and field data indicate that sandbags leak extensively under:"
        ];
        
        $sections[] = [
            'type' => 'list',
            'items' => [
                'rising tide scenarios',
                'wave impact and pressure',
                'hydrostatic head',
                'water intrusion at ground interface',
                'wind-driven rain events'
            ]
        ];
        
        $sections[] = [
            'type' => 'paragraph',
            'content' => "Key findings affecting {$city} homeowners:"
        ];
        
        $sections[] = [
            'type' => 'list',
            'items' => [
                'Sandbags provide only 30–50% sealing effectiveness',
                'Gaps between bags allow dozens of gallons of water per hour',
                'Wave action displaces or collapses stacked sandbags within minutes',
                'Contaminated bags must be discarded after every use'
            ]
        ];
        
        $sections[] = [
            'type' => 'paragraph',
            'content' => "This performance gap is especially dangerous in coastal and canal-side homes near {$landmark}, where surge conditions magnify water pressure."
        ];
        
        // Aluminum Flood Panels Section
        $sections[] = [
            'type' => 'heading',
            'level' => 2,
            'content' => 'Aluminum Flood Panels Becoming the SWFL Standard'
        ];
        
        $sections[] = [
            'type' => 'paragraph',
            'content' => "Engineered aluminum flood barriers now dominate the Southwest Florida market because they offer:"
        ];
        
        $sections[] = [
            'type' => 'list',
            'items' => [
                '95–99% watertight compression sealing',
                'EPDM marine-grade gaskets',
                '20–40+ year lifespan',
                'Deployment in 7–30 minutes by 1–2 people',
                'Compliance with ASCE 24-14 and Florida Building Code R322'
            ]
        ];
        
        $sections[] = [
            'type' => 'paragraph',
            'content' => "A 20-year cost analysis found:"
        ];
        
        $sections[] = [
            'type' => 'list',
            'items' => [
                'Sandbags cost $25,000+ over repeated deployments',
                'Flood panels cost $7,000 with minimal maintenance',
                'Resulting in $18,000 lifetime savings'
            ]
        ];
        
        $sections[] = [
            'type' => 'paragraph',
            'content' => "For {$city}, where storm frequency and insurance claims are rising, this cost advantage has major long-term impact."
        ];
        
        // Code Requirements Section
        $sections[] = [
            'type' => 'heading',
            'level' => 2,
            'content' => "Local Code Requirements Affecting {$city} Homeowners"
        ];
        
        $sections[] = [
            'type' => 'paragraph',
            'content' => "Florida Building Code mandates:"
        ];
        
        $sections[] = [
            'type' => 'list',
            'items' => [
                'Homes in flood zones must elevate to BFE + 1 ft freeboard',
                'Materials below elevation must be flood damage-resistant',
                'Residential structures cannot use dry floodproofing',
                'Engineered flood barriers protecting openings must be certified'
            ]
        ];
        
        $sections[] = [
            'type' => 'paragraph',
            'content' => "ASCE 24 further requires ANSI/FM 2510-certified barriers for openings in:"
        ];
        
        $sections[] = [
            'type' => 'list',
            'items' => [
                'Coastal A Zones',
                'V Zones',
                'Waterfront structures',
                'Homes below elevation thresholds'
            ]
        ];
        
        $sections[] = [
            'type' => 'paragraph',
            'content' => "This means engineered panels are the only compliant option for most of {$city}'s coastal neighborhoods."
        ];
        
        // Local Installer Section
        $sections[] = [
            'type' => 'heading',
            'level' => 2,
            'content' => "The Local Installer Landscape in {$city}"
        ];
        
        $sections[] = [
            'type' => 'paragraph',
            'content' => "Based on regional service maps, the primary providers covering {$city} include:"
        ];
        
        $sections[] = [
            'type' => 'paragraph',
            'content' => $installers
        ];
        
        $sections[] = [
            'type' => 'paragraph',
            'content' => "These companies provide:"
        ];
        
        $sections[] = [
            'type' => 'list',
            'items' => [
                'custom-engineered panels',
                'stamped design documents',
                'installation + permitting guidance',
                'annual maintenance programs',
                'emergency deployment support'
            ]
        ];
        
        $sections[] = [
            'type' => 'paragraph',
            'content' => "Their proximity to {$city} allows rapid response before landfall events."
        ];
        
        // Insurance Section
        $sections[] = [
            'type' => 'heading',
            'level' => 2,
            'content' => "Insurance Premium Reductions for {$city} Residents"
        ];
        
        $sections[] = [
            'type' => 'paragraph',
            'content' => "Flood panels can reduce insurance by:"
        ];
        
        $sections[] = [
            'type' => 'list',
            'items' => [
                '5–35% property-level savings',
                'Up to 50% when combined with elevation improvements',
                'Added savings when {$city} participates in CRS (Community Rating System)'
            ]
        ];
        
        $sections[] = [
            'type' => 'paragraph',
            'content' => "Given {$city}'s average flood insurance cost of \${$insurance} annually, homeowners can save:"
        ];
        
        $sections[] = [
            'type' => 'list',
            'items' => [
                '$240–$320/year',
                '$4,800–$12,800 over 20–40 years'
            ]
        ];
        
        $sections[] = [
            'type' => 'paragraph',
            'content' => "This offsets installation cost significantly."
        ];
        
        // Price Guide Section
        $sections[] = [
            'type' => 'heading',
            'level' => 2,
            'content' => "Price Guide for {$city}"
        ];
        
        $sections[] = [
            'type' => 'paragraph',
            'content' => "Typical installed costs:"
        ];
        
        $sections[] = [
            'type' => 'list',
            'items' => [
                'Entry doors: $1,200–$3,100',
                'Single garage: $2,500–$5,500',
                'Double garage: $4,300–$8,500',
                'Sliding glass doors: $2,200–$4,800',
                'Whole-home protection: $18,000–$42,000'
            ]
        ];
        
        $sections[] = [
            'type' => 'paragraph',
            'content' => "DIY kits range from $379 (Tiger Dam) to $2,500 (Zip Flood Control)."
        ];
        
        // Maintenance Section
        $sections[] = [
            'type' => 'heading',
            'level' => 2,
            'content' => 'Maintenance Requirements for Long-Term Reliability'
        ];
        
        $sections[] = [
            'type' => 'paragraph',
            'content' => "Homeowners should follow:"
        ];
        
        $sections[] = [
            'type' => 'list',
            'items' => [
                'quarterly visual inspections',
                'semi-annual cleaning of tracks + hardware',
                'EPDM gasket lubrication',
                'annual hydrostatic leak testing',
                'seasonal mock deployments (pre-hurricane)'
            ]
        ];
        
        $sections[] = [
            'type' => 'paragraph',
            'content' => "Improper maintenance voids warranties from most manufacturers."
        ];
        
        // Editorial Closing
        $sections[] = [
            'type' => 'paragraph',
            'content' => "As hurricanes intensify and flooding becomes more severe across {$city}, engineered flood panels are rapidly replacing sandbags as the preferred—and in some cases required—method of securing homes. With code updates, insurance incentives, and stronger local installer networks, Southwest Florida homeowners now have access to resilient, long-term solutions that offer measurable, proven protection."
        ];
        
        return $sections;
    }
    
    /**
     * Get a random news image for Florida flood articles
     * Returns a random image URL from a curated list of Florida flood-related images
     */
    private static function getRandomNewsImage($baseUrl, $citySlug = null)
    {
        // Curated list of Florida flood/flooding news images
        // These should be relevant, high-quality images suitable for news articles
        $images = [
            // Blog/News images
            '/assets/images/blog/flood-protection-blog.jpg',
            
            // Homepage images (flood protection related)
            '/assets/images/homepage/cropped-2026-01-11-17.53.15-scaled-2.jpg',
            '/assets/images/homepage/cropped-cropped-rubicon_flood_privatehome-1-1536x1104.jpg',
            '/assets/images/homepage/cropped-IMG_0070-rotated-1.jpg',
            '/assets/images/homepage/cropped-rubiconfloodbarrier2-scaled-e1755554554647.jpg',
            
            // Product images (can be used for news context)
            '/assets/images/products/modular-aluminum-flood-barriers.jpg',
            '/assets/images/products/garage-dam-kits.jpg',
            '/assets/images/products/doorway-flood-panels.jpg',
        ];
        
        // Use city slug as seed for consistent image per city, but still random
        if ($citySlug) {
            mt_srand(crc32($citySlug . date('Y-m')));
        }
        
        $randomImage = $images[array_rand($images)];
        
        // Reset seed
        if ($citySlug) {
            mt_srand();
        }
        
        return $baseUrl . $randomImage;
    }
    
    private static function generateSchema($city, $citySlug, $title, $date)
    {
        $baseUrl = Config::get('app_url');
        $url = $baseUrl . '/news/flood-barriers-' . $citySlug;
        
        // Generate description from subtitle
        $description = "A new technical report shows why traditional sandbags underperform during storm surge, wave impact, and flash flooding—prompting emergency managers and insurers across {$city} to push residents toward aluminum flood panel systems.";
        
        // Get random news image
        $imageUrl = self::getRandomNewsImage($baseUrl, $citySlug);
        
        return [
            '@context' => 'https://schema.org',
            '@type' => 'NewsArticle',
            'headline' => $title,
            'description' => $description,
            'datePublished' => $date . 'T00:00:00+00:00', // ISO 8601 format
            'dateModified' => $date . 'T00:00:00+00:00',
            'author' => [
                [
                    '@type' => 'Organization',
                    'name' => 'Flood Barrier Pros',
                    'url' => $baseUrl
                ]
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'Flood Barrier Pros',
                'url' => $baseUrl,
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => $baseUrl . '/assets/images/logo/flood-barrier-pros-logo.png',
                    'width' => 600,
                    'height' => 60
                ]
            ],
            'image' => [$imageUrl],
            'articleSection' => 'Flood Protection',
            'about' => [
                [
                    '@type' => 'Thing',
                    'name' => 'flood panels'
                ],
                [
                    '@type' => 'Thing',
                    'name' => 'storm surge'
                ],
                [
                    '@type' => 'Thing',
                    'name' => 'flood barriers'
                ],
                [
                    '@type' => 'Place',
                    'name' => "{$city} Florida"
                ]
            ],
            'keywords' => [
                "{$city} flood panels",
                "flood barriers {$city}",
                'SWFL flood protection',
                'aluminum flood barriers',
                'storm surge protection'
            ],
            'url' => $url,
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $url
            ],
            'inLanguage' => 'en-US'
        ];
    }
    
    private static function generateInternalLinks($citySlug, $city)
    {
        $baseUrl = Config::get('app_url');
        
        return [
            'upward' => [
                [
                    'url' => $baseUrl . '/fl/' . $citySlug . '/modular-flood-barrier',
                    'anchor' => "{$city} flood panels"
                ],
                [
                    'url' => $baseUrl . '/products',
                    'anchor' => 'flood barriers ' . $city
                ]
            ],
            'sideways' => [
                [
                    'url' => $baseUrl . '/fl/' . $citySlug . '/garage-dam-kit',
                    'anchor' => "garage flood barriers {$city}"
                ],
                [
                    'url' => $baseUrl . '/fl/' . $citySlug . '/doorway-flood-panel',
                    'anchor' => "storm surge protection {$city}"
                ]
            ],
            'downward' => [
                [
                    'url' => $baseUrl . '/products/modular-flood-barrier',
                    'anchor' => 'ASCE 24 compliant flood panels'
                ],
                [
                    'url' => $baseUrl . '/testimonials',
                    'anchor' => 'flood barrier case studies'
                ]
            ]
        ];
    }
    
    public static function getAltTag($city, $productType = 'panels')
    {
        $cityDisplay = ucwords(str_replace('-', ' ', $city));
        
        if ($productType === 'panels') {
            return "{$cityDisplay} flood panels | aluminum flood barrier system | storm surge protection";
        } elseif ($productType === 'garage') {
            return "garage flood barrier installation {$cityDisplay} | hurricane protection system";
        }
        
        return "{$cityDisplay} flood panels | aluminum flood barrier system | storm surge protection";
    }
}

