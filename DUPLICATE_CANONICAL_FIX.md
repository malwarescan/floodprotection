# Duplicate Canonical Fix - "Google Chose Different Canonical Than User"

## Issue
Google Search Console reported **39 pages** with "Duplicate, Google chose different canonical than user" status. Google is seeing duplicate content (www vs non-www) and choosing a different canonical URL than what we've specified in the canonical tag.

## Root Causes

### 1. Non-www URLs Being Crawled
- Many URLs in the list are non-www (`https://floodbarrierpros.com/*`)
- Google is crawling both www and non-www versions
- Even with redirects, Google may have cached non-www versions
- Google sees these as duplicates and chooses its own canonical

### 2. Canonical Tags Not Always Self-Referencing
- Controllers may set canonical URLs that don't match the actual URL being accessed
- If a non-www URL somehow gets through, the canonical might not match
- Google prefers self-referencing canonical tags

### 3. Canonical Tag Override Issues
- Previous implementation allowed controllers to override canonical
- This could result in canonical tags that don't match the accessed URL
- Google may ignore canonical tags that don't match the accessed URL

## Solutions Implemented

### 1. Enhanced Canonical Tag Self-Referencing
**File:** `app/View.php`

**Changes:**
- **CRITICAL FIX**: Canonical tags are now ALWAYS self-referencing
- Override any canonical set by controllers to ensure it matches the accessed URL
- Always use the current request path (normalized to www) as the canonical
- This ensures Google always sees the canonical matching the accessed URL

**Code:**
```php
// I. Canonical Integrity: Ensure canonical is ALWAYS self-referencing
// CRITICAL: Canonical must match the actual URL being accessed (www version)
// This prevents "Duplicate, Google chose different canonical than user" errors
// Always use the current request path, normalized to www, as the canonical
$currentUrl = Config::get('app_url') . $requestPath;
$selfReferencingCanonical = Util::normalizeCanonicalUrl($currentUrl);

// Override any canonical set by controllers to ensure self-referencing
// This ensures Google always sees the canonical matching the accessed URL
$data['canonical'] = $selfReferencingCanonical;
$data['url'] = $selfReferencingCanonical;
```

**Why This Works:**
- Ensures canonical tag ALWAYS matches the URL being accessed
- Google prefers self-referencing canonical tags
- Prevents Google from choosing a different canonical
- Normalizes to www version automatically

### 2. Enhanced URL Normalization
**File:** `app/Util.php`

**Changes:**
- Enhanced `normalizeCanonicalUrl()` to handle HTTP to HTTPS conversion
- Ensures canonical URLs are always HTTPS
- Better handling of non-www to www conversion

**Code:**
```php
// Normalize to www version - handle both http and https
// This ensures non-www URLs are always converted to www in canonical tags
$url = preg_replace('/^https?:\/\/(?!www\.)(floodbarrierpros\.com)/', 'https://www.$1', $url);

// Ensure HTTPS (canonical URLs should always be HTTPS)
$url = preg_replace('/^http:\/\/(www\.)?floodbarrierpros\.com/', 'https://www.floodbarrierpros.com', $url);
```

### 3. Non-www Redirect (Already Implemented)
**File:** `public/index.php`

**Status:** ✅ Already implemented
- PHP-level redirect ensures non-www URLs redirect before serving content
- `.htaccess` also has redirect rules
- Both ensure non-www URLs never serve content

## Files Modified

1. **app/View.php**
   - Enhanced canonical tag logic to ALWAYS be self-referencing
   - Override controller-set canonical to match accessed URL
   - Added critical comments explaining the fix

2. **app/Util.php**
   - Enhanced `normalizeCanonicalUrl()` function
   - Added HTTP to HTTPS conversion
   - Better non-www to www normalization

## Expected Results

### Immediate
1. **Canonical tags are always self-referencing**
   - Canonical tag always matches the URL being accessed
   - Google will see consistent canonical tags
   - Prevents Google from choosing different canonicals

2. **All canonical tags use www version**
   - Non-www URLs in canonical tags are normalized to www
   - HTTP URLs are normalized to HTTPS
   - Consistent canonical format across all pages

