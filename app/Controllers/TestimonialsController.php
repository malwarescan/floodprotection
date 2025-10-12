<?php

namespace App\Controllers;

use App\Config;
use App\Schema;
use App\Util;
use App\View;

class TestimonialsController
{
    private string $reviewsPath;

    public function __construct()
    {
        $this->reviewsPath = __DIR__ . '/../Data/reviews.csv';
    }

    public function index()
    {
        $all = Util::getCsvData('reviews.csv');

        // Extract filters
        $sku = $_GET['sku'] ?? '';
        $city = $_GET['city'] ?? '';
        $minRating = max(0, (int)($_GET['min_rating'] ?? 0));
        $q = trim($_GET['q'] ?? '');

        // City inference from SKU suffix like ...-MIAMI / ...-TAMPA
        $cityMap = [
            'MIAMI' => 'Miami', 'TAMPA' => 'Tampa', 'ORLANDO' => 'Orlando', 'JAX' => 'Jacksonville',
            'NAPLES' => 'Naples', 'FORTMYERS' => 'Fort Myers', 'PENSACOLA' => 'Pensacola', 'KEYWEST' => 'Key West'
        ];
        $augment = function($r) use($cityMap) {
            $parts = explode('-', $r['sku'] ?? '');
            $code = strtoupper($parts[count($parts)-1] ?? '');
            $r['_city'] = $cityMap[$code] ?? '';
            return $r;
        };
        $all = array_map($augment, $all);

        // Filter
        $filtered = array_values(array_filter($all, function($r) use($sku, $city, $minRating, $q) {
            if ($sku && ($r['sku'] ?? '') !== $sku) return false;
            if ($city && strcasecmp($r['_city'] ?? '', $city) !== 0) return false;
            if ($minRating && (int)$r['rating'] < $minRating) return false;
            if ($q) {
                $hay = strtolower(($r['title'] ?? '') . ' ' . ($r['body'] ?? ''));
                if (strpos($hay, strtolower($q)) === false) return false;
            }
            return true;
        }));

        // Pagination
        $per = 12;
        $page = max(1, (int)($_GET['page'] ?? 1));
        $total = count($filtered);
        $pages = max(1, (int)ceil($total / $per));
        $page = min($page, $pages);
        $slice = array_slice($filtered, ($page - 1) * $per, $per);

        // Meta
        $title = 'Customer Testimonials | ' . Config::get('app_name');
        $desc = 'Read real homeowner reviews of our USA-made home flood barriers and door/garage dam kits.';
        $canonical = Config::get('app_url') . '/testimonials';

        // JSON-LD: ItemList with Review objects pointing to canonical products
        $jsonld = Schema::graph([
            Schema::website(Config::get('app_url')),
            Schema::reviewItemList($slice, Config::get('app_url')),
            Schema::breadcrumb([['Home', '/'], ['Testimonials', '/testimonials']])
        ]);

        // View data
        $cities = array_values(array_unique(array_filter(array_map(fn($r) => $r['_city'], $all))));
        sort($cities);
        $skus = array_values(array_unique(array_filter(array_map(fn($r) => $r['sku'], $all))));
        sort($skus);

        $data = [
            'title' => $title,
            'description' => $desc,
            'canonical' => $canonical,
            'reviews' => $slice,
            'total' => $total,
            'page' => $page,
            'pages' => $pages,
            'per' => $per,
            'filters' => ['sku' => $sku, 'city' => $city, 'minRating' => $minRating, 'q' => $q],
            'cities' => $cities,
            'skus' => $skus,
            'jsonld' => $jsonld
        ];

        return View::renderPage('testimonials', $data);
    }

    public function showSku($sku)
    {
        $all = Util::getCsvData('reviews.csv');
        $rows = array_values(array_filter($all, fn($r) => ($r['sku'] ?? '') === $sku));

        if (!$rows) {
            http_response_code(404);
            echo 'Not found';
            return;
        }

        // Aggregate
        $ratings = array_map(fn($r) => (int)$r['rating'], $rows);
        $avg = round(array_sum($ratings) / max(1, count($ratings)), 1);
        $count = count($ratings);

        // Infer product name from SKU
        $productName = 'Home Flood Barrier Kit';
        if (str_contains($sku, 'MIAMI')) $productName .= ' – Miami';
        if (str_contains($sku, 'TAMPA')) $productName .= ' – Tampa';
        if (str_contains($sku, 'ORLANDO')) $productName .= ' – Orlando';
        if (str_contains($sku, 'JAX')) $productName .= ' – Jacksonville';
        if (str_contains($sku, 'NAPLES')) $productName .= ' – Naples';
        if (str_contains($sku, 'FORTMYERS')) $productName .= ' – Fort Myers';
        if (str_contains($sku, 'PENSACOLA')) $productName .= ' – Pensacola';
        if (str_contains($sku, 'KEYWEST')) $productName .= ' – Key West';

        $title = 'Customer Testimonials: ' . $productName . ' | ' . Config::get('app_name');
        $desc = 'Real product reviews for ' . $productName . '. USA-made materials, reusable panels and door/garage dams.';
        $canonical = Config::get('app_url') . '/testimonials/' . $sku;

        // Product + AggregateRating + Review nodes
        $reviewNodes = array_map(function($r) use ($sku) {
            $productId = Config::get('app_url') . '/products/' . strtolower($sku) . '#product';
            return Schema::review(
                $r['title'],
                $r['author'],
                (int)$r['rating'],
                $r['date'],
                $r['body'],
                $sku,
                $productId
            );
        }, array_slice($rows, 0, 50)); // cap in JSON-LD

        // Determine product image based on SKU
        $productImage = Config::get('app_url') . '/assets/modular-flood-barrier.jpg';
        if (str_contains($sku, 'GARAGE') || str_contains($sku, 'DOORDAM')) {
            $productImage = Config::get('app_url') . '/assets/garage-dam-kit.jpg';
        } elseif (str_contains($sku, 'PANEL') || str_contains($sku, 'DOOR-PANEL') || str_contains($sku, 'BASEMENT')) {
            $productImage = Config::get('app_url') . '/assets/doorway-flood-panel.jpg';
        }
        
        $product = Schema::productWithReviews(
            $productName,
            $sku,
            'Modular, rapid-deploy flood barrier system for residential openings.',
            $productImage, // image
            'Rubicon Flood Control',
            'Flood Barrier Pros',
            $reviewNodes,
            Schema::aggregateRating($avg, $count),
            1499, // lowPrice
            4299, // highPrice
            'USD'
        );

        $jsonld = Schema::graph([
            Schema::website(Config::get('app_url')),
            Schema::breadcrumb([['Home', '/'], ['Testimonials', '/testimonials'], [$sku, '/testimonials/' . $sku]]),
            $product
        ]);

        $data = [
            'title' => $title,
            'description' => $desc,
            'canonical' => $canonical,
            'sku' => $sku,
            'productName' => $productName,
            'avg' => $avg,
            'count' => $count,
            'reviews' => $rows,
            'jsonld' => $jsonld
        ];

        return View::renderPage('testimonials-sku', $data);
    }
}
