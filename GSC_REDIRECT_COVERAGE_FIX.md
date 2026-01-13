# GSC Redirect Coverage Issue Fix

## Issue Summary

Google Search Console reports **390 pages with redirects** (as of 2026-01-13). The breakdown:

- **2 HTTP URLs** (`http://`) → Redirect to HTTPS
- **241 non-www HTTPS URLs** (`https://floodbarrierpros.com`) → Redirect to www
- **159 old product SKU URLs** (`/products/rfp-*`) → Redirect to canonical location pages
- **Other URLs** (regions with trailing slashes, keyword variations, etc.) → Redirect to canonical versions

## Root Cause Analysis

All redirects are **intentional and correct**. They serve important purposes:

1. **HTTP → HTTPS**: Security best practice
2. **Non-www → www**: Canonical domain enforcement
3. **Old product SKUs → Location pages**: Legacy URL cleanup and SEO consolidation
4. **Keyword variations → Canonical keywords**: URL normalization

However, Google Search Console flags these as "coverage issues" because:
- Google discovered URLs that redirect instead of serving content
- Google prefers direct access to canonical URLs
- Redirects can slow down crawling and indexing

## Current Redirect Implementation

### 1. HTTP → HTTPS Redirect
**Location:** `public/.htaccess` (lines 16-22)

```apache
RewriteCond %{REQUEST_URI} !^/(data|sitemaps)/ [NC]
RewriteCond %{HTTPS} off
RewriteCond %{HTTP:X-Forwarded-Proto} !https
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [R=301,L]
```

**Status:** ✅ Working correctly

### 2. Non-www → www Redirect
**Locations:**
- `public/.htaccess` (lines 24-31) - Primary
- `public/index.php` (lines 24-32) - Backup

```php
// PHP-level backup redirect
if ($host === 'floodbarrierpros.com') {
    $redirectUrl = 'https://www.floodbarrierpros.com' . $requestUri;
    header('Location: ' . $redirectUrl, true, 301);
    exit;
}
```

**Status:** ✅ Working correctly

### 3. Old Product SKU Redirects
**Location:** `app/Router.php` - `handleRedirects()` method (lines 234-300)

Redirects `/products/rfp-*` URLs to:
- Location pages: `/fl/{city}/{product-slug}` (if city is detected)
- Canonical product pages: `/products/{product-slug}` (if no city detected)

**Status:** ✅ Working correctly

### 4. Trailing Slash Redirects
**Location:** `app/Router.php` - `handleRedirects()` method (lines 217-220)

Removes trailing slashes (except root):
```php
if ($uri !== '/' && substr($uri, -1) === '/') {
    return rtrim($uri, '/');
}
```

**Status:** ✅ Working correctly

### 5. Keyword Variation Redirects
**Location:** `app/Router.php` - `handleRedirects()` method (lines 317-337)

- `/flood-panels/{city}` → `/home-flood-barriers/{city}`
- `/flood-protection/{city}` → `/home-flood-barriers/{city}`
- `/flood-panels` → `/home-flood-barriers`
- `/flood-protection` → `/home-flood-barriers`

**Status:** ✅ Working correctly

## Sitemap Configuration

**Current Configuration:**
- `app/Config.php`: `app_url` = `'https://www.floodbarrierpros.com'` (canonical www)
- All sitemaps use `Config::get('app_url')` as base URL
- Sitemaps only include canonical URLs (www, HTTPS, no old SKU URLs)

**Status:** ✅ Correct - sitemaps only include canonical URLs

## Why Google Still Sees Redirects

Even though sitemaps are correct, Google discovers redirect URLs through:

1. **External Links**: Other sites may link to non-www or old product SKU URLs
2. **Old Sitemaps**: Previously submitted sitemaps may have included old URLs
3. **Google's Discovery**: Google discovers URLs through various crawling methods
4. **Crawl Lag**: Google needs time to recrawl and update its index

## Solution Strategy

### ✅ What's Already Correct

1. All redirects use **301 (permanent)** status codes
2. Sitemaps only include canonical URLs (www, HTTPS)
3. Redirect logic is properly implemented
4. Canonical tags use www URLs

