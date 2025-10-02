# Rubicon Flood Protection - Florida Programmatic SEO Site

A production-ready PHP 8.1+ application for Rubicon Flood Protection, focused on Florida programmatic SEO with comprehensive JSON-LD schema markup.

## Features

- **Programmatic SEO**: Dynamic pages generated from CSV data (567+ keyword/city combinations)
- **Comprehensive Schema**: Auto-generated JSON-LD for LocalBusiness, Service, Product, FAQ, BlogPosting, NewsArticle
- **Modern UI**: Clean, responsive design with mobile-first approach
- **SEO Optimized**: Complete sitemaps, RSS feeds, robots.txt, canonical URLs
- **Content Management**: Markdown-based blog and news system
- **Fast Performance**: No framework overhead, optimized for speed

## File Structure

```
rubicon/
├── public/
│   ├── index.php          # Single entry point
│   ├── .htaccess          # URL rewriting
│   └── assets/
│       └── app.css        # Minified stylesheet
├── app/
│   ├── Config.php         # Application configuration
│   ├── Router.php         # Simple routing system
│   ├── View.php           # Template rendering
│   ├── Schema.php         # JSON-LD schema generation
│   ├── Util.php           # Helper functions
│   ├── Data/
│   │   ├── matrix.csv     # Keyword × city data (567 rows)
│   │   ├── resources.csv  # Q&A resources
│   │   ├── blog/          # Markdown blog posts
│   │   └── news/          # Markdown news articles
│   ├── Controllers/
│   │   ├── PagesController.php
│   │   ├── BlogController.php
│   │   ├── NewsController.php
│   │   ├── FeedController.php
│   │   └── SitemapController.php
│   └── Templates/
│       ├── layout.php
│       ├── home.php
│       ├── matrix-page.php
│       ├── blog-post.php
│       ├── news-article.php
│       └── resources.php
└── README.md
```

## Routes

- `/` - Home page
- `/{keyword}/{city-slug}` - Matrix pages (e.g., `/home-flood-barriers/miami`)
- `/resources/{topic-slug}/{city}` - Resource pages (e.g., `/resources/door-dams/miami`)
- `/blog` - Blog index
- `/blog/{slug}` - Blog post
- `/news` - News index
- `/news/{slug}` - News article
- `/sitemap.xml` - Sitemap index
- `/sitemap-*.xml` - Individual sitemaps
- `/feed.xml` - RSS feed
- `/robots.txt` - Robots file
- `/healthz` - Health check

## Installation

1. **Requirements**:
   - PHP 8.1 or higher
   - Web server (Apache/Nginx)
   - No database required

2. **Local Development**:
   ```bash
   cd rubicon
   php -S 0.0.0.0:8080 -t public
   ```
   Visit: http://localhost:8080

3. **Production Deployment**:
   - Point web server document root to `public/` directory
   - Ensure `.htaccess` is enabled (Apache) or configure URL rewriting (Nginx)
   - Set `APP_ENV=production` environment variable

## Configuration

Edit `app/Config.php` to customize:
- App name and URL
- Phone number and address
- Data file paths
- Environment settings

## Data Management

### Matrix Data (`app/Data/matrix.csv`)
Contains 567 rows of keyword/city combinations with:
- URL paths, titles, meta descriptions
- Product information (name, brand, SKU, pricing)
- Contact details (phone, address)
- Geographic data (lat/lng, county)
- Custom JSON-LD (optional)

### Resources (`app/Data/resources.csv`)
Q&A data for FAQ pages:
- Topic, city, question, answer
- Source URLs for credibility

### Content Management
- **Blog posts**: Add `.md` files to `app/Data/blog/`
- **News articles**: Add `.md` files to `app/Data/news/`
- Both support front-matter for metadata

## Schema Markup

The application automatically generates comprehensive JSON-LD schema:

- **WebSite** with SearchAction (all pages)
- **LocalBusiness** with NAP and geo data
- **Service** for each keyword/city combination
- **Product** with pricing and availability
- **BreadcrumbList** for navigation
- **FAQPage** when resources are available
- **BlogPosting** for blog content
- **NewsArticle** with Speakable for news

## SEO Features

- **Sitemaps**: Multiple sitemaps for different content types
- **RSS Feed**: Blog content syndication
- **Meta Tags**: Complete Open Graph and Twitter Card support
- **Canonical URLs**: Proper canonicalization
- **Mobile-First**: Responsive design
- **Fast Loading**: Optimized CSS and minimal JavaScript

## Performance

- **No Framework Overhead**: Pure PHP for maximum speed
- **Efficient Routing**: Simple pattern matching
- **Cached Data**: CSV data loaded once per request
- **Minified CSS**: Single stylesheet for all pages
- **Optimized Images**: Ready for image optimization

## Browser Support

- Modern browsers (Chrome, Firefox, Safari, Edge)
- Mobile responsive design
- Progressive enhancement approach

## Security

- **Input Sanitization**: All user input properly escaped
- **No SQL Injection**: No database queries
- **File Access Control**: Restricted to data directory
- **Error Handling**: Graceful error pages

## Maintenance

- **Content Updates**: Edit CSV files or Markdown files
- **Schema Updates**: Modify `app/Schema.php`
- **Styling**: Update `public/assets/app.css`
- **Templates**: Modify files in `app/Templates/`

## License

Proprietary - Rubicon Flood Protection

## Support

For technical support or questions about this application, contact the development team.
