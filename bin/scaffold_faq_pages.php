<?php
/**
 * FAQ Page Scaffolding Tool
 * Creates empty FAQ JSON files for planned topics
 * 
 * Usage: php bin/scaffold_faq_pages.php
 */

// Define Phase 1 cornerstone FAQ pages
$phase1_faqs = [
    'flood-panels-miami' => [
        'title' => 'Flood Panels Miami – FAQs & Installation Guide',
        'description' => 'Answers to Miami homeowners\' top questions about flood panels, installation, and permitting.'
    ],
    'clearwater-flood-protection' => [
        'title' => 'Clearwater Flood Protection – Expert FAQ Guide', 
        'description' => 'Complete FAQ guide for Clearwater flood protection. Learn about barriers, installation, and storm surge protection.'
    ],
    'flood-barrier-installation-problems' => [
        'title' => 'Flood Barrier Installation Problems – Troubleshooting Guide',
        'description' => 'Common flood barrier installation problems and solutions. Expert troubleshooting for alignment, sealing, and anchoring issues.'
    ],
    'custom-flood-panels' => [
        'title' => 'Custom Flood Panels – Sizing & Installation FAQ',
        'description' => 'Everything about custom flood panels: sizing, materials, installation, and pricing. Get answers for your specific requirements.'
    ],
    'clearwater-beach-flood-protection' => [
        'title' => 'Clearwater Beach Flood Protection – Coastal FAQ Guide',
        'description' => 'Coastal flood protection FAQ for Clearwater Beach. Storm surge barriers, elevation requirements, and beachfront property protection.'
    ]
];

// Define Phase 2 category FAQ pages
$phase2_faqs = [
    // Installation & Setup
    'flood-barrier-installation' => [
        'title' => 'Flood Barrier Installation – Complete Guide',
        'description' => 'Everything you need to know about flood barrier installation, from planning to completion.'
    ],
    'garage-flood-panel-installation' => [
        'title' => 'Garage Flood Panel Installation – Step by Step',
        'description' => 'Complete guide to garage flood panel installation, including preparation and maintenance.'
    ],
    
    // Maintenance & Failures
    'flood-panel-leak-repair' => [
        'title' => 'Flood Panel Leak Repair – Troubleshooting Guide',
        'description' => 'How to identify and repair flood panel leaks, including prevention strategies.'
    ],
    'flood-barrier-maintenance' => [
        'title' => 'Flood Barrier Maintenance – Complete Guide',
        'description' => 'Comprehensive maintenance guide for flood barriers, including schedules and procedures.'
    ],
    
    // Customization
    'doorway-flood-panel-custom' => [
        'title' => 'Custom Doorway Flood Panels – Design Guide',
        'description' => 'Everything about custom doorway flood panels, from design to installation.'
    ],
    'flood-gate-sizing' => [
        'title' => 'Flood Gate Sizing – Measurement Guide',
        'description' => 'How to properly size flood gates for your specific openings and requirements.'
    ],
    
    // Local Coverage
    'flood-barriers-sarasota' => [
        'title' => 'Flood Barriers Sarasota – Local Guide',
        'description' => 'Complete guide to flood barriers in Sarasota, including local requirements and installation.'
    ],
    'flood-protection-naples' => [
        'title' => 'Flood Protection Naples – Expert Guide',
        'description' => 'Everything about flood protection in Naples, from barriers to insurance considerations.'
    ]
];

// Define Phase 3 long-tail FAQ pages
$phase3_faqs = [
    'fema-approved-flood-barriers' => [
        'title' => 'FEMA Approved Flood Barriers – Compliance Guide',
        'description' => 'Everything about FEMA approval for flood barriers, including standards and certification requirements.'
    ],
    'flood-barriers-insurance-rates' => [
        'title' => 'Flood Barriers and Insurance Rates – Impact Guide',
        'description' => 'How flood barriers affect insurance rates, including documentation and rate reduction strategies.'
    ],
    'coastal-corrosion-resistance' => [
        'title' => 'Coastal Corrosion Resistance – Material Guide',
        'description' => 'Best materials for coastal flood barriers, including corrosion resistance and maintenance considerations.'
    ],
    'historic-homes-flood-panels' => [
        'title' => 'Historic Homes Flood Panels – Preservation Guide',
        'description' => 'Flood panel solutions for historic homes, including preservation requirements and reversible installation methods.'
    ]
];

// Create data directory
$dataDir = __DIR__ . '/../data/faqs/pages';
if (!is_dir($dataDir)) {
    mkdir($dataDir, 0755, true);
}

// Function to create empty FAQ JSON file
function createFaqFile($slug, $data) {
    global $dataDir;
    
    $filename = $dataDir . '/faq__' . $slug . '.json';
    
    if (file_exists($filename)) {
        echo "Skipping $slug - file already exists\n";
        return;
    }
    
    // Create empty FAQ structure
    $faqData = [
        [
            "q" => "Sample Question for " . $data['title'],
            "a" => "<p>This is a placeholder answer for " . $data['title'] . ". Replace this content with actual FAQ questions and answers.</p><p>Each FAQ should be comprehensive and provide valuable information to users searching for this topic.</p>"
        ]
    ];
    
    file_put_contents($filename, json_encode($faqData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    echo "Created: $filename\n";
}

// Create Phase 1 FAQ files
echo "Creating Phase 1 FAQ files...\n";
foreach ($phase1_faqs as $slug => $data) {
    createFaqFile($slug, $data);
}

// Create Phase 2 FAQ files
echo "\nCreating Phase 2 FAQ files...\n";
foreach ($phase2_faqs as $slug => $data) {
    createFaqFile($slug, $data);
}

// Create Phase 3 FAQ files
echo "\nCreating Phase 3 FAQ files...\n";
foreach ($phase3_faqs as $slug => $data) {
    createFaqFile($slug, $data);
}

echo "\nFAQ scaffolding complete!\n";
echo "Total FAQ files created: " . (count($phase1_faqs) + count($phase2_faqs) + count($phase3_faqs)) . "\n";
echo "\nNext steps:\n";
echo "1. Populate the JSON files with actual FAQ content\n";
echo "2. Test the FAQ pages at /faq/{slug}\n";
echo "3. Add internal links between FAQ and service/product pages\n";
echo "4. Monitor search performance and user engagement\n";
?>
