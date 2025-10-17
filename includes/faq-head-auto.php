<?php
declare(strict_types=1);

/**
 * Auto-inject FAQPage JSON-LD into <head>.
 * Uses existing Faqs::locate() and Schema::faq() from your stack.
 *
 * Usage in your head template (AFTER you set $ctx):
 *   require_once __DIR__.'/faq-head-auto.php';
 *
 * Notes:
 * - Emits nothing if no FAQs exist for the current URL.
 * - Respects Schema::emitOnce guard to avoid duplicates.
 */

require_once __DIR__.'/../lib/Faqs.php';
require_once __DIR__.'/../lib/Schema.php';

$currentUrl = $ctx['page']['url'] ?? '';
if ($currentUrl) {
  $autoFaq = [];
  // Priority: explicit $ctx['faq'] (controller-provided), else file-based per URL:
  if (!empty($ctx['faq']) && is_array($ctx['faq'])) {
    $autoFaq = $ctx['faq'];
  } else {
    $autoFaq = Faqs::locate($currentUrl);
  }

  if (!empty($autoFaq)) {
    echo Schema::faq($autoFaq); // prints a single FAQPage JSON-LD block
  }
}
