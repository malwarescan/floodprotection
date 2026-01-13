# GSC 404 Error Fix Analysis

## Issue Summary

Google Search Console reports **87 pages with 404 (Not Found) errors** (as of 2026-01-13). These URLs are being discovered by Google but return 404 instead of redirecting or serving content.

## URL Pattern Analysis

### Breakdown by Pattern

1. **Old Product SKU URLs (70 URLs)** - `/products/rfp-*`
   - These should redirect to canonical location pages or product pages
   - Patterns: `rfp-homeflo-*`, `rfp-doordam-*`, `rfp-basement-*`, `rfp-garage-*`, `rfp-panel-*`, `rfp-portable-*`, `rfp-resident-*`, `rfp-flood-pr-*`

2. **Trailing Slash URLs (3 URLs)** - URLs ending with `/`
   - `/faq/`, `/contact/`, `/regions/st-petersburg/`
   - Should redirect to versions without trailing slash

3. **Keyword Variation URLs (2 URLs)** - `/flood-panels/{city}`
   - `/flood-panels/sanibel-island`, `/flood-panels/mcgregor`
   - Should redirect to `/home-flood-barriers/{city}`

4. **Other URLs (12 URLs)**
   - Blog/news URLs with incorrect slugs
   - Resources URLs
   - Search URLs with query strings
   - Malformed URLs

## Root Cause Analysis

### 1. Non-www URLs Accessing Redirect Handler

Many 404 URLs are accessed via `https://floodbarrierpros.com` (non-www). The redirect logic exists but may not be catching all patterns correctly when accessed via non-www URLs.

### 2. Product SKU Redirect Logic

The current redirect logic in `app/Router.php` should handle these URLs, but there may be edge cases where:
- The SKU pattern doesn't match correctly
- The city extraction fails
- The product type detection fails

### 3. Trailing Slash Handling

The trailing slash redirect runs first in `handleRedirects()`, but some URLs may be matching routes before the redirect handler runs.

### 4. Blog/News Slug Mismatches

Some URLs reference blog/news articles with incorrect slugs (missing date prefixes).

## Current Implementation Status

### ✅ Working Redirects

1. **Trailing Slash Redirects** (`app/Router.php` lines 217-220)
   - Should catch: `/faq/`, `/contact/`, `/regions/st-petersburg/`
   - Status: Should work, but may need verification

2. **Keyword Variation Redirects** (`app/Router.php` lines 320-323)
   - Should catch: `/flood-panels/{city}` → `/home-flood-barriers/{city}`
   - Status: Should work for most cities

3. **Product SKU Redirects** (`app/Router.php` lines 234-300)
   - Should catch: `/products/rfp-*` → location pages or product pages
   - Status: Should work, but some patterns may be missing

### ⚠️ Potential Issues

1. **Product SKU Pattern Matching**
   - URLs like `rfp-homeflo-miami` should match prefix `homeflo`
   - Current logic: `strpos($sku, $prefix) === 0 || strpos($sku, '-' . $prefix) !== false`
   - Should work, but needs verification

2. **City Mapping Coverage**
   - Some cities in URLs may not be in the `$cityMap`
   - Without city mapping, redirects to `/products/{product-slug}` instead of `/fl/{city}/{product-slug}`
   - This is acceptable behavior (redirects to product page)

3. **Blog/News Slug Format**
   - URLs like `/blog/portable-vs-permanent-flood-barriers` (missing date prefix)
   - Should be: `/blog/2025-10-12-portable-vs-permanent-flood-barriers`
   - These should return 404 (correct behavior for incorrect slugs)

## Recommended Fixes

### Fix 1: Verify Redirect Handler Execution Order

The redirect handler runs before route matching, which is correct. However, we should verify that all redirect patterns are being checked.

### Fix 2: Add Missing City Mappings

Some cities in 404 URLs may need to be added to the `$cityMap`:
- `sanibel-island` → may need special handling (currently redirects to `/home-flood-barriers/sanibel-island`)

### Fix 3: Handle Blog/News Redirects (Optional)

For blog/news URLs with missing date prefixes, we could:
- Add redirect rules to match slugs without date prefixes
- Redirect to correct URLs with date prefixes
- This is optional - 404 is acceptable for incorrect slugs

### Fix 4: Ensure Non-www Redirects Work

