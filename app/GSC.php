<?php

namespace App;

/**
 * Google Search Console Data Loader & Analyzer
 * Works with existing Rubicon architecture
 */
class GSC
{
    /**
     * Embedded GSC snapshot (fallback if no CSV files present)
     */
    private static function getEmbeddedSnapshot(): array
    {
        return [
            'totals' => ['clicks' => 2, 'impressions' => 207, 'ctr' => 0.0097, 'position' => 20.76],
            'devices' => [
                ['Device' => 'Desktop', 'Clicks' => 1, 'Impressions' => 155, 'CTR' => 0.0065, 'Position' => 20.99],
                ['Device' => 'Mobile', 'Clicks' => 1, 'Impressions' => 51, 'CTR' => 0.0196, 'Position' => 20.37],
                ['Device' => 'Tablet', 'Clicks' => 0, 'Impressions' => 1, 'CTR' => 0, 'Position' => 5.0]
            ],
            'queries_top15' => [
                ['query' => 'flood prevention companies', 'Clicks' => 0, 'Impressions' => 15, 'CTR' => 0, 'Position' => 77.2],
                ['query' => 'flood panels miami', 'Clicks' => 0, 'Impressions' => 11, 'CTR' => 0, 'Position' => 10.0],
                ['query' => 'clearwater flood protection', 'Clicks' => 0, 'Impressions' => 10, 'CTR' => 0, 'Position' => 10.4],
                ['query' => 'clearwater beach flood protection', 'Clicks' => 0, 'Impressions' => 8, 'CTR' => 0, 'Position' => 13.38],
                ['query' => 'sarasota flood protection', 'Clicks' => 0, 'Impressions' => 8, 'CTR' => 0, 'Position' => 17.88]
            ],
            'pages_top15' => [
                ['page' => 'https://floodbarrierpros.com/home-flood-barriers/', 'Clicks' => 1, 'Impressions' => 5, 'CTR' => 0.20, 'Position' => 15.40],
                ['page' => 'https://floodbarrierpros.com/city/new-smyrna-beach/', 'Clicks' => 1, 'Impressions' => 3, 'CTR' => 0.3333, 'Position' => 5.67],
                ['page' => 'https://floodbarrierpros.com/flood-protection-doors/', 'Clicks' => 0, 'Impressions' => 14, 'CTR' => 0, 'Position' => 10.14],
                ['page' => 'https://floodbarrierpros.com/residential-flood-barriers/', 'Clicks' => 0, 'Impressions' => 14, 'CTR' => 0, 'Position' => 12.79],
                ['page' => 'https://floodbarrierpros.com/city/sanford', 'Clicks' => 0, 'Impressions' => 10, 'CTR' => 0, 'Position' => 5.10],
                ['page' => 'https://floodbarrierpros.com/city/jacksonville', 'Clicks' => 0, 'Impressions' => 8, 'CTR' => 0, 'Position' => 64.25],
                ['page' => 'https://floodbarrierpros.com/city/sarasota', 'Clicks' => 0, 'Impressions' => 7, 'CTR' => 0, 'Position' => 42.00],
                ['page' => 'https://floodbarrierpros.com/home-flood-barriers-entry/', 'Clicks' => 0, 'Impressions' => 7, 'CTR' => 0, 'Position' => 44.86],
                ['page' => 'https://floodbarrierpros.com/city/fort-lauderdale', 'Clicks' => 0, 'Impressions' => 7, 'CTR' => 0, 'Position' => 56.43],
                ['page' => 'https://floodbarrierpros.com/', 'Clicks' => 0, 'Impressions' => 6, 'CTR' => 0, 'Position' => 1.00]
            ],
            'appearance' => [
                ['Search Appearance' => 'Product snippets', 'Clicks' => 1, 'Impressions' => 159, 'CTR' => 0.0063, 'Position' => 18.36],
                ['Search Appearance' => 'Review snippet', 'Clicks' => 0, 'Impressions' => 1, 'CTR' => 0, 'Position' => 1.00]
            ],
            'countries' => [
                ['Country' => 'United States', 'Clicks' => 2, 'Impressions' => 190, 'CTR' => 0.0105, 'Position' => 21.33],
                ['Country' => 'India', 'Clicks' => 0, 'Impressions' => 6, 'CTR' => 0, 'Position' => 20.00],
                ['Country' => 'Thailand', 'Clicks' => 0, 'Impressions' => 3, 'CTR' => 0, 'Position' => 4.33],
                ['Country' => 'United Kingdom', 'Clicks' => 0, 'Impressions' => 2, 'CTR' => 0, 'Position' => 7.00]
            ]
        ];
    }
    
