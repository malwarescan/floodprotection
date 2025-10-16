<?php
declare(strict_types=1);

final class ContentLoader
{
    private static array $cache = [];

    public static function loadJson(string $absPath): array {
        if (isset(self::$cache[$absPath])) return self::$cache[$absPath];
        if (!is_file($absPath)) return self::$cache[$absPath] = [];

        $raw = file_get_contents($absPath);
        if ($raw === false || trim($raw) === '') return self::$cache[$absPath] = [];

        $data = json_decode($raw, true);
        if (!is_array($data)) return self::$cache[$absPath] = [];
        return self::$cache[$absPath] = $data;
    }

    public static function safeHtmlText(string $html): string {
        // Allow basic markup for long answers (p, br, ul/ol, li, strong, em, a)
        // but strip scripts/iframes/events.
        $allowed = '<p><br><ul><ol><li><strong><em><b><i><a>';
        $clean = strip_tags($html, $allowed);
        // Remove on* attrs
        $clean = preg_replace('/\son[a-z]+\s*=\s*"[^"]*"/i', '', $clean);
        $clean = preg_replace("/\son[a-z]+\s*=\s*'[^']*'/i", '', $clean);
        // Only allow href on <a>, remove javascript: URIs
        $clean = preg_replace_callback('/<a\s+[^>]*>/i', function($m){
            $tag = $m[0];
            // keep only href and rel, target
            $attr = [];
            if (preg_match('/href\s*=\s*"([^"]*)"/i', $tag, $hm) || preg_match("/href\s*=\s*'([^']*)'/i", $tag, $hm)) {
                $href = $hm[1];
                if (stripos($href,'javascript:') === false) $attr[] = 'href="'.htmlspecialchars($href, ENT_QUOTES).'"';
            }
            if (preg_match('/target\s*=\s*"_blank"/i', $tag)) $attr[] = 'target="_blank"';
            $attr[] = 'rel="nofollow"';
            return '<a '.implode(' ', array_unique($attr)).'>';
        }, $clean);
        return $clean;
    }
}
