<?php

namespace App;

/**
 * SWFL Flood-Barrier Pages Content Generator
 * 
 * Generates localized, SEO-optimized content for Southwest Florida
 * flood barrier pages following the SEO Kernel standards.
 */
class SWFLContent
{
    /**
     * City-specific data for SWFL municipalities
     */
    private static $cityData = [
        'fort-myers' => [
            'name' => 'Fort Myers',
            'county' => 'Lee',
            'flood_zones' => ['AE', 'VE', 'A'],
            'surge_heights' => '8-12 feet',
            'hurricanes' => ['Ian (2022)', 'Irma (2017)', 'Charley (2004)'],
            'landmarks' => ['Caloosahatchee River', 'Edison & Ford Winter Estates'],
            'waterways' => ['Caloosahatchee River', 'Estero Bay'],
            'elevation_risk' => 'Low-lying coastal',
            'flood_history' => 'Severe flooding during Hurricane Ian with 8-12 foot surge'
        ],
        'cape-coral' => [
            'name' => 'Cape Coral',
            'county' => 'Lee',
            'flood_zones' => ['AE', 'VE'],
            'surge_heights' => '6-10 feet',
            'hurricanes' => ['Ian (2022)', 'Irma (2017)'],
            'landmarks' => ['Cape Coral Parkway', 'Four Mile Cove'],
            'waterways' => ['400+ miles of canals', 'Caloosahatchee River'],
            'elevation_risk' => 'Extensive canal system',
            'flood_history' => 'Canal overflow and storm surge during major storms'
        ],
        'naples' => [
            'name' => 'Naples',
            'county' => 'Collier',
            'flood_zones' => ['VE', 'AE', 'A'],
            'surge_heights' => '10-15 feet',
            'hurricanes' => ['Ian (2022)', 'Irma (2017)', 'Wilma (2005)'],
            'landmarks' => ['Naples Pier', 'Third Street South'],
            'waterways' => ['Gulf of Mexico', 'Naples Bay'],
            'elevation_risk' => 'Coastal high-risk',
            'flood_history' => 'Extreme surge during Ian, extensive coastal flooding'
        ],
        'bonita-springs' => [
            'name' => 'Bonita Springs',
            'county' => 'Lee',
            'flood_zones' => ['AE', 'VE'],
            'surge_heights' => '7-11 feet',
            'hurricanes' => ['Ian (2022)', 'Irma (2017)'],
            'landmarks' => ['Bonita Beach', 'Estero Bay'],
            'waterways' => ['Estero Bay', 'Imperial River'],
            'elevation_risk' => 'Coastal and riverine',
            'flood_history' => 'Bay surge and river overflow during storms'
        ],
        'estero' => [
            'name' => 'Estero',
            'county' => 'Lee',
            'flood_zones' => ['AE', 'A'],
            'surge_heights' => '6-9 feet',
            'hurricanes' => ['Ian (2022)', 'Irma (2017)'],
            'landmarks' => ['Estero Bay', 'Corkscrew Road'],
            'waterways' => ['Estero Bay', 'Estero River'],
            'elevation_risk' => 'Coastal moderate',
            'flood_history' => 'Bay surge and inland flooding'
        ],
        'sanibel' => [
            'name' => 'Sanibel',
            'county' => 'Lee',
            'flood_zones' => ['VE', 'AE'],
            'surge_heights' => '12-18 feet',
            'hurricanes' => ['Ian (2022)', 'Charley (2004)'],
            'landmarks' => ['Sanibel Lighthouse', 'Bowman\'s Beach'],
            'waterways' => ['Gulf of Mexico', 'San Carlos Bay'],
            'elevation_risk' => 'Barrier island extreme',
            'flood_history' => 'Devastating surge during Ian, complete island flooding'
        ],
        'pine-island' => [
            'name' => 'Pine Island',
            'county' => 'Lee',
            'flood_zones' => ['AE', 'VE'],
            'surge_heights' => '8-14 feet',
            'hurricanes' => ['Ian (2022)', 'Charley (2004)'],
            'landmarks' => ['Matlacha Pass', 'Bokeelia'],
            'waterways' => ['Matlacha Pass', 'Pine Island Sound'],
            'elevation_risk' => 'Low-lying barrier',
            'flood_history' => 'Extreme surge, complete island inundation during Ian'
        ],
        'marco-island' => [
            'name' => 'Marco Island',
            'county' => 'Collier',
            'flood_zones' => ['VE', 'AE'],
            'surge_heights' => '11-16 feet',
            'hurricanes' => ['Ian (2022)', 'Irma (2017)', 'Wilma (2005)'],
            'landmarks' => ['Marco Beach', 'Tigertail Beach'],
            'waterways' => ['Gulf of Mexico', 'Marco River'],
            'elevation_risk' => 'Coastal extreme',
            'flood_history' => 'Severe surge and coastal flooding during major storms'
        ],
        'sarasota' => [
            'name' => 'Sarasota',
            'county' => 'Sarasota',
            'flood_zones' => ['AE', 'VE', 'A'],
            'surge_heights' => '7-12 feet',
            'hurricanes' => ['Ian (2022)', 'Irma (2017)'],
            'landmarks' => ['Siesta Key', 'Lido Key'],
            'waterways' => ['Gulf of Mexico', 'Sarasota Bay'],
            'elevation_risk' => 'Coastal moderate-high',
            'flood_history' => 'Bay surge and coastal flooding during major storms'
        ],
        'hillsborough' => [
            'name' => 'Hillsborough',
            'county' => 'Hillsborough',
            'flood_zones' => ['AE', 'A'],
            'surge_heights' => '6-10 feet',
            'hurricanes' => ['Ian (2022)', 'Irma (2017)'],
            'landmarks' => ['Tampa Bay', 'Hillsborough River'],
            'waterways' => ['Tampa Bay', 'Hillsborough River'],
            'elevation_risk' => 'Bay and riverine',
            'flood_history' => 'Bay surge and river overflow during storms'
        ],
        'jensen-beach' => [
            'name' => 'Jensen Beach',
            'county' => 'Martin',
            'flood_zones' => ['AE', 'VE'],
            'surge_heights' => '6-9 feet',
            'hurricanes' => ['Ian (2022)', 'Irma (2017)'],
            'landmarks' => ['Jensen Beach', 'Indian River'],
            'waterways' => ['Indian River', 'Atlantic Ocean'],
            'elevation_risk' => 'Coastal moderate',
            'flood_history' => 'Coastal surge and river flooding'
        ],
        'lehigh-acres' => [
            'name' => 'Lehigh Acres',
            'county' => 'Lee',
            'flood_zones' => ['X', 'A', 'AE'],
            'surge_heights' => 'localized levels',
            'hurricanes' => ['Ian (2022)', 'Irma (2017)'],
            'landmarks' => ['Harns Marsh', 'Lehigh Acres Trailhead Park'],
            'waterways' => ['Orange River', 'Numerous canals'],
            'elevation_risk' => 'Inland sheet flow',
            'flood_history' => 'Significant street flooding and canal overflow during heavy rains'
        ],
        'north-fort-myers' => [
            'name' => 'North Fort Myers',
            'county' => 'Lee',
            'flood_zones' => ['AE', 'VE', 'X'],
            'surge_heights' => '8-11 feet',
            'hurricanes' => ['Ian (2022)', 'Irma (2017)'],
            'landmarks' => ['Shell Factory', 'North Fort Myers High School'],
            'waterways' => ['Caloosahatchee River', 'Hancock Creek'],
            'elevation_risk' => 'River-adjacent',
            'flood_history' => 'Severe riverine surge and structural flooding during major storms'
        ]
    ];
    
