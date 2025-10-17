#!/usr/bin/env php
<?php
declare(strict_types=1);

/**
 * Rubicon Content Validator
 *
 * Validates FAQ JSONs and Product Review JSONs used by the site.
 *
 * Usage:
 *   php /bin/validate_faqs.php
 *   php /bin/validate_faqs.php --fix --min-qa=8 --max-qa=20 --report=/tmp/faq-report.json
 *
 * Exits with code 0 on success, >0 on any error.
 */

$opts = getopt('', [
  'fix',            // pretty-print JSON files in-place
  'min-qa::',       // minimum Q&A per file (default 1)
  'max-qa::',       // maximum Q&A per file (default 50)
  'report::',       // path to write JSON report
]);

$MIN_QA = isset($opts['min-qa']) ? (int)$opts['min-qa'] : 1;
$MAX_QA = isset($opts['max-qa']) ? (int)$opts['max-qa'] : 50;
$FIX     = array_key_exists('fix', $opts);
$REPORT  = $opts['report'] ?? null;

$ROOT = realpath(__DIR__.'/..') ?: dirname(__DIR__);
$FAQ_DIRS = [
  $ROOT.'/data/faqs/pages',
  $ROOT.'/data/faqs/products',
  $ROOT.'/data/faqs/city/home-flood-barriers',
  $ROOT.'/data/faqs/city/residential-flood-panels',
];
$REVIEWS_DIR = $ROOT.'/data/reviews/products';

$allowedTags = '<p><br><ul><ol><li><strong><em><b><i><a>';
$forbiddenTagRegex = '~</?(script|iframe|object|embed|style|svg|meta|link|form|input|button|textarea|video|audio)[^>]*>~i';
$onAttrRegex = '/\son[a-z]+\s*=\s*("|\').*?\1/i';
$javascriptHrefRegex = '/href\s*=\s*("|\')\s*javascript:/i';

$errors = [];
$warnings = [];
$checkedFiles = [];

function readJsonFile(string $file): array {
  $raw = file_get_contents($file);
  if ($raw === false) throw new RuntimeException("Cannot read: $file");
  $data = json_decode($raw, true);
  if (!is_array($data)) throw new RuntimeException("Invalid JSON in $file");
  return [$data, $raw];
}
function prettyWrite(string $file, array $data): void {
  $json = json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
  file_put_contents($file, $json."\n");
}

function gatherJsonFiles(string $dir): array {
  $out = [];
  if (!is_dir($dir)) return $out;
  $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS));
  foreach ($it as $f) {
    if ($f->isFile() && preg_match('/\.json$/i', $f->getFilename())) {
      $out[] = $f->getPathname();
    }
  }
  sort($out);
  return $out;
}

function sanitizePreview(string $html, string $allowedTags): string {
  // lightweight preview of what ContentLoader::safeHtmlText would allow
  $clean = strip_tags($html, $allowedTags);
  // strip on* attributes roughly
  $clean = preg_replace('/\son[a-z]+\s*=\s*("|\').*?\1/i', '', $clean);
  // strip javascript: hrefs
  $clean = preg_replace_callback('/<a\s+[^>]*>/i', function($m){
    $tag = $m[0];
    if (preg_match('/href\s*=\s*("|\')(.*?)\1/i', $tag, $mm)) {
      $href = trim($mm[2]);
      if (stripos($href, 'javascript:') === 0) {
        // remove href attr
        $tag = preg_replace('/\s*href\s*=\s*("|\')(.*?)\1/i', '', $tag);
      }
    }
    return $tag;
  }, $clean);
  return $clean;
}

function validateAnswerHtml(string $html, string $file, int $idx, array &$errors, array &$warnings, string $allowedTags, string $forbiddenTagRegex, string $onAttrRegex, string $javascriptHrefRegex): void {
  if (preg_match($forbiddenTagRegex, $html)) {
    $errors[] = "$file [Q#".($idx+1)."] contains forbidden HTML tag (script/iframe/etc).";
  }
  if (preg_match($onAttrRegex, $html)) {
    $errors[] = "$file [Q#".($idx+1)."] contains inline event attributes (on*).";
  }
  if (preg_match($javascriptHrefRegex, $html)) {
    $errors[] = "$file [Q#".($idx+1)."] contains javascript: href.";
  }
  // Basic link shape warnings
  if (preg_match_all('/<a\s+[^>]*href\s*=\s*("|\')(.*?)\1/i', $html, $m)) {
    foreach ($m[2] as $href) {
      $href = trim($href);
      if ($href === '') {
        $warnings[] = "$file [Q#".($idx+1)."] link with empty href.";
      }
      // warn about spaces and non-http/internal schemes
      if (preg_match('/\s/', $href)) {
        $warnings[] = "$file [Q#".($idx+1)."] href contains whitespace: $href";
      }
      if (!preg_match('~^(https?://|/).*~i', $href)) {
        $warnings[] = "$file [Q#".($idx+1)."] href is not absolute http(s) or site-absolute path: $href";
      }
    }
  }
  // Simulate sanitization preview
  $preview = sanitizePreview($html, $allowedTags);
  if (trim($preview) === '') {
    $warnings[] = "$file [Q#".($idx+1)."] answer sanitized to empty; check markup.";
  }
}

