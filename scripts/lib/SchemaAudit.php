<?php

namespace AuditLib;

class SchemaAudit
{
    public static function classify(array $ld): array
    {
        $types = [];
        $stack = is_array($ld) ? [$ld] : [];
        
        while ($stack) {
            $node = array_pop($stack);
            
            if (isset($node['@type'])) {
                $t = is_array($node['@type']) ? $node['@type'] : [$node['@type']];
                $types = array_merge($types, $t);
            }
            
            // Traverse @graph
            if (isset($node['@graph']) && is_array($node['@graph'])) {
                foreach ($node['@graph'] as $item) {
                    if (is_array($item)) $stack[] = $item;
                }
            }
            
            foreach ($node as $k => $v) {
                if ($k !== '@type' && $k !== '@graph' && is_array($v)) {
                    $stack[] = $v;
                }
            }
        }
        
        return array_values(array_unique($types));
    }

    public static function hasRequiredProps(array $obj, array $props): array
    {
        $missing = [];
        
        foreach ($props as $p) {
            if (!self::dotExists($obj, $p)) {
                $missing[] = $p;
            }
        }
        
        return $missing;
    }

    private static function dotExists(array $obj, string $path): bool
    {
        $parts = explode('.', $path);
        $cur = $obj;
        
        foreach ($parts as $p) {
            if (is_array($cur) && array_key_exists($p, $cur)) {
                $cur = $cur[$p];
            } else {
                return false;
            }
        }
        
        return true;
    }

    public static function validateByType(array $jsonlds, array $cfgSchema): array
    {
        $issues = [];
        $requiredProps = $cfgSchema['required_props'] ?? [];
        $offerReq = $cfgSchema['product_offer_required'] ?? [];
        $offerOk = $cfgSchema['product_offer_ok_types'] ?? [];

        foreach ($jsonlds as $doc) {
            // Handle @graph
            $items = [];
            if (isset($doc['@graph']) && is_array($doc['@graph'])) {
                $items = $doc['@graph'];
            } else {
                $items = [$doc];
            }
            
            foreach ($items as $item) {
                $types = self::classify($item);
                
                foreach ($types as $type) {
                    if (!isset($requiredProps[$type])) continue;
                    
                    $missing = self::hasRequiredProps($item, $requiredProps[$type]);
                    
                    // Special Product.offers validation
                    if ($type === 'Product' && isset($item['offers'])) {
                        $offers = self::isAssoc($item['offers']) ? [$item['offers']] : $item['offers'];
                        $offerTypeOk = false;
                        $offerMissing = [];
                        
                        foreach ($offers as $of) {
                            if (isset($of['@type']) && in_array($of['@type'], $offerOk)) {
                                $offerTypeOk = true;
                            }
                            
                            foreach ($offerReq as $p) {
                                if (!array_key_exists($p, $of)) {
                                    $offerMissing[] = "offers.$p";
                                }
                            }
                        }
                        
                        if (!$offerTypeOk) {
                            $missing[] = 'offers.@type (Offer or AggregateOffer)';
                        }
                        
                        $missing = array_merge($missing, array_unique($offerMissing));
                    }
                    
                    if ($missing) {
                        $issues[] = "$type missing: " . implode(', ', array_unique($missing));
                    }
                }
            }
        }
        
        return $issues;
    }
    
    private static function isAssoc($arr): bool
    {
        return is_array($arr) && array_keys($arr) !== range(0, count($arr) - 1);
    }
}

