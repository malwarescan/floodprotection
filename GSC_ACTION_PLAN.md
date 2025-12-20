# Google Search Console Action Plan
## Post-Deployment Steps for City-Specific Flood Panels Pages

### ✅ Pages Deployed
1. `/residential-flood-panels/cape-coral`
2. `/residential-flood-panels/fort-myers`
3. `/residential-flood-panels/naples`
4. `/residential-flood-panels/bonita-springs`

### Base URL
https://www.floodbarrierpros.com

---

## STEP 1: Request Indexing (IMMEDIATE)

### URLs to Request Indexing For:
1. `https://www.floodbarrierpros.com/residential-flood-panels/cape-coral`
2. `https://www.floodbarrierpros.com/residential-flood-panels/fort-myers`
3. `https://www.floodbarrierpros.com/residential-flood-panels/naples`
4. `https://www.floodbarrierpros.com/residential-flood-panels/bonita-springs`

### How to Request:
1. Go to GSC → **URL Inspection** tool
2. Paste each URL
3. Click **"Request Indexing"**
4. Wait for "URL is on Google" confirmation (usually 1-24 hours)

**Why:** Forces Google to crawl and index these pages immediately instead of waiting for natural discovery.

---

## STEP 2: Validate Structured Data (WITHIN 24 HOURS)

### Check Rich Results Test:
1. GSC → **Enhancements** → **Structured Data**
2. Or use: https://search.google.com/test/rich-results
3. Test each city page URL

### Expected Schema Types:
- ✅ `LocalBusiness` (with city-specific `areaServed`)
- ✅ `Service` (Residential Flood Panel Installation)
- ✅ `FAQPage` (city-specific questions)

### What to Verify:
- No errors or warnings
- All FAQ questions appear in rich results test
- LocalBusiness shows correct city in `areaServed`

---

## STEP 3: Submit Updated Sitemap (IF NEEDED)

### Current Sitemap:
- Main sitemap: `https://www.floodbarrierpros.com/sitemap.xml`
- Pages are already included (verified)

### Action:
1. GSC → **Sitemaps**
2. If sitemap was updated, click **"Resubmit"**
3. If not already submitted, add: `https://www.floodbarrierpros.com/sitemap.xml`

**Why:** Ensures Google knows about all pages and their priority.

---

## STEP 4: Monitor Performance (ONGOING)

### Create Custom Query Filters:

#### For Cape Coral:
- Filter: `cape coral flood panels`
- Filter: `cape coral flood protection`
- Filter: `flood panels cape coral`

#### For Fort Myers:
- Filter: `fort myers flood panels`
- Filter: `fort myers flood protection`
- Filter: `storm surge protection fort myers`

#### For Naples:
- Filter: `naples flood panels`
- Filter: `naples flood protection`
- Filter: `coastal flood protection naples`

#### For Bonita Springs:
- Filter: `bonita springs flood panels`
- Filter: `bonita springs flood protection`

### Metrics to Track (Weekly):
1. **Impressions** - Should increase over 2-4 weeks
2. **CTR** - Should emerge from zero within 1-2 weeks
3. **Average Position** - Target: move from 30-50 range to top 20
4. **Clicks** - Track actual traffic

---

## STEP 5: Check for Issues (WEEKLY)

### GSC Sections to Monitor:

#### Coverage Report:
- Check for indexing errors
- Verify all 4 pages are indexed
- Fix any "Excluded" or "Error" statuses

#### Mobile Usability:
- Ensure pages pass mobile-friendly test
- Fix any mobile rendering issues

#### Core Web Vitals:
- Monitor page speed
- Fix any "Poor" or "Needs Improvement" ratings

#### Security Issues:
- Check for any security warnings
- Address immediately if found

---

## STEP 6: Validate Intent Matching (AFTER 1 WEEK)

### Use GSC Performance Report:
1. Filter by each city page URL
2. Check which queries are triggering each page
3. Verify:
   - Cape Coral queries → Cape Coral page
   - Fort Myers queries → Fort Myers page
   - Naples queries → Naples page
   - Bonita Springs queries → Bonita Springs page

