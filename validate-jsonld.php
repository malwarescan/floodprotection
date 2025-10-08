#!/usr/bin/env php
<?php
/**
 * JSON-LD Validation Script
 * 
 * This script validates the JSON-LD structured data on various pages
 * to ensure reviews are properly mapped and no errors exist.
 * 
 * Usage: php validate-jsonld.php [url]
 */

function extractJsonLd($html) {
    $pattern = '/<script type="application\/ld\+json">(.*?)<\/script>/s';
    preg_match_all($pattern, $html, $matches);
    
    $jsonLdBlocks = [];
    foreach ($matches[1] as $json) {
        $decoded = json_decode($json, true);
        if ($decoded !== null) {
            $jsonLdBlocks[] = $decoded;
        }
    }
    
    return $jsonLdBlocks;
}

function validateReviews($jsonLd, $pageName) {
    $issues = [];
    
    foreach ($jsonLd as $block) {
        if (isset($block['@graph'])) {
            foreach ($block['@graph'] as $item) {
                // Check if this is a Product with reviews
                if (isset($item['@type']) && $item['@type'] === 'Product') {
                    if (isset($item['review'])) {
                        echo "✓ Product found with reviews on $pageName\n";
                        
                        // Validate aggregateRating exists
                        if (!isset($item['aggregateRating'])) {
                            $issues[] = "Product has reviews but missing aggregateRating on $pageName";
                        } else {
                            echo "  ✓ aggregateRating: {$item['aggregateRating']['ratingValue']} ({$item['aggregateRating']['reviewCount']} reviews)\n";
                        }
                        
                        // Validate review structure
                        foreach ($item['review'] as $idx => $review) {
                            if (!isset($review['author'])) {
                                $issues[] = "Review $idx missing author on $pageName";
                            }
                            if (!isset($review['reviewRating'])) {
                                $issues[] = "Review $idx missing reviewRating on $pageName";
                            }
                            if (!isset($review['reviewBody'])) {
                                $issues[] = "Review $idx missing reviewBody on $pageName";
                            }
                        }
                        
                        echo "  ✓ " . count($item['review']) . " reviews validated\n";
                    }
                }
                
                // Check if this is an ItemList with Reviews
                if (isset($item['@type']) && $item['@type'] === 'ItemList') {
                    if (isset($item['itemListElement'])) {
                        echo "✓ ItemList found on $pageName\n";
                        
                        $reviewCount = 0;
                        foreach ($item['itemListElement'] as $listItem) {
                            if (isset($listItem['item']['@type']) && $listItem['item']['@type'] === 'Review') {
                                $reviewCount++;
                                
                                $review = $listItem['item'];
                                
                                // Validate itemReviewed
                                if (!isset($review['itemReviewed'])) {
                                    $issues[] = "Review in ItemList missing itemReviewed on $pageName";
                                } else {
                                    if (!isset($review['itemReviewed']['@type'])) {
                                        $issues[] = "itemReviewed missing @type on $pageName";
                                    }
                                    if (!isset($review['itemReviewed']['name'])) {
                                        $issues[] = "itemReviewed missing name on $pageName (THIS CAUSES 'Missing reviewed item name' ERROR)";
                                    }
                                    if (!isset($review['itemReviewed']['url'])) {
                                        $issues[] = "itemReviewed missing url on $pageName";
                                    }
                                }
                            }
                        }
                        
                        echo "  ✓ $reviewCount reviews in ItemList validated\n";
                    }
                }
                
                // Check for reviews on non-Product types (this causes errors!)
                if (isset($item['@type']) && in_array($item['@type'], ['Organization', 'Service', 'LocalBusiness', 'WebPage'])) {
                    if (isset($item['review']) || isset($item['aggregateRating'])) {
                        $issues[] = "CRITICAL: {$item['@type']} has reviews/aggregateRating on $pageName (THIS CAUSES 'Item does not support reviews' ERROR)";
                    }
                }
            }
        }
    }
    
    return $issues;
}

// Test URLs
$baseUrl = 'http://localhost:8888';
$testPages = [
    'Homepage' => '/',
    'Testimonials' => '/testimonials',
    'Product: Modular Barrier' => '/products/modular-flood-barrier',
    'Product: Garage Dam' => '/products/garage-dam-kit',
    'Product: Doorway Panel' => '/products/doorway-flood-panel',
    'Location: Naples' => '/fl/naples/modular-flood-barrier',
];

if (isset($argv[1])) {
    // Custom URL provided
    $url = $argv[1];
    $html = @file_get_contents($url);
    
    if ($html === false) {
        echo "Error: Could not fetch $url\n";
        echo "Make sure the server is running: php -S localhost:8888 -t public\n";
        exit(1);
    }
    
    $jsonLd = extractJsonLd($html);
    $issues = validateReviews($jsonLd, $url);
    
    if (empty($issues)) {
        echo "\n✓ All validations passed for $url\n";
    } else {
        echo "\n✗ Issues found:\n";
        foreach ($issues as $issue) {
            echo "  - $issue\n";
        }
    }
} else {
    // Test all pages
    echo "JSON-LD Validation Report\n";
    echo "========================\n\n";
    
    $allIssues = [];
    
    foreach ($testPages as $name => $path) {
        echo "\nTesting: $name ($path)\n";
        echo str_repeat('-', 50) . "\n";
        
        $url = $baseUrl . $path;
        $html = @file_get_contents($url);
        
        if ($html === false) {
            echo "✗ Could not fetch page\n";
            echo "  Make sure the server is running: php -S localhost:8888 -t public\n";
            continue;
        }
        
        $jsonLd = extractJsonLd($html);
        $issues = validateReviews($jsonLd, $name);
        
        if (!empty($issues)) {
            $allIssues = array_merge($allIssues, $issues);
            echo "\n✗ Issues found:\n";
            foreach ($issues as $issue) {
                echo "  - $issue\n";
            }
        }
        
        echo "\n";
    }
    
    echo "\n" . str_repeat('=', 50) . "\n";
    if (empty($allIssues)) {
        echo "✓ All validations passed! No issues found.\n";
        echo "\nNext steps:\n";
        echo "1. Deploy changes to production\n";
        echo "2. Test with Google Rich Results Test: https://search.google.com/test/rich-results\n";
        echo "3. Submit sitemap to Google Search Console\n";
        echo "4. Monitor for 2-4 weeks for review stars to appear\n";
    } else {
        echo "✗ Total issues found: " . count($allIssues) . "\n\n";
        foreach ($allIssues as $issue) {
            echo "  - $issue\n";
        }
    }
}