    /**
     * Generate page title for city page (query-matched)
     */
    public static function getPageTitle($city, $keyword = 'flood barriers')
    {
        return \App\QueryDrivenContent::getMetaTitle($city, $keyword);
    }
    
    /**
     * Generate H1 for city page (query-matched)
     */
    public static function getH1($city, $keyword = 'flood barriers')
    {
        return \App\QueryDrivenContent::getH1($city, $keyword);
    }
    
    /**
     * Generate intro paragraph (90-120 words)
     */
    public static function getIntro($city)
    {
        $data = self::getCityData($city);
        if (!$data) {
            return self::getGenericIntro($city);
        }
        
        $zones = implode('/', $data['flood_zones']);
        $hurricanes = implode(', ', array_slice($data['hurricanes'], 0, 2));
        
        return "{$data['name']} faces significant flood risk from storm surge and heavy rainfall, with documented surge heights reaching {$data['surge_heights']} during recent hurricanes including {$hurricanes}. Located in {$data['county']} County, the area is primarily in Flood Zones {$zones}, requiring FEMA-compliant flood protection systems. {$data['flood_history']}. Homeowners and businesses must meet NFIP (National Flood Insurance Program) requirements, which often mandate elevation certificates and approved barrier systems. Our flood barrier installation services in {$data['name']} provide rapid-deploy aluminum panels, garage shields, and modular systems designed to withstand {$data['surge_heights']} surge events. Contact us for a free assessment and FEMA-compliant installation quote.";
    }
    
