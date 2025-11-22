<?php
/**
 * Process GSC data according to SEO_GSC_URL_AUDIT_KERNEL
 * Outputs JSONL format for each URL
 */

$pagesFile = '/Users/malware/Downloads/floodbarrierpros.com-Performance-on-Search-2025-11-22 (2)/Pages.csv';
$queriesFile = '/Users/malware/Downloads/floodbarrierpros.com-Performance-on-Search-2025-11-22 (2)/Queries.csv';

// Read Pages CSV
$pages = [];
if (($handle = fopen($pagesFile, 'r')) !== false) {
    $header = fgetcsv($handle, 0, ',', '"', '\\');
    while (($row = fgetcsv($handle, 0, ',', '"', '\\')) !== false) {
        if (count($row) >= 5) {
            $pages[] = [
                'url' => $row[0],
                'clicks' => (int)$row[1],
                'impressions' => (int)$row[2],
                'ctr' => floatval(str_replace('%', '', $row[3])),
                'position' => floatval($row[4])
            ];
        }
    }
    fclose($handle);
}

// Read Queries CSV
$queries = [];
if (($handle = fopen($queriesFile, 'r')) !== false) {
    $header = fgetcsv($handle, 0, ',', '"', '\\');
    while (($row = fgetcsv($handle, 0, ',', '"', '\\')) !== false) {
        if (count($row) >= 5) {
            $queries[] = [
                'query' => $row[0],
                'clicks' => (int)$row[1],
                'impressions' => (int)$row[2],
                'ctr' => floatval(str_replace('%', '', $row[3])),
                'position' => floatval($row[4])
            ];
        }
    }
    fclose($handle);
}

