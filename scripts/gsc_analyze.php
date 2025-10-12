#!/usr/bin/env php
<?php
/**
 * Google Search Console Analysis Script
 * Generates actionable recommendations based on GSC data
 */

require_once __DIR__ . '/../app/GSC.php';
require_once __DIR__ . '/../app/Config.php';
require_once __DIR__ . '/../app/Util.php';

use App\GSC;

echo "=== Google Search Console Analysis ===\n\n";

// Load GSC data
echo "Loading GSC data...\n";
$gscData = GSC::load();

// Generate report
echo "Analyzing performance...\n";
$report = GSC::generateReport($gscData);

// Save report
$reportPath = __DIR__ . '/../reports/gsc_recommendations.md';
$reportsDir = dirname($reportPath);

if (!is_dir($reportsDir)) {
    mkdir($reportsDir, 0755, true);
}

file_put_contents($reportPath, $report);

echo "\n✅ Report generated: $reportPath\n\n";

// Display summary
echo "=== Quick Summary ===\n\n";

$totals = $gscData['totals'];
echo "Performance:\n";
echo "  Clicks: {$totals['clicks']}\n";
echo "  Impressions: {$totals['impressions']}\n";
echo "  CTR: " . number_format($totals['ctr'] * 100, 2) . "%\n";
echo "  Avg Position: " . number_format($totals['position'], 1) . "\n\n";

// Show opportunities
$opportunities = GSC::getOpportunities($gscData);
echo "Top Opportunities ({count($opportunities)} found):\n";
foreach (array_slice($opportunities, 0, 5) as $i => $opp) {
    echo "  " . ($i + 1) . ". \"{$opp['query']}\" - Pos {$opp['position']}, {$opp['impressions']} impressions\n";
}
echo "\n";

// Show low CTR pages
$lowCTR = GSC::getLowCTRPages($gscData);
if (!empty($lowCTR)) {
    echo "Pages Needing CTR Boost ({count($lowCTR)} found):\n";
    foreach ($lowCTR as $page) {
        $url = str_replace('https://floodbarrierpros.com', '', $page['page']);
        echo "  • $url - Pos {$page['position']}, CTR " . number_format($page['ctr'] * 100, 1) . "%\n";
    }
    echo "\n";
}

echo "📄 Full report: reports/gsc_recommendations.md\n\n";

// Check for missing pages
echo "=== Missing Page Analysis ===\n\n";

$matrixFile = __DIR__ . '/../app/Data/matrix.csv';
if (file_exists($matrixFile)) {
    $matrix = array_map(fn($line) => str_getcsv($line, ',', '"', '\\'), file($matrixFile));
    $headers = array_shift($matrix);
    
    echo "Checking for pages mentioned in GSC that might not exist...\n\n";
    
    foreach ($opportunities as $opp) {
        $parsed = GSC::parseQuery($opp['query']);
        
        if ($parsed['city'] && $parsed['service']) {
            // Check if page exists in matrix
            $found = false;
            foreach ($matrix as $row) {
                $rowData = array_combine($headers, $row);
                if (stripos($rowData['url_path'] ?? '', $parsed['city']) !== false &&
                    stripos($rowData['url_path'] ?? '', $parsed['service']) !== false) {
                    $found = true;
                    break;
                }
            }
            
            if (!$found) {
                echo "⚠️  Query: \"{$opp['query']}\"\n";
                echo "    Suggested: /{$parsed['service']}/{$parsed['city']}\n";
                echo "    Status: Not found in matrix - consider creating\n\n";
            } else {
                echo "✅ Query: \"{$opp['query']}\" - Page exists, needs optimization\n\n";
            }
        }
    }
}

echo "\nAnalysis complete!\n";

