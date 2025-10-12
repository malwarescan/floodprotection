#!/usr/bin/env php
<?php
/**
 * Comprehensive SEO Audit Tool
 * Crawls all URLs and validates title, meta, canonical, content, schema, URL hygiene, and style
 */

require __DIR__ . '/lib/Http.php';
require __DIR__ . '/lib/Html.php';
require __DIR__ . '/lib/SchemaAudit.php';
require __DIR__ . '/lib/Heuristics.php';
require __DIR__ . '/lib/Report.php';

use AuditLib\Http;
use AuditLib\Html;
use AuditLib\SchemaAudit;
use AuditLib\Heuristics;
use AuditLib\Report;

$cfg = require __DIR__ . '/../config/audit.config.php';
$site = rtrim($cfg['site_url'], '/');

@mkdir(__DIR__ . '/../reports', 0777, true);

echo "=== SEO Audit Tool ===\n\n";
echo "Site: $site\n";
echo "Collecting URLs from sitemaps...\n";

function collectUrls(array $cfg, string $site): array
{
    $urls = [];
    
    foreach ($cfg['sitemap_paths'] as $sp) {
        $u = $site . $sp;
        echo "  Fetching: $u\n";
        
        $res = Http::get($u, $cfg['http']);
        
        if ($res['code'] >= 200 && $res['code'] < 400 && strpos($res['ctype'], 'xml') !== false) {
            preg_match_all('~<loc>(.*?)</loc>~i', $res['body'], $m);
            foreach ($m[1] ?? [] as $loc) {
                $urls[] = trim($loc);
            }
            echo "    Found: " . count($m[1] ?? []) . " URLs\n";
        } else {
            echo "    Failed: HTTP {$res['code']}\n";
        }
    }
    
    $seed = __DIR__ . '/../seed/extra_urls.txt';
    if (file_exists($seed)) {
        foreach (file($seed) as $line) {
            $line = trim($line);
            if ($line && $line[0] !== '#') {
                $urls[] = $line;
            }
        }
    }
    
    $urls = array_values(array_unique($urls));
    sort($urls);
    
    return $urls;
}

$urls = collectUrls($cfg, $site);
echo "\nTotal URLs to audit: " . count($urls) . "\n";
echo "Starting audit...\n\n";

$rows = [];
$shinglesIndex = [];
$weights = $cfg['scoring'];
$processed = 0;