// Process each URL
foreach ($pages as $page) {
    $url = $page['url'];
    $clicks = $page['clicks'];
    $impressions = $page['impressions'];
    $ctr = $page['ctr'];
    $position = $page['position'];
    
    // Determine status_guess
    $statusGuess = 'EXISTS';
    if (strpos($url, '/sitemap') !== false || strpos($url, '.ndjson') !== false || strpos($url, '.xml') !== false) {
        $statusGuess = 'EXISTS'; // Technical files exist but should be noindex
    }
    
    // Determine action
    $action = 'KEEP_AS_IS';
    $priority = 'LOW';
    
    // Priority calculation
    if ($impressions >= 50) {
        $priority = 'HIGH';
    } elseif ($impressions >= 20) {
        $priority = 'MEDIUM';
    }
    
    // Action determination
    if (strpos($url, '/sitemap') !== false || strpos($url, '.ndjson') !== false || strpos($url, '.xml') !== false) {
        $action = 'DEINDEX_OR_NOINDEX';
    } elseif ($impressions > 0 && $ctr == 0 && $impressions >= 20) {
        // Urgent: High impressions but zero clicks = meta problem
        $action = 'REWRITE_META';
        if ($impressions >= 50) {
            $priority = 'HIGH';
        } else {
            $priority = 'MEDIUM';
        }
    } elseif ($impressions > 0 && $ctr < 0.5 && $impressions >= 30) {
        // Very low CTR on decent impressions = meta needs work
        $action = 'REWRITE_META';
        if ($impressions >= 50) {
            $priority = 'HIGH';
        }
    } elseif ($impressions > 0 && $ctr < 1 && $impressions >= 50 && $position < 20) {
        // Good position but low CTR = meta issue
        $action = 'REWRITE_META';
        $priority = 'HIGH';
    }
    
    // Extract page type and location
    $path = parse_url($url, PHP_URL_PATH);
    if ($path === false) {
        $path = '/';
    }
    $pathParts = array_filter(explode('/', $path));
    
    // Generate meta based on URL pattern
    $metaTitle = '';
    $metaDescription = '';
    $h1 = '';
    $pagePurpose = '';
    $outline = [];
    
    // Pattern matching for different URL types
    if ($path === '/' || $path === '') {
        $metaTitle = 'Flood Barriers Florida | FEMA-Approved Installation';
        $metaDescription = 'Professional flood barrier installation across Florida. FEMA-aligned systems, same-week service, free assessments. Serving Miami, Tampa, Orlando, Naples.';
        $h1 = 'Flood Barrier Installation Services in Florida';
        $pagePurpose = 'Homepage targeting high-value flood barrier queries across Florida markets.';
        $outline = [
            'Hero section with primary CTA and location selector',
            'Service areas map highlighting coverage',
            'Product showcase: modular barriers, garage dams, doorway panels',
            'Why choose us: FEMA-aligned, licensed, fast installation',
            'Top cities served with quick links',
            'Customer testimonials and reviews',
            'Free assessment CTA'
        ];
    } elseif (preg_match('#^/flood-panels/([^/]+)$#', $path, $m)) {
        $city = ucwords(str_replace('-', ' ', $m[1]));
        $metaTitle = "Flood Panels {$city} FL | Installation & Pricing";
        $metaDescription = "Flood panel installation in {$city}, FL. FEMA-aligned systems, rapid deployment, free assessment. Licensed contractors serving {$city} area.";
        $h1 = "Flood Panels {$city}, FL";
        $pagePurpose = "Target 'flood panels {$city}' queries with local service page.";
        $outline = [
            "Why {$city} needs flood panels: local flood risk factors",
            "Our flood panel systems: modular, garage, doorway options",
            "Installation process in {$city}: timeline and requirements",
            "Pricing and financing options",
            "{$city} flood zones and elevation requirements",
            "Local permits and code compliance",
            "Customer reviews from {$city} area",
            "Free assessment booking form"
        ];
    } elseif (preg_match('#^/home-flood-barriers/([^/]+)$#', $path, $m)) {
        $city = ucwords(str_replace('-', ' ', $m[1]));
        $metaTitle = "Home Flood Barriers {$city} FL | Install & Service";
        $metaDescription = "Home flood barrier installation in {$city}, FL. Perimeter systems, door panels, garage dams. Free assessment, same-week install available.";
        $h1 = "Home Flood Barriers {$city}, FL";
        $pagePurpose = "Target 'flood barriers {$city}' and 'home flood protection {$city}' queries.";
        $outline = [
            "Home flood barrier solutions for {$city}",
            "Perimeter vs doorway systems: which is right for your home",
            "Installation timeline and process",
            "{$city}-specific flood risks and protection needs",
            "Product options: modular barriers, garage dams, doorway panels",
            "Pricing and financing",
            "Local customer testimonials",
            "Schedule free assessment"
        ];
    } elseif (preg_match('#^/flood-protection-for-homes/([^/]+)$#', $path, $m)) {
        $city = ucwords(str_replace('-', ' ', $m[1]));
        $metaTitle = "Flood Protection {$city} FL | Home Systems";
        $metaDescription = "Complete flood protection for {$city} homes. FEMA-aligned barriers, installation, maintenance. Free assessment, licensed contractors.";
        $h1 = "Flood Protection for Homes in {$city}, FL";
        $pagePurpose = "Target 'flood protection {$city}' and 'home flood protection' queries.";
        $outline = [
            "Comprehensive flood protection solutions for {$city} homes",
            "Assessment process: identifying vulnerabilities",
            "System types: perimeter, doorway, garage protection",
            "Installation and maintenance services",
            "{$city} flood zones and elevation requirements",
            "Insurance benefits and premium reductions",
            "Customer success stories",
            "Get started: free assessment"
        ];
    } elseif (preg_match('#^/city/([^/]+)$#', $path, $m)) {
        $city = ucwords(str_replace('-', ' ', $m[1]));
        $metaTitle = "Flood Barriers {$city} FL | Local Installation";
        $metaDescription = "Flood barrier installation in {$city}, FL. Local experts, FEMA-aligned systems, free assessment. Serving {$city} area.";
        $h1 = "Flood Barriers {$city}, FL";
        $pagePurpose = "City landing page targeting 'flood barriers {$city}' queries.";
        $outline = [
            "About {$city} flood protection needs",
            "Our services in {$city}: installation, maintenance, consultation",
            "{$city} flood zones and risk assessment",
            "Product options available",
            "Local permits and code compliance",
            "Customer reviews from {$city}",
            "Service areas within {$city}",
            "Contact for free assessment"
        ];
    } elseif (preg_match('#^/faq/([^/]+)$#', $path, $m)) {
        $slug = str_replace('-', ' ', $m[1]);
        $topic = ucwords($slug);
        $metaTitle = "{$topic} FAQ | Flood Barrier Pros";
        $metaDescription = "Frequently asked questions about {$slug}. Expert answers from licensed flood protection contractors in Florida.";
        $h1 = "{$topic} - Frequently Asked Questions";
        $pagePurpose = "FAQ page targeting informational queries about {$slug}.";
        $outline = [
            "What is {$slug}?",
            "How does {$slug} work?",
            "Benefits and considerations",
            "Installation requirements",
            "Cost and pricing factors",
            "Maintenance and care",
            "Common questions and answers",
            "Related resources"
        ];
    } elseif (preg_match('#^/products/([^/]+)$#', $path, $m)) {
        $product = ucwords(str_replace('-', ' ', $m[1]));
        $metaTitle = "{$product} | FEMA-Approved Flood Protection";
        $metaDescription = "{$product} for flood protection. FEMA-aligned, reusable, rapid deployment. Free assessment, professional installation available.";
        $h1 = "{$product}";
        $pagePurpose = "Product page targeting product-specific queries.";
        $outline = [
            "Product overview and specifications",
            "Features and benefits",
            "Installation requirements",
            "Pricing and availability",
            "Customer reviews and ratings",
            "Comparison with alternatives",
            "FAQs about this product",
            "Request free assessment"
        ];
    } elseif (preg_match('#^/blog/([^/]+)$#', $path, $m)) {
        $slug = $m[1];
        $title = ucwords(str_replace('-', ' ', preg_replace('/\d{4}-\d{2}-\d{2}-/', '', $slug)));
        $metaTitle = "{$title} | Flood Barrier Blog";
        $metaDescription = "Learn about {$title}. Expert insights on flood protection, installation, and maintenance from licensed contractors.";
        $h1 = $title;
        $pagePurpose = "Blog post targeting informational queries.";
        $outline = [
            "Introduction and key points",
            "Main content sections",
            "Practical examples and case studies",
            "Actionable takeaways",
            "Related resources",
            "Call-to-action"
        ];
    } elseif (preg_match('#^/flood-barriers/([^/]+)$#', $path, $m)) {
        $city = ucwords(str_replace('-', ' ', $m[1]));
        $metaTitle = "Flood Barriers {$city} FL | Installation";
        $metaDescription = "Flood barrier installation in {$city}, FL. FEMA-aligned systems, professional installation, free assessment.";
        $h1 = "Flood Barriers {$city}, FL";
        $pagePurpose = "Target 'flood barriers {$city}' queries.";
        $outline = [
            "Flood barrier solutions for {$city}",
            "Installation services and process",
            "{$city}-specific flood risks",
            "Product options",
            "Pricing information",
            "Customer testimonials",
            "Free assessment booking"
        ];
    } elseif (preg_match('#^/flood-protection/([^/]+)$#', $path, $m)) {
        $city = ucwords(str_replace('-', ' ', $m[1]));
        $metaTitle = "Flood Protection {$city} FL | Services";
        $metaDescription = "Flood protection services in {$city}, FL. FEMA-aligned barriers, installation, maintenance. Free assessment available.";
        $h1 = "Flood Protection {$city}, FL";
        $pagePurpose = "Target 'flood protection {$city}' queries.";
        $outline = [
            "Flood protection solutions for {$city}",
            "Service types and options",
            "Installation process",
            "{$city} flood zones",
            "Pricing and financing",
            "Customer reviews",
            "Contact for assessment"
        ];
    } elseif (preg_match('#^/testimonials#', $path)) {
        $metaTitle = "Customer Reviews | Flood Barrier Pros";
        $metaDescription = "Real customer reviews and testimonials for flood barrier installation. Verified reviews from Florida homeowners.";
        $h1 = "Customer Reviews & Testimonials";
        $pagePurpose = "Testimonials page for social proof and review snippets.";
        $outline = [
            "Featured customer reviews",
            "Product-specific testimonials",
            "Location-based reviews",
            "Review filtering options",
            "Submit your review",
            "Trust indicators"
        ];
    } elseif (preg_match('#^/regions/([^/]+)$#', $path, $m)) {
        $region = ucwords(str_replace('-', ' ', $m[1]));
        $metaTitle = "{$region} Flood Protection | SWFL Regions";
        $metaDescription = "Flood protection services in {$region}, Southwest Florida. Engineered systems, perimeter barriers, pump plans.";
        $h1 = "{$region} Flood Protection";
        $pagePurpose = "Regional service page for Southwest Florida areas.";
        $outline = [
            "{$region} flood risk profile",
            "Recommended protection systems",
            "Installation considerations",
            "Local regulations and permits",
            "Service areas",
            "Customer testimonials",
            "Contact for assessment"
        ];
    } else {
        // Generic fallback - ensure SEO-compliant length
        $metaTitle = "Flood Protection Services | Flood Barrier Pros";
        $metaDescription = "Professional flood barrier installation and protection services in Florida. FEMA-aligned systems, free assessments, licensed contractors. Serving Miami, Tampa, Orlando, Naples.";
        $h1 = "Flood Protection Services";
        $pagePurpose = "General service page.";
        $outline = [
            "Service overview",
            "Our approach",
            "Service areas",
            "Get started"
        ];
    }
    
    // Enforce SEO meta length constraints
    if (strlen($metaTitle) > 60) {
        $metaTitle = substr($metaTitle, 0, 57) . '...';
    }
    if (strlen($metaDescription) < 120) {
        // Pad with relevant keywords if too short
        $metaDescription .= " Expert installation, fast service, warranty coverage.";
    }
    if (strlen($metaDescription) > 160) {
        $metaDescription = substr($metaDescription, 0, 157) . '...';
    }
    
    // Special handling for sitemaps and technical files
    if ($action === 'DEINDEX_OR_NOINDEX') {
        $metaTitle = '';
        $metaDescription = '';
        $h1 = '';
        $pagePurpose = 'Technical sitemap file - should be noindexed.';
        $outline = [];
    }
    
    // Build output record
    $record = [
        'url' => $url,
        'gsc_clicks' => $clicks,
        'gsc_impressions' => $impressions,
        'gsc_ctr' => $ctr,
        'gsc_position' => $position,
        'status_guess' => $statusGuess,
        'action' => $action,
        'priority' => $priority,
        'recommended_meta_title' => $metaTitle,
        'recommended_meta_description' => $metaDescription,
        'recommended_h1' => $h1,
        'recommended_page_purpose' => $pagePurpose,
        'recommended_outline' => $outline,
        'notes' => ($impressions > 0 && $ctr == 0 && $impressions >= 20) ? 'Zero CTR despite impressions - urgent meta rewrite needed' : (($impressions > 0 && $ctr < 0.5 && $impressions >= 30) ? 'Very low CTR - meta optimization needed' : (($action === 'DEINDEX_OR_NOINDEX') ? 'Technical file - should be noindexed' : ''))
    ];
    
    echo json_encode($record, JSON_UNESCAPED_SLASHES) . "\n";
}

