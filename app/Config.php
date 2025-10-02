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
                'phone' => '+1-239-330-8888',
                'email' => 'Dylan@rubiconflood.com',
                'address' => '3729 Chiquita Blvd S',
                'city' => 'Cape Coral',
                'state' => 'FL',
                'zip' => '33914',
                'brand' => 'Rubicon Flood Control',
                'contact_name' => 'Dylan DiFalco',
                'contact_title' => 'Sales Manager'
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
}
