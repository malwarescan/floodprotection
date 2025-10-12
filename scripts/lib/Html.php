<?php

namespace AuditLib;

class Html
{
    public static function dom(string $html): \DOMXPath
    {
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html, LIBXML_NOWARNING | LIBXML_NOERROR);
        libxml_clear_errors();
        return new \DOMXPath($dom);
    }

    public static function text(\DOMXPath $x, string $xpath): ?string
    {
        $n = $x->query($xpath)->item(0);
        return $n ? trim($n->textContent) : null;
    }

    public static function attr(\DOMXPath $x, string $xpath, string $attr): ?string
    {
        $n = $x->query($xpath)->item(0);
        return $n && $n->attributes && $n->attributes->getNamedItem($attr)
            ? trim($n->attributes->getNamedItem($attr)->nodeValue)
            : null;
    }

    public static function extractJsonLd(\DOMXPath $x): array
    {
        $nodes = $x->query('//script[@type="application/ld+json"]');
        $out = [];
        
        foreach ($nodes as $n) {
            $raw = trim($n->textContent);
            if (!$raw) continue;
            
            $jsons = self::splitPossiblyConcatenatedJson($raw);
            foreach ($jsons as $j) {
                $data = json_decode($j, true);
                if ($data) $out[] = $data;
            }
        }
        
        return $out;
    }

    private static function splitPossiblyConcatenatedJson(string $raw): array
    {
        $raw = trim($raw);
        if ($raw === '') return [];
        if ($raw[0] === '[') return [$raw];
        
        // Sometimes multiple objects concatenated
        if (strpos($raw, '}{') !== false) {
            $parts = preg_split('/}\s*{/', $raw);
            $jsons = [];
            foreach ($parts as $i => $p) {
                if ($i === 0) {
                    $jsons[] = $p . '}';
                } elseif ($i === count($parts) - 1) {
                    $jsons[] = '{' . $p;
                } else {
                    $jsons[] = '{' . $p . '}';
                }
            }
            return $jsons;
        }
        
        return [$raw];
    }

    public static function mainContentWords(\DOMXPath $x): int
    {
        // Exclude header/footer/nav
        $xp = '//main|//article|//div[contains(@class,"content") or contains(@class,"prose") or contains(@class,"container")]';
        $nodes = $x->query($xp);
        $txt = '';
        
        foreach ($nodes as $n) {
            $txt .= ' ' . preg_replace('/\s+/', ' ', $n->textContent ?? '');
        }
        
        $txt = trim($txt);
        return $txt ? str_word_count($txt) : 0;
    }

    public static function count(\DOMXPath $x, string $xp): int
    {
        return $x->query($xp)->length;
    }

    public static function collectCssVars(string $html): array
    {
        preg_match_all('/--[a-z0-9\-]+\s*:/i', $html, $m);
        return array_unique(array_map(fn($s) => trim(rtrim($s, ':')), $m[0] ?? []));
    }

    public static function stripBoiler(string $html): string
    {
        // Crude boilerplate removal for shingling
        $html = preg_replace('~<(header|nav|footer|script|style)[\s\S]*?</\1>~i', ' ', $html);
        $text = strip_tags($html);
        return strtolower(preg_replace('/\s+/', ' ', $text));
    }
}

