<?php
require_once __DIR__.'/../lib/Schema.php';
require_once __DIR__.'/../lib/Faqs.php';
require_once __DIR__.'/../lib/Reviews.php';

/**
 * Expect $ctx array from your router/template:
 * $ctx = [
 *  'site' => ['url'=>'https://floodbarrierpros.com','name'=>'Flood Barrier Pros','logo'=>'https://.../logo.png','telephone'=>'+1-xxx','address'=>[...] ],
 *  'page' => ['url'=>..., 'name'=>..., 'description'=>..., 'inLanguage'=>'en'],
 *  'breadcrumbs' => [ ['name'=>'Home','item'=>'https://floodbarrierpros.com/'], ... ],
 *  'product' => [...],          // when on /products/*
 *  'serviceLocal' => [...],     // when on city landers
 *  'faq' => [ ['q'=>'','a'=>''], ...], // if you have real Q&A
 *  'itemList' => [ ['name'=>'','url'=>''], ... ] // for category/guide listing pages
 * ];
 */

echo Schema::organization([
  'name' => $ctx['site']['name'] ?? null,
  'url'  => $ctx['site']['url'] ?? null,
  'logo' => $ctx['site']['logo'] ?? null,
  'telephone' => $ctx['site']['telephone'] ?? null,
  'address' => $ctx['site']['address'] ?? null,
  'sameAs' => $ctx['site']['sameAs'] ?? null
]);

echo Schema::website([
  'url' => $ctx['site']['url'] ?? null,
  // Optional internal search (uncomment if present):
  // 'searchAction' => [
  //   'target' => 'https://floodbarrierpros.com/search?q={search_term_string}',
  //   'query-input' => 'required name=search_term_string'
  // ]
]);

if (!empty($ctx['breadcrumbs'])) {
  $trailId = rtrim($ctx['site']['url'] ?? '','/').'/#breadcrumb';
  echo Schema::breadcrumbs($ctx['breadcrumbs'], $trailId);
}

echo Schema::webpage($ctx['page'] ?? []);

if (!empty($ctx['product'])) {
  // If product URL matches /products/{slug}, pull reviews
  $pUrl = $ctx['product']['url'] ?? ($ctx['page']['url'] ?? '');
  if (preg_match('#/products/([^/]+)/?$#i', $pUrl, $m)) {
    $slug = strtolower($m[1]);
    $brand = $ctx['product']['brand'] ?? ($ctx['site']['name'] ?? 'Flood Barrier Pros');

    $reviews = Reviews::loadForProductSlug($slug);
    [$reviewBlocks, $agg] = Reviews::toSchemaBlocks($pUrl, (string)$brand, $reviews);

    // Attach AggregateRating to product (only if we have real reviews)
    if (!empty($agg)) {
      $ctx['product']['aggregateRating'] = $agg;
    }
    // Emit Product first (with optional aggregateRating)
    echo Schema::product($ctx['product']);

    // Emit individual Review[] as separate JSON-LD blocks (allowed)
    if (!empty($reviewBlocks)) {
      foreach ($reviewBlocks as $rb) {
        // print via Schema wrapper directly:
        echo '<script type="application/ld+json">'.json_encode(array_merge(['@context'=>'https://schema.org'], $rb), JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)."</script>\n";
      }
    }
  } else {
    // Non-product pages passed 'product' by accident—ignore reviews
    echo Schema::product($ctx['product']);
  }
}

if (!empty($ctx['serviceLocal'])) {
  echo Schema::serviceLocal($ctx['serviceLocal']);
}

if (!empty($ctx['itemList'])) {
  $id = rtrim(($ctx['page']['url'] ?? ''),'/').'#itemlist';
  echo Schema::itemList($ctx['itemList'], $id);
}

// Deep FAQ priority order:
// 1) Explicit $ctx['faq'] from controller/template
// 2) File-based match from Faqs::locate(current page URL)
// Only emit if we have content
$faqItems = [];
if (!empty($ctx['faq']) && is_array($ctx['faq'])) {
  $faqItems = $ctx['faq'];
} else {
  $pageUrl = $ctx['page']['url'] ?? '';
  if ($pageUrl) $faqItems = Faqs::locate($pageUrl);
}
if (!empty($faqItems)) echo Schema::faq($faqItems);
