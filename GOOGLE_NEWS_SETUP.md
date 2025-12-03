# Google News Setup - Complete Implementation

## ✅ NewsArticle Schema (JSON-LD)

All programmatic news articles now include **Google News-compliant NewsArticle schema** with:

### Required Fields
- ✅ **headline** - Article title
- ✅ **datePublished** - ISO 8601 format (`YYYY-MM-DDTHH:MM:SS+00:00`)
- ✅ **dateModified** - ISO 8601 format
- ✅ **author** - Organization (Flood Barrier Pros)
- ✅ **publisher** - Organization with logo (ImageObject with width/height)
- ✅ **image** - ImageObject with URL, width (1200), height (630)
- ✅ **description** - Article description/subtitle
- ✅ **url** - Canonical URL
- ✅ **mainEntityOfPage** - WebPage with @id

### Additional Fields
- ✅ **articleSection** - "Flood Protection"
- ✅ **about** - Array of Thing/Place objects
- ✅ **keywords** - Array of relevant keywords
- ✅ **inLanguage** - "en-US"

### Schema Location
- Rendered in `<head>` via `layout.php`
- Format: `application/ld+json`
- Included in `@graph` array with WebSite and BreadcrumbList

## ✅ Google News XML Sitemap

### Sitemap URL
- **Location**: `/sitemap-news.xml`
- **Format**: Google News XML with `news:` namespace
- **Includes**: All 20 programmatic articles + markdown news articles

### Required Tags
- ✅ **xmlns:news** - `http://www.google.com/schemas/sitemap-news/0.9`
- ✅ **news:publication** - Contains:
  - `news:name` - "Flood Barrier Pros"
  - `news:language` - "en"
- ✅ **news:publication_date** - W3C format (`YYYY-MM-DDTHH:MM:SS+00:00`)
- ✅ **news:title** - Article headline

### Included Articles
All 20 programmatic news articles:
1. Fort Myers
2. Cape Coral
3. Naples
4. Bonita Springs
5. Estero
6. Sanibel
7. Pine Island
8. Marco Island
9. Sarasota
10. Tampa
11. St. Petersburg
12. Clearwater
13. Bradenton
14. Venice
15. Port Charlotte
16. Punta Gorda
17. Miami
18. Miami Beach
19. Key West
20. Key Largo

Plus any markdown-based news articles from `/app/Data/news/`

## Schema Example

```json
{
  "@context": "https://schema.org",
  "@type": "NewsArticle",
  "headline": "New Data Warns Fort Myers Homeowners: Sandbags Fail in 50% of Flood Events...",
  "description": "A new technical report shows why traditional sandbags underperform...",
  "datePublished": "2025-12-02T00:00:00+00:00",
  "dateModified": "2025-12-02T00:00:00+00:00",
  "author": {
    "@type": "Organization",
    "name": "Flood Barrier Pros",
    "url": "https://www.floodbarrierpros.com"
  },
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
  "image": {
    "@type": "ImageObject",
    "url": "https://www.floodbarrierpros.com/assets/images/blog/flood-protection-blog.jpg",
    "width": 1200,
    "height": 630
  },
  "articleSection": "Flood Protection",
  "url": "https://www.floodbarrierpros.com/news/flood-barriers-fort-myers",
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "https://www.floodbarrierpros.com/news/flood-barriers-fort-myers"
  },
  "inLanguage": "en-US"
}
```

## Sitemap Example

```xml
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" 
        xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">
  <url>
    <loc>https://www.floodbarrierpros.com/news/flood-barriers-fort-myers</loc>
    <lastmod>2025-12-02</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.9</priority>
    <news:news>
      <news:publication>
        <news:name>Flood Barrier Pros</news:name>
        <news:language>en</news:language>
      </news:publication>
      <news:publication_date>2025-12-02T00:00:00+00:00</news:publication_date>
      <news:title>New Data Warns Fort Myers Homeowners: Sandbags Fail in 50% of Flood Events...</news:title>
    </news:news>
  </url>
</urlset>
```

## Next Steps for Google News Submission

1. **Submit Sitemap to Google Search Console**
   - Go to Google Search Console
   - Navigate to Sitemaps
   - Submit: `https://www.floodbarrierpros.com/sitemap-news.xml`

2. **Verify Schema**
   - Use Google's Rich Results Test: https://search.google.com/test/rich-results
   - Test URL: `https://www.floodbarrierpros.com/news/flood-barriers-fort-myers`
   - Verify NewsArticle schema is detected

3. **Apply for Google News**
   - Ensure you meet Google News content policies
   - Submit application through Google News Publisher Center
   - Wait for approval (typically 2-4 weeks)

4. **Monitor Performance**
   - Check Google Search Console for indexing status
   - Monitor impressions and clicks for news articles
   - Track schema validation errors

## Files Modified

- `app/NewsArticleGenerator.php` - Updated schema with image, description, proper date format
- `app/Controllers/SitemapController.php` - Added programmatic articles to news sitemap
- `app/View.php` - Fixed publisher name and date format in sitemap

## Verification

✅ All 20 articles have NewsArticle schema
✅ All articles included in `/sitemap-news.xml`
✅ Schema includes all required fields
✅ Sitemap uses proper Google News XML format
✅ Publisher name: "Flood Barrier Pros"
✅ Dates in ISO 8601 / W3C format
✅ Images included with dimensions

## Testing

Test the sitemap:
```bash
curl http://localhost:8000/sitemap-news.xml
```

Test schema on a page:
```bash
curl http://localhost:8000/news/flood-barriers-fort-myers | grep -A 20 'application/ld+json'
```

Validate with Google:
- Rich Results Test: https://search.google.com/test/rich-results
- Schema Validator: https://validator.schema.org/

