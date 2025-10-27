<?php

namespace App;

class Config
{
    public static function get($key, $default = null)
    {
        static $config = null;
        
        if ($config === null) {
            $config = [
                'app_name' => 'Flood Barrier Pros',
                'app_url' => 'https://floodbarrierpros.com',
                'app_env' => $_ENV['APP_ENV'] ?? 'production',
                'data_path' => __DIR__ . '/Data',
                'templates_path' => __DIR__ . '/Templates',
                'phone' => '+1-239-810-8761',
                'email' => 'Dylan@rubiconflood.com',
                'address' => '3729 Chiquita Blvd S',
                'city' => 'Cape Coral',
                'state' => 'FL',
                'zip' => '33914',
                'brand' => 'Rubicon Flood Control',
                'contact_name' => 'Dylan DiFalco',
                'contact_title' => 'Sales Manager',
                'google_publisher_code' => '', // Add your Reader Revenue Manager code snippet here
                'google_analytics_id' => '' // Add your Google Analytics ID from Publisher Center
            ];
        }
        
        return $config[$key] ?? $default;
    }
    
    public static function isProduction()
    {
        return self::get('app_env') === 'production';
    }
    
    public static function getDataPath($file = '')
    {
        return self::get('data_path') . ($file ? '/' . $file : '');
    }
    
    public static function getTemplatesPath($file = '')
    {
        return self::get('templates_path') . ($file ? '/' . $file : '');
    }
    
    public static function getPhoneLink()
    {
        // Return phone number formatted for tel: links (no dashes, spaces)
        return 'tel:' . preg_replace('/[^0-9+]/', '', self::get('phone'));
    }
    
    public static function getSmsLink($message = '')
    {
        // Return phone number formatted for sms: links
        $phone = preg_replace('/[^0-9+]/', '', self::get('phone'));
        $link = 'sms:' . $phone;
        if (!empty($message)) {
            $link .= '?&body=' . urlencode($message);
        }
        return $link;
    }
}
