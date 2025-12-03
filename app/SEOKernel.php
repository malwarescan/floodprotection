<?php

namespace App;

/**
 * SEO ABSOLUTE STANDARD v1 - Kernel Enforcement
 * 
 * Enforces universal, non-negotiable SEO and technical baseline
 * across every page, every template, every environment.
 */
class SEOKernel
{
    private static $violations = [];
    private static $warnings = [];
    
    /**
     * Validate all kernel rules for a page
     * 
     * @param array $pageData Page data including title, description, canonical, etc.
     * @param string $html Rendered HTML output
     * @param array $schema Structured data array
     * @return array ['valid' => bool, 'violations' => [], 'warnings' => []]
     */
    public static function validatePage($pageData, $html, $schema = [])
    {
        self::$violations = [];
        self::$warnings = [];
        
        // I. Canonical Integrity
        self::validateCanonicalIntegrity($pageData, $html);
        
        // II. SSR/CSR Consistency
        self::validateSSRConsistency($html);
        
        // III. Critical Request Survival
        self::validateRequestSurvival($html);
        
        // IV. Structured Data Kernel
        self::validateStructuredData($schema, $pageData);
        
        // V. Head Tag Kernel
        self::validateHeadTags($html, $pageData);
        
        // VI. Content Structure
        self::validateContentStructure($html);
        
        // VII. Internal Linking
        self::validateInternalLinking($html);
        
        // VIII. Performance/Crawlability
        self::validatePerformance($html);
        
        // IX. Log/Console (checked during runtime)
        // X. Ontological Truth (enforced by structure)
        
        $isValid = empty(self::$violations);
        
        return [
            'valid' => $isValid,
            'violations' => self::$violations,
            'warnings' => self::$warnings,
            'score' => self::calculateScore()
        ];
    }
    
    /**
     * I. Canonical Integrity Rules
     */
    private static function validateCanonicalIntegrity($pageData, $html)
    {
        $canonical = $pageData['canonical'] ?? null;
        
        if (!$canonical) {
            self::$violations[] = 'I.1: Missing canonical URL';
            return;
        }
        
        // Rule 1: Must be self-referencing
        if (!self::isSelfReferencing($canonical, $pageData['url'] ?? '')) {
            self::$violations[] = 'I.1: Canonical is not self-referencing';
        }
        
        // Rule 2: Must be SSR-generated (check if present in raw HTML)
        if (stripos($html, '<link rel="canonical"') === false) {
            self::$violations[] = 'I.2: Canonical not found in SSR markup';
        }
        
        // Rule 4: og:url must match canonical
        preg_match('/property="og:url"\s+content="([^"]+)"/i', $html, $ogUrl);
        if (!empty($ogUrl[1]) && $ogUrl[1] !== $canonical) {
            self::$violations[] = 'I.4: og:url does not match canonical exactly';
        }
        
        // Check structured data URLs
        if (!empty($pageData['schema'])) {
            self::validateSchemaUrls($pageData['schema'], $canonical);
        }
    }
    
    /**
     * II. SSR/CSR Consistency Enforcement
     */
    private static function validateSSRConsistency($html)
    {
        // Check for hydration-dependent patterns
        if (preg_match('/display:\s*none.*h[1-6]/i', $html)) {
            self::$violations[] = 'II.4: Using display:none on semantic headings';
        }
        
        // Check for conditional rendering that might not appear in SSR
        if (preg_match('/v-if|v-show|ng-if|ng-show|conditional.*render/i', $html)) {
            self::$warnings[] = 'II.3: Potential conditional rendering detected';
        }
        
        // Check for client-only blocks
        if (preg_match('/client-only|no-ssr|v-cloak/i', $html)) {
            self::$violations[] = 'II.3: Client-only blocks detected in SSR output';
        }
    }
    
    /**
     * III. Critical Request Survival Kernel
     */
    private static function validateRequestSurvival($html)
    {
        // Check for blocking API calls
        if (preg_match('/axios\.(get|post).*\.then\(/i', $html)) {
            self::$warnings[] = 'III.1: Potential blocking API calls detected';
        }
        
        // Check for unhandled promise rejections
        if (preg_match('/\.catch\s*\(\s*\)/i', $html)) {
            self::$warnings[] = 'III.2: Empty catch blocks may not handle failures';
        }
    }
    