foreach ($urls as $url) {
    $processed++;
    if ($processed % 10 == 0) {
        echo "  Progress: $processed/" . count($urls) . "\r";
    }
    
    $r = [
        'url' => $url,
        'page_type' => '',
        'title' => '',
        'title_len' => 0,
        'meta_desc_len' => 0,
        'canonical' => '',
        'word_count' => 0,
        'h2' => 0,
        'media' => 0,
        'schema_types' => '',
        'schema_issues' => '',
        'url_issues' => '',
        'style_issues' => '',
        'ok_title' => 0,
        'ok_meta' => 0,
        'ok_canonical' => 0,
        'ok_content' => 0,
        'ok_schema' => 0,
        'ok_url' => 0,
        'ok_style' => 0,
        'score' => 0,
        'notes' => ''
    ];

    $http = Http::get($url, $cfg['http']);
    
    if ($http['code'] < 200 || $http['code'] >= 400 || !$http['body']) {
        $r['notes'] = "HTTP {$http['code']} {$http['error']}";
        $rows[] = finish($r, $weights);
        continue;
    }

    $x = Html::dom($http['body']);
    $r['page_type'] = Heuristics::pageType($url, $site);

    // Title & meta
    $title = Html::text($x, '//title');
    $desc = Html::attr($x, '//meta[translate(@name,"ABCDEFGHIJKLMNOPQRSTUVWXYZ","abcdefghijklmnopqrstuvwxyz")="description"]', 'content');
    
    $r['title'] = $title ?? '';
    $r['title_len'] = mb_strlen($r['title']);
    $r['meta_desc_len'] = $desc ? mb_strlen($desc) : 0;
    $r['ok_title'] = ($r['title_len'] >= $cfg['title']['min'] && $r['title_len'] <= $cfg['title']['max']);
    $r['ok_meta'] = ($r['meta_desc_len'] >= $cfg['meta_description']['min'] && $r['meta_desc_len'] <= $cfg['meta_description']['max']);

    // Canonical
    $canon = Html::attr($x, '//link[translate(@rel,"ABCDEFGHIJKLMNOPQRSTUVWXYZ","abcdefghijklmnopqrstuvwxyz")="canonical"]', 'href');
    $r['canonical'] = $canon ?: '';
    $canonOk = false;
    
    if ($canon) {
        $canonOk = (stripos($canon, 'https://') === 0) && (rtrim($canon, '/') === rtrim($url, '/'));
    }
    
    $r['ok_canonical'] = $canonOk ? 1 : 0;

    // Content depth
    $r['word_count'] = Html::mainContentWords($x);
    $r['h2'] = Html::count($x, '//h2');
    $r['media'] = Html::count($x, '//img|//video|//figure');
    
    $contentOk = ($r['word_count'] >= $cfg['content']['min_words'] && 
                  $r['h2'] >= $cfg['content']['min_h2'] && 
                  $r['media'] >= $cfg['content']['min_media']);

    // FAQ requirement by type
    $needsFaq = in_array($r['page_type'], $cfg['content']['faq_required_for']);
    $hasFaq = Html::count($x, '//script[@type="application/ld+json" and contains(., "FAQPage")]') > 0;
    
    if ($needsFaq && !$hasFaq) {
        $contentOk = false;
    }

    // Schema
    $jsonlds = Html::extractJsonLd($x);
    $typesPresent = [];
    
    foreach ($jsonlds as $ld) {
        $typesPresent = array_merge($typesPresent, SchemaAudit::classify($ld));
    }
    
    $typesPresent = array_values(array_unique($typesPresent));
    $r['schema_types'] = implode(',', $typesPresent);

    $reqTypes = [];
    if ($r['page_type'] === 'homepage') $reqTypes = $cfg['schema']['homepage_required'];
    if ($r['page_type'] === 'city') $reqTypes = $cfg['schema']['city_required'];
    if ($r['page_type'] === 'service') $reqTypes = $cfg['schema']['service_required'];
    if ($r['page_type'] === 'product') $reqTypes = $cfg['schema']['product_required'];
    if ($r['page_type'] === 'article') $reqTypes = $cfg['schema']['article_required'];

    $missingTypes = array_diff($reqTypes, $typesPresent);
    $propIssues = SchemaAudit::validateByType($jsonlds, $cfg['schema']);
    
    $schemaOk = (empty($missingTypes) && empty($propIssues));
    $schemaNotes = [];
    
    if ($missingTypes) $schemaNotes[] = 'Missing types: ' . implode(', ', $missingTypes);
    if ($propIssues) $schemaNotes[] = implode(' | ', $propIssues);
    
    $r['schema_issues'] = implode(' || ', $schemaNotes);

    // URL hygiene
    $urlIssues = Heuristics::urlIssues($url, $cfg['url']);
    $r['url_issues'] = implode(' | ', $urlIssues);
    $urlOk = empty($urlIssues);

    // Style consistency
    $styleIssues = [];
    
    foreach ($cfg['style']['require_css'] as $css) {
        if (strpos($http['body'], $css) === false) {
            $styleIssues[] = "Missing CSS: $css";
        }
    }
    
    $vars = Html::collectCssVars($http['body']);
    foreach ($cfg['style']['require_tokens'] as $t) {
        if (!in_array($t, $vars)) {
            $styleIssues[] = "Missing CSS var: $t";
        }
    }
    
    foreach ($cfg['style']['require_partials_markers'] as $m) {
        if (strpos($http['body'], $m) === false) {
            $styleIssues[] = "Missing marker: $m";
        }
    }
    
    $r['style_issues'] = implode(' | ', $styleIssues);
    $styleOk = empty($styleIssues);

    // Duplication (shingling) - sample only to avoid memory issues
    if (count($shinglesIndex) < 100) {
        $clean = Html::stripBoiler($http['body']);
        $sh = Heuristics::shingles($clean, $cfg['duplication']['shingle_n']);
        $dupNote = '';
        
        foreach ($shinglesIndex as $otherUrl => $otherSh) {
            $jac = Heuristics::jaccard($sh, $otherSh);
            if ($jac > $cfg['duplication']['max_jaccard']) {
                $dupNote = "High similarity vs " . basename($otherUrl) . " (J=" . round($jac, 2) . ")";
                $contentOk = false;
                break;
            }
        }
        
        $shinglesIndex[$url] = $sh;
    }

    $r['ok_content'] = $contentOk ? 1 : 0;
    $r['ok_schema'] = $schemaOk ? 1 : 0;
    $r['ok_url'] = $urlOk ? 1 : 0;
    $r['ok_style'] = $styleOk ? 1 : 0;

    // Notes
    $notes = [];
    if (isset($dupNote) && $dupNote) $notes[] = $dupNote;
    if (!$r['ok_title']) $notes[] = "Title {$r['title_len']} chars (want {$cfg['title']['min']}-{$cfg['title']['max']})";
    if (!$r['ok_meta']) $notes[] = "Meta {$r['meta_desc_len']} chars (want {$cfg['meta_description']['min']}-{$cfg['meta_description']['max']})";
    if (!$r['ok_canonical']) $notes[] = "Canonical issue";
    if (!$r['ok_content']) $notes[] = "Content: {$r['word_count']} words, {$r['h2']} H2s, {$r['media']} media";
    if (!$r['ok_schema']) $notes[] = $r['schema_issues'] ?: "Schema missing";
    if (!$r['ok_url']) $notes[] = $r['url_issues'];
    if (!$r['ok_style']) $notes[] = $r['style_issues'];
    
    $r['notes'] = implode(' || ', array_filter($notes));

    $rows[] = finish($r, $weights);
}

