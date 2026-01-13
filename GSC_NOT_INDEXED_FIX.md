# GSC "Crawled - Currently Not Indexed" Analysis

## Issue Summary

Google Search Console reports **122 pages with "Crawled - currently not indexed"** status (as of 2026-01-13). These pages have been crawled by Google but are not being indexed.

## URL Pattern Analysis

### Breakdown by Type

1. **Sitemap/Technical Files (8 URLs)** - Should NOT be indexed
   - `/sitemaps/sitemap-*.xml` files
   - `/sitemaps/sitemap-ai.ndjson`
   - `/favicon.ico`
   - `/sitemap-news.xml`
   - **Status**: ✅ Correct behavior - these files should not be indexed

2. **Non-www URLs (101 URLs)** - Should redirect to www
   - `https://floodbarrierpros.com/*` (non-www)
   - **Status**: Should redirect to www before indexing

3. **Content Pages (13+ URLs)** - Should be indexed
   - City pages (`/city/*`)
   - Service pages (`/home-flood-barriers/*`, `/residential-flood-panels/*`, `/flood-protection-for-homes/*`)
   - Location pages (`/fl/*`)
   - FAQ pages (`/faq/*`)
   - Testimonials (`/testimonials/*`)
   - News articles (`/news/*`)

## Root Cause Analysis

### 1. Sitemap Files (Expected Behavior)

**Status**: ✅ **Correct** - Sitemap files should NOT be indexed
- Sitemaps are discovery tools, not content pages
- Google crawls them to discover URLs but doesn't index them
- This is expected and correct behavior

**Recommendation**: No action needed - this is correct behavior

### 2. Non-www URLs (Redirect Issue)

**101 URLs are non-www** (`https://floodbarrierpros.com/*`)
- These should redirect to www versions
- Non-www → www redirects are implemented (`.htaccess` and `index.php`)
- Google may have crawled these before redirects were fully propagated
- Once redirected, Google will index the www version instead

**Recommendation**: Monitor - redirects are in place, Google will update as it recrawls

### 3. Content Pages Not Indexed

**Possible Reasons:**
1. **Duplicate Content**: Pages may be duplicates of other indexed pages
2. **Low Quality**: Google's algorithm may determine pages don't add value
3. **Crawl Priority**: Google may prioritize other pages for indexing
4. **Indexing Delay**: Pages may be queued for indexing (normal delay)

## Current Implementation Status

### ✅ Redirects Implemented

1. **Non-www → www Redirect**
   - **Location**: `public/.htaccess` (lines 24-31), `public/index.php` (lines 24-32)
   - **Status**: ✅ Implemented
   - Non-www URLs redirect to www before content is served

### ✅ Meta Robots Tags

1. **Content Pages**
   - **Location**: `app/Templates/layout.php`
   - **Status**: ✅ Implemented
   - Meta robots tag: `index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1`
   - Explicitly tells Google to index pages

2. **Sitemap Files**
   - **Status**: ✅ Should not have index directive (they're XML files, not HTML)
   - Sitemap files are served as XML, not HTML pages
   - Google correctly doesn't index them

## Why Google Doesn't Index Some Pages

Google may choose not to index pages for various reasons:

1. **Sitemap Files**: Correctly not indexed (discovery tools, not content)
2. **Duplicate Content**: Google may choose one version to index
3. **Quality Signals**: Google's algorithm determines indexing priority
4. **Crawl Budget**: Google allocates crawl budget based on site authority and update frequency
5. **Indexing Delay**: Normal delay between crawling and indexing

## Expected Behavior

### Sitemap Files (8 URLs)
- **Status**: ✅ **Correct** - Should NOT be indexed
- **Action**: No action needed
- These are discovery tools, not content pages

### Non-www URLs (101 URLs)
- **Status**: Should redirect to www
- **Action**: Monitor - redirects are in place
- **Expected Resolution**: As Google recrawls, it will follow redirects and index www versions

### Content Pages (13+ URLs)
- **Status**: May be indexed over time or may remain not indexed
- **Reason**: Google's algorithmic decision based on quality, duplicates, etc.
- **Action**: Monitor - this is normal behavior for some pages

## Recommendations

### 1. Sitemap Files (No Action Needed)
- **Status**: ✅ Correct behavior
- **Action**: None - sitemaps should not be indexed
- **Note**: This is expected and correct

### 2. Non-www URLs (Monitor)
- **Status**: Redirects are in place
- **Action**: Monitor as Google recrawls
- **Expected Resolution**: 2-8 weeks as Google recrawls and follows redirects

### 3. Content Pages (Normal Behavior)
- **Status**: Google's algorithmic decision
- **Action**: Monitor - this is normal
- **Factors**:
  - Google may index pages over time
  - Some pages may remain not indexed (normal)
  - Focus on improving page quality and reducing duplicates

### 4. Improve Content Quality (Optional)
- Ensure pages have unique, high-quality content
- Reduce duplicate content across pages
- Ensure pages add value beyond other indexed pages
- Improve internal linking structure

## Testing Verification

### Verify Sitemap Files Should Not Be Indexed

```bash
# Check sitemap file content-type (should be XML, not HTML)
curl -I https://www.floodbarrierpros.com/sitemaps/sitemap-blog.xml
# Should return: Content-Type: application/xml (not text/html)
# Should NOT have meta robots tag (it's XML, not HTML)
```

### Verify Non-www Redirects

```bash
# Test non-www → www redirect
curl -I https://floodbarrierpros.com/city/orlando
# Should return: 301 → https://www.floodbarrierpros.com/city/orlando
```

### Verify Content Pages Have Index Directive

```bash
# Check meta robots tag on content pages
curl -s https://www.floodbarrierpros.com/city/venice | grep -i 'meta.*robots'
# Should return: <meta name="robots" content="index, follow, ..." />
```

## Conclusion

### ✅ Sitemap Files (8 URLs)
- **Status**: ✅ **Correct behavior** - Should NOT be indexed
- **Action**: None needed
- This is expected and correct

### ✅ Non-www URLs (101 URLs)
- **Status**: Redirects are implemented
- **Action**: Monitor as Google recrawls
- **Expected Resolution**: 2-8 weeks

### ✅ Content Pages (13+ URLs)
- **Status**: Google's algorithmic decision
- **Action**: Monitor - this is normal behavior
- Some pages may be indexed over time, others may remain not indexed

**Overall**: Most of these "not indexed" statuses are either:
1. **Expected behavior** (sitemap files shouldn't be indexed)
2. **Temporary** (non-www URLs that redirect)
3. **Normal** (Google's algorithmic indexing decisions)

**No code changes are needed** - the implementation is correct.

## Related Documentation

- `INDEXING_FIX_SUMMARY.md` - Previous indexing fixes
- `INDEXING_ISSUES_ANALYSIS.md` - Indexing issues analysis
- `GSC_REDIRECT_COVERAGE_FIX.md` - Redirect coverage fix
- `GSC_DUPLICATE_CANONICAL_FIX.md` - Duplicate canonical fix