    /**
     * Generate "Why Flood Barriers Are Critical" section (140-180 words)
     */
    public static function getWhyCritical($city)
    {
        $data = self::getCityData($city);
        if (!$data) {
            return self::getGenericWhyCritical($city);
        }
        
        $hurricanes = implode(', ', $data['hurricanes']);
        $landmark = $data['landmarks'][0] ?? 'the area';
        
        return "Recent hurricanes including {$hurricanes} have demonstrated the critical need for flood barriers in {$data['name']}. During Hurricane Ian in 2022, surge heights reached {$data['surge_heights']}, causing extensive property damage throughout {$data['county']} County. Properties near {$landmark} and along {$data['waterways'][0]} experienced severe flooding, with many structures requiring complete restoration. {$data['name']} building codes require flood-resistant construction in Zones {$data['flood_zones'][0]} and {$data['flood_zones'][1]}, and proximity to {$data['waterways'][0]} increases risk significantly. Elevation certificates are mandatory for properties in high-risk zones, and flood barriers provide the first line of defense against surge events. Our installation services ensure compliance with local codes while providing rapid-deploy protection that can be activated within hours of storm warnings. Learn more about our comprehensive flood protection services for Southwest Florida.";
    }
    
    /**
     * Generate product breakdown section
     */
    public static function getProductBreakdown()
    {
        return [
            [
                'name' => 'Aluminum Flood Panels',
                'description' => '6063 T-6 aluminum panels with EPDM sealing, rated for surge heights up to 12 feet. Rapid deployment, reusable design, FEMA-compliant. Installation time: 2-4 hours for standard openings.',
                'durability' => '20+ years',
                'surge_rating' => 'Up to 12 feet',
                'maintenance' => 'Annual inspection, clean and store after storms'
            ],
            [
                'name' => 'Garage Flood Shields',
                'description' => 'Modular garage door protection systems designed for residential and commercial openings. Weather-resistant seals, quick-install tracks, rated for 8-10 foot surge events.',
                'durability' => '15+ years',
                'surge_rating' => '8-10 feet',
                'maintenance' => 'Pre-season hardware check, panel storage'
            ],
            [
                'name' => 'Hydro-Inflatable Barriers',
                'description' => 'Emergency deployment barriers that inflate with water pressure. Ideal for temporary protection during storm events. Deploy in 30-60 minutes, remove after storm passes.',
                'durability' => '5-7 years',
                'surge_rating' => '6-8 feet',
                'maintenance' => 'Annual inspection, replace if damaged'
            ],
            [
                'name' => 'Modular Commercial Barricades',
                'description' => 'Heavy-duty aluminum systems for large commercial openings, storefronts, and warehouse entrances. Custom-engineered for openings up to 20 feet wide, surge-rated up to 15 feet.',
                'durability' => '25+ years',
                'surge_rating' => 'Up to 15 feet',
                'maintenance' => 'Quarterly inspection, professional maintenance recommended'
            ]
        ];
    }
    
