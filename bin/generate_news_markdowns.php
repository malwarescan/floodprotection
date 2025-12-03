#!/usr/bin/env php
<?php

/**
 * Generate markdown files for all programmatic news articles
 */

require_once __DIR__ . '/../app/Config.php';
require_once __DIR__ . '/../app/NewsArticleGenerator.php';

$cities = [
    'fort-myers' => 'Fort Myers',
    'cape-coral' => 'Cape Coral',
    'naples' => 'Naples',
    'bonita-springs' => 'Bonita Springs',
    'estero' => 'Estero',
    'sanibel' => 'Sanibel',
    'pine-island' => 'Pine Island',
    'marco-island' => 'Marco Island',
    'sarasota' => 'Sarasota',
    'tampa' => 'Tampa',
    'st-petersburg' => 'St. Petersburg',
    'clearwater' => 'Clearwater',
    'bradenton' => 'Bradenton',
    'venice' => 'Venice',
    'port-charlotte' => 'Port Charlotte',
    'punta-gorda' => 'Punta Gorda',
    'miami' => 'Miami',
    'miami-beach' => 'Miami Beach',
    'key-west' => 'Key West',
    'key-largo' => 'Key Largo'
];

$newsPath = __DIR__ . '/../app/Data/news';
$today = date('Y-m-d');

echo "Generating markdown files for all programmatic news articles...\n\n";

foreach ($cities as $slug => $name) {
    $article = \App\NewsArticleGenerator::generateArticle($slug);
    
    if (!$article || empty($article['title'])) {
        echo "✗ Failed to generate article for {$name}\n";
        continue;
    }
    
    // Generate filename: YYYY-MM-DD-flood-barriers-{city}.md
    $filename = $today . '-flood-barriers-' . $slug . '.md';
    $filepath = $newsPath . '/' . $filename;
    
    // Build markdown content
    $markdown = "---\n";
    $markdown .= "title: \"" . addslashes($article['title']) . "\"\n";
    $markdown .= "description: \"" . addslashes($article['subtitle']) . "\"\n";
    $markdown .= "date: {$today}\n";
    $markdown .= "tags: [flood-barriers, {$slug}, swfl, flood-protection, storm-surge]\n";
    $markdown .= "city: {$name}\n";
    $markdown .= "county: {$article['county']}\n";
    $markdown .= "---\n\n";
    
    // Add title as H1
    $markdown .= "# " . $article['title'] . "\n\n";
    
    // Add subtitle
    $markdown .= "**" . $article['dateline'] . "** - " . $article['subtitle'] . "\n\n";
    
    // Convert content sections to markdown
    foreach ($article['content'] as $section) {
        if ($section['type'] === 'heading') {
            $level = str_repeat('#', $section['level'] + 1);
            $markdown .= $level . " " . $section['content'] . "\n\n";
        } elseif ($section['type'] === 'paragraph') {
            $markdown .= $section['content'] . "\n\n";
        } elseif ($section['type'] === 'list') {
            foreach ($section['items'] as $item) {
                $markdown .= "- " . $item . "\n";
            }
            $markdown .= "\n";
        }
    }
    
    // Add internal links section
    if (isset($article['internal_links'])) {
        $markdown .= "## Related Flood Protection Resources\n\n";
        
        if (isset($article['internal_links']['upward'])) {
            foreach ($article['internal_links']['upward'] as $link) {
                $markdown .= "- [" . $link['anchor'] . "](" . $link['url'] . ")\n";
            }
        }
        
        if (isset($article['internal_links']['sideways'])) {
            foreach ($article['internal_links']['sideways'] as $link) {
                $markdown .= "- [" . $link['anchor'] . "](" . $link['url'] . ")\n";
            }
        }
        
        if (isset($article['internal_links']['downward'])) {
            foreach ($article['internal_links']['downward'] as $link) {
                $markdown .= "- [" . $link['anchor'] . "](" . $link['url'] . ")\n";
            }
        }
        
        $markdown .= "\n";
    }
    
    // Write file
    file_put_contents($filepath, $markdown);
    
    echo "✓ Created: {$filename}\n";
}

echo "\nAll markdown files generated successfully!\n";
echo "Files saved to: {$newsPath}\n";