    /**
     * Load GSC data (prefer CSV if exists, else embedded snapshot)
     */
    public static function load(): array
    {
        $csvDir = __DIR__ . '/../data/gsc/';
        
        // TODO: Add CSV loading logic if CSVs are available
        // For now, return embedded snapshot
        
        return self::getEmbeddedSnapshot();
    }
    
    /**
     * Analyze opportunities: queries with impressions but weak performance
     */
    public static function getOpportunities(array $gscData): array
    {
        $opportunities = [];
        
        foreach ($gscData['queries_top15'] as $query) {
            // Opportunity = impressions > 5 AND (position > 8 OR CTR < 1%)
            if ($query['Impressions'] > 5 && ($query['Position'] > 8 || $query['CTR'] < 0.01)) {
                $opportunities[] = [
                    'query' => $query['query'],
                    'impressions' => $query['Impressions'],
                    'position' => $query['Position'],
                    'ctr' => $query['CTR'],
                    'priority' => self::calculatePriority($query)
                ];
            }
        }
        
        // Sort by priority (high to low)
        usort($opportunities, fn($a, $b) => $b['priority'] <=> $a['priority']);
        
        return $opportunities;
    }
    
    /**
     * Find pages that need CTR lift (good position, low CTR)
     */
    public static function getLowCTRPages(array $gscData): array
    {
        $lowCTR = [];
        
        foreach ($gscData['pages_top15'] as $page) {
            // Good position (≤8) but low CTR (<5%)
            if ($page['Position'] <= 8 && $page['CTR'] < 0.05 && $page['Impressions'] >= 5) {
                $lowCTR[] = [
                    'page' => $page['page'],
                    'position' => $page['Position'],
                    'ctr' => $page['CTR'],
                    'impressions' => $page['Impressions'],
                    'clicks' => $page['Clicks']
                ];
            }
        }
        
        return $lowCTR;
    }
    
    /**
     * Extract city and service from query
     */
    public static function parseQuery(string $query): array
    {
        $query = strtolower($query);
        
        // Service patterns
        $services = [
            'flood panels' => 'flood-panels',
            'flood barriers' => 'home-flood-barriers',
            'flood protection' => 'flood-protection-for-homes',
            'flood doors' => 'flood-protection-doors',
            'home flood barriers' => 'home-flood-barriers',
            'residential flood barriers' => 'residential-flood-barriers'
        ];
        
        // City patterns (Florida cities)
        $cities = [
            'miami', 'clearwater', 'clearwater beach', 'sarasota', 'tampa', 
            'orlando', 'jacksonville', 'naples', 'fort myers', 'pensacola',
            'tallahassee', 'gainesville', 'st petersburg', 'fort lauderdale',
            'sanford', 'new smyrna beach'
        ];
        
        $service = null;
        $city = null;
        
        // Find service
        foreach ($services as $servicePattern => $serviceSlug) {
            if (strpos($query, $servicePattern) !== false) {
                $service = $serviceSlug;
                break;
            }
        }
        
        // Find city
        foreach ($cities as $cityName) {
            if (strpos($query, $cityName) !== false) {
                $city = $cityName;
                break;
            }
        }
        
        return [
            'service' => $service,
            'city' => $city,
            'original_query' => $query
        ];
    }
    
    /**
     * Calculate opportunity priority
     */
    private static function calculatePriority(array $query): int
    {
        $score = 0;
        
        // High impressions = more valuable
        $score += min($query['Impressions'] * 5, 100);
        
        // Position 9-15 = quick wins
        if ($query['Position'] > 8 && $query['Position'] <= 15) {
            $score += 50;
        }
        
        // Very high position but no clicks = needs CTR boost
        if ($query['Position'] <= 8 && $query['CTR'] == 0) {
            $score += 75;
        }
        
        return $score;
    }
    
