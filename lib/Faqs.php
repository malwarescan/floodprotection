<?php
declare(strict_types=1);
require_once __DIR__.'/ContentLoader.php';

final class Faqs
{
    /**
     * Resolve a FAQ file path for a given absolute URL.
     * Strategy:
     *  - Products:     /data/faqs/products/{slug}.json
     *  - City pages:   /data/faqs/city/{type}/{city}.json
     *  - Exact URL:    /data/faqs/pages/{slugified_path}.json
     *  - Fallback:     /data/faqs/default.json (optional)
     */
    public static function locate(string $absUrl): array {
        $path = parse_url($absUrl, PHP_URL_PATH) ?? '/';
        $candidates = [];

        // Products: /products/{slug}
        if (preg_match('#^/products/([^/]+)/?$#i', $path, $m)) {
            $slug = strtolower($m[1]);
            $candidates[] = __DIR__.'/../data/faqs/products/'.$slug.'.json';
        }

        // City pages:
        if (preg_match('#^/(home-flood-barriers|residential-flood-panels)/([^/]+)/?$#i', $path, $m)) {
            $type = strtolower($m[1]);       // home-flood-barriers or residential-flood-panels
            $city = strtolower($m[2]);       // city slug
            $candidates[] = __DIR__."/../data/faqs/city/{$type}/{$city}.json";
            $candidates[] = __DIR__."/../data/faqs/city/{$type}/default.json"; // type-level default (optional)
        }

        // Exact path mapping (safe slug)
        $slugged = trim(str_replace(['/','\\'], '__', trim($path, '/')), '_');
        if ($slugged !== '') {
            $candidates[] = __DIR__.'/../data/faqs/pages/'.$slugged.'.json';
        }

        // Global default (optional)
        $candidates[] = __DIR__.'/../data/faqs/default.json';

        foreach ($candidates as $f) {
            $items = ContentLoader::loadJson($f);
            if (!empty($items)) return self::normalize($items);
        }
        return [];
    }

    private static function normalize(array $rows): array {
        $out = [];
        foreach ($rows as $r) {
            if (empty($r['q']) || empty($r['a'])) continue;
            // allow long HTML answers, but sanitize
            $q = trim((string)$r['q']);
            $a = ContentLoader::safeHtmlText((string)$r['a']);
            if ($q !== '' && $a !== '') $out[] = ['q'=>$q, 'a'=>$a];
        }
        return $out;
    }
}
