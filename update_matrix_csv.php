<?php
/**
 * Update matrix.csv with new meta titles and descriptions from GSC recommendations
 */

require_once __DIR__ . '/app/Config.php';
require_once __DIR__ . '/app/Util.php';

$updates = json_decode(file_get_contents(__DIR__ . '/gsc_updates.json'), true);
$matrixFile = __DIR__ . '/app/Data/matrix.csv';

// Read matrix CSV
$rows = [];
$headers = [];
$handle = fopen($matrixFile, 'r');
if ($handle) {
    $headers = fgetcsv($handle, 0, ',', '"', '\\');
    while (($row = fgetcsv($handle, 0, ',', '"', '\\')) !== false) {
        if (count($row) === count($headers)) {
            $rows[] = array_combine($headers, $row);
        }
    }
    fclose($handle);
}

// Create update map
$updateMap = [];
foreach ($updates['matrix'] as $update) {
    $key = $update['keyword'] . '|' . $update['city'];
    $updateMap[$key] = $update;
}

// Update rows
$updated = 0;
foreach ($rows as &$row) {
    $keyword = \App\Util::slugify($row['keyword'] ?? '');
    $city = \App\Util::slugify($row['city'] ?? '');
    $key = $keyword . '|' . $city;
    
    if (isset($updateMap[$key])) {
        $update = $updateMap[$key];
        $row['title'] = $update['title'];
        $row['meta_description'] = $update['description'];
        $updated++;
        echo "Updated: {$row['url_path']}\n";
    }
}

// Write back to CSV
$handle = fopen($matrixFile, 'w');
if ($handle) {
    fputcsv($handle, $headers, ',', '"', '\\');
    foreach ($rows as $row) {
        $values = [];
        foreach ($headers as $header) {
            $values[] = $row[$header] ?? '';
        }
        fputcsv($handle, $values, ',', '"', '\\');
    }
    fclose($handle);
    echo "\nUpdated {$updated} rows in matrix.csv\n";
} else {
    echo "Error: Could not write to matrix.csv\n";
    exit(1);
}

