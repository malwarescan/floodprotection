# JSON-LD Schema Implementation for Review Rich Results

## Overview
This document describes the JSON-LD structured data implementation to fix Google Search Console errors and enable review rich results for product pages.

## Problems Fixed

### 1. "Item does not support reviews" Error
**Issue**: Reviews were attached to Organization/Service pages which don't support review markup.

**Solution**: Reviews are now only attached to Product pages. Service and Organization pages no longer have review properties.

### 2. "Missing reviewed item name" Error
**Issue**: Review objects didn't properly reference the reviewed product with required properties.

**Solution**: All reviews now use `itemReviewed` with full Product object including `@type`, `@id`, `name`, and `url`.

## Implementation Details

### A. Product Pages (Review-Eligible)
**URLs**:
- `/products/modular-flood-barrier`
- `/products/garage-dam-kit`
- `/products/doorway-flood-panel`

**Schema**: Each product page includes:
```json
{
  "@type": "Product",
  "@id": "https://floodbarrierpros.com/products/modular-flood-barrier#product",
  "url": "https://floodbarrierpros.com/products/modular-flood-barrier",
  "name": "Modular Flood Barrier System",
  "sku": "RFP-MOD-BARRIER",
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "4.7",
    "reviewCount": "6"
  },
  "review": [
    {
      "@type": "Review",
      "datePublished": "2024-12-15",
      "author": {"@type": "Person", "name": "John Smith"},
      "reviewRating": {"@type": "Rating", "ratingValue": "5", "bestRating": "5"},
      "reviewBody": "These barriers saved our home..."
    }
  ]
}
```

**Files Modified**:
- `app/Controllers/ProductController.php` - Already had proper Product schema ✅

### B. Testimonials Page
**URL**: `/testimonials`

**Schema**: ItemList with Review objects that point to canonical products via `itemReviewed`:
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
        "author": {"@type": "Person", "name": "John Smith"},
        "reviewRating": {"@type": "Rating", "ratingValue": "5", "bestRating": "5"},
        "reviewBody": "These barriers saved our home...",
        "itemReviewed": {
          "@type": "Product",
          "@id": "https://floodbarrierpros.com/products/modular-flood-barrier#product",
          "name": "Modular Flood Barrier System",
          "url": "https://floodbarrierpros.com/products/modular-flood-barrier"
        }
      }
    }
  ]
}
```

**Files Modified**:
- `app/Schema.php` - Added `reviewItemList()` method
- `app/Controllers/TestimonialsController.php` - Updated to use `reviewItemList()`

**SKU Mapping**: The system automatically maps SKUs to canonical products:
- `RFP-HOMEFLO-*` → `/products/modular-flood-barrier`
- `RFP-MOD-BARRIER` → `/products/modular-flood-barrier`
- `RFP-GARAGE-*` → `/products/garage-dam-kit`
- `RFP-DOORDAM-*` → `/products/garage-dam-kit`
- `RFP-PANEL-*` → `/products/doorway-flood-panel`
- `RFP-BASEMENT-*` → `/products/doorway-flood-panel`

### C. Homepage
**URL**: `/`

**Schema**: Organization (without reviews):
```json
{
  "@type": "Organization",
  "name": "Flood Barrier Pros",
  "url": "https://floodbarrierpros.com/",
  "logo": "https://floodbarrierpros.com/logo.png",
  "brand": {"@type": "Brand", "name": "Rubicon Flood Protection"},
  "contactPoint": [{
    "@type": "ContactPoint",
    "telephone": "+1-239-330-8888",
    "contactType": "customer service",
    "areaServed": "US-FL"
  }],
  "sameAs": [
    "https://www.facebook.com/61574735757374/"
  ]
}
```

**Files Modified**:
- `app/Schema.php` - Enhanced `organization()` method
- `app/Controllers/PagesController.php` - Updated `home()` method

### D. City/Location Pages
**URLs**: `/fl/{city}/{product}` (e.g., `/fl/naples/modular-flood-barrier`)

**Schema**: Service/WebPage (without reviews):
```json
{
  "@type": "WebPage",
  "name": "Modular Flood Barrier System – Naples, FL",
  "url": "https://floodbarrierpros.com/fl/naples/modular-flood-barrier",
  "about": {
    "@id": "https://floodbarrierpros.com/products/modular-flood-barrier#product"
  }
}
```

**Files Modified**:
- `app/Controllers/LocationController.php` - Already had proper schema ✅

## Key Principles

1. **Reviews only on Product pages**: Only `@type: Product` can have `review` and `aggregateRating` properties.

2. **Every reviewed item needs a name**: All `itemReviewed` references include `@type`, `@id`, `name`, and `url`.

3. **Sync numbers to on-page content**: If 36 reviews are displayed, `reviewCount` is 36.

4. **SSR HTML**: All JSON-LD is server-side rendered in the initial HTML, not injected client-side.

5. **Canonical product references**: All reviews point to the canonical product URL using `@id` references.

## Validation

Use these tools to validate the implementation:

1. **Google Rich Results Test**: https://search.google.com/test/rich-results
2. **Schema.org Validator**: https://validator.schema.org/
3. **Google Search Console**: Monitor "Review snippets" report for errors

## Files Changed

1. `app/Schema.php` - Added `reviewItemList()` and enhanced `organization()` methods
2. `app/Controllers/PagesController.php` - Updated homepage to use Organization schema
3. `app/Controllers/TestimonialsController.php` - Updated to use proper Review ItemList

## Testing Checklist

- [ ] Homepage shows Organization schema (no reviews)
- [ ] Each product page shows Product schema with aggregateRating and reviews
- [ ] Testimonials page shows ItemList with Reviews pointing to products
- [ ] City/location pages show Service/WebPage schema (no reviews)
- [ ] All SKUs map correctly to canonical products
- [ ] Review counts match visible reviews on page
- [ ] Google Rich Results Test passes for product pages
- [ ] No "Item does not support reviews" errors
- [ ] No "Missing reviewed item name" errors

## Next Steps

1. Deploy changes to production
2. Submit sitemap to Google Search Console
3. Use "Request Indexing" for key product pages
4. Monitor Rich Results report for 2-4 weeks
5. Check for review stars appearing in search results

## Notes

- The global `organizationGraph()` in `layout.php` provides detailed entity information site-wide
- Product pages use canonical `@id` references for entity linking
- Reviews on testimonials page support the product pages but won't show stars themselves
- Service and city pages reference products via `about` or `isRelatedTo` without adding reviews

