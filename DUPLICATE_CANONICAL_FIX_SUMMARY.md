# Duplicate Canonical Fix Summary

## Issue
Google Search Console reported 2 pages with "Duplicate, Google chose different canonical than user" status. Google was selecting a different canonical URL than what was specified in the canonical tag.

## Affected URLs
- `https://floodbarrierpros.com/faq/flood-barrier-insurance-benefits`
- `https://floodbarrierpros.com/faq/glass-fa`

## Root Causes
1. **Non-www URLs being crawled** - Google was crawling non-www versions before redirects were fully propagated
2. **Canonical tag inconsistency** - Some FAQ pages might have had canonical tags pointing to non-www versions
3. **Missing FAQ page mappings** - Some FAQ slugs weren't in the pageMap, using default canonical
4. **Truncated slugs** - URL like `glass-fa` might be a truncated version of `glass-facade-protection`

## Solutions Implemented

### 1. Enhanced FAQ Controller Canonical Handling
Updated `FaqController::generatePageData()` to:
- Normalize slugs to handle special characters and truncation
- Add explicit mappings for affected pages (`glass-fa`, `glass-facade-protection`, `flood-barrier-insurance-benefits`)
- Double-check canonical normalization using `Util::normalizeCanonicalUrl()`
- Ensure all canonical URLs are normalized to www version

### 2. Added Missing FAQ Page Mappings
Added explicit page data for:
- `glass-fa` → redirects canonical to `glass-facade-protection`
- `glass-facade-protection` → proper canonical
- `flood-barrier-insurance-benefits` → proper canonical

### 3. Canonical Normalization Double-Check
Even though `View::renderPage()` normalizes canonical URLs, we added an extra normalization step in the FAQ controller to ensure consistency.

## Files Modified

1. **app/Controllers/FaqController.php**
   - Enhanced `generatePageData()` method
   - Added slug normalization
   - Added explicit mappings for affected pages
   - Added double-check canonical normalization

## Expected Results

1. **Immediate**:
   - All FAQ pages now have explicit canonical URLs pointing to www version
   - Affected pages have proper metadata and canonical tags
   - Canonical URLs are normalized consistently

2. **After Google Re-crawl**:
   - Google will see consistent canonical tags pointing to www versions
   - "Duplicate, Google chose different canonical than user" issues should resolve
   - Google will align with our canonical choices
   - Expected resolution time: 1-2 weeks after deployment

## Why Google Chose Different Canonical

Common reasons Google chooses a different canonical:
1. **Multiple versions accessible** - Both www and non-www were accessible (now fixed with redirects)
2. **Canonical tag inconsistency** - Tags pointed to different URLs (now normalized)
3. **Content similarity** - Google saw identical content on different URLs (redirects fix this)
4. **Authority signals** - Google preferred one version based on signals (www is now canonical)

## Testing Recommendations

1. Verify canonical tags on affected pages:
   ```bash
   curl https://www.floodbarrierpros.com/faq/flood-barrier-insurance-benefits | grep -i "canonical"
   curl https://www.floodbarrierpros.com/faq/glass-fa | grep -i "canonical"
   # Should show: <link rel="canonical" href="https://www.floodbarrierpros.com/faq/..."/>
   ```

2. Test redirects:
   ```bash
   curl -I https://floodbarrierpros.com/faq/flood-barrier-insurance-benefits
   # Should redirect to https://www.floodbarrierpros.com/faq/flood-barrier-insurance-benefits
   ```

3. Verify canonical consistency:
   ```bash
   # Both www and non-www should have same canonical (www)
   curl https://www.floodbarrierpros.com/faq/glass-fa | grep canonical
   curl https://floodbarrierpros.com/faq/glass-fa | grep canonical
   # Both should show www canonical
   ```

4. Monitor Google Search Console:
   - Wait for Google to re-crawl pages
   - Check "Coverage" report for duplicate canonical issues
   - Verify issues decrease over time

## Additional Recommendations

1. **Request Re-indexing**: After deployment, manually request indexing for affected URLs in Google Search Console

2. **Monitor Canonical Tags**: Use Google Search Console's URL Inspection tool to verify canonical tags are correct

3. **Check for Other Duplicates**: Review other FAQ pages to ensure they all have proper canonical tags

4. **Wait for Re-crawl**: Google typically re-crawls pages within 1-2 weeks, but can take longer

## Notes

- The canonical normalization happens at multiple levels:
  1. FAQ controller sets canonical using Config::get('app_url') (www)
  2. FAQ controller double-checks normalization
  3. View::renderPage() normalizes canonical URLs
  4. This ensures consistency even if accessed via non-www URL (before redirect)

- Combined with the redirect fixes (non-www → www), this ensures:
  - All URL variations redirect to www
  - All canonical tags point to www
  - Google will eventually align with our canonical choices

