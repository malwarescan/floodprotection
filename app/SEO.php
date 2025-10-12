<?php

namespace App;

/**
 * SEO Meta Templates
 * Server-rendered titles and descriptions optimized for CTR
 */
class SEO
{
    /**
     * Homepage title
     */
    public static function homepageTitle(): string
    {
        return Config::get('app_name') . ' | Flood Barriers & Home Flood Protection';
    }
    
    /**
     * Homepage description
     */
    public static function homepageDesc(): string
    {
        return 'FEMA-aligned flood barrier systems for homes and businesses. Florida, Texas & Arizona coverage. Free on-site assessment.';
    }
    
    /**
     * City + Service page title
     */
    public static function titleCityService(string $service, string $city, string $state = 'FL'): string
    {
        return "{$service} in {$city}, {$state} | Flood Barriers & Protection | " . Config::get('app_name');
    }
    
    /**
     * City + Service page description
     */
    public static function descCityService(string $service, string $city, string $state = 'FL'): string
    {
        return "Install and service {$service} in {$city}, {$state}. FEMA-aligned specs, fast lead times, professional installation. Free on-site assessment.";
    }
    
    /**
     * CTR-optimized title for Sanford (good position, needs clicks)
     */
    public static function titleSanford(): string
    {
        return 'Flood Barriers in Sanford, FL — Custom Panels, Fast Install | ' . Config::get('app_name');
    }
    
    /**
     * CTR-optimized description for Sanford
     */
    public static function descSanford(): string
    {
        return 'Protect your Sanford property with custom flood barriers. Code-compliant installation, 2-4 week lead times. Free on-site assessment. Serving Seminole County.';
    }
    
    /**
     * Blog article title
     */
    public static function titleBlogArticle(string $title): string
    {
        return $title . ' | ' . Config::get('app_name');
    }
    
    /**
     * Resource page title
     */
    public static function titleResource(string $title): string
    {
        return $title . ' | Resources | ' . Config::get('app_name');
    }
}