function validateFaqFile(string $file, int $minQA, int $maxQA, array &$errors, array &$warnings, string $allowedTags, string $forbiddenTagRegex, string $onAttrRegex, string $javascriptHrefRegex, bool $fix): void {
  [$data, $raw] = readJsonFile($file);

  if (!is_array($data)) {
    $errors[] = "$file is not a JSON array.";
    return;
  }
  $count = count($data);
  if ($count < $minQA) $errors[] = "$file has only $count Q&A (min $minQA).";
  if ($count > $maxQA) $warnings[] = "$file has $count Q&A (exceeds max $maxQA).";

  foreach ($data as $i => $row) {
    if (!is_array($row)) {
      $errors[] = "$file [Q#".($i+1)."] entry is not an object.";
      continue;
    }
    $q = trim((string)($row['q'] ?? ''));
    $a = (string)($row['a'] ?? '');
    if ($q === '') $errors[] = "$file [Q#".($i+1)."] missing or empty 'q'.";
    if (trim(strip_tags($a)) === '') $errors[] = "$file [Q#".($i+1)."] missing or empty 'a' (text).";
    validateAnswerHtml($a, $file, $i, $errors, $warnings, $allowedTags, $forbiddenTagRegex, $onAttrRegex, $javascriptHrefRegex);
  }

  // Pretty print fix
  if ($fix) {
    prettyWrite($file, $data);
  }
}

function validateReviewFile(string $file, array &$errors, array &$warnings, bool $fix): void {
  [$data, $raw] = readJsonFile($file);
  if (!is_array($data)) { $errors[] = "$file is not a JSON array."; return; }

  foreach ($data as $i => $row) {
    if (!is_array($row)) { $errors[] = "$file [R#".($i+1)."] entry is not an object."; continue; }
    $author = trim((string)($row['author'] ?? ''));
    $body   = trim(strip_tags((string)($row['reviewBody'] ?? '')));
    $date   = trim((string)($row['datePublished'] ?? ''));
    $rating = isset($row['ratingValue']) ? (int)$row['ratingValue'] : null;

    if ($author === '') $errors[] = "$file [R#".($i+1)."] missing author.";
    if ($body === '')   $errors[] = "$file [R#".($i+1)."] missing reviewBody.";
    if ($date !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
      $warnings[] = "$file [R#".($i+1)."] datePublished not YYYY-MM-DD: '$date'";
    }
    if ($rating !== null && ($rating < 1 || $rating > 5)) {
      $errors[] = "$file [R#".($i+1)."] ratingValue out of range (1..5): $rating";
    }
  }
  if ($fix) {
    prettyWrite($file, $data);
  }
}

// Collect all files
$faqFiles = [];
foreach ($FAQ_DIRS as $d) { $faqFiles = array_merge($faqFiles, gatherJsonFiles($d)); }
$reviewFiles = gatherJsonFiles($REVIEWS_DIR);

foreach ($faqFiles as $f) {
  $checkedFiles[] = $f;
  try {
    validateFaqFile($f, $MIN_QA, $MAX_QA, $errors, $warnings, $allowedTags, $forbiddenTagRegex, $onAttrRegex, $javascriptHrefRegex, $FIX);
  } catch (Throwable $e) {
    $errors[] = "$f exception: ".$e->getMessage();
  }
}
foreach ($reviewFiles as $f) {
  $checkedFiles[] = $f;
  try {
    validateReviewFile($f, $errors, $warnings, $FIX);
  } catch (Throwable $e) {
    $errors[] = "$f exception: ".$e->getMessage();
  }
}

$report = [
  'checked'  => $checkedFiles,
  'errors'   => $errors,
  'warnings' => $warnings,
  'summary'  => [
    'files_checked' => count($checkedFiles),
    'faq_files'     => count($faqFiles),
    'review_files'  => count($reviewFiles),
    'error_count'   => count($errors),
    'warning_count' => count($warnings),
    'min_qa'        => $MIN_QA,
    'max_qa'        => $MAX_QA,
    'fixed'         => (bool)$FIX,
    'timestamp'     => date('c'),
  ],
];

if ($REPORT) {
  @file_put_contents($REPORT, json_encode($report, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)."\n");
}

// Console output
echo "Rubicon Content Validator\n";
echo "Checked ".count($checkedFiles)." files (FAQ: ".count($faqFiles).", Reviews: ".count($reviewFiles).")\n";
if ($errors) {
  echo "ERRORS (".count($errors)."):\n";
  foreach ($errors as $e) echo "  - $e\n";
}
if ($warnings) {
  echo "WARNINGS (".count($warnings)."):\n";
  foreach ($warnings as $w) echo "  - $w\n";
}
if (!$errors && !$warnings) {
  echo "All good ✅\n";
}

exit($errors ? 1 : 0);
