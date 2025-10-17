# Rubicon Sitemap Architecture Guide

## Overview

This guide covers the sectioned sitemap architecture implemented for FloodBarrierPros, optimized for AI indexing, crawl efficiency, and Search Console diagnostics.

## Architecture

### Sitemap Structure

```
/sitemap-index.xml.gz          ← Main index (submit this to GSC)
├── /sitemap-static.xml.gz     ← Core pages (home, about, contact)
├── /sitemap-products.xml.gz   ← Product pages (/products/*)
├── /sitemap-faq.xml.gz        ← FAQ pages (/faq/*)
├── /sitemap-reviews.xml.gz    ← Testimonials & reviews
└── /sitemap-blog.xml.gz       ← Blog posts & news
```

### Why Sectioned Sitemaps?

#### ✅ Crawl Efficiency & Priority Control
- **FAQ sitemap**: Weekly crawl (structured Q&A content)
- **Product sitemap**: Daily crawl (high commercial value)
- **Blog sitemap**: Daily crawl (time-sensitive content)
- **Review sitemap**: Monthly crawl (low churn)

#### ✅ AI & Semantic Crawling (2025)
- LLMs prioritize thematic clusters
- `/faq-sitemap.xml` signals structured Q&A for AI Overview training
- `/product-sitemap.xml` boosts product snippet eligibility

#### ✅ Indexation Diagnostics
- Google Search Console shows per-section indexation health
- Clear feedback on which schema types are working
- Independent error containment

## Usage

### Generate Sitemaps

```bash
# Basic generation
php bin/build_sitemaps.php

# Custom options
php bin/build_sitemaps.php \
  --base=https://floodbarrierpros.com \
  --output=public/sitemaps/ \
  --gzip=1 \
  --max-urls=10000
```

### Automated Regeneration

```bash
# Test cron script
php bin/cron_sitemaps.php

# Set up cron job (daily at 2 AM)
0 2 * * * php /path/to/bin/cron_sitemaps.php
```

### Access Sitemaps

- **Index**: `https://floodbarrierpros.com/sitemaps/sitemap-index.xml.gz`
- **FAQ**: `https://floodbarrierpros.com/sitemaps/sitemap-faq.xml.gz`
- **Products**: `https://floodbarrierpros.com/sitemaps/sitemap-products.xml.gz`

## Configuration

### robots.txt Integration

The generator automatically updates `robots.txt` with sitemap references:

```
User-agent: *
Allow: /
Disallow: /admin/
Disallow: /private/

# Sitemaps
Sitemap: https://floodbarrierpros.com/sitemaps/sitemap-index.xml.gz
Sitemap: https://floodbarrierpros.com/sitemaps/sitemap-faq.xml.gz
Sitemap: https://floodbarrierpros.com/sitemaps/sitemap-products.xml.gz
```

### Content Sources

| Sitemap | Source Directory | URL Pattern |
|---------|------------------|-------------|
| FAQ | `/data/faqs/pages/` | `/faq/{slug}` |
| Products | Hardcoded | `/products/{slug}` |
| Reviews | `/data/reviews/products/` | `/testimonials/{slug}` |
| Blog | `/app/Data/blog/` | `/blog/{slug}` |
| Static | Hardcoded | Core pages |

## Google Search Console Setup

### 1. Submit Sitemap Index

Submit only the main index to GSC:
```
https://floodbarrierpros.com/sitemaps/sitemap-index.xml.gz
```

### 2. Monitor Section Performance

In GSC, you'll see separate reports for:
- FAQ pages indexation
- Product rich results eligibility
- Blog post coverage
- Review snippet validation

### 3. AI Overview Optimization

The FAQ sitemap is specifically optimized for AI Overview inclusion:
- Structured Q&A format
- High priority (0.8)
- Weekly changefreq
- Semantic clustering

## Maintenance

### File Size Limits
- Max 10,000 URLs per sitemap
- Max 50MB per file (gzipped)
- Automatic splitting if limits exceeded

### Regeneration Schedule
- **Products**: Daily (commercial priority)
- **FAQ**: Weekly (content updates)
- **Blog**: On publish (time-sensitive)
- **Reviews**: Monthly (low churn)

### Monitoring
- Check GSC for indexation errors
- Monitor crawl frequency per section
- Track rich result eligibility

## Troubleshooting

### Common Issues

1. **404 on sitemap URLs**
   - Check file permissions in `/public/sitemaps/`
   - Verify router routes are registered

2. **Empty sitemaps**
   - Check source directories exist
   - Verify file naming conventions

3. **GSC submission errors**
   - Ensure gzipped files are accessible
   - Check robots.txt references

### Debug Commands

```bash
# Check sitemap generation
php bin/build_sitemaps.php --force

# Test sitemap access
curl -I https://floodbarrierpros.com/sitemaps/sitemap-index.xml.gz

# Validate XML structure
gunzip -c public/sitemaps/sitemap-faq.xml.gz | xmllint --format -
```

## Performance Benefits

### Before (Single Sitemap)
- 646 URLs in one file
- Mixed content types
- Difficult diagnostics
- Single point of failure

### After (Sectioned Sitemaps)
- 5 focused sitemaps
- Clear content categorization
- Independent monitoring
- AI-optimized structure

## Next Steps

1. **Submit to GSC**: Add sitemap-index.xml.gz to Google Search Console
2. **Monitor Performance**: Track indexation rates per section
3. **Optimize Content**: Use GSC data to improve FAQ and product pages
4. **AI Integration**: Monitor AI Overview inclusion for FAQ content
5. **Automation**: Set up cron job for regular regeneration

## Files Created

- `bin/build_sitemaps.php` - Main sitemap generator
- `bin/cron_sitemaps.php` - Automated regeneration script
- `public/sitemaps/` - Generated sitemap files
- `public/robots.txt` - Updated with sitemap references
- `SITEMAP_GUIDE.md` - This documentation

## Support

For issues or questions:
1. Check logs in `/logs/sitemap_cron.log`
2. Verify file permissions and directory structure
3. Test individual sitemap URLs
4. Review GSC indexation reports
