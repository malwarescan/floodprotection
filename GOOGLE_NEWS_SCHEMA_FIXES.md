# Google News Schema Fixes - Why Articles Weren't Being Caught

## Issues Found & Fixed

### 1. ✅ Escaped Quotes in Headline/Description
**Problem**: Markdown front matter had quotes around values, causing double-escaping in JSON-LD
**Fix**: Updated `Util::parseMarkdownFrontMatter()` to strip surrounding quotes from values

### 2. ✅ Author Format
**Problem**: Author was a single object, but Google requires array format for multiple authors
**Fix**: Changed `author` from object to array: `[{ "@type": "Organization", ... }]`

### 3. ✅ Image Format  
**Problem**: Image was a single object, Google prefers array format for multiple images
**Fix**: Changed `image` to array: `[{ "@type": "ImageObject", ... }]`

### 4. ✅ Speakable CSS Selectors
**Problem**: CSS selectors (`article h1`, `article .lead`) don't match our HTML structure
**Fix**: Removed `speakable` property (not required, and selectors were incorrect)

## Current Schema (Google-Compliant)

```json
{
  "@type": "NewsArticle",
  "headline": "New Data Warns Fort Myers Homeowners: Sandbags Fail...",
  "description": "A new technical report shows why traditional sandbags...",
  "datePublished": "2025-12-03T00:00:00+00:00",
  "dateModified": "2025-12-03T00:00:00+00:00",
  "author": [
    {
      "@type": "Organization",
      "name": "Flood Barrier Pros",
      "url": "https://www.floodbarrierpros.com"
    }
  ],
  "publisher": {
    "@type": "Organization",
    "name": "Flood Barrier Pros",
    "url": "https://www.floodbarrierpros.com",
    "logo": {
      "@type": "ImageObject",
      "url": "https://www.floodbarrierpros.com/assets/images/logo/flood-barrier-pros-logo.png",
      "width": 600,
      "height": 60
    }
  },
  "image": [
    {
      "@type": "ImageObject",
      "url": "https://www.floodbarrierpros.com/assets/images/blog/flood-protection-blog.jpg",
      "width": 1200,
      "height": 630
    }
  ],
  "articleSection": "Flood Protection",
  "url": "https://www.floodbarrierpros.com/news/2025-12-03-flood-barriers-fort-myers",
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "https://www.floodbarrierpros.com/news/2025-12-03-flood-barriers-fort-myers"
  },
  "inLanguage": "en-US"
}
```

## Google's Requirements (Per Documentation)

According to [Google's Article structured data documentation](https://developers.google.com/search/docs/appearance/structured-data/article):

### Required Properties
- ✅ **headline** - Article title
- ✅ **author** - Array format (can be Person or Organization)
- ✅ **datePublished** - ISO 8601 format
- ✅ **publisher** - Organization with name and logo

### Recommended Properties
- ✅ **description** - Article description
- ✅ **dateModified** - ISO 8601 format
- ✅ **image** - Array of ImageObject
- ✅ **articleSection** - Section name
- ✅ **url** - Canonical URL
- ✅ **mainEntityOfPage** - WebPage with @id

## Additional Requirements for Google News

1. **News Sitemap** ✅
   - All articles in `/sitemap-news.xml`
   - Proper `news:` namespace
   - Publication date in W3C format

2. **Content Quality** ✅
   - Original, high-quality content
   - Proper article structure
   - Local relevance

3. **Technical Requirements** ✅
   - Valid HTML
   - Accessible images
   - Proper canonical URLs

## Files Modified

- `app/Util.php` - Fixed markdown front matter parsing (removes quotes)
- `app/Schema.php` - Fixed author/image arrays, removed speakable
- `app/NewsArticleGenerator.php` - Fixed author/image arrays

## Testing

Test schema validation:
```bash
curl http://localhost:8000/news/2025-12-03-flood-barriers-fort-myers | grep -A 40 '"@type": "NewsArticle"'
```

Validate with Google:
- Rich Results Test: https://search.google.com/test/rich-results
- Schema Validator: https://validator.schema.org/

## Next Steps

1. **Re-crawl in Google Search Console** - Request indexing for all 21 articles
2. **Submit News Sitemap** - Ensure `/sitemap-news.xml` is submitted
3. **Monitor** - Check Google Search Console for schema validation
4. **Wait** - Google News indexing can take 2-4 weeks

## Why Google Might Not Be Catching It

Even with correct schema, Google News has additional requirements:

1. **Time**: Articles must be recent (typically within 48 hours for news sitemap)
2. **Approval**: Site must be approved for Google News (separate application)
3. **Content**: Must meet Google News content policies
4. **Authority**: Site needs established authority in news category
5. **Crawl Frequency**: Google needs to crawl and index the pages

The schema is now correct - the remaining factors are time, approval, and Google's crawl/indexing process.

