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
                
                // Remove surrounding quotes from values
                if ((strpos($value, '"') === 0 && substr($value, -1) === '"') || 
                    (strpos($value, "'") === 0 && substr($value, -1) === "'")) {
                    $value = substr($value, 1, -1);
                }
                
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
    
    public static function markdownToHtml($markdown)
    {
        // Escape HTML entities first
        $html = htmlspecialchars($markdown, ENT_NOQUOTES);
        
        // Skip the first H1 (since it's already in the page header) by converting to H2
        // Match the first instance of H1
        $html = preg_replace('/^# (.+)$/m', '<h2>$1</h2>', $html, 1);
        
        // Convert remaining headers
        $html = preg_replace('/^### (.+)$/m', '<h3>$1</h3>', $html);
        $html = preg_replace('/^## (.+)$/m', '<h2>$1</h2>', $html);
        
        // Bold
        $html = preg_replace('/\*\*(.+?)\*\*/s', '<strong>$1</strong>', $html);
        
        // Italic
        $html = preg_replace('/\*(.+?)\*/s', '<em>$1</em>', $html);
        
        // Links
        $html = preg_replace('/\[([^\]]+)\]\(([^\)]+)\)/', '<a href="$2">$1</a>', $html);
        
        // Unordered lists
        $html = preg_replace_callback('/^((?:[-*+] .+\n?)+)/m', function($matches) {
            $items = preg_replace('/^[-*+] (.+)$/m', '<li>$1</li>', trim($matches[1]));
            return '<ul>' . $items . '</ul>';
        }, $html);
        
        // Ordered lists
        $html = preg_replace_callback('/^((?:\d+\. .+\n?)+)/m', function($matches) {
            $items = preg_replace('/^\d+\. (.+)$/m', '<li>$1</li>', trim($matches[1]));
            return '<ol>' . $items . '</ol>';
        }, $html);
        
        // Tables
        $html = preg_replace_callback('/^\|.+\|$/m', function($matches) {
            static $inTable = false;
            static $isHeader = true;
            
            $line = $matches[0];
            
            // Skip separator lines
            if (preg_match('/^\|[\s\-:|]+\|$/', $line)) {
                $isHeader = false;
                return '';
            }
            
            $cells = array_map('trim', explode('|', trim($line, '|')));
            $tag = $isHeader ? 'th' : 'td';
            $row = '<tr>';
            foreach ($cells as $cell) {
                $row .= "<$tag>" . trim($cell) . "</$tag>";
            }
            $row .= '</tr>';
            
            if (!$inTable) {
                $inTable = true;
                $row = '<table>' . $row;
            }
            
            if ($isHeader) {
                $isHeader = false;
                $row = str_replace('<tr>', '<thead><tr>', $row);
                $row = str_replace('</tr>', '</tr></thead><tbody>', $row);
            }
            
            return $row;
        }, $html);
        
        // Close table if needed
        if (strpos($html, '<table>') !== false && strpos($html, '</table>') === false) {
            $html = str_replace('<tbody>', '<tbody>', $html);
            $html = preg_replace('/(<\/tr>)(?!.*<\/tr>)/s', '$1</tbody></table>', $html);
        }
        
        // Code blocks (fenced with ```)
        $html = preg_replace('/```(?:\w+)?\n(.+?)```/s', '<pre><code>$1</code></pre>', $html);
        
        // Inline code
        $html = preg_replace('/`([^`]+)`/', '<code>$1</code>', $html);
        
        // Blockquotes
        $html = preg_replace('/^&gt; (.+)$/m', '<blockquote>$1</blockquote>', $html);
        
        // Horizontal rules
        $html = preg_replace('/^(---|\*\*\*|___)\s*$/m', '<hr>', $html);
        
        // Paragraphs - wrap non-tag lines
        $lines = explode("\n", $html);
        $result = [];
        $inParagraph = false;
        
        foreach ($lines as $line) {
            $trimmed = trim($line);
            
            // Check if line is already wrapped in a block element
            $isBlock = preg_match('/^<(h[1-6]|ul|ol|pre|blockquote|hr|table|tr|thead|tbody)/', $trimmed);
            $isClosing = preg_match('/^<\/(ul|ol|pre|blockquote|table|thead|tbody)>/', $trimmed);
            
            if (empty($trimmed)) {
                if ($inParagraph) {
                    $result[] = '</p>';
                    $inParagraph = false;
                }
                $result[] = '';
            } elseif ($isBlock || $isClosing) {
                if ($inParagraph) {
                    $result[] = '</p>';
                    $inParagraph = false;
                }
                $result[] = $line;
            } else {
                if (!$inParagraph) {
                    $result[] = '<p>';
                    $inParagraph = true;
                }
                $result[] = $line;
            }
        }
        
        if ($inParagraph) {
            $result[] = '</p>';
        }
        
        return implode("\n", $result);
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
    
    /**
     * Normalize URL to use www version for canonical URLs
     * Ensures all canonical URLs consistently use www.floodbarrierpros.com
     */
    public static function normalizeCanonicalUrl($url)
    {
        // If URL is relative, prepend base URL
        if (strpos($url, 'http') !== 0) {
            $url = Config::get('app_url') . $url;
        }
        
        // Normalize to www version
        $url = preg_replace('/^https?:\/\/(?!www\.)(floodbarrierpros\.com)/', 'https://www.$1', $url);
        
        return $url;
    }
}
