<?php
/**
 * Minimal mapper that derives $ctx from your known URL patterns.
 * Call: $ctx = map_ctx($absUrl, $title, $desc, $siteMeta, $pageData);
 * Then include schema-head.php.
 */

function map_ctx(string $absUrl, string $title, string $desc, array $site, array $pageData = []): array {
    $ctx = [
        'site' => $site,
        'page' => [
            'url' => $absUrl,
            'name' => $title,
            'description' => $desc,
            'inLanguage' => 'en'
        ],
        'breadcrumbs' => [['name'=>'Home','item'=>rtrim($site['url'],'/').'/']]
    ];

    $path = parse_url($absUrl, PHP_URL_PATH) ?? '/';

    // Products
    if (preg_match('#^/products/([^/]+)/*$#', $path, $m)) {
        $slug = $m[1];
        // Expect $pageData['product'] to be passed by template/controller
        if (!empty($pageData['product'])) $ctx['product'] = $pageData['product'];
        $ctx['breadcrumbs'][] = ['name'=>'Products', 'item'=>rtrim($site['url'],'/').'/products/'];
        $ctx['breadcrumbs'][] = ['name'=>$title, 'item'=>$absUrl];
        return $ctx;
    }

    // City landers: /home-flood-barriers/{city} OR /residential-flood-panels/{city}
    if (preg_match('#^/(home-flood-barriers|residential-flood-panels)/([^/]+)/?$#', $path, $m)) {
        $type = $m[1];
        $city = ucwords(str_replace('-', ' ', $m[2]));
        // Expect $pageData['serviceLocal'] from template with real details
        if (!empty($pageData['serviceLocal'])) $ctx['serviceLocal'] = $pageData['serviceLocal'];
        $ctx['breadcrumbs'][] = ['name'=> ($type==='home-flood-barriers'?'Home Flood Barriers':'Residential Flood Panels'),
                                 'item'=> rtrim($site['url'],'/').'/'.$type.'/'];
        $ctx['breadcrumbs'][] = ['name'=> $city, 'item'=> $absUrl];
        // Optional FAQ if provided
        if (!empty($pageData['faq'])) $ctx['faq'] = $pageData['faq'];
        return $ctx;
    }

    // Category/guide: /flood-protection-for-homes
    if ($path === '/flood-protection-for-homes' || str_starts_with($path, '/flood-protection-for-homes')) {
        // Expect $pageData['itemList'] (child city URLs with names)
        if (!empty($pageData['itemList'])) $ctx['itemList'] = $pageData['itemList'];
        $ctx['breadcrumbs'][] = ['name'=>'Flood Protection For Homes', 'item'=>rtrim($site['url'],'/').'/flood-protection-for-homes'];
        return $ctx;
    }

    // Testimonials page can feed reviews into product templates, but we do not emit generic Organization reviews here by default.
    if (str_starts_with($path, '/testimonials')) {
        $ctx['breadcrumbs'][] = ['name'=>'Testimonials', 'item'=>$absUrl];
        return $ctx;
    }

    // Fallback
    $ctx['breadcrumbs'][] = ['name'=>$title, 'item'=>$absUrl];
    return $ctx;
}
