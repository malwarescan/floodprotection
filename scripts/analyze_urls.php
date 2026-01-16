<?php

$inputFile = __DIR__ . '/../data/url_metrics.txt';
$lines = file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$output = "# URL Analysis and Optimization Plan\n\n";
$output .= "| URL | Impressions | CTR | Analysis | Proposed Title | Proposed Description | Schema |\n";
$output .= "|---|---|---|---|---|---|---|\n";

$count = 0;

foreach ($lines as $line) {
    if (strpos($line, 'http') === 0) {
        $url = trim($line);
        continue;
    }
    
    // Parse metrics line
    $parts = preg_split('/\s+/', trim($line));
    if (count($parts) < 4) continue;
    
    $clicks = $parts[0];
    $impressions = $parts[1];
    $ctr = $parts[2];
    $position = $parts[3];
    
    // Parse URL path
    $parsedUrl = parse_url($url);
    $path = $parsedUrl['path'] ?? '/';
    $segments = array_filter(explode('/', $path));
    $segments = array_values($segments); // Re-index
    
    $analysis = "Low CTR";
    $title = "";
    $desc = "";
    $schema = "";
    
    // Optimization Logic
    if (empty($segments)) {
        // Home
        $title = "Florida's #1 Rated Flood Barriers | FEMA-Compliant Home Protection";
        $desc = "Protect your home with Florida's most trusted flood barriers. FEMA-approved, reusable aluminum panels & garage dams. Free statewide assessment.";
        $schema = "Organization, LocalBusiness";
        $analysis = "Generic title needs upgrade";
    } elseif ($segments[0] == 'products') {
        $product = $segments[1] ?? '';
        $schema = "Product";
        if (strpos($product, 'modular') !== false) {
            $title = "Modular Aluminum Flood Barriers | Reusable & FEMA-Compliant";
            $desc = "Protect your property with lightweight, industrial-strength aluminum flood barriers. Easy deployment in minutes. Request a quote.";
        } elseif (strpos($product, 'garage') !== false) {
            $title = "Garage Door Flood Barriers | Quick-Deploy Dam Kits";
            $desc = "Seal your garage against floodwaters instantly. Heavy-duty reusable garage flood barriers. Easy DIY installation available.";
        } else {
             $title = ucwords(str_replace('-', ' ', $product)) . " | Flood Barrier Pros";
             $desc = "High-quality " . str_replace('-', ' ', $product) . " for flood protection. Durable, effective, and ready to ship.";
        }
    } elseif (in_array($segments[0], ['home-flood-barriers', 'flood-barriers', 'residential-flood-panels', 'flood-protection-for-homes', 'driveway-flood-barriers', 'portable-flood-barriers'])) {
        $city = isset($segments[1]) ? ucwords(str_replace('-', ' ', $segments[1])) : 'Florida';
        $title = "Flood Barriers {$city}, FL | Reusable Home Protection";
        $desc = "Protect your {$city} home from flooding with FEMA-approved aluminum flood barriers. Quick installation, reusable panels, and free risk assessment.";
        $schema = "Service (FloodProtection)";
        $analysis = "Intent: Residential Protection";
    } elseif ($segments[0] == 'city' || $segments[0] == 'regions') {
        $city = isset($segments[1]) ? ucwords(str_replace('-', ' ', $segments[1])) : 'Florida';
        $title = "Flood Prevention Services in {$city} | Flood Barrier Pros";
        $desc = "Expert flood prevention services for {$city}. We install FEMA-compliant flood barriers, garage dams, and door panels. Schedule your free consultation.";
        $schema = "LocalBusiness";
        $analysis = "Intent: Local Service Find";
    } elseif ($segments[0] == 'faq') {
        $topic = isset($segments[1]) ? ucwords(str_replace('-', ' ', $segments[1])) : 'FAQ';
        $title = "{$topic} | Flood Barrier Pros Expert Guide";
        $desc = "Expert answers: {$topic}. Learn about installation, maintenance, and FEMA compliance for home flood barriers.";
        $schema = "FAQPage";
        $analysis = "Informational Query";
    } elseif ($segments[0] == 'blog' || $segments[0] == 'news') {
        $topic = isset($segments[1]) ? ucwords(str_replace('-', ' ', $segments[1])) : 'News';
        $title = "{$topic} | Flood Protection Insights";
        $desc = "Latest news and insights on {$topic}. Stay informed about flood risks and protection technologies.";
        $schema = "Article";
        $analysis = "Content/News";
    } elseif ($segments[0] == 'fl') {
        // /fl/city/product
        $city = isset($segments[1]) ? ucwords(str_replace('-', ' ', $segments[1])) : 'Florida';
        $product = isset($segments[2]) ? ucwords(str_replace('-', ' ', $segments[2])) : 'Flood Barriers';
        $title = "{$product} Installation {$city}, FL | Custom Fit";
        $desc = "Professional {$product} installation in {$city}. Custom-fitted for your property. reliable flood protection starting at $899.";
        $schema = "Service + Product";
        $analysis = "Intent: Specific Product in Location";
    } else {
        $title = "Flood Barrier Pros | Flood Protection Services";
        $desc = "Professional flood barrier systems and installation.";
        $schema = "WebPage";
    }
    
    $output .= "| `{$path}` | {$impressions} | {$ctr} | {$analysis} | **{$title}** | {$desc} | {$schema} |\n";
    $count++;
}

file_put_contents(__DIR__ . '/../SEO_ANALYSIS_AND_PLAN.md', $output);
echo "Analysis complete. Generated report with $count entries.";