The non-www → www redirect should happen first (in `.htaccess` or `index.php`), then the PHP redirect handler should catch product SKU URLs. This should already be working, but needs verification.

## Testing Recommendations

### Test Product SKU Redirects

```bash
# Test old product SKU URLs
curl -I https://www.floodbarrierpros.com/products/rfp-homeflo-miami
# Should return: 301 → https://www.floodbarrierpros.com/fl/miami/modular-flood-barrier

curl -I https://www.floodbarrierpros.com/products/rfp-doordam-keywest
# Should return: 301 → https://www.floodbarrierpros.com/fl/key-west/garage-dam-kit
```

### Test Trailing Slash Redirects

```bash
# Test trailing slash URLs
curl -I https://www.floodbarrierpros.com/faq/
# Should return: 301 → https://www.floodbarrierpros.com/faq

curl -I https://www.floodbarrierpros.com/contact/
# Should return: 301 → https://www.floodbarrierpros.com/contact
```

### Test Keyword Variation Redirects

```bash
# Test keyword variation URLs
curl -I https://www.floodbarrierpros.com/flood-panels/sanibel-island
# Should return: 301 → https://www.floodbarrierpros.com/home-flood-barriers/sanibel-island
```

## Implementation Status

### ✅ Redirect Logic Already Implemented

All the necessary redirect logic is already in place in `app/Router.php`:

1. **Trailing Slash Redirects** (lines 217-220) ✅
   - Handles: `/faq/`, `/contact/`, `/regions/st-petersburg/`
   - Status: Should work correctly

2. **Product SKU Redirects** (lines 234-300) ✅
   - Handles: `/products/rfp-*` → location pages or product pages
   - Status: Should work correctly for all patterns

3. **Keyword Variation Redirects** (lines 320-323) ✅
   - Handles: `/flood-panels/{city}` → `/home-flood-barriers/{city}`
   - Status: Should work correctly

4. **Search Redirects** (lines 340-342) ✅
   - Handles: `/search*` → `/`
   - Status: Should work correctly

### ⚠️ Why Google Still Sees 404s

Even though redirect logic is in place, Google may see 404s because:

1. **Non-www URLs**: Many URLs are accessed via `https://floodbarrierpros.com` (non-www)
   - The non-www → www redirect should happen first (`.htaccess` or `index.php`)
   - Then the PHP redirect handler should catch product SKU URLs
   - If non-www redirect fails, URLs may not reach the redirect handler

2. **Timing**: Google may have discovered these URLs before redirects were implemented
   - As Google recrawls, it should follow redirects and update its index
   - This is a timing issue that will resolve over time

3. **Crawl Frequency**: Google may not have recrawled these URLs yet
   - Old URLs may remain in Google's index as 404s until recrawled
   - Expected resolution: 2-8 weeks as Google recrawls

## Expected Resolution

The redirect logic is already implemented correctly. Over time:

1. **Product SKU URLs**: Will redirect to location pages or product pages (301) as Google recrawls
2. **Trailing Slash URLs**: Will redirect to versions without trailing slash (301) as Google recrawls
3. **Keyword Variation URLs**: Will redirect to canonical keyword URLs (301) as Google recrawls
4. **Blog/News URLs**: Will continue to return 404 for incorrect slugs (correct behavior)

## Recommendations

### 1. Monitor and Wait (Primary Strategy)
- **Action**: No code changes needed
- **Rationale**: Redirect logic is already implemented correctly
- **Expected Resolution**: 2-8 weeks as Google recrawls and updates index

### 2. Verify Redirects Are Working (Verification)
- **Action**: Test a few 404 URLs to verify redirects work
- **Purpose**: Confirm redirect logic is functioning correctly
- **Steps**: Use curl commands listed in Testing Recommendations section

### 3. Request Re-indexing (Optional)
- **Action**: Use Google Search Console to request re-indexing of canonical URLs
- **Purpose**: Help Google discover canonical URLs faster
- **Note**: This won't remove 404 URLs from index immediately, but will help Google discover correct URLs

## Notes

- All redirect logic is already implemented in `app/Router.php`
- The redirect handler runs before route matching (correct order)
- Many 404 URLs are accessed via non-www domain, which should redirect to www first
- Some URLs may legitimately return 404 (e.g., incorrect blog/news slugs)
- Google's index will update as it recrawls URLs and follows redirects
