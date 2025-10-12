<?php

namespace App;

class Util
{
    public static function slugify($text)
    {
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
        $text = preg_replace('/[\s-]+/', '-', $text);
        return trim($text, '-');
    }
    
    public static function truncate($text, $length = 160, $suffix = '...')
    {
        if (strlen($text) <= $length) {
            return $text;
        }
        
        return substr($text, 0, $length - strlen($suffix)) . $suffix;
    }
    
    public static function formatDate($date, $format = 'Y-m-d')
    {
        if (is_string($date)) {
            $date = new \DateTime($date);
        }
        
        return $date->format($format);
    }
    
    public static function getCsvData($file)
    {
        $data = [];
        $filePath = Config::getDataPath($file);
        
        if (!file_exists($filePath)) {
            return $data;
        }
        
        $handle = fopen($filePath, 'r');
        if ($handle === false) {
            return $data;
        }
        
        $headers = fgetcsv($handle, 0, ',', '"', '\\');
        if ($headers === false) {
            fclose($handle);
            return $data;
        }
        
        while (($row = fgetcsv($handle, 0, ',', '"', '\\')) !== false) {
            $data[] = array_combine($headers, $row);
        }
        
        fclose($handle);
        return $data;
    }
    
    public static function findMatrixRow($keyword, $city)
    {
        $data = self::getCsvData('matrix.csv');
        
        foreach ($data as $row) {
            if (self::slugify($row['keyword']) === $keyword && 
                self::slugify($row['city']) === $city) {
                return $row;
            }
        }
        
        return null;
    }
    
    public static function getResourcesByTopic($topic, $city = null)
    {
        $data = self::getCsvData('resources.csv');
        $filtered = [];
        
        foreach ($data as $row) {
            if (self::slugify($row['topic']) === $topic) {
                if ($city === null || self::slugify($row['city']) === $city) {
                    $filtered[] = $row;
                }
            }
        }
        
        return $filtered;
    }
    
    public static function getBlogPosts($limit = null)
    {
        $posts = [];
        $blogPath = Config::getDataPath('blog');
        
        if (!is_dir($blogPath)) {
            return $posts;
        }
        
        $files = glob($blogPath . '/*.md');
        usort($files, function($a, $b) {
            return filemtime($b) - filemtime($a);
        });
        
        if ($limit) {
            $files = array_slice($files, 0, $limit);
        }
        
        foreach ($files as $file) {
            $content = file_get_contents($file);
            $post = self::parseMarkdownFrontMatter($content);
            $post['slug'] = basename($file, '.md');
            $post['file'] = $file;
            $posts[] = $post;
        }
        
        return $posts;
    }
    
    public static function getNewsArticles($limit = null)
    {
        $articles = [];
        $newsPath = Config::getDataPath('news');
        
        if (!is_dir($newsPath)) {
            return $articles;
        }
        
        $files = glob($newsPath . '/*.md');
        usort($files, function($a, $b) {
            return filemtime($b) - filemtime($a);
        });
        
        if ($limit) {
            $files = array_slice($files, 0, $limit);
        }
        
        foreach ($files as $file) {
            $content = file_get_contents($file);
            $article = self::parseMarkdownFrontMatter($content);
            $article['slug'] = basename($file, '.md');
            $article['file'] = $file;
            $articles[] = $article;
        }
        
        return $articles;
    }
    
    public static function parseMarkdownFrontMatter($content)
    {
        $parts = preg_split('/^---\s*$/m', $content, 3);
        
        if (count($parts) < 3) {
            return [
                'title' => 'Untitled',
                'description' => '',
                'date' => date('Y-m-d'),
                'tags' => [],
                'city' => '',
                'county' => '',
                'content' => $content
            ];
        }
        
        $frontMatter = $parts[1];
        $content = $parts[2];
        
        $data = [];
        $lines = explode("\n", $frontMatter);
        
        foreach ($lines as $line) {
            if (strpos($line, ':') !== false) {
                list($key, $value) = explode(':', $line, 2);
                $key = trim($key);
                $value = trim($value);
                
                if ($key === 'tags' && strpos($value, '[') === 0) {
                    $value = json_decode($value, true) ?: [];
                }
                
                $data[$key] = $value;
            }
        }
        
        $data['content'] = $content;
        
        return array_merge([
            'title' => 'Untitled',
            'description' => '',
            'date' => date('Y-m-d'),
            'tags' => [],
            'city' => '',
            'county' => '',
            'content' => ''
        ], $data);
    }
    
    public static function getSitemapUrls()
    {
        $urls = [];
        $data = self::getCsvData('matrix.csv');
        
        foreach ($data as $row) {
            $urls[] = [
                'url' => Config::get('app_url') . $row['url_path'],
                'lastmod' => $row['lastmod'] ?? date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.8'
            ];
        }
        
        return $urls;
    }
    
    /**
     * Get nearby cities for internal linking (alphabetical neighbors)
     */
    public static function getNearbyCities(string $currentCity, int $limit = 6): array
    {
        $data = self::getCsvData('matrix.csv');
        $cities = [];
        
        // Extract unique cities
        foreach ($data as $row) {
            $city = $row['city'] ?? '';
            if ($city && !isset($cities[$city])) {
                $cities[$city] = [
                    'name' => $city,
                    'url' => $row['url_path'] ?? '',
                    'county' => $row['county'] ?? ''
                ];
            }
        }
        
        // Sort alphabetically
        ksort($cities);
        $cityNames = array_keys($cities);
        
        // Find current city index
        $currentIndex = array_search($currentCity, $cityNames);
        if ($currentIndex === false) {
            // City not found, return first N
            return array_slice(array_values($cities), 0, $limit);
        }
        
        // Get neighbors (before and after current city)
        $nearby = [];
        $half = (int)floor($limit / 2);
        
        for ($i = $currentIndex - $half; $i <= $currentIndex + $half; $i++) {
            if ($i >= 0 && $i < count($cityNames) && $cityNames[$i] !== $currentCity) {
                $nearby[] = $cities[$cityNames[$i]];
            }
        }
        
        // Fill remaining with next cities if needed
        while (count($nearby) < $limit && count($nearby) < count($cities) - 1) {
            $nextIndex = $currentIndex + count($nearby) + 1;
            if ($nextIndex < count($cityNames)) {
                $nearby[] = $cities[$cityNames[$nextIndex]];
            } else {
                break;
            }
        }
        
        return array_slice($nearby, 0, $limit);
    }
    
    /**
     * Get related services in the same city for internal linking
     */
    public static function getRelatedServices(string $currentCity, string $currentKeyword, int $limit = 5): array
    {
        $data = self::getCsvData('matrix.csv');
        $services = [];
        
        foreach ($data as $row) {
            $city = $row['city'] ?? '';
            $keyword = $row['keyword'] ?? '';
            
            // Same city, different service
            if ($city === $currentCity && $keyword !== $currentKeyword) {
                $services[] = [
                    'keyword' => $keyword,
                    'url' => $row['url_path'] ?? '',
                    'title' => $row['h1'] ?? $keyword
                ];
            }
        }
        
        return array_slice($services, 0, $limit);
    }
}
