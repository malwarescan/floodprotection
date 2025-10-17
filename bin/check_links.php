#!/usr/bin/env php
<?php
declare(strict_types=1);

/**
 * Rubicon Broken Link Checker
 *
 * - Loads a sitemap.xml or sitemap index (URL or local file)
 * - Crawls listed pages (GET)
 * - Extracts internal links: <a href>, <img src>, <script src>, <link href>, CSS url()
 * - HEAD-checks each internal URL (fallback to tiny GET when HEAD isn't allowed)
 * - Skips external links by default (configurable)
 * - Outputs a CSV report with status codes and errors
 *
 * Usage examples:
 *   php bin/check_links.php --base=https://floodbarrierpros.com --sitemap=https://floodbarrierpros.com/sitemap.xml
 *   php bin/check_links.php --base=https://floodbarrierpros.com --sitemap=/var/www/public/sitemap.xml --out=var/link-report.csv
 *   php bin/check_links.php --base=https://floodbarrierpros.com --sitemap=sitemap.xml --concurrency=20 --timeout=12 --include="/^\\/faq\\//"
 *
 * Exit codes: 0 = OK (no hard errors), 1 = found broken links or runtime error
 */

ini_set('memory_limit', '1024M');

$opts = getopt('', [
  'base:',        // required: site origin, e.g. https://example.com
  'sitemap:',     // required: URL or absolute path to sitemap.xml or index
  'out::',        // optional: CSV path (default ./link-report.csv)
  'concurrency::',// optional: curl multi concurrency (default 16)
  'timeout::',    // optional: per request timeout seconds (default 10)
  'retries::',    // optional: retry count for 5xx/timeouts (default 1)
  'skip-external::', // optional: 1/0 (default 1)
  'include::',    // optional: regex to include only matching page paths
  'exclude::',    // optional: regex to exclude page paths
  'paths-only::', // optional: 1/0 (if 1, do not parse HTML; only check URLs from sitemap)
]);

/* ---------- Config ---------- */
$BASE = rtrim($opts['base'] ?? '', '/');
$SITEMAP = $opts['sitemap'] ?? '';
if (!$BASE || !$SITEMAP) {
  fwrite(STDERR, "Usage: php bin/check_links.php --base=https://site --sitemap=/path/or/url [--out=report.csv]\n");
  exit(1);
}
$OUT_CSV = $opts['out'] ?? getcwd().'/link-report.csv';
$CONCURRENCY = max(1, (int)($opts['concurrency'] ?? 16));
$TIMEOUT = max(2, (int)($opts['timeout'] ?? 10));
$RETRIES = max(0, (int)($opts['retries'] ?? 1));
$SKIP_EXTERNAL = !isset($opts['skip-external']) || (string)$opts['skip-external'] === '1';
$INCLUDE_RE = isset($opts['include']) ? trim((string)$opts['include']) : '';
$EXCLUDE_RE = isset($opts['exclude']) ? trim((string)$opts['exclude']) : '';
$PATHS_ONLY = isset($opts['paths-only']) && (string)$opts['paths-only'] === '1';

$UA = 'RubiconLinkChecker/1.0 (+link-audit)';
$OK_PAGE_CODES = [200, 201, 202, 203, 204, 206, 301, 302, 303, 304, 307, 308];
$OK_ASSET_CODES = [200, 204, 206, 301, 302, 303, 304, 307, 308];