    /**
     * IV. Structured Data Kernel
     */
    private static function validateStructuredData($schema, $pageData)
    {
        if (empty($schema)) {
            self::$violations[] = 'IV.2: Missing structured data';
            return;
        }
        
        $completeness = self::calculateSchemaCompleteness($schema, $pageData);
        
        if ($completeness < 90) {
            self::$violations[] = "IV.6: Schema completeness {$completeness}% < 90% threshold";
        }
        
        // Check for required schemas
        $hasWebPage = false;
        $hasContextual = false;
        
        if (is_array($schema)) {
            foreach ($schema as $item) {
                if (isset($item['@type']) && $item['@type'] === 'WebPage') {
                    $hasWebPage = true;
                }
                if (isset($item['@type']) && in_array($item['@type'], ['Product', 'Article', 'BlogPosting', 'FAQPage', 'Service'])) {
                    $hasContextual = true;
                }
            }
        }
        
        if (!$hasWebPage) {
            self::$violations[] = 'IV.3: Missing WebPage schema';
        }
        
        if (!$hasContextual) {
            self::$warnings[] = 'IV.3: Missing contextual schema (Product, Article, etc.)';
        }
    }
    
    /**
     * V. Head Tag Kernel
     */
    private static function validateHeadTags($html, $pageData)
    {
        // Check for required meta tags in raw HTML
        $required = ['title', 'description', 'canonical'];
        
        foreach ($required as $tag) {
            if ($tag === 'canonical') {
                if (stripos($html, '<link rel="canonical"') === false) {
                    self::$violations[] = "V.3: Missing {$tag} in SSR head";
                }
            } elseif ($tag === 'title') {
                if (stripos($html, '<title>') === false) {
                    self::$violations[] = "V.3: Missing {$tag} in SSR head";
                }
            } elseif ($tag === 'description') {
                if (stripos($html, 'name="description"') === false) {
                    self::$violations[] = "V.3: Missing {$tag} in SSR head";
                }
            }
        }
        
        // Check for script-injected meta tags (should not exist in SSR)
        if (preg_match('/document\.(createElement|querySelector).*meta/i', $html)) {
            self::$violations[] = 'V.1: Script-injected meta tags detected';
        }
    }
    
    /**
     * VI. Content Structure Rules
     */
    private static function validateContentStructure($html)
    {
        // Count headings
        preg_match_all('/<h1[^>]*>(.*?)<\/h1>/i', $html, $h1s);
        preg_match_all('/<h2[^>]*>(.*?)<\/h2>/i', $html, $h2s);
        preg_match_all('/<h3[^>]*>(.*?)<\/h3>/i', $html, $h3s);
        
        $h1Count = count($h1s[0]);
        $h2Count = count($h2s[0]);
        $h3Count = count($h3s[0]);
        
        if ($h1Count !== 1) {
            self::$violations[] = "VI.1: Expected 1 H1, found {$h1Count}";
        }
        
        if ($h2Count < 2 || $h2Count > 6) {
            self::$warnings[] = "VI.1: H2 count ({$h2Count}) outside recommended 2-6 range";
        }
        
        if ($h3Count > 0 && ($h3Count < 2 || $h3Count > 6)) {
            self::$warnings[] = "VI.1: H3 count ({$h3Count}) outside recommended 2-6 range";
        }
        
        // Check for FAQ section
        if (stripos($html, 'faq') === false && stripos($html, 'frequently asked') === false) {
            self::$warnings[] = 'VI.2: No FAQ section detected';
        }
        
        // Check for internal links
        preg_match_all('/<a[^>]+href=["\']([^"\']+)["\'][^>]*>/i', $html, $links);
        $internalLinks = array_filter($links[1], function($url) {
            return strpos($url, 'http') !== 0 || strpos($url, Config::get('app_url')) === 0;
        });
        
        if (count($internalLinks) < 3) {
            self::$warnings[] = 'VI.2: Insufficient internal links (< 3)';
        }
    }
    