echo "\n\nGenerating reports...\n";

$csv = __DIR__ . '/../reports/seo_audit_latest.csv';
$md = __DIR__ . '/../reports/seo_audit_latest.md';

Report::csv($csv, $rows);

$summary = [
    'Scanned URLs' => count($rows),
    'Generated' => gmdate('Y-m-d H:i:s') . ' UTC',
    'Site' => $site
];

Report::md($md, $summary, $rows);

echo "\n✅ Audit complete!\n";
echo "   CSV: $csv\n";
echo "   MD:  $md\n";
echo "   URLs audited: " . count($rows) . "\n\n";

// Quick summary
$totalScore = 0;
$perfect = 0;
$good = 0;
$needsWork = 0;

foreach ($rows as $r) {
    $totalScore += $r['score'];
    if ($r['score'] >= 90) $perfect++;
    elseif ($r['score'] >= 70) $good++;
    else $needsWork++;
}

$avgScore = count($rows) > 0 ? round($totalScore / count($rows), 1) : 0;

echo "Summary:\n";
echo "  Average Score: $avgScore/100\n";
echo "  Perfect (≥90): $perfect\n";
echo "  Good (70-89): $good\n";
echo "  Needs Work (<70): $needsWork\n\n";

function finish(array $r, array $weights): array
{
    $parts = [
        'title' => (bool)$r['ok_title'],
        'meta' => (bool)$r['ok_meta'],
        'canonical' => (bool)$r['ok_canonical'],
        'content' => (bool)$r['ok_content'],
        'schema' => (bool)$r['ok_schema'],
        'url' => (bool)$r['ok_url'],
        'style' => (bool)$r['ok_style']
    ];
    
    $r['score'] = Report::score($weights, $parts);
    return $r;
}