    /**
     * Generate installation & permitting section (120-160 words)
     */
    public static function getInstallationPermitting($city)
    {
        $data = self::getCityData($city);
        $county = $data['county'] ?? 'Lee';
        
        return "Flood barrier installation in {$data['name']} requires compliance with {$county} County building codes and local HOA regulations. Properties in Flood Zones {$data['flood_zones'][0]} and {$data['flood_zones'][1]} must submit elevation certificates with permit applications. {$county} County requires structural engineering approval for barrier systems exceeding 4 feet in height, and HOA approval is mandatory for visible exterior installations. Permits typically process within 7-14 business days, and our team handles all documentation including site plans, elevation certificates, and product specifications. Installation must be completed by licensed contractors, and final inspections are required before barrier systems are approved for use. We coordinate with county officials and HOAs to ensure full compliance. Learn more about our installation services and permit assistance.";
    }
    
    /**
     * Generate pricing guide section
     */
    public static function getPricingGuide($city)
    {
        return [
            'panels' => [
                'range' => '$17-$42 per sq ft',
                'factors' => 'Panel height, material thickness, custom cuts, hardware requirements'
            ],
            'door_entry' => [
                'range' => '$900-$2,600 per door/entry',
                'factors' => 'Opening size, track system complexity, seal requirements, permit fees'
            ],
            'commercial' => [
                'range' => '$2,500-$8,500 for large commercial openings',
                'factors' => 'Opening width, structural requirements, custom engineering, installation complexity'
            ]
        ];
    }
    
    /**
     * Generate case studies section (40-60 words each)
     */
    public static function getCaseStudies($city)
    {
        $data = self::getCityData($city);
        $landmark = $data['landmarks'][0] ?? 'a local landmark';
        $road = $data['landmarks'][1] ?? 'a major thoroughfare';
        
        return [
            [
                'location' => "Home near {$landmark}",
                'scenario' => "Faced {$data['surge_heights']} surge during Hurricane Ian",
                'solution' => 'Installed aluminum flood panels on all ground-level openings',
                'result' => 'Zero water intrusion, property fully protected'
            ],
            [
                'location' => "Business on {$road}",
                'scenario' => "Commercial storefront in Zone {$data['flood_zones'][0]}",
                'solution' => 'Modular commercial barricade system with custom engineering',
                'result' => 'Business operational within 24 hours post-storm'
            ],
            [
                'location' => "Residential property in {$data['name']}",
                'scenario' => "Storm surge threat with 48-hour warning",
                'solution' => 'Rapid-deploy hydro-inflatable barriers',
                'result' => 'Deployed in 45 minutes, complete protection during event'
            ]
        ];
    }
    
    /**
     * Generate maintenance checklist
     */
    public static function getMaintenanceChecklist()
    {
        return [
            'Pre-season inspection (May-June): Check all panels for damage, verify hardware integrity, test deployment mechanisms',
            'Panel storage & labeling: Store panels in labeled containers, maintain inventory list, ensure easy access',
            'Hardware checks: Inspect tracks, bolts, seals, and mounting brackets for corrosion or wear',
            'Deployment timing: Monitor weather forecasts, deploy 24-48 hours before expected landfall, secure all openings',
            'Post-storm review: Inspect barriers for damage, clean and dry all components, document any issues for insurance'
        ];
    }
    