    /**
     * VII. Internal Linking Kernel
     */
    private static function validateInternalLinking($html)
    {
        // Check for JS-only links
        if (preg_match('/onclick.*window\.location|href.*javascript:/i', $html)) {
            self::$violations[] = 'VII.5: JS-only links detected';
        }
        
        // Check for proper anchor tags
        preg_match_all('/<a[^>]+href=["\']([^"\']+)["\'][^>]*>/i', $html, $links);
        if (empty($links[1])) {
            self::$warnings[] = 'VII.4: No internal links found (potential orphan page)';
        }
    }
    
    /**
     * VIII. Performance / Crawlability Kernel
     */
    private static function validatePerformance($html)
    {
        // Check for blocking scripts
        if (preg_match('/<script[^>]*(?!async|defer)[^>]*src/i', $html)) {
            self::$warnings[] = 'VIII.1: Potential blocking scripts detected';
        }
        
        // Check for hydration blockers
        if (preg_match('/hydration.*block|block.*hydration/i', $html)) {
            self::$violations[] = 'VIII.5: Hydration blockers detected';
        }
    }
    
    /**
     * Calculate schema completeness score
     */
    private static function calculateSchemaCompleteness($schema, $pageData)
    {
        $required = ['@type', 'url', 'name'];
        $score = 0;
        $maxScore = 0;
        
        if (is_array($schema)) {
            foreach ($schema as $item) {
                if (is_array($item)) {
                    foreach ($required as $field) {
                        $maxScore += 10;
                        if (isset($item[$field]) && !empty($item[$field])) {
                            $score += 10;
                        }
                    }
                }
            }
        }
        
        return $maxScore > 0 ? round(($score / $maxScore) * 100) : 0;
    }
    
    /**
     * Validate schema URLs match canonical
     */
    private static function validateSchemaUrls($schema, $canonical)
    {
        if (is_array($schema)) {
            foreach ($schema as $item) {
                if (isset($item['url']) && $item['url'] !== $canonical) {
                    self::$violations[] = 'I.4: Schema URL does not match canonical';
                }
            }
        }
    }
    
    /**
     * Check if canonical is self-referencing
     */
    private static function isSelfReferencing($canonical, $currentUrl)
    {
        // Normalize URLs for comparison
        $canonical = rtrim($canonical, '/');
        $currentUrl = rtrim($currentUrl, '/');
        
        return $canonical === $currentUrl || 
               str_replace(Config::get('app_url'), '', $canonical) === str_replace(Config::get('app_url'), '', $currentUrl);
    }
    
    /**
     * Calculate overall validation score
     */
    private static function calculateScore()
    {
        $violationPenalty = count(self::$violations) * 10;
        $warningPenalty = count(self::$warnings) * 2;
        
        return max(0, 100 - $violationPenalty - $warningPenalty);
    }
    
    /**
     * Block deployment if violations exist
     * 
     * @throws \Exception if violations found
     */
    public static function enforceDeploymentBlock($pageData, $html, $schema = [])
    {
        $result = self::validatePage($pageData, $html, $schema);
        
        if (!$result['valid']) {
            $message = "DEPLOYMENT BLOCKED: SEO Kernel violations detected:\n\n";
            foreach ($result['violations'] as $violation) {
                $message .= "  ❌ {$violation}\n";
            }
            if (!empty($result['warnings'])) {
                $message .= "\nWarnings:\n";
                foreach ($result['warnings'] as $warning) {
                    $message .= "  ⚠️  {$warning}\n";
                }
            }
            
            throw new \Exception($message);
        }
        
        return $result;
    }
    
    /**
     * Get validation report
     */
    public static function getReport($pageData, $html, $schema = [])
    {
        $result = self::validatePage($pageData, $html, $schema);
        
        return [
            'status' => $result['valid'] ? 'PASS' : 'FAIL',
            'score' => $result['score'],
            'violations' => $result['violations'],
            'warnings' => $result['warnings'],
            'summary' => [
                'total_violations' => count($result['violations']),
                'total_warnings' => count($result['warnings']),
                'canonical_ok' => !in_array('I.1', array_map(fn($v) => substr($v, 0, 3), $result['violations'])),
                'schema_ok' => !in_array('IV.', array_map(fn($v) => substr($v, 0, 3), $result['violations'])),
                'structure_ok' => !in_array('VI.', array_map(fn($v) => substr($v, 0, 3), $result['violations']))
            ]
        ];
    }
}