### If Intent Mismatch Detected:
- Review page content for geographic clarity
- Check meta titles/descriptions
- Verify structured data `areaServed` is correct
- Ensure H1 and first paragraph are city-specific

---

## STEP 7: Monitor Rich Results (AFTER 2 WEEKS)

### Check for Rich Result Types:
1. **FAQ Rich Snippets** - Should appear in SERPs
2. **Local Business Info** - May appear in knowledge panels
3. **Service Listings** - May appear in local pack

### How to Check:
- GSC → **Enhancements** → **Structured Data**
- Look for "Valid" status with rich result previews
- Monitor actual SERP appearance via manual searches

---

## STEP 8: Performance Benchmarks (AFTER 30 DAYS)

### Success Criteria:

#### Cape Coral Page:
- ✅ Impressions: 100+ per week
- ✅ CTR: > 1% on target queries
- ✅ Position: Top 20 for "cape coral flood panels"
- ✅ Rich results: FAQ snippets appearing

#### Fort Myers Page:
- ✅ Impressions: 100+ per week
- ✅ CTR: > 1% on target queries
- ✅ Position: Top 20 for "fort myers flood panels"
- ✅ Rich results: FAQ snippets appearing

#### Naples Page:
- ✅ Impressions: 50+ per week (smaller market)
- ✅ CTR: > 1.5% on target queries (higher intent)
- ✅ Position: Top 15 for "naples flood panels"
- ✅ Rich results: FAQ snippets appearing

#### Bonita Springs Page:
- ✅ Impressions: 50+ per week (smaller market)
- ✅ CTR: > 1.5% on target queries
- ✅ Position: Top 20 for "bonita springs flood panels"
- ✅ Rich results: FAQ snippets appearing

---

## STEP 9: Fix Any GSC Warnings (AS NEEDED)

### Common Issues to Watch For:

#### "Duplicate FAQPage"
- **Fix:** Ensure only one FAQPage schema per page
- **Check:** Verify controller isn't duplicating schema

#### "Missing field 'review'"
- **Status:** Already fixed (added to Product schema)
- **Monitor:** Should not reappear

#### "Page not mobile-friendly"
- **Fix:** Test with Google Mobile-Friendly Test
- **Action:** Adjust responsive CSS if needed

#### "Crawl errors"
- **Fix:** Check server logs, verify URLs are accessible
- **Action:** Fix 404s, 500s, or blocked resources

---

## STEP 10: Create Performance Dashboard (OPTIONAL)

### Track Weekly:
- Total impressions (all 4 pages)
- Total clicks (all 4 pages)
- Average CTR
- Average position
- Rich result appearances
- Indexing status

### Tools:
- GSC Performance Report (export to CSV)
- Google Sheets for tracking
- Data Studio for visualization

---

## IMMEDIATE ACTIONS (DO TODAY):

1. ✅ Request indexing for all 4 city pages
2. ✅ Test structured data with Rich Results Test
3. ✅ Verify sitemap is submitted and up-to-date
4. ✅ Check Coverage report for any errors

## WEEKLY ACTIONS (EVERY MONDAY):

1. Review Performance report for each city
2. Check for new GSC warnings/errors
3. Monitor query-to-page mapping
4. Track CTR and position trends

## MONTHLY ACTIONS (EVERY 1ST OF MONTH):

1. Export performance data
2. Compare month-over-month metrics
3. Identify optimization opportunities
4. Review and update content if needed

---

## EXPECTED TIMELINE:

- **Week 1:** Pages indexed, initial impressions appear
- **Week 2:** CTR emerges, positions start moving
- **Week 3-4:** Rich results appear, positions stabilize
- **Month 2:** Full performance data available, optimization opportunities clear

---

## NOTES:

- **DO NOT** make content changes for 30 days after deployment (per META DIRECTIVE)
- **DO** monitor GSC daily for first week, then weekly
- **DO** document any anomalies or unexpected query mappings
- **DO** celebrate when CTR > 0% (means Google is selecting your pages!)

