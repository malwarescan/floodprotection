# Canonical Tag Fix Summary

## Issue
Google Search Console reported 169 pages with "Alternate page with proper canonical tag" issues. The site was accessible via both `www.floodbarrierpros.com` and `floodbarrierpros.com` (non-www), causing duplicate content issues.

## Root Cause
1. **Config.php** was set to use `https://floodbarrierpros.com` (non-www)
2. **View.php** was using `$_SERVER['REQUEST_URI']` directly, which could reflect either www or non-www depending on how users accessed the page
3. No server-level redirect was in place to enforce a canonical domain
4. Canonical URLs were not consistently normalized to use the www version

## Solution Implemented

### 1. Updated Config.php
- Changed `app_url` from `https://floodbarrierpros.com` to `https://www.floodbarrierpros.com`
- This ensures all new canonical URLs use the www version

### 2. Added URL Normalization Function (Util.php)
- Created `Util::normalizeCanonicalUrl()` function that:
  - Handles both relative and absolute URLs
  - Normalizes non-www URLs to www version
  - Ensures consistent canonical URL format across the site

### 3. Updated View.php
- Modified `renderPage()` to normalize canonical URLs:
  - Normalizes the default canonical URL constructed from `REQUEST_URI`
  - Normalizes any canonical URL passed in the `$data` array
  - Ensures all pages have consistent www canonical URLs

### 4. Added .htaccess Redirect Rule
- Added 301 redirect from non-www to www:
  ```apache
  RewriteCond %{HTTP_HOST} ^floodbarrierpros\.com$ [NC]
  RewriteRule ^(.*)$ https://www.floodbarrierpros.com/$1 [R=301,L]
  ```
- This ensures all non-www requests are permanently redirected to www

## Files Modified

1. **app/Config.php**
   - Updated `app_url` to use www version

2. **app/Util.php**
   - Added `normalizeCanonicalUrl()` helper function

3. **app/View.php**
   - Updated `renderPage()` to normalize canonical URLs

4. **public/.htaccess**
   - Added redirect rule from non-www to www

## Expected Results

1. **Immediate**: All new page requests will have canonical tags pointing to www version
2. **After Google Re-crawl**: 
   - Non-www URLs will redirect to www (301 redirect)
   - All canonical tags will consistently point to www version
   - Google Search Console issues should resolve as pages are re-crawled

## Testing Recommendations

1. Test that non-www URLs redirect to www:
   ```bash
   curl -I https://floodbarrierpros.com/regions/goodland/
   # Should return 301 redirect to https://www.floodbarrierpros.com/regions/goodland/
   ```

2. Verify canonical tags on pages:
   - Check that all `<link rel="canonical">` tags use `https://www.floodbarrierpros.com`
   - Test both www and non-www access (non-www should redirect)

3. Monitor Google Search Console:
   - Wait for Google to re-crawl affected pages
   - Verify that "Alternate page with proper canonical tag" issues decrease
   - Expected resolution time: 1-2 weeks after deployment

## Notes

- The redirect rule in .htaccess should be placed before the existing rewrite rules
- All existing controllers that use `Config::get('app_url')` will automatically use the www version
- The normalization function handles edge cases like relative URLs and already-normalized URLs

