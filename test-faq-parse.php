<?php
$content = file_get_contents(__DIR__ . '/app/Data/blog/2025-09-29-epic-flood-barrier-fail-st-pete.md');

// Parse FAQs
preg_match('/## Frequently Asked Questions\s*\n(.*?)(?=\n##|\z)/s', $content, $matches);

if (empty($matches[1])) {
    echo "No FAQ section found\n";
    exit;
}

$faqSection = $matches[1];
echo "=== FAQ Section ===\n";
echo $faqSection;
echo "\n\n";

// Parse FAQ items - split on ### headers
$faqItems = preg_split('/\n### /', $faqSection);

echo "=== Parsed FAQs ===\n";
foreach ($faqItems as $item) {
    // Skip if empty
    if (trim($item) === '') continue;
    
    // Split on first newline to get question and answer
    $parts = preg_split('/\n/', $item, 2);
    
    if (count($parts) < 2) continue;
    
    $question = trim($parts[0]);
    $answer = trim($parts[1]);
    
    // Clean up answer
    $answer = preg_replace('/\n+/', ' ', $answer);
    $answer = preg_replace('/\s+/', ' ', $answer);
    $answer = trim($answer);
    
    echo "Q: " . $question . "\n";
    echo "A: " . $answer . "\n\n";
}

echo "Total FAQs found: " . count($faqItems) . "\n";
