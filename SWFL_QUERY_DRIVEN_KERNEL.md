# SWFL Flood-Barrier Network — Query-Driven SEO Kernel

## Implementation Summary

This kernel implements a **data-driven SEO system** that uses actual Google Search Console query data to generate content, headings, anchor text, and schema that matches real user search behavior.

## Core Components

### 1. QueryDrivenContent.php
Central class that generates all content based on GSC query patterns:

- **H1/H2 Generation**: Matches exact query language (e.g., "Flood Panels Miami", "Garage Flood Barriers Sarasota")
- **Anchor Text Rules**: Generates query-matched anchor text, forbids generic phrases like "learn more"
- **Alt Tag Generation**: Creates alt tags matching query patterns (e.g., "Flood panels Fort Myers | aluminum hurricane panel barriers")
- **Meta Title/Description**: Generates CTR-optimized titles and descriptions based on query intent
- **Internal Link Architecture**: Creates upward/downward/sideways link structures based on query gaps

### 2. SWFLContent.php Updates
- Integrated QueryDrivenContent for all headings and meta tags
- Expanded schema generation to include:
  - Multiple Product schemas per page (based on keyword)
  - Service schema with expanded serviceType
  - FAQPage schema
  - HowTo schema
  - LocalBusiness schema
  - BreadcrumbList schema

### 3. swfl_query_matrix.csv
Complete CSV matrix with 100+ cities mapped to:
- Query keywords
- Intent types (Transactional, Commercial, Informational)
- Product matches
- Required schema types
- Anchor text patterns
- Alt tag patterns
- Internal link structures

### 4. Template Updates
- **matrix-page.php**: Uses query-driven H2s, internal links with query-matched anchors
- **location.php**: Uses query-driven alt tags for product images

### 5. Controller Updates
- **PagesController.php**: Integrates QueryDrivenContent for SWFL pages
- **LocationController.php**: Uses QueryDrivenContent for alt tags and removes "Rubicon" branding

## Key Features

### Query-Matched Headings
All H1/H2 headings now match actual search queries:
- "Miami Flood Panels & Flood Barriers" (not generic "Flood Barriers")
- "Garage Flood Barriers Installation in Sarasota" (matches "garage flood barriers sarasota")
- "Commercial Flood Protection Systems for Hillsborough Businesses" (matches "flood barriers hillsborough")

### Anchor Text Rules
- ✅ Allowed: "flood panels miami", "miami flood protection", "garage flood barriers sarasota"
- ❌ Forbidden: "learn more", "click here", "our service", "details"

### Expanded Schema
Every city page now includes:
1. **Multiple Product schemas** (one per product type mentioned in keyword)
2. **Service schema** with expanded serviceType
3. **LocalBusiness schema** with areaServed
4. **FAQPage schema** with city-specific FAQs
5. **HowTo schema** with installation steps
6. **BreadcrumbList schema**

### Internal Linking Architecture
- **Upward links**: Hub → Products → City
- **Sideways links**: Nearby cities with query-matched anchors
- **Downward links**: Case studies, blog, testimonials

### Alt Tag Optimization
All images use query-matched alt tags:
- "Flood panels Fort Myers | aluminum hurricane panel barriers"
- "Garage flood barriers Sarasota | storm surge protection shield"
- "Flood barriers Hillsborough | coastal surge protection"

## Missing Cities Added

Added to SWFLContent.php:
- Sarasota
- Hillsborough
- Jensen Beach

All cities from swfl_query_matrix.csv are now supported.

## Usage

### For City Pages
```php
$h1 = QueryDrivenContent::getH1($citySlug, $keyword);
$h2s = QueryDrivenContent::getH2s($citySlug, $keyword);
$metaTitle = QueryDrivenContent::getMetaTitle($citySlug, $keyword);
$metaDescription = QueryDrivenContent::getMetaDescription($citySlug, $keyword);
$altTag = QueryDrivenContent::getAltTag($product, $city, $productType);
$internalLinks = QueryDrivenContent::getInternalLinkTargets($citySlug, $keyword);
```

### For Anchor Text Validation
```php
$isValid = QueryDrivenContent::validateAnchorText($anchor, $city, $keyword);
```

## Expected SEO Impact

1. **CTR Improvement**: Query-matched titles and descriptions increase click-through rates
2. **Keyword Alignment**: Headings match exact search queries, improving relevance
3. **Link Equity**: Query-matched anchor text passes more relevant signals
4. **Image SEO**: Query-matched alt tags improve image search visibility
5. **AI Overview Presence**: Expanded schema increases visibility in AI Overview results
6. **Crawl Efficiency**: Internal linking architecture ensures all pages are discoverable

## Next Steps

1. **Monitor GSC**: Track CTR improvements for pages with query-matched content
2. **Expand Query Matrix**: Add more cities as new queries appear in GSC
3. **A/B Test**: Compare query-matched vs. generic content performance
4. **Schema Validation**: Run Google's Rich Results Test on all city pages
5. **Internal Link Audit**: Verify all pages link upward/downward/sideways

## Files Modified

- `app/QueryDrivenContent.php` (NEW)
- `app/SWFLContent.php` (UPDATED)
- `app/Controllers/PagesController.php` (UPDATED)
- `app/Controllers/LocationController.php` (UPDATED)
- `app/Templates/matrix-page.php` (UPDATED)
- `app/Templates/location.php` (UPDATED)
- `app/Data/swfl_query_matrix.csv` (NEW)

## Compliance

This implementation follows the **SUDO META-DIRECTIVE KERNEL** requirements:
- ✅ Query-matched headings (H1/H2)
- ✅ Query-matched anchor text
- ✅ Query-matched alt tags
- ✅ Expanded schema (Product, Service, FAQ, HowTo, LocalBusiness)
- ✅ Internal linking architecture
- ✅ No "Rubicon" branding
- ✅ All content matches real search queries

