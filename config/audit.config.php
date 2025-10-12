<?php
// Audit Configuration
return [
  'site_url' => 'https://floodbarrierpros.com',

  'sitemap_paths' => [
    '/sitemap.xml',
    '/sitemap-matrix.xml'
  ],
  
  'http' => [
    'timeout' => 20,
    'retries' => 2,
    'user_agent' => 'SEO-AuditBot/1.0 (+audit)'
  ],
  
  'title' => [
    'min' => 30,
    'max' => 60
  ],
  
  'meta_description' => [
    'min' => 110,
    'max' => 165
  ],
  
  'content' => [
    'min_words' => 200, // Adjusted for location pages
    'min_h2' => 2,
    'min_media' => 0, // Many pages don't have images yet
    'faq_required_for' => [] // Optional for now
  ],
  
  'duplication' => [
    'shingle_n' => 3,
    'max_jaccard' => 0.25
  ],
  
  'schema' => [
    'homepage_required' => ['WebSite'],
    'city_required'     => ['LocalBusiness','BreadcrumbList'],
    'service_required'  => ['Product','BreadcrumbList'],
    'product_required'  => ['Product','BreadcrumbList'],
    'article_required'  => ['Article','BreadcrumbList'],
    
    'required_props' => [
      'WebSite' => ['url','potentialAction'],
      'LocalBusiness' => ['name','url','address','telephone'],
      'Service' => ['name'],
      'Product' => ['name','offers'],
      'FAQPage' => ['mainEntity'],
      'Article' => ['headline','datePublished'],
      'BreadcrumbList' => ['itemListElement']
    ],
    
    'product_offer_required' => ['@type','priceCurrency'],
    'product_offer_ok_types' => ['Offer','AggregateOffer'],
  ],
  
  'url' => [
    'lowercase' => true,
    'kebab' => true,
    'max_len' => 115,
    'force_trailing_slash' => false, // Flexible
    'no_querystring' => true
  ],
  
  'style' => [
    'require_css' => ['/assets/app.css'],
    'require_tokens' => [], // Not using CSS vars yet
    'require_partials_markers' => [], // Flexible
    'require_classes' => ['container'] // Minimal check
  ],
  
  'scoring' => [
    'title' => 10,
    'meta' => 10,
    'canonical' => 10,
    'content' => 30,
    'schema' => 25,
    'url' => 10,
    'style' => 5
  ]
];

