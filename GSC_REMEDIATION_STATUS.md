# GSC Remediation Status
**SUDO META DIRECTIVE Implementation**

---

## P0: CANONICAL HOST ENFORCEMENT ✅ COMPLETE

### Verified:
- ✅ Config uses `https://www.floodbarrierpros.com`
- ✅ `.htaccess` has HTTP→HTTPS redirect (301)
- ✅ `.htaccess` has non-www→www redirect (301)
- ✅ PHP-level redirect in `index.php` (backup)
- ✅ Canonical tags in layout use `$canonical` variable
- ✅ `View::normalizeSchemaUrls()` normalizes JSON-LD URLs to canonical
- ✅ Sitemaps use `Config::get('app_url')` (www)

**Status:** P0 COMPLETE - No action needed

---

## P1: PAGE INTENT LOCKING ⚠️ NEEDS FIXES

### Issues Found:

#### 1. Matrix Pages (City/Service Pages)
**File:** `app/Controllers/PagesController.php::matrix()`
**Issue:** SWFLContent::generateSchema() includes Product schema on city/service pages
**Required:** Remove Product schema, keep only LocalBusiness, Service, FAQPage, BreadcrumbList

#### 2. Product Pages
**File:** `app/Controllers/ProductController.php`
**Status:** Need to verify no LocalBusiness/Service/FAQPage schema

#### 3. Blog Pages
**File:** `app/Controllers/BlogController.php`
**Status:** Need to verify no Product/Review/LocalBusiness/Service schema

---

## P2: STRUCTURED DATA RECONSTRUCTION ⚠️ NEEDS FIXES

### A) Product Pages
**Current:** Product, Offer, AggregateRating, BreadcrumbList ✅
**Issue:** Need to verify no LocalBusiness, FAQPage, Service

### B) City/Service Pages
**Current:** LocalBusiness, Service, FAQPage, BreadcrumbList, **Product** ❌
**Required:** Remove Product schema from city/service pages
**File:** `app/SWFLContent.php::generateSchema()`

### C) Blog Pages
**Current:** Article, BreadcrumbList ✅
**Status:** Need to verify no Product/Review/LocalBusiness/Service

---

## P3-P7: PENDING

- P3: Snippet & CTR Repair (titles/meta for top-10 queries)
- P4: Above-the-fold conversion blocks
- P5: Internal link funnels
- P6: Geo hardening
- P7: Verification checklist

---

## IMMEDIATE ACTION REQUIRED

**Priority 1:** Remove Product schema from city/service pages (P1/P2)
- Modify `SWFLContent::generateSchema()` to NOT include Product schema
- OR filter out Product schema in matrix() method

**Priority 2:** Verify product pages have correct schema only
**Priority 3:** Verify blog pages have correct schema only

