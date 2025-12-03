# Google Search Console Action Checklist

## ✅ Immediate Actions

### 1. Submit New Sitemap
**Location:** Google Search Console → Sitemaps → Add new sitemap

**Sitemap URL:**
```
https://www.floodbarrierpros.com/sitemaps/sitemap-index.xml.gz
```

**Why:** This includes all updated pages with correct www URLs and new pages (products, resources, contact).

---

### 2. Request Re-Indexing of Key Pages
**Location:** Google Search Console → URL Inspection → Enter URL → Request Indexing

**Priority Pages to Re-Index:**
1. `https://www.floodbarrierpros.com/` (Homepage)
2. `https://www.floodbarrierpros.com/products` (New page)
3. `https://www.floodbarrierpros.com/resources` (New page)
4. `https://www.floodbarrierpros.com/contact` (New page)
5. `https://www.floodbarrierpros.com/city/tampa` (Previously broken)

**Why:** Forces Google to re-crawl and verify fixes are applied.

---

### 3. Verify Fixes in Coverage Report
**Location:** Google Search Console → Coverage

**Check These Issues (should be resolved):**
- ✅ **Alternate page with proper canonical tag** (169 pages)
  - Status: Fixed - All canonical URLs now use www version
  - Action: Monitor for decrease over next few days

- ✅ **Not found (404)** (81 pages)
  - Status: Fixed - Added redirects and new pages
  - Action: Monitor for decrease

- ✅ **Page with redirect** (2 pages)
  - Status: Fixed - HTTP→HTTPS redirects implemented
  - Action: Should disappear

- ✅ **Crawled - currently not indexed** (17 pages)
  - Status: Fixed - Added robots meta tags and sitemaps
  - Action: Request indexing for these pages

- ✅ **Duplicate, Google chose different canonical than user** (2 pages)
  - Status: Fixed - Canonical URLs normalized
  - Action: Should resolve automatically

---

### 4. Check Structured Data
**Location:** Google Search Console → Enhancements → Structured Data

**Verify:**
- ✅ Product schema includes `applicableCountry` in `hasMerchantReturnPolicy`
- ✅ LocalBusiness schema is valid
- ✅ FAQPage schema (where applicable)
- ✅ BreadcrumbList schema

**Action:** Check for any errors or warnings.

---

### 5. Monitor Performance
**Location:** Google Search Console → Performance

**Monitor:**
- Search impressions (should increase)
- Click-through rate (CTR)
- Average position
- Core Web Vitals (LCP, FID, CLS)

**Action:** Compare performance before/after fixes.

---

### 6. Check Mobile Usability
**Location:** Google Search Console → Mobile Usability

**Verify:**
- All pages are mobile-friendly
- No mobile usability errors

---

### 7. Verify Resource Loading
**Location:** Google Search Console → Page Resources

**Check:**
- ✅ Preline CSS should load from unpkg (not jsdelivr)
- ⚠️ Tailwind CDN redirect is normal (CDN versioning)
- ✅ ourcasa.ai embed script disabled (prevents 404)

**Action:** Monitor for any new resource errors.

---

## 📊 Expected Results Timeline

### Week 1
- Sitemap submitted and processed
- Re-indexing requests processed
- Coverage errors start decreasing

### Week 2-4
- Coverage errors significantly reduced
- Performance metrics improve
- New pages start appearing in search results

### Month 2-3
- Full indexing of all pages
- Improved search rankings
- Better CTR from optimized meta tags

---

## 🔍 Monitoring Checklist

**Daily (First Week):**
- [ ] Check Coverage report for new errors
- [ ] Monitor Performance metrics
- [ ] Check URL Inspection for re-indexing status

**Weekly:**
- [ ] Review Coverage report trends
- [ ] Check Structured Data for errors
- [ ] Monitor Core Web Vitals
- [ ] Review search queries and positions

**Monthly:**
- [ ] Full SEO audit
- [ ] Compare performance vs. previous month
- [ ] Review and update sitemaps if needed

---

## 📝 Notes

- **Canonical URLs:** All now use `https://www.floodbarrierpros.com`
- **Sitemaps:** Updated with www URLs and new pages
- **Redirects:** HTTP→HTTPS and non-www→www implemented
- **Resource Errors:** Fixed Preline CSS MIME type, disabled broken ourcasa.ai script
- **New Pages:** Products, Resources, Contact pages added

---

## 🚨 If Issues Persist

1. **Check URL Inspection** for specific pages
2. **Review Coverage Details** for error explanations
3. **Verify .htaccess** redirects are working
4. **Check robots.txt** is accessible
5. **Verify sitemap** is accessible and valid XML

---

## 📞 Support Resources

- **Google Search Console Help:** https://support.google.com/webmasters
- **Sitemap Guidelines:** https://developers.google.com/search/docs/crawling-indexing/sitemaps/overview
- **Canonical URLs:** https://developers.google.com/search/docs/crawling-indexing/canonicalization