    /**
     * Generate FAQ entries (6-10, 40-70 words each)
     */
    public static function getFAQs($city)
    {
        $data = self::getCityData($city);
        $cityName = $data['name'] ?? $city;
        
        return [
            [
                'question' => "How much do flood barriers cost in {$cityName}?",
                'answer' => "Flood barrier costs in {$cityName} range from \$17-\$42 per square foot for aluminum panels, \$900-\$2,600 per door/entry opening, and \$2,500-\$8,500 for large commercial systems. Final pricing depends on opening size, material selection, installation complexity, and permit requirements. Contact us for a free assessment and detailed quote."
            ],
            [
                'question' => "What materials are used for flood barriers?",
                'answer' => "Our flood barriers use 6063 T-6 aluminum construction with EPDM rubber sealing for watertight protection. Aluminum provides corrosion resistance in coastal environments, while EPDM seals prevent water intrusion. Systems are rated for surge heights up to 15 feet and designed for 20+ years of service life."
            ],
            [
                'question' => "Will flood barriers reduce my insurance premiums?",
                'answer' => "FEMA-compliant flood barriers may qualify for NFIP premium reductions when properly installed and documented. Insurance companies often offer discounts for properties with certified flood protection systems. We provide all documentation needed for insurance claims and premium reduction applications."
            ],
            [
                'question' => "Are flood barriers FEMA-compliant?",
                'answer' => "Yes, our aluminum flood barrier systems meet FEMA Technical Bulletin 3-93 requirements for flood-resistant construction. Systems are engineered to withstand specified surge heights and are approved for use in Flood Zones AE and VE. We provide FEMA compliance documentation with every installation."
            ],
            [
                'question' => "How quickly can flood barriers be deployed?",
                'answer' => "Pre-installed track systems allow rapid deployment in 30-60 minutes for standard openings. Hydro-inflatable barriers deploy even faster, typically in 15-30 minutes. We recommend deploying barriers 24-48 hours before expected storm landfall to ensure adequate preparation time."
            ],
            [
                'question' => "How long do flood barriers last?",
                'answer' => "Aluminum flood barriers have a service life of 20+ years with proper maintenance. Garage shields last 15+ years, while hydro-inflatable barriers typically last 5-7 years. Annual inspections and proper storage extend system longevity significantly."
            ],
            [
                'question' => "Are flood barriers suitable for condos and HOAs?",
                'answer' => "Yes, flood barriers can be installed in condos and HOA properties with proper approval. We coordinate with HOA boards to ensure compliance with architectural guidelines and obtain necessary approvals. Systems can be designed to be minimally visible when not in use."
            ],
            [
                'question' => "What's the difference between Flood Zone VE and AE?",
                'answer' => "Flood Zone VE (coastal high hazard) requires structures to withstand wave action and surge, while Zone AE (base flood) requires protection from stillwater flooding. Both zones require FEMA-compliant barriers, but VE zones may need higher surge ratings and additional structural considerations."
            ]
        ];
    }
    
