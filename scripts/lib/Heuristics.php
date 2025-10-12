<?php

namespace AuditLib;

class Heuristics
{
    public static function pageType(string $url, string $site): string
    {
        $p = parse_url($url, PHP_URL_PATH) ?: '/';
        
        if ($p === '/') return 'homepage';
        if (preg_match('~/(city|locations?)/~i', $p)) return 'city';
        if (preg_match('~/(service|services)/~i', $p)) return 'service';
        if (preg_match('~/(product|products)/~i', $p)) return 'product';
        if (preg_match('~/(blog|news|resources|insights)/~i', $p)) return 'article';
        if (preg_match('~/(home\-flood|flood\-protection|flood\-panels|flood\-barriers|portable|driveway)~i', $p)) return 'service';
        
        return 'generic';
    }

    public static function urlIssues(string $url, array $cfg): array
    {
        $issues = [];
        $p = parse_url($url);
        
        if (!$p || empty($p['path'])) {
            return ['unparseable URL'];
        }
        
        $path = $p['path'];

        if (!empty($cfg['lowercase']) && $path !== strtolower($path)) {
            $issues[] = 'URL not lowercase';
        }
        
        if (!empty($cfg['kebab']) && preg_match('~[ _]~', $path)) {
            $issues[] = 'URL not kebab-case';
        }
        
        if (!empty($cfg['force_trailing_slash']) && substr($path, -1) !== '/') {
            $issues[] = 'Missing trailing slash';
        }
        
        if (!empty($cfg['no_querystring']) && !empty($p['query'])) {
            $issues[] = 'Querystring present';
        }
        
        if (!empty($cfg['max_len']) && strlen($url) > $cfg['max_len']) {
            $issues[] = 'URL too long';
        }
        
        return $issues;
    }

    public static function shingles(string $text, int $n = 3): array
    {
        $words = preg_split('/\s+/', trim($text));
        $sh = [];
        
        for ($i = 0; $i <= count($words) - $n; $i++) {
            $sh[] = implode(' ', array_slice($words, $i, $n));
        }
        
        return array_unique($sh);
    }

    public static function jaccard(array $a, array $b): float
    {
        if (!$a || !$b) return 0.0;
        
        $ia = array_intersect($a, $b);
        $ua = array_unique(array_merge($a, $b));
        
        return count($ia) / max(1, count($ua));
    }
}

