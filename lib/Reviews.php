<?php
declare(strict_types=1);
require_once __DIR__.'/ContentLoader.php';

final class Reviews
{
    /**
     * Reviews are grouped by product slug:
     *   /data/reviews/products/{slug}.json
     * JSON format:
     * [
     *   {
     *     "author": "Jane D",
     *     "datePublished": "2025-08-21",
     *     "reviewBody": "Detailed, honest review (can be long).",
     *     "name": "Great sealing under surge",
     *     "ratingValue": 5,   // integer 1..5
     *     "bestRating": 5,    // optional, defaults to 5
     *     "worstRating": 1    // optional, defaults to 1
     *   },
     *   ...
     * ]
     */
    public static function loadForProductSlug(string $slug): array {
        $file = __DIR__.'/../data/reviews/products/'.strtolower($slug).'.json';
        $rows = ContentLoader::loadJson($file);
        return self::normalize($rows);
    }

    private static function normalize(array $rows): array {
        $out = [];
        foreach ($rows as $r) {
            $rv = (int)($r['ratingValue'] ?? 0);
            if ($rv < 1 || $rv > 5) $rv = 0;
            $row = array_filter([
                'author' => isset($r['author']) ? trim((string)$r['author']) : null,
                'datePublished' => isset($r['datePublished']) ? trim((string)$r['datePublished']) : null,
                'reviewBody' => !empty($r['reviewBody']) ? ContentLoader::safeHtmlText((string)$r['reviewBody']) : null,
                'name' => isset($r['name']) ? trim((string)$r['name']) : null,
                'ratingValue' => $rv ?: null,
                'bestRating' => isset($r['bestRating']) ? (int)$r['bestRating'] : 5,
                'worstRating' => isset($r['worstRating']) ? (int)$r['worstRating'] : 1
            ]);
            if (!empty($row['author']) && !empty($row['reviewBody'])) $out[] = $row;
        }
        return $out;
    }

    public static function toSchemaBlocks(string $productUrl, string $brandName, array $reviews): array {
        // Build Review[] + AggregateRating if we have any reviews
        if (empty($reviews)) return [[], null];

        $schemaReviews = [];
        $sum = 0; $count = 0;

        foreach ($reviews as $r) {
            $sum += ($r['ratingValue'] ?? 0);
            if (!empty($r['ratingValue'])) $count++;

            $schemaReviews[] = array_filter([
                '@type' => 'Review',
                'author' => !empty($r['author']) ? ['@type'=>'Person','name'=>$r['author']] : null,
                'datePublished' => $r['datePublished'] ?? null,
                'reviewBody' => $r['reviewBody'] ?? null,
                'name' => $r['name'] ?? null,
                'reviewRating' => !empty($r['ratingValue']) ? [
                    '@type' => 'Rating',
                    'ratingValue' => $r['ratingValue'],
                    'bestRating' => $r['bestRating'] ?? 5,
                    'worstRating' => $r['worstRating'] ?? 1
                ] : null,
                'itemReviewed' => [
                    '@type' => 'Product',
                    'name'  => $brandName, // kept minimal; product object is added by main Product block
                    'url'   => $productUrl
                ]
            ]);
        }

        $agg = null;
        if ($count > 0) {
            $agg = [
                '@type' => 'AggregateRating',
                'ratingValue' => round($sum / $count, 2),
                'ratingCount' => $count,
                'reviewCount' => $count
            ];
        }
        return [$schemaReviews, $agg];
    }
}
