<?php
declare(strict_types=1);

final class Schema
{
    // Prevent duplicate prints
    private static array $printed = [];

    private static function emitOnce(string $key, array $data): string {
        if (isset(self::$printed[$key])) return '';
        self::$printed[$key] = true;
        return self::wrap($data);
    }

    private static function wrap(array $data): string {
        // Ensure @context present
        if (!isset($data['@context'])) $data['@context'] = 'https://schema.org';
        $json = json_encode($data, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
        if ($json === false) return '';
        return '<script type="application/ld+json">'.$json.'</script>'."\n";
    }

    private static function emitMany(string $key, array $blocks): string {
        if (isset(self::$printed[$key])) return '';
        self::$printed[$key] = true;
        $out = '';
        foreach ($blocks as $b) {
            if (!is_array($b) || empty($b)) continue;
            if (!isset($b['@context'])) $b['@context'] = 'https://schema.org';
            $j = json_encode($b, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
            if ($j !== false) $out .= '<script type="application/ld+json">'.$j."</script>\n";
        }
        return $out;
    }

    // --- Core blocks ---

    public static function organization(array $org): string {
        // Required: name, url. Optional: logo, sameAs[], telephone, address
        $data = [
            '@type' => 'Organization',
            '@id'   => rtrim($org['url'],'/').'#organization',
            'name'  => $org['name'] ?? null,
            'url'   => $org['url'] ?? null,
        ];
        if (!empty($org['logo'])) $data['logo'] = $org['logo'];
        if (!empty($org['sameAs']) && is_array($org['sameAs'])) $data['sameAs'] = array_values($org['sameAs']);
        if (!empty($org['telephone'])) $data['telephone'] = $org['telephone'];
        if (!empty($org['address']) && is_array($org['address'])) $data['address'] = array_filter([
            '@type' => 'PostalAddress',
            'streetAddress' => $org['address']['streetAddress'] ?? null,
            'addressLocality' => $org['address']['addressLocality'] ?? null,
            'addressRegion' => $org['address']['addressRegion'] ?? null,
            'postalCode' => $org['address']['postalCode'] ?? null,
            'addressCountry' => $org['address']['addressCountry'] ?? null,
        ]);
        return self::emitOnce('org', array_filter($data));
    }

    public static function website(array $site): string {
        // Required: url. Optional: searchAction { target, query-input }
        $id = rtrim($site['url'] ?? '','/').'#website';
        $data = [
            '@type' => 'WebSite',
            '@id'   => $id,
            'url'   => $site['url'] ?? null,
        ];
        if (!empty($site['searchAction']) && !empty($site['searchAction']['target']) && !empty($site['searchAction']['query-input'])) {
            $data['potentialAction'] = [
                '@type' => 'SearchAction',
                'target' => $site['searchAction']['target'],
                'query-input' => $site['searchAction']['query-input']
            ];
        }
        return self::emitOnce('website', array_filter($data));
    }

    public static function webpage(array $page): string {
        // Required: url. Optional: name, description, inLanguage, breadcrumbId
        $id  = rtrim($page['url'] ?? '','/').'#webpage';
        $data = [
            '@type' => 'WebPage',
            '@id'   => $id,
            'url'   => $page['url'] ?? null,
            'name'  => $page['name'] ?? null,
            'description' => $page['description'] ?? null,
            'inLanguage'  => $page['inLanguage'] ?? null,
        ];
        if (!empty($page['breadcrumbId'])) $data['isPartOf'] = ['@id' => $page['breadcrumbId']];
        return self::emitOnce('webpage:'.$id, array_filter($data));
    }

    public static function breadcrumbs(array $items, string $trailId): string {
        // items: [ ['name'=>'Home','item'=>'https://...'], ... ]
        if (empty($items)) return '';
        $data = [
            '@type' => 'BreadcrumbList',
            '@id'   => $trailId,
            'itemListElement' => []
        ];
        $pos = 1;
        foreach ($items as $it) {
            if (empty($it['name']) || empty($it['item'])) continue;
            $data['itemListElement'][] = [
                '@type' => 'ListItem','position'=>$pos++,
                'name'  => $it['name'],
                'item'  => $it['item']
            ];
        }
        if (empty($data['itemListElement'])) return '';
        return self::emitOnce('breadcrumb:'.$trailId, $data);
    }

    // --- Product (for /products/*) ---

    public static function product(array $p): string {
        // Required: name, url
        // Optional: sku, mpn, brand{name}, image[], description, offers{price, priceCurrency, availability, url}, aggregateRating, review[]
        $data = [
            '@type' => 'Product',
            'name'  => $p['name'] ?? null,
            'url'   => $p['url'] ?? null,
            'description' => $p['description'] ?? null,
        ];
        foreach (['sku','mpn'] as $k) if (!empty($p[$k])) $data[$k] = $p[$k];
        if (!empty($p['brand'])) $data['brand'] = ['@type'=>'Brand','name'=>$p['brand']];
        if (!empty($p['image']) && is_array($p['image'])) $data['image'] = array_values($p['image']);

        if (!empty($p['offers']) && is_array($p['offers'])) {
            $offers = array_filter([
                '@type'=>'Offer',
                'url'=>$p['offers']['url'] ?? $p['url'] ?? null,
                'price'=>$p['offers']['price'] ?? null,
                'priceCurrency'=>$p['offers']['priceCurrency'] ?? null,
                'availability'=>$p['offers']['availability'] ?? null,
                'itemCondition'=>$p['offers']['itemCondition'] ?? null
            ]);
            if (!empty($offers)) $data['offers'] = $offers;
        }

        if (!empty($p['aggregateRating']) && is_array($p['aggregateRating'])) {
            $ar = array_filter([
                '@type'=>'AggregateRating',
                'ratingValue'=>$p['aggregateRating']['ratingValue'] ?? null,
                'ratingCount'=>$p['aggregateRating']['ratingCount'] ?? null,
                'reviewCount'=>$p['aggregateRating']['reviewCount'] ?? null
            ]);
            if (!empty($ar)) $data['aggregateRating'] = $ar;
        }

        if (!empty($p['reviews']) && is_array($p['reviews'])) {
            $reviews = [];
            foreach ($p['reviews'] as $r) {
                $rv = array_filter([
                    '@type'=>'Review',
                    'author'=> !empty($r['author']) ? ['@type'=>'Person','name'=>$r['author']] : null,
                    'datePublished'=> $r['datePublished'] ?? null,
                    'reviewBody'=> $r['reviewBody'] ?? null,
                    'name'=> $r['name'] ?? null,
                    'reviewRating'=> !empty($r['reviewRating']) ? array_filter([
                        '@type'=>'Rating',
                        'ratingValue'=>$r['reviewRating']['ratingValue'] ?? null,
                        'bestRating'=>$r['reviewRating']['bestRating'] ?? null,
                        'worstRating'=>$r['reviewRating']['worstRating'] ?? null
                    ]) : null
                ]);
                if (!empty($rv)) $reviews[] = $rv;
            }
            if (!empty($reviews)) $data['review'] = $reviews;
        }

        return self::emitOnce('product:'.($p['url'] ?? uniqid()), array_filter($data));
    }

    // --- Service / Local landing (for city pages) ---

    public static function serviceLocal(array $s): string {
        // s: name, url, areaServed{name}, serviceType, provider{Organization fields}, openingHoursSpecification?, priceRange?
        $data = [
            '@type'=>'Service',
            'name'=> $s['name'] ?? null,
            'serviceType'=> $s['serviceType'] ?? null,
            'areaServed'=> !empty($s['areaServed']) ? ['@type'=>'City','name'=>$s['areaServed']] : null,
            'provider'=> !empty($s['provider']) ? array_filter([
                '@type'=>'Organization',
                'name'=>$s['provider']['name'] ?? null,
                'url' =>$s['provider']['url'] ?? null,
                'telephone'=>$s['provider']['telephone'] ?? null,
            ]) : null,
            'url'=> $s['url'] ?? null,
            'description' => $s['description'] ?? null
        ];
        if (!empty($s['openingHoursSpecification'])) $data['openingHoursSpecification'] = $s['openingHoursSpecification'];
        if (!empty($s['priceRange'])) $data['priceRange'] = $s['priceRange'];
        return self::emitOnce('service:'.($s['url'] ?? uniqid()), array_filter($data));
    }

    public static function faq(array $items): string {
        // items: [ ['q'=>'','a'=>''], ... ]
        if (empty($items)) return '';
        $main = ['@type'=>'FAQPage','mainEntity'=>[]];
        foreach ($items as $fa) {
            if (empty($fa['q']) || empty($fa['a'])) continue;
            $main['mainEntity'][] = [
                '@type'=>'Question',
                'name'=>$fa['q'],
                'acceptedAnswer'=>['@type'=>'Answer','text'=>$fa['a']]
            ];
        }
        if (empty($main['mainEntity'])) return '';
        return self::emitOnce('faq', $main);
    }

    public static function itemList(array $list, string $id): string {
        // list: [ ['name'=>'Miami Home Flood Barriers','url'=>'...'], ... ]
        if (empty($list)) return '';
        $els = [];
        $pos = 1;
        foreach ($list as $it) {
            if (empty($it['name']) || empty($it['url'])) continue;
            $els[] = [
                '@type'=>'ListItem',
                'position'=>$pos++,
                'url'=>$it['url'],
                'name'=>$it['name']
            ];
        }
        if (empty($els)) return '';
        $data = ['@type'=>'ItemList','@id'=>$id,'itemListElement'=>$els];
        return self::emitOnce('itemlist:'.$id, $data);
    }

    // --- Optional: JobPosting sanitizer (not emitted unless you call it) ---

    public static function sanitizeExperience(?string $val): ?string {
        if ($val === null) return null;
        $map = [
            'noExperienceRequired' => ['none','no','entry','0','no experience'],
            'someExperience'       => ['1-2','1','2','junior','some'],
            'experienced'          => ['3+','3','4','5','mid','experienced'],
            'expert'               => ['senior','lead','principal','10+','8+']
        ];
        $v = strtolower(trim($val));
        foreach ($map as $enum => $aliases) {
            foreach ($aliases as $a) if (strpos($v, $a) !== false) return $enum;
        }
        return 'someExperience';
    }
}