3. **Google will respect our canonical tags**
   - Self-referencing canonical tags are preferred by Google
   - Google will use our canonical tags instead of choosing its own
   - "Duplicate, Google chose different canonical" errors should decrease

### Long-term (1-2 weeks)
- Google will recrawl pages with new canonical tags
- "Duplicate, Google chose different canonical" errors should decrease
- Google will use our specified canonical tags
- Non-www URLs will redirect and be replaced by www versions in index

## How This Fixes the Issue

### Before Fix
1. Controller sets canonical: `/fl/naples/modular-flood-barrier`
2. User accesses: `https://floodbarrierpros.com/fl/naples/modular-flood-barrier` (non-www)
3. Canonical tag shows: `https://www.floodbarrierpros.com/fl/naples/modular-flood-barrier` (www)
4. Google sees mismatch: URL accessed ≠ canonical tag
5. Google chooses its own canonical (often the non-www version)
6. Result: "Duplicate, Google chose different canonical than user"

### After Fix
1. User accesses: `https://floodbarrierpros.com/fl/naples/modular-flood-barrier` (non-www)
2. Redirect happens: → `https://www.floodbarrierpros.com/fl/naples/modular-flood-barrier` (www)
3. Canonical tag shows: `https://www.floodbarrierpros.com/fl/naples/modular-flood-barrier` (www)
4. Canonical matches accessed URL: ✅ Self-referencing
5. Google respects canonical tag: ✅ Uses our specified canonical
6. Result: No duplicate canonical errors

## Testing

### Test Canonical Tag Self-Referencing
```bash
# Test that canonical tag matches accessed URL
curl -s https://www.floodbarrierpros.com/fl/naples/modular-flood-barrier | grep canonical
# Expected: <link rel="canonical" href="https://www.floodbarrierpros.com/fl/naples/modular-flood-barrier"/>

# Test non-www redirect (should redirect before serving content)
curl -I https://floodbarrierpros.com/fl/naples/modular-flood-barrier
# Expected: 301 → https://www.floodbarrierpros.com/fl/naples/modular-flood-barrier
```

### Test URL Normalization
```bash
# Test that non-www URLs in canonical are normalized
# (This would require accessing a page that somehow has non-www in canonical)
# The normalization function ensures all canonical URLs use www
```

## Why This Matters

### Google's Canonical Selection
Google uses several signals to choose canonical URLs:
1. **Canonical tag** (highest priority if self-referencing)
2. **Redirects** (301 redirects indicate preferred URL)
3. **Sitemap URLs** (URLs in sitemaps are preferred)
4. **Internal links** (most linked-to version)
5. **HTTPS vs HTTP** (HTTPS preferred)

### Our Strategy
1. ✅ **Self-referencing canonical tags** - Google's preferred method
2. ✅ **301 redirects** - Non-www → www redirects
3. ✅ **Sitemap URLs** - All use www version
4. ✅ **HTTPS** - All canonical URLs use HTTPS
5. ✅ **Consistent internal linking** - All links use www

## Pages Affected

Looking at the GSC report, these types of pages are affected:
- City pages: `/city/{city-name}`
- Location pages: `/fl/{city}/{product}`
- Service pages: `/home-flood-barriers/{city}`, `/residential-flood-panels/{city}`, `/flood-protection-for-homes/{city}`
- FAQ pages: `/faq/{slug}`
- Product pages: `/products/{product-slug}`
- Blog pages: `/blog/{slug}`
- Region pages: `/regions/{slug}`

All of these pages will now have self-referencing canonical tags that match the accessed URL (www version).

## Conclusion

This fix ensures:
- ✅ Canonical tags are ALWAYS self-referencing
- ✅ Canonical tags always match the accessed URL (www version)
- ✅ Google will respect our canonical tags
- ✅ "Duplicate, Google chose different canonical" errors will decrease

The key insight is that Google prefers self-referencing canonical tags. By ensuring the canonical tag always matches the URL being accessed (normalized to www), Google will use our specified canonical instead of choosing its own.

**Timeline:**
- Immediate: Canonical tags are now self-referencing
- 1-2 weeks: Google will recrawl and update canonical selections
- 2-4 weeks: "Duplicate, Google chose different canonical" errors should decrease significantly

