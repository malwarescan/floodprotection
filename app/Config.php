<?php

namespace App;

class Config
{
    public static function get($key, $default = null)
    {
        static $config = null;
        
        if ($config === null) {
            $config = [
                'app_name' => 'Rubicon Flood Protection',
                'app_url' => 'https://rubiconfloodprotection.com',
                'app_env' => $_ENV['APP_ENV'] ?? 'production',
                'data_path' => __DIR__ . '/Data',
                'templates_path' => __DIR__ . '/Templates',
                'phone' => '+1 (844) 555-0172',
                'address' => '1234 Barrier Way',
                'zip' => '33101',
                'brand' => 'Rubicon Flood Protection'
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