/* ---------- Helpers ---------- */
function isUrl(string $s): bool { return (bool)preg_match('~^https?://~i', $s); }
function fetch(string $urlOrPath, int $timeout, string $ua): array {
  if (isUrl($urlOrPath)) {
    $ch = curl_init($urlOrPath);
    curl_setopt_array($ch, [
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_MAXREDIRS      => 5,
      CURLOPT_CONNECTTIMEOUT => $timeout,
      CURLOPT_TIMEOUT        => $timeout,
      CURLOPT_USERAGENT      => $ua,
      CURLOPT_SSL_VERIFYPEER => true,
      CURLOPT_SSL_VERIFYHOST => 2,
      CURLOPT_HTTPHEADER     => ['Accept: */*'],
    ]);
    $body = curl_exec($ch);
    $err  = curl_error($ch);
    $code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return [$code, $body ?: '', $err ?: ''];
  } else {
    if (!is_file($urlOrPath)) return [0, '', "File not found: $urlOrPath"];
    $body = @file_get_contents($urlOrPath);
    return [200, $body !== false ? $body : '', $body === false ? 'read_error' : ''];
  }
}
function parseXmlUrls(string $xml): array {
  $urls = [];
  libxml_use_internal_errors(true);
  $doc = simplexml_load_string($xml);
  if (!$doc) return $urls;

  $ns = $doc->getNamespaces(true);
  // sitemap index?
  if (isset($doc->sitemap)) {
    foreach ($doc->sitemap as $sm) {
      $loc = trim((string)$sm->loc);
      if ($loc) $urls[] = $loc;
    }
    return ['__INDEX__' => $urls];
  }
  // urlset
  foreach ($doc->url as $u) {
    $loc = trim((string)$u->loc);
    if ($loc) $urls[] = $loc;
  }
  return $urls;
}
function normalizeUrl(string $base, string $maybe, bool $stripHash = true): ?string {
  $maybe = trim($maybe);
  if ($maybe === '') return null;
  // skip mailto, tel, javascript, data
  if (preg_match('~^(mailto:|tel:|javascript:|data:)~i', $maybe)) return null;
  // fragments
  if ($stripHash) $maybe = preg_replace('~#.*$~', '', $maybe);

  if (preg_match('~^https?://~i', $maybe)) return $maybe;
  if (strpos($maybe, '//') === 0) return 'https:'.$maybe;

  // site-absolute path
  if (strpos($maybe, '/') === 0) return $base.$maybe;

  // relative path: resolve
  // default resolve to base root
  $u = parse_url($base);
  if (!$u) return null;
  $root = $u['scheme'].'://'.$u['host'].(isset($u['port'])?':'.$u['port']:'');
  // treat as relative to root for sitemap-discovered pages; within page parsing we'll resolve against page URL instead
  return $root.'/'.ltrim($maybe, './');
}
function sameHost(string $base, string $url): bool {
  $a = parse_url($base); $b = parse_url($url);
  return isset($a['host'], $b['host']) && strtolower($a['host']) === strtolower($b['host']);
}
function htmlExtractLinks(string $html, string $pageUrl): array {
  $out = [];
  // href/src in <a>, <img>, <script>, <link>
  if (preg_match_all('~<(a|img|script|link)\b[^>]*(href|src)\s*=\s*([\'"])(.*?)\3~i', $html, $m, PREG_SET_ORDER)) {
    foreach ($m as $row) {
      $tag = strtolower($row[1]); $attr = strtolower($row[2]); $val = trim($row[4]);
      $url = resolveAgainst($pageUrl, $val);
      if ($url) $out[] = ['type'=>$tag, 'url'=>$url];
    }
  }
  // CSS url(...)
  if (preg_match_all('~url\(\s*([\'"]?)([^)\'"]+)\1\s*\)~i', $html, $m2, PREG_SET_ORDER)) {
    foreach ($m2 as $row) {
      $val = trim($row[2]);
      $url = resolveAgainst($pageUrl, $val);
      if ($url) $out[] = ['type'=>'css', 'url'=>$url];
    }
  }
  // de-dup
  $seen = [];
  $res = [];
  foreach ($out as $o) {
    $k = $o['type'].'|'.$o['url'];
    if (!isset($seen[$k])) { $seen[$k]=1; $res[]=$o; }
  }
  return $res;
}
function resolveAgainst(string $pageUrl, string $ref): ?string {
  $ref = trim($ref);
  if ($ref === '' || preg_match('~^(mailto:|tel:|javascript:|data:)~i', $ref)) return null;
  $ref = preg_replace('~#.*$~', '', $ref);
  if (preg_match('~^https?://~i', $ref)) return $ref;
  if (strpos($ref, '//') === 0) return 'https:'.$ref;

  $p = parse_url($pageUrl);
  if (!$p || !isset($p['scheme'], $p['host'])) return null;
  $scheme = $p['scheme']; $host = $p['host']; $port = isset($p['port'])?':'.$p['port']:'';
  $basePath = isset($p['path']) ? $p['path'] : '/';
  if (substr($ref,0,1) === '/') {
    return $scheme.'://'.$host.$port.$ref;
  }
  // relative
  $dir = rtrim(dirname($basePath), '/\\');
  if ($dir === '') $dir = '/';
  $full = $scheme.'://'.$host.$port.$dir.'/'.$ref;
  // normalize ../ and ./
  $parts = explode('/', parse_url($full, PHP_URL_PATH) ?? '/');
  $stack = [];
  foreach ($parts as $part) {
    if ($part === '' || $part === '.') continue;
    if ($part === '..') array_pop($stack);
    else $stack[] = $part;
  }
  $path = '/'.implode('/', $stack);
  return $scheme.'://'.$host.$port.$path;
}
function headOrTinyGet(array $urls, int $timeout, string $ua, int $retries): array {
  // Multi HEAD
  $results = multiRequest($urls, 'HEAD', $timeout, $ua);
  // Fallback GET for 405/501/0
  $fallback = [];
  foreach ($results as $u => $r) {
    $code = $r['code'];
    if ($code === 0 || $code === 405 || $code === 501) $fallback[$u] = $u;
  }
  if ($fallback) {
    $tiny = multiRequest(array_keys($fallback), 'GET', $timeout, $ua, true);
    foreach ($tiny as $u => $r) { $results[$u] = $r; }
  }
  // Retries for 5xx/timeouts
  if ($retries > 0) {
    $retrySet = [];
    foreach ($results as $u=>$r) {
      if ($r['code'] === 0 || ($r['code'] >= 500 && $r['code'] <= 599)) $retrySet[] = $u;
    }
    if ($retrySet) {
      $retry = multiRequest($retrySet, 'HEAD', $timeout, $ua);
      foreach ($retry as $u=>$r) $results[$u] = $r;
    }
  }
  return $results;
}
function multiRequest(array $urls, string $method, int $timeout, string $ua, bool $rangeGet=false): array {
  global $CONCURRENCY;
  $res = [];
  $chunks = array_chunk(array_values($urls), $CONCURRENCY);
  foreach ($chunks as $chunk) {
    $mh = curl_multi_init();
    $map = [];
    foreach ($chunk as $u) {
      $ch = curl_init($u);
      $headers = ['Accept: */*'];
      if ($rangeGet) $headers[] = 'Range: bytes=0-0';
      curl_setopt_array($ch, [
        CURLOPT_NOBODY        => ($method === 'HEAD'),
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_RETURNTRANSFER=> true,
        CURLOPT_FOLLOWLOCATION=> true,
        CURLOPT_MAXREDIRS     => 5,
        CURLOPT_CONNECTTIMEOUT=> $timeout,
        CURLOPT_TIMEOUT       => $timeout,
        CURLOPT_USERAGENT     => $ua,
        CURLOPT_SSL_VERIFYPEER=> true,
        CURLOPT_SSL_VERIFYHOST=> 2,
        CURLOPT_HEADER        => true,
        CURLOPT_HTTPHEADER    => $headers,
      ]);
      curl_multi_add_handle($mh, $ch);
      $map[(int)$ch] = $u;
    }
    do {
      $status = curl_multi_exec($mh, $active);
      curl_multi_select($mh, 0.5);
    } while ($active && $status == CURLM_OK);

    foreach ($map as $hid => $u) {
      $chList = array_keys($map);
      foreach ($chList as $k) { /* noop */ }
      $ch = null;
      foreach ($map as $key => $urlv) {
        if ($urlv === $u) {
          foreach ($chunk as $candidate) { /* noop */ }
        }
      }
    }
    // fetch in a safer loop
    foreach ($map as $id => $u) {
      $ch = null;
      foreach ($chunk as $candidate) { /* noop */ }
      // We can't access handle by id directly; iterate handles
    }
    // Workaround: track again
    foreach ($chunk as $u2) { /* noop */ }

    // Better: iterate through handles using curl_multi_info_read
    while ($info = curl_multi_info_read($mh)) {
      $ch = $info['handle'];
      $u  = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL) ?: 'unknown';
      $header = curl_multi_getcontent($ch);
      $err = curl_error($ch);
      $code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
      $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL) ?: '';
      $res[$u] = [
        'code' => $code,
        'final_url' => $finalUrl,
        'error' => $err,
      ];
      curl_multi_remove_handle($mh, $ch);
      curl_close($ch);
    }
    curl_multi_close($mh);
  }
  return $res;
}

