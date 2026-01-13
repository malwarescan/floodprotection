
# Redirect Analysis - GSC Coverage Report

## Issue Summary
Google Search Console is reporting **279 pages with redirects** (detected starting 2025-11-23). These redirects are **intentional and correct**, but Google is flagging them as coverage issues.

## Types of Redirects Found

### 1. Old Product SKU URLs (Majority of redirects)
**Pattern:** `/products/rfp-{sku}`

**Examples:**
- `https://www.floodbarrierpros.com/products/rfp-resident-labell` → redirects to location page
- `https://www.floodbarrierpros.com/products/rfp-home-flo-auburn` → redirects to location page
- `https://www.floodbarrierpros.com/products/rfp-flood-pr-tampa` → redirects to `/fl/tampa/modular-flood-barrier`

**Why these exist:**
- Legacy URLs from old product system
- External links may still point to these URLs
- Old sitemaps may have included them
- Internal links may reference them

**Current handling:**
- `app/Router.php` `handleRedirects()` method redirects these to canonical location pages
- Uses 301 (permanent) redirects
- Maps SKU prefixes to product types and cities
- Redirects to `/fl/{city}/{product-slug}` format

**Status:** ✅ **Working as intended** - These are legacy URLs that should redirect

### 2. Non-www to www Redirects
**Pattern:** `https://floodbarrierpros.com/*` → `https://www.floodbarrierpros.com/*`

**Examples:**
- `https://floodbarrierpros.com/flood-panels/miami` → `https://www.floodbarrierpros.com/flood-panels/miami`
- `https://floodbarrierpros.com/home-flood-barriers/fort-lauderdale` → `https://www.floodbarrierpros.com/home-flood-barriers/fort-lauderdale`

**Why these exist:**
- Google crawls both www and non-www versions
- Canonical domain is `www.floodbarrierpros.com`
- `.htaccess` redirects non-www to www

**Current handling:**
- `.htaccess` rule (lines 22-29) redirects non-www to www
- Uses 301 (permanent) redirects
- Only runs on HTTPS requests

**Status:** ✅ **Working as intended** - Canonical domain enforcement

### 3. HTTP to HTTPS Redirects
**Pattern:** `http://*` → `https://*`

**Examples:**
- `http://www.floodbarrierpros.com/` → `https://www.floodbarrierpros.com/`
- `http://floodbarrierpros.com/` → `https://www.floodbarrierpros.com/`

**Why these exist:**
- Some external links may use HTTP
- Google may crawl HTTP versions

**Current handling:**
- `.htaccess` rule (lines 14-20) redirects HTTP to HTTPS
- Uses 301 (permanent) redirects
- Must run before www redirect

**Status:** ✅ **Working as intended** - Security best practice

## Why Google Flags These as Issues

Google Search Console's "Page with redirect" issue means:
- Google discovered a URL that redirects instead of serving content
- Google prefers direct access to canonical URLs
- Redirects can slow down crawling and indexing

However, these redirects are **necessary and correct**:
1. **Legacy URL cleanup** - Old product SKU URLs need to redirect to new structure
2. **Canonical domain enforcement** - Non-www must redirect to www
3. **Security** - HTTP must redirect to HTTPS

## Current Implementation Status

### ✅ What's Working Correctly

1. **Redirect Handler** (`app/Router.php`)
   - Handles old product SKU URLs
   - Maps SKUs to cities and products
   - Uses 301 permanent redirects

2. **Server-Level Redirects** (`.htaccess`)
   - HTTP → HTTPS (301)
   - Non-www → www (301)
   - Proper redirect order

3. **Sitemaps**
   - Only include www URLs (from `Config::get('app_url')`)
   - Do NOT include old product SKU URLs
   - Use canonical URLs only

4. **Canonical Tags**
   - All pages use www URLs in canonical tags
   - Consistent domain usage

### ⚠️ Why Google Still Sees These

1. **External Links** - Other sites may link to old product SKU URLs
2. **Old Sitemaps** - Previously submitted sitemaps may have included old URLs
3. **Google's Discovery** - Google may discover URLs through various means
4. **Crawl Lag** - Google needs time to recrawl and update its index

## Recommendations

### 1. Monitor and Wait (Recommended)
- These redirects are **correct and necessary**
- Google will eventually update its index
- Redirects will resolve as Google recrawls
- No action needed - this is expected behavior

### 2. Request Re-indexing (Optional)
- In GSC, request re-indexing of canonical URLs
- This helps Google discover the final destinations faster
- Use "URL Inspection" tool for important pages

### 3. Check for External Links (Optional)
- Use tools like Ahrefs/SEMrush to find external links to old URLs
- Contact site owners to update links (if feasible)
- Focus on high-authority sites first

### 4. Verify Redirects Are Working (Verification)
Test a few redirects to ensure they're working:
```bash
# Test old product SKU redirect
curl -I https://www.floodbarrierpros.com/products/rfp-resident-labell
# Should return: 301 → https://www.floodbarrierpros.com/fl/{city}/modular-flood-barrier

# Test non-www redirect
curl -I https://floodbarrierpros.com/
# Should return: 301 → https://www.floodbarrierpros.com/

# Test HTTP redirect
curl -I http://www.floodbarrierpros.com/
# Should return: 301 → https://www.floodbarrierpros.com/
```

## Conclusion

**These redirects are intentional and correct.** They serve important purposes:
- ✅ Clean up legacy URLs
- ✅ Enforce canonical domain (www)
- ✅ Enforce HTTPS security

Google Search Console flags them as "issues" because they redirect instead of serving content, but this is the **desired behavior**. Over time, as Google recrawls and updates its index, these will resolve naturally.

**No code changes needed** - the redirect implementation is working correctly.

