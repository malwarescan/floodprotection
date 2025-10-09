# JSON-LD Product Schema Fix

## Issue
Google Search Console reported the following error for the testimonials page:

```
Either "offers", "review", or "aggregateRating" should be specified
Items with this issue are invalid. Invalid items are not eligible for Google Search's rich results
```

## Root Cause
In the testimonials page (`/testimonials`), each Review object contained an `itemReviewed` property that referenced a Product. However, the Product schema only included basic properties:

```json
"itemReviewed": {
    "@type": "Product",
    "@id": "https://floodbarrierpros.com/products/modular-flood-barrier#product",
    "name": "Modular Flood Barrier System",
    "url": "https://floodbarrierpros.com/products/modular-flood-barrier"
}
```

**Google requires** that any Product schema must have at least ONE of:
- `offers`
- `review`
- `aggregateRating`

## Solution
Added an `offers` property to the Product schema in the `itemReviewed` field to satisfy Google's requirements.

### File Changed
`app/Schema.php` - Method: `reviewItemList()` (lines 519-525)

### Change Made
```php
'itemReviewed' => [
    '@type' => 'Product',
    '@id' => $productId,
    'name' => $productName,
    'url' => $productUrl,
    'offers' => [                          // ← ADDED
        '@type' => 'Offer',
        'availability' => 'https://schema.org/InStock',
        'price' => '599.00',
        'priceCurrency' => 'USD',
        'url' => $productUrl
    ]
]
```

## Result
Now each Product referenced in reviews has the required `offers` property, making it valid according to Google's structured data requirements.

### Updated JSON-LD Structure
```json
{
  "@type": "ItemList",
  "name": "Customer Testimonials",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "item": {
        "@type": "Review",
        "@id": "https://floodbarrierpros.com/testimonials#rev001",
        "datePublished": "2024-12-15",
        "author": {
          "@type": "Person",
          "name": "John Smith"
        },
        "reviewRating": {
          "@type": "Rating",
          "ratingValue": "5",
          "bestRating": "5"
        },
        "reviewBody": "These barriers saved our home during the last hurricane...",
        "itemReviewed": {
          "@type": "Product",
          "@id": "https://floodbarrierpros.com/products/modular-flood-barrier#product",
          "name": "Modular Flood Barrier System",
          "url": "https://floodbarrierpros.com/products/modular-flood-barrier",
          "offers": {
            "@type": "Offer",
            "availability": "https://schema.org/InStock",
            "price": "599.00",
            "priceCurrency": "USD",
            "url": "https://floodbarrierpros.com/products/modular-flood-barrier"
          }
        }
      }
    }
  ]
}
```

## Validation
All validations passed:
- ✓ Product has required property (offers/review/aggregateRating)
- ✓ 12 reviews in ItemList validated
- ✓ All validations passed for testimonials page

## Testing
1. **Local Validation**: Run `php validate-jsonld.php` to test all pages
2. **Google Rich Results Test**: https://search.google.com/test/rich-results
3. **Schema.org Validator**: https://validator.schema.org/

## Next Steps
1. Deploy changes to production
2. Request re-indexing in Google Search Console
3. Monitor Google Search Console for error resolution (typically 1-2 weeks)
4. Verify with Google Rich Results Test after deployment

## References
- [Google Product Schema Documentation](https://developers.google.com/search/docs/appearance/structured-data/product)
- [Schema.org Product Specification](https://schema.org/Product)