    /**
     * Generate comprehensive JSON-LD schema for city page
     * Expanded schema for AI Overview visibility
     */
    public static function generateSchema($city, $url, $serviceDescription = null, $keyword = 'flood barriers')
    {
        $data = self::getCityData($city);
        $cityName = $data['name'] ?? ucwords(str_replace('-', ' ', $city));
        $county = $data['county'] ?? 'Lee';
        
        if (!$serviceDescription) {
            $serviceDescription = "Professional flood barrier installation and storm surge protection services in {$cityName}, {$county} County, Florida. FEMA-compliant systems, rapid deployment, and comprehensive maintenance support.";
        }
        
        $faqs = self::getFAQs($city);
        $faqEntities = array_map(function($faq) {
            return [
                '@type' => 'Question',
                'name' => $faq['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq['answer']
                ]
            ];
        }, $faqs);
        
        $breadcrumbs = [
            ['name' => 'Home', 'item' => Config::get('app_url')],
            ['name' => 'Flood Barriers', 'item' => Config::get('app_url') . '/products'],
            ['name' => $cityName . ' Flood Barriers', 'item' => $url]
        ];
        
        $breadcrumbItems = array_map(function($item, $index) {
            return [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $item['name'],
                'item' => $item['item']
            ];
        }, $breadcrumbs, array_keys($breadcrumbs));
        
        // P1/P2 COMPLIANCE: City/Service pages must NOT include Product schema
        // Product schema is only allowed on dedicated product pages (/products/*)
        // Per SUDO META DIRECTIVE: City/service pages = LocalBusiness, Service, BreadcrumbList, FAQPage only
        
        return [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'LocalBusiness',
                    'name' => "Flood Barrier Pros - {$cityName}",
                    'url' => $url,
                    'address' => [
                        '@type' => 'PostalAddress',
                        'addressLocality' => $cityName,
                        'addressRegion' => 'FL',
                        'addressCountry' => 'US'
                    ],
                    'areaServed' => [
                        '@type' => 'City',
                        'name' => $cityName
                    ],
                    'telephone' => Config::get('phone'),
                    'priceRange' => '$$',
                    'openingHours' => 'Mo-Fr 08:00-18:00'
                ],
                [
                    '@type' => 'Service',
                    'name' => "Flood Barrier Installation in {$cityName}",
                    'serviceType' => 'Flood Barriers, Storm Surge Protection, FEMA-Compliant Installations, Aluminum Flood Panels, Garage Flood Shields',
                    'provider' => [
                        '@type' => 'LocalBusiness',
                        'name' => 'Flood Barrier Pros',
                        'url' => Config::get('app_url')
                    ],
                    'areaServed' => [
                        '@type' => 'City',
                        'name' => $cityName
                    ],
                    'description' => $serviceDescription,
                    'offers' => [
                        '@type' => 'Offer',
                        'priceCurrency' => 'USD',
                        'availability' => 'https://schema.org/InStock',
                        'url' => $url
                    ]
                ],
                [
                    '@type' => 'FAQPage',
                    'mainEntity' => $faqEntities
                ],
                [
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => $breadcrumbItems
                ],
                [
                    '@type' => 'HowTo',
                    'name' => "How to Install Flood Barriers in {$cityName}",
                    'description' => "Step-by-step guide for installing flood barriers in {$cityName}, {$county} County, Florida",
                    'totalTime' => 'PT4H',
                    'step' => [
                        [
                            '@type' => 'HowToStep',
                            'position' => 1,
                            'name' => 'Measure all openings',
                            'text' => 'Measure width and height of all doorways, garage openings, and ground-level windows that require protection. Record measurements and note any obstructions or special requirements.'
                        ],
                        [
                            '@type' => 'HowToStep',
                            'position' => 2,
                            'name' => 'Cut and prepare mounting tracks',
                            'text' => 'Cut aluminum tracks to measured lengths using appropriate tools. Prepare mounting surfaces, ensuring they are clean and structurally sound for track installation.'
                        ],
                        [
                            '@type' => 'HowToStep',
                            'position' => 3,
                            'name' => 'Install tracks',
                            'text' => 'Mount tracks using provided hardware, ensuring level installation and proper spacing. Secure tracks to structural elements, not just surface materials.'
                        ],
                        [
                            '@type' => 'HowToStep',
                            'position' => 4,
                            'name' => 'Deploy before storm',
                            'text' => 'Insert flood panels into tracks 24-48 hours before expected storm landfall. Verify all panels are properly seated and seals are intact. Test deployment mechanism to ensure smooth operation.'
                        ]
                    ]
                ]
            ]
        ];
    }
    
    /**
     * Get city name from slug
     */
    private static function getCityName($city)
    {
        $data = self::getCityData($city);
        return $data['name'] ?? ucwords(str_replace('-', ' ', $city));
    }
    
    /**
     * Get city data
     */
    private static function getCityData($city)
    {
        return self::$cityData[$city] ?? null;
    }
    
    /**
     * Generic intro fallback
     */
    private static function getGenericIntro($city)
    {
        $cityName = ucwords(str_replace('-', ' ', $city));
        return "{$cityName} faces significant flood risk from storm surge and heavy rainfall. Located in Southwest Florida, the area requires FEMA-compliant flood protection systems. Our flood barrier installation services provide rapid-deploy aluminum panels, garage shields, and modular systems. Contact us for a free assessment.";
    }
    
    /**
     * Generic why critical fallback
     */
    private static function getGenericWhyCritical($city)
    {
        $cityName = ucwords(str_replace('-', ' ', $city));
        return "Recent hurricanes have demonstrated the critical need for flood barriers in {$cityName}. Properties in high-risk flood zones require FEMA-compliant protection systems. Our installation services ensure compliance with local codes while providing rapid-deploy protection.";
    }
    
    /**
     * Check if city is in SWFL
     */
    public static function isSWFLCity($citySlug)
    {
        return isset(self::$cityData[$citySlug]);
    }
    
    /**
     * Get all SWFL city slugs
     */
    public static function getSWFLCities()
    {
        return array_keys(self::$cityData);
    }
}