/* ---------- Load sitemap(s) ---------- */
echo "Loading sitemap: $SITEMAP\n";
[$code, $xml, $err] = fetch($SITEMAP, $TIMEOUT, $UA);
if ($code && $code >= 400) { fwrite(STDERR, "Sitemap HTTP $code\n"); exit(1); }
if ($err) { fwrite(STDERR, "Sitemap fetch error: $err\n"); exit(1); }
$parsed = parseXmlUrls($xml);
$sitemapUrls = [];

if (is_array($parsed) && isset($parsed['__INDEX__'])) {
  foreach ($parsed['__INDEX__'] as $smurl) {
    echo "  → Loading child sitemap: $smurl\n";
    [$c, $x, $e] = fetch($smurl, $TIMEOUT, $UA);
    if ($e || ($c && $c >= 400)) { fwrite(STDERR, "  ❌ $smurl ($c) $e\n"); continue; }
    $u = parseXmlUrls($x);
    if (is_array($u)) $sitemapUrls = array_merge($sitemapUrls, $u);
  }
} else {
  $sitemapUrls = is_array($parsed) ? $parsed : [];
}
$sitemapUrls = array_values(array_unique(array_map(fn($u)=>rtrim($u,'/'), $sitemapUrls)));

echo "Found ".count($sitemapUrls)." page URLs in sitemap.\n";