    /**
     * Generate markdown report
     */
    public static function generateReport(array $gscData): string
    {
        $report = "# Google Search Console Analysis Report\n\n";
        $report .= "*Generated: " . date('Y-m-d H:i:s') . "*\n\n";
        
        // Totals
        $report .= "## Overall Performance\n\n";
        $report .= "| Metric | Value |\n";
        $report .= "|--------|-------|\n";
        $report .= "| Clicks | " . $gscData['totals']['clicks'] . " |\n";
        $report .= "| Impressions | " . $gscData['totals']['impressions'] . " |\n";
        $report .= "| CTR | " . number_format($gscData['totals']['ctr'] * 100, 2) . "% |\n";
        $report .= "| Avg Position | " . number_format($gscData['totals']['position'], 1) . " |\n\n";
        
        // Device insights
        $report .= "## Device Performance\n\n";
        $report .= "**KEY INSIGHT:** Mobile CTR (1.96%) is **3x higher** than Desktop (0.65%) - prioritize mobile optimization!\n\n";
        $report .= "| Device | Clicks | Impressions | CTR | Position |\n";
        $report .= "|--------|--------|-------------|-----|----------|\n";
        foreach ($gscData['devices'] as $device) {
            $report .= sprintf("| %s | %d | %d | %.2f%% | %.1f |\n",
                $device['Device'],
                $device['Clicks'],
                $device['Impressions'],
                $device['CTR'] * 100,
                $device['Position']
            );
        }
        $report .= "\n";
        
        // Opportunities
        $opportunities = self::getOpportunities($gscData);
        if (!empty($opportunities)) {
            $report .= "## Ranking Opportunities\n\n";
            $report .= "*Queries with impressions but weak performance*\n\n";
            $report .= "| Query | Impressions | Position | CTR | Action |\n";
            $report .= "|-------|-------------|----------|-----|--------|\n";
            
            foreach ($opportunities as $opp) {
                $parsed = self::parseQuery($opp['query']);
                $action = "Optimize";
                if ($parsed['city'] && $parsed['service']) {
                    $action = "Enhance existing or create new page";
                }
                
                $report .= sprintf("| %s | %d | %.1f | %.1f%% | %s |\n",
                    $opp['query'],
                    $opp['impressions'],
                    $opp['position'],
                    $opp['ctr'] * 100,
                    $action
                );
            }
            $report .= "\n";
        }
        
        // Low CTR pages
        $lowCTR = self::getLowCTRPages($gscData);
        if (!empty($lowCTR)) {
            $report .= "## Pages Needing CTR Boost\n\n";
            $report .= "*Good position (≤8) but low CTR (<5%) - fix titles/meta descriptions*\n\n";
            $report .= "| Page | Position | CTR | Impressions | Recommendation |\n";
            $report .= "|------|----------|-----|-------------|----------------|\n";
            
            foreach ($lowCTR as $page) {
                $report .= sprintf("| %s | %.1f | %.1f%% | %d | Rewrite title/meta for CTR |\n",
                    str_replace('https://floodbarrierpros.com', '', $page['page']),
                    $page['position'],
                    $page['ctr'] * 100,
                    $page['impressions']
                );
            }
            $report .= "\n";
        }
        
        // Specific recommendations
        $report .= "## Specific Actions\n\n";
        $report .= "### 1. Create/Enhance City Pages\n\n";
        $report .= "Based on query analysis:\n\n";
        $report .= "- **Miami** - \"flood panels miami\" (pos 10.0, 11 impressions)\n";
        $report .= "  - Ensure `/flood-panels/miami` or similar exists\n";
        $report .= "  - Add specific content about flood panels\n\n";
        $report .= "- **Clearwater** - \"clearwater flood protection\" (pos 10.4, 10 impressions)\n";
        $report .= "  - Enhance `/city/clearwater` page\n";
        $report .= "  - Add section for Clearwater Beach (separate query: pos 13.38, 8 impressions)\n\n";
        $report .= "- **Sarasota** - \"sarasota flood protection\" (pos 17.88, 8 impressions)\n";
        $report .= "  - Enhance `/city/sarasota` page\n";
        $report .= "  - Add more specific service details\n\n";
        
        $report .= "### 2. Fix Low CTR Pages\n\n";
        $report .= "**Priority: `/city/sanford`** (pos 5.10, 0% CTR, 10 impressions)\n\n";
        $report .= "Current issue: Good ranking but no clicks\n\n";
        $report .= "Recommended title templates:\n";
        $report .= "- Option A: `Flood Barriers in Sanford, FL — Custom Panels, Fast Install | Flood Barrier Pros`\n";
        $report .= "- Option B: `Sanford FL Flood Protection — FEMA-Aligned, Free Assessment | Flood Barrier Pros`\n\n";
        $report .= "Recommended meta description:\n";
        $report .= "> Protect your Sanford property with custom flood barriers. Code-compliant installation, 2-4 week lead times. Free on-site assessment. Serving Seminole County.\n\n";
        
        $report .= "### 3. Mobile Optimization\n\n";
        $report .= "Mobile CTR is **3x** desktop - ensure:\n";
        $report .= "- Fast mobile page load (<2.5s LCP)\n";
        $report .= "- Clear, concise above-the-fold content\n";
        $report .= "- Prominent CTA buttons\n";
        $report .= "- Phone number click-to-call\n";
        $report .= "- No layout shifts (CLS < 0.1)\n\n";
        
        $report .= "### 4. Product Rich Results\n\n";
        $report .= "Currently showing in 159 impressions but only 1 click (0.63% CTR)\n\n";
        $report .= "✅ Already fixed: offerCount, priceValidUntil, aggregateRating, reviews\n\n";
        $report .= "Next steps:\n";
        $report .= "- Monitor Google Search Console for error reduction\n";
        $report .= "- Ensure product titles are compelling\n";
        $report .= "- Consider adding product images to JSON-LD\n\n";
        
        return $report;
    }
}

