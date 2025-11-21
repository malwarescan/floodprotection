<?php

namespace App\Controllers;

class FaqController
{
    public function show($slug)
    {
        // Generate page metadata based on slug
        $pageData = $this->generatePageData($slug);
        
        // Use View::renderPage to include layout with Preline styling
        return \App\View::renderPage('faq', $pageData);
    }
    
    private function generatePageData($slug)
    {
        // Normalize slug (handle special characters and truncation)
        $normalizedSlug = strtolower(trim($slug));
        
        // Map slug to page metadata
        $pageMap = [
            'flood-panels-miami' => [
                'title' => 'Flood Panels Miami – FAQs & Installation Guide',
                'description' => 'Answers to Miami homeowners\' top questions about flood panels, installation, and permitting. Expert guidance for coastal flood protection.',
                'canonical' => \App\Config::get('app_url') . '/faq/flood-panels-miami'
            ],
            'clearwater-flood-protection' => [
                'title' => 'Clearwater Flood Protection – Expert FAQ Guide',
                'description' => 'Complete FAQ guide for Clearwater flood protection. Learn about barriers, installation, and storm surge protection for Tampa Bay area.',
                'canonical' => \App\Config::get('app_url') . '/faq/clearwater-flood-protection'
            ],
            'flood-barrier-installation-problems' => [
                'title' => 'Flood Barrier Installation Problems – Troubleshooting Guide',
                'description' => 'Common flood barrier installation problems and solutions. Expert troubleshooting for alignment, sealing, and anchoring issues.',
                'canonical' => \App\Config::get('app_url') . '/faq/flood-barrier-installation-problems'
            ],
            'custom-flood-panels' => [
                'title' => 'Custom Flood Panels – Sizing & Installation FAQ',
                'description' => 'Everything about custom flood panels: sizing, materials, installation, and pricing. Get answers for your specific requirements.',
                'canonical' => \App\Config::get('app_url') . '/faq/custom-flood-panels'
            ],
            'clearwater-beach-flood-protection' => [
                'title' => 'Clearwater Beach Flood Protection – Coastal FAQ Guide',
                'description' => 'Coastal flood protection FAQ for Clearwater Beach. Storm surge barriers, elevation requirements, and beachfront property protection.',
                'canonical' => \App\Config::get('app_url') . '/faq/clearwater-beach-flood-protection'
            ],
            // Handle truncated or variant slugs
            'glass-fa' => [
                'title' => 'Glass Façade Flood Protection – FAQ Guide',
                'description' => 'FAQ guide for glass façade flood protection. Learn about protecting glass buildings and storefronts from flood damage.',
                'canonical' => \App\Config::get('app_url') . '/faq/glass-facade-protection'
            ],
            'glass-facade-protection' => [
                'title' => 'Glass Façade Flood Protection – FAQ Guide',
                'description' => 'FAQ guide for glass façade flood protection. Learn about protecting glass buildings and storefronts from flood damage.',
                'canonical' => \App\Config::get('app_url') . '/faq/glass-facade-protection'
            ],
            'flood-barrier-insurance-benefits' => [
                'title' => 'Flood Barrier Insurance Benefits – FAQ Guide',
                'description' => 'Learn how flood barriers can reduce insurance premiums and provide protection benefits. Expert answers about insurance discounts.',
                'canonical' => \App\Config::get('app_url') . '/faq/flood-barrier-insurance-benefits'
            ]
        ];
        
        // Default fallback - ensure canonical is always normalized to www
        $default = [
            'title' => 'Flood Protection FAQ | ' . \App\Config::get('app_name'),
            'description' => 'Frequently asked questions about flood barriers, installation, and protection solutions in Florida.',
            'canonical' => \App\Config::get('app_url') . '/faq/' . $normalizedSlug
        ];
        
        $pageData = $pageMap[$normalizedSlug] ?? $default;
        
        // Ensure canonical is always normalized to www (double-check)
        if (isset($pageData['canonical'])) {
            $pageData['canonical'] = \App\Util::normalizeCanonicalUrl($pageData['canonical']);
        }
        
        return $pageData;
    }
    
}