### 📋 Recommended Actions

#### 1. Monitor and Wait (Primary Strategy)
- **Action**: No code changes needed
- **Rationale**: Redirects are working correctly. Google will recrawl and update its index over time
- **Expected Resolution**: 2-8 weeks after deployment

#### 2. Verify Sitemaps (Verification)
- **Action**: Ensure all sitemaps use canonical URLs
- **Status**: ✅ Already verified - sitemaps use `Config::get('app_url')` which is `https://www.floodbarrierpros.com`

#### 3. Submit Updated Sitemaps (Optional)
- **Action**: Resubmit sitemaps to Google Search Console
- **Purpose**: Ensure Google has the latest sitemap with only canonical URLs
- **Steps**:
  1. Go to Google Search Console
  2. Navigate to Sitemaps
  3. Resubmit `https://www.floodbarrierpros.com/sitemaps/sitemap-index.xml`

#### 4. Request Re-indexing (Optional)
- **Action**: Use Google Search Console to request re-indexing of canonical URLs
- **Purpose**: Help Google discover canonical URLs faster
- **Note**: This won't remove redirect URLs from index immediately

## Expected Behavior Over Time

### Timeline

- **Week 1-2**: Google recrawls redirect URLs, follows 301 redirects
- **Week 3-4**: Google updates index with canonical URLs
- **Week 5-8**: Redirect URLs gradually drop from coverage report
- **Week 8+**: Most redirect URLs resolved, coverage report improves

### Factors Affecting Resolution Speed

1. **Crawl Frequency**: Google crawls based on site authority and update frequency
2. **External Links**: URLs with many external links may take longer to update
3. **Old URLs**: URLs that haven't been crawled recently may take longer
4. **Index Update Lag**: Google's index updates can take several weeks

## Testing Verification

### Test Redirects Are Working

```bash
# Test HTTP → HTTPS redirect
curl -I http://www.floodbarrierpros.com/
# Should return: 301 → https://www.floodbarrierpros.com/

# Test non-www → www redirect
curl -I https://floodbarrierpros.com/
# Should return: 301 → https://www.floodbarrierpros.com/

# Test old product SKU redirect
curl -I https://www.floodbarrierpros.com/products/rfp-home-flo-tampa
# Should return: 301 → https://www.floodbarrierpros.com/fl/tampa/modular-flood-barrier

# Test trailing slash redirect
curl -I https://www.floodbarrierpros.com/regions/marco-island/
# Should return: 301 → https://www.floodbarrierpros.com/regions/marco-island

# Test keyword variation redirect
curl -I https://www.floodbarrierpros.com/flood-panels/miami
# Should return: 301 → https://www.floodbarrierpros.com/home-flood-barriers/miami
```

### Verify Sitemaps Use Canonical URLs

```bash
# Check sitemap index
curl -s https://www.floodbarrierpros.com/sitemaps/sitemap-index.xml | grep -o 'https://www.floodbarrierpros.com[^<]*' | head -20

# All URLs should start with https://www.floodbarrierpros.com
# Should NOT include:
# - http:// URLs
# - https://floodbarrierpros.com (non-www)
# - /products/rfp-* URLs
```

## Conclusion

**These redirects are intentional and correct.** They serve important purposes:
- Security (HTTP → HTTPS)
- Canonical domain enforcement (non-www → www)
- Legacy URL cleanup (old product SKUs → canonical URLs)
- URL normalization (keyword variations → canonical keywords)

Google Search Console flags them as "coverage issues" because they redirect instead of serving content, but this is **desired behavior**. Over time, as Google recrawls and updates its index, these will resolve naturally.

**No code changes are needed** - the redirect implementation is working correctly. The recommended action is to monitor the coverage report over the next 2-8 weeks as Google recrawls and updates its index.

## Related Documentation

- `REDIRECT_ANALYSIS.md` - Detailed redirect analysis
- `REDIRECT_FIX_SUMMARY.md` - Previous redirect fixes
- `GSC_REDIRECT_FIX_SUMMARY.md` - GSC redirect fix summary
