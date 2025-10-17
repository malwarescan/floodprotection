<?php
declare(strict_types=1);

/**
 * Renders FAQ Q&A as accessible accordions.
 * Uses the same Faqs::locate() so visual content matches the JSON-LD.
 *
 * Usage in your page template (BODY):
 *   <?php require_once __DIR__.'/faq-render.php'; render_faq_section($ctx); ?>
 */

require_once __DIR__.'/../lib/Faqs.php';

function render_faq_section(array $ctx): void {
  $pageUrl = $ctx['page']['url'] ?? '';
  if (!$pageUrl) return;

  $items = [];
  if (!empty($ctx['faq']) && is_array($ctx['faq'])) {
    $items = $ctx['faq'];
  } else {
    $items = Faqs::locate($pageUrl);
  }
  if (empty($items)) return;

  // Basic styles are utility-friendly; tweak in your CSS/Tailwind if you prefer
  echo '<section class="faq-section max-w-3xl mx-auto px-4 py-10" aria-labelledby="faq-heading">';
  echo '<h2 id="faq-heading" class="text-2xl md:text-3xl font-semibold mb-6">Frequently Asked Questions</h2>';

  echo '<div class="divide-y divide-gray-200">';
  $i = 0;
  foreach ($items as $qa) {
    $i++;
    $qid = 'faq-q-'.$i;
    $aid = 'faq-a-'.$i;
    $q = htmlspecialchars($qa['q'], ENT_QUOTES);
    // 'a' is already sanitized by Faqs::locate() via ContentLoader::safeHtmlText()
    $a = $qa['a'];

    echo '<div class="py-4">';
    echo '  <button type="button" class="w-full text-left flex items-start justify-between gap-4 focus:outline-none" aria-controls="'.$aid.'" aria-expanded="false" id="'.$qid.'">';
    echo '    <span class="font-medium text-lg">'.$q.'</span>';
    echo '    <span class="shrink-0" aria-hidden="true">+</span>';
    echo '  </button>';
    echo '  <div id="'.$aid.'" role="region" aria-labelledby="'.$qid.'" class="hidden mt-3 text-gray-700 leading-relaxed">';
    echo        $a; // sanitized HTML
    echo '  </div>';
    echo '</div>';
  }
  echo '</div>';
  echo '</section>';

  // Small progressive enhancement script (no framework required)
  ?>
  <script>
    (function () {
      const items = document.querySelectorAll('.faq-section button[aria-controls]');
      items.forEach(btn => {
        btn.addEventListener('click', () => {
          const targetId = btn.getAttribute('aria-controls');
          const panel = document.getElementById(targetId);
          const expanded = btn.getAttribute('aria-expanded') === 'true';
          btn.setAttribute('aria-expanded', String(!expanded));
          panel.classList.toggle('hidden', expanded);
          // toggle icon
          const icon = btn.querySelector('span[aria-hidden="true"]');
          if (icon) icon.textContent = expanded ? '+' : '–';
        });
      });
    })();
  </script>
  <?php
}