/* ---------- Filter include/exclude ---------- */
$pages = [];
foreach ($sitemapUrls as $u) {
  if ($SKIP_EXTERNAL && !sameHost($BASE, $u)) continue;
  $path = parse_url($u, PHP_URL_PATH) ?? '/';
  if ($INCLUDE_RE && !preg_match($INCLUDE_RE, $path)) continue;
  if ($EXCLUDE_RE && preg_match($EXCLUDE_RE, $path)) continue;
  $pages[] = $u;
}
$pages = array_values(array_unique($pages));
echo "Pages to crawl after filters: ".count($pages)."\n";
if (!$pages) { echo "Nothing to do.\n"; exit(0); }

/* ---------- Crawl pages & collect internal links ---------- */
$allLinks = []; // [ [source, url, type], ... ]
if ($PATHS_ONLY) {
  foreach ($pages as $p) {
    $allLinks[] = ['source'=>$p, 'url'=>$p, 'type'=>'page'];
  }
} else {
  foreach ($pages as $p) {
    echo "GET: $p\n";
    [$pc, $body, $perr] = fetch($p, $TIMEOUT, $UA);
    if ($pc >= 400 || $perr) {
      $allLinks[] = ['source'=>$p, 'url'=>$p, 'type'=>'page'];
      continue;
    }
    $links = htmlExtractLinks($body, $p);
    // Always include the page itself for status
    $allLinks[] = ['source'=>$p, 'url'=>$p, 'type'=>'page'];
    foreach ($links as $lnk) {
      $u = $lnk['url'];
      if ($SKIP_EXTERNAL && !sameHost($BASE, $u)) continue;
      $allLinks[] = ['source'=>$p, 'url'=>rtrim($u,'/'), 'type'=>$lnk['type']];
    }
  }
}

/* ---------- De-dup & batch HEAD/GET ---------- */
$uniqueTargets = [];
foreach ($allLinks as $row) $uniqueTargets[$row['url']] = true;
$targetList = array_keys($uniqueTargets);
echo "Unique internal URLs to check: ".count($targetList)."\n";

$results = headOrTinyGet($targetList, $TIMEOUT, $UA, $RETRIES);

/* ---------- Build CSV report ---------- */
$fp = fopen($OUT_CSV, 'w');
fputcsv($fp, ['source_url','link_url','type','method','status','ok','final_url','error'], ',', '"', '\\');

$brokenCount = 0;
$byUrl = [];
foreach ($allLinks as $row) {
  $u = $row['url'];
  $type = $row['type'];
  $r = $results[$u] ?? ['code'=>0,'final_url'=>'','error'=>'not_checked'];
  $code = (int)$r['code'];
  $okSet = ($type === 'page') ? $OK_PAGE_CODES : $OK_ASSET_CODES;
  $ok = in_array($code, $okSet, true) ? '1' : '0';
  if ($ok === '0') $brokenCount++;

  // Determine method used (we don't store per-URL; infer by fallback rule)
  $method = ($code === 405 || $code === 501) ? 'GET' : 'HEAD/GET';

  fputcsv($fp, [
    $row['source'],
    $u,
    $type,
    $method,
    $code,
    $ok,
    $r['final_url'] ?? '',
    $r['error'] ?? ''
  ], ',', '"', '\\');
}
fclose($fp);

echo "Report written: $OUT_CSV\n";
echo $brokenCount ? "Broken links found: $brokenCount ❌\n" : "All links OK ✅\n";
exit($brokenCount ? 1 : 0);
