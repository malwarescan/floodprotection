# GSC Remediation Implementation Plan
**SUDO META DIRECTIVE - Authoritative Execution**

---

## P0: CANONICAL HOST ENFORCEMENT ✅ (MOSTLY COMPLETE)

### Status Check:
- ✅ Config uses `https://www.floodbarrierpros.com`
- ✅ `.htaccess` has HTTP→HTTPS redirect (301)
- ✅ `.htaccess` has non-www→www redirect (301)
- ✅ PHP-level redirect in `index.php` (backup)
- ✅ Canonical tags in layout use `$canonical` variable
- ⚠️ Need to verify JSON-LD URLs are canonical
- ⚠️ Need to verify sitemaps use www URLs only

### Actions Required:
1. Verify all JSON-LD schema uses canonical URLs
2. Regenerate sitemaps with www URLs only
3. Verify no non-canonical URLs in sitemaps

---

## P1: PAGE INTENT LOCKING

### Intent Taxonomy:
- **Product pages** → TRANSACTIONAL (Product schema only)
- **City/service pages** → LEAD-GEN (LocalBusiness/Service only)
- **Blog pages** → INFORMATIONAL (Article only)

### Current Issues to Fix:
1. Product pages may have LocalBusiness/Service (remove)
2. City pages may have Product schema (remove)
3. Blog pages may have Product/Review schema (remove)

---

## P2: STRUCTURED DATA RECONSTRUCTION

### A) Product Pages
**Required:** Product, Offer, AggregateRating (if real), BreadcrumbList
**Remove:** LocalBusiness, FAQPage, Service

### B) City/Service Pages
**Required:** LocalBusiness, Service, BreadcrumbList, FAQPage (if real Q&A)
**Remove:** Product, Review, AggregateRating

### C) Blog Pages
**Required:** Article, BreadcrumbList
**Remove:** Product, Review, LocalBusiness, Service

---

## P3: SNIPPET & CTR REPAIR

### Target Queries:
- flood barriers hillsborough
- flood barriers clearwater
- flood barriers gulfport
- flood panels miami
- clearwater beach flood protection

### Title Formula:
`Flood Barriers in {City/County}, FL | Installation & Quotes | FloodBarrierPros`

### Meta Description Rules:
- Include exact query wording
- Service action (install, quote)
- Trust hook (permits, lead time, warranty)

---

## P4: ABOVE-THE-FOLD CONVERSION BLOCK

Every service page must show:
1. City-specific headline
2. Primary CTA: "Get a Flood Barrier Quote in {City}"
3. Trust anchors (install turnaround, compliance, service area)

---

## P5: INTERNAL LINK FUNNELS

- Blog → Relevant city service page + product page + quote CTA
- City page → Product options + installation process + case studies + FAQ

---

## P6: GEO & RELEVANCE HARDENING

- Explicit US + Florida service language on homepage, service pages, footer
- No international positioning signals
- No ambiguous service areas

---

## P7: VERIFICATION & LOCK-IN

Post-deployment checklist:
- Inspect 5 priority URLs in GSC
- Confirm Google-selected canonical = user-declared canonical
- Rich results eligibility restored
- No duplicate URL variants indexed

---

## IMPLEMENTATION PRIORITY

1. **P0** - Complete canonical verification (JSON-LD, sitemaps)
2. **P1** - Remove mixed schema types
3. **P2** - Reconstruct schema per page type
4. **P3** - Fix titles/meta for top-10 queries
5. **P4** - Add conversion blocks
6. **P5** - Internal linking
7. **P6** - Geo hardening
8. **P7** - Verification

