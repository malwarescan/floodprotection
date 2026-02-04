# GSC Performance Implementation Plan

**Created:** February 3, 2026  
**Source:** GSC Performance Analysis 2026-02-03  
**Scope:** CTR improvement, St. Petersburg cluster, mobile CRO, schema scaling

---

## Overview

| Phase | Timeline | Focus |
|-------|----------|-------|
| Phase 1 (P0) | Week 1 | St. Pete CRO, meta refresh, mobile CTA |
| Phase 2 (P1) | Weeks 2–4 | St. Pete cluster expansion, product pages, review schema |
| Phase 3 (P2) | Weeks 5–8 | Commercial segment, high-CTR replication, featured snippets |

---

## Phase 1: P0 — Week 1

### 1.1 St. Petersburg Content & CRO

**Objective:** Improve city/st-petersburg and home-flood-barriers/st-petersburg (combined 156 impressions, 0 clicks).

| Task | Owner | Files / Location | Deliverable |
|------|-------|------------------|-------------|
| 1.1a | Content | `app/Controllers/PagesController.php` | Update `cityMetaMap['st-petersburg']` title/description (lines 382–387) |
| 1.1b | Content | `app/Controllers/PagesController.php` | Add home-flood-barriers/st-petersburg meta to matrix or SWFL content |
| 1.1c | Content | `app/Templates/city.php` | Add sticky CTA (phone + quote button) above fold |
| 1.1d | Content | `app/Templates/matrix-page.php` | Add sticky CTA for St. Pete matrix pages |
| 1.1e | Content | Copy | Add local proof: “Serving Shore Acres, Snell Isle, Pinellas Park” |

**Acceptance Criteria:**
- [ ] St. Pete city page title ≤ 60 chars, description ≤ 155 chars
- [ ] Sticky CTA visible on mobile without scroll
- [ ] At least one local neighborhood mention above fold

**Suggested Meta (st-petersburg city):**
- Title: `St Petersburg FL Flood Barriers | #1 Rated | Free Quote`
- Desc: `St Petersburg flood barrier installation. Shore Acres, Snell Isle, Pinellas Park. 5-star, FEMA-compliant, 24hr install. Call for free assessment.`

---

### 1.2 Title/Description Refresh — Top 10 Zero-CTR Queries

**Objective:** Improve CTR for queries in positions 5–10 with 0 clicks.

| Query | Current Primary Page | Action |
|-------|----------------------|--------|
| flood panels miami | home-flood-barriers/miami or matrix | Add Miami-specific meta to cityMetaMap or matrix |
| flood barriers clearwater | home-flood-barriers/clearwater | cityMetaMap exists; refine title/desc |
| riviera beach flood protection | home-flood-barriers/riviera-beach | Add to cityMetaMap if missing |
| flood barriers gulfport | home-flood-barriers/gulfport | Add to cityMetaMap if missing |
| fort myers flood protection | home-flood-barriers/fort-myers | Add to cityMetaMap if missing |
| flood barriers st pete beach | home-flood-barriers/st-pete-beach | cityMetaMap exists; refine |

| Task | Owner | Files | Deliverable |
|------|-------|-------|-------------|
| 1.2a | SEO | `app/Controllers/PagesController.php` | Add/update cityMetaMap for: miami, clearwater, riviera-beach, gulfport, fort-myers |
| 1.2b | SEO | `app/SEO.php` | Add `titleMiami()`, `descMiami()`, etc., or extend cityMetaMap |
| 1.2c | SEO | Matrix / SWFL | Ensure matrix rows for these cities use CTR-optimized meta |

**Meta Template (CTR-focused):**
- Title: `{Service} in {City}, FL — Free Quote | {Brand}`
- Desc: `{City} {service}. FEMA-approved, 5-star rated, free assessment. Call today.` (≤155 chars)

---

### 1.3 Mobile CTA Audit

**Objective:** Ensure CTAs are visible and tap-friendly on mobile for high-impression pages.

| Task | Owner | Files | Deliverable |
|------|-------|-------|-------------|
| 1.3a | UX | `app/Templates/layout.php` | Verify sticky header/footer CTA on mobile |
| 1.3b | UX | `app/Templates/city.php` | Add primary CTA block (phone + form) above fold |
| 1.3c | UX | `app/Templates/matrix-page.php` | Same CTA block for matrix pages |
| 1.3d | UX | `app/Templates/location.php` | Same for /fl/{city}/{product} pages |
| 1.3e | QA | Manual | Test tap targets ≥ 44px, forms usable on 375px width |

**Acceptance Criteria:**
- [ ] Primary CTA visible without scroll on iPhone SE (375px)
- [ ] Phone number is `tel:` link, tappable
- [ ] Form fields have adequate touch targets

---

### Phase 1 Checklist

- [x] 1.1 St. Pete CRO complete
- [x] 1.2 Meta refresh for 6+ cities complete
- [x] 1.3 Mobile CTA audit complete (sticky CTA on city, matrix, location)
- [ ] Deploy to production
- [ ] Request indexing in GSC for updated URLs

---

## Phase 2: P1 — Weeks 2–4

### 2.1 St. Pete Cluster Expansion

**Objective:** Add neighborhood-specific content (Shore Acres, Snell Isle, Pinellas Park) to capture long-tail queries.

| Task | Owner | Files | Deliverable |
|------|-------|-------|-------------|
| 2.1a | Content | `app/Data/matrix.csv` or `swfl_matrix.csv` | Add rows for: shore-acres, snell-isle (if not present) |
| 2.1b | Content | `app/Controllers/PagesController.php` | Add cityMetaMap entries for new neighborhoods |
| 2.1c | Content | Copy | 200–400 word sections for each neighborhood on city/st-petersburg |
| 2.1d | Content | `app/Templates/city.php` | Add neighborhood accordion or expandable sections |

**Queries to Target:**
- flood barriers snell isle
- flood barriers shore acres
- flood barriers pinellas county
- flood barriers pinellas park

---

### 2.2 Product Page Alignment

**Objective:** Align product pages with queries: “garage door flood barrier,” “modular flood barriers,” “flood proof garage doors.”

| Task | Owner | Files | Deliverable |
|------|-------|-------|-------------|
| 2.2a | SEO | `app/Controllers/ProductController.php` | Update modular-flood-barrier and garage-dam-kit meta |
| 2.2b | Content | `app/Templates/product-modular-flood-barrier.php` | Add H2s: “Modular Flood Barriers,” “Flood Proof Garage Door Solutions” |
| 2.2c | Content | `app/Templates/product-garage-dam-kit.php` | Add H2s: “Garage Door Flood Barrier,” “Flood Proof Garage Doors” |
| 2.2d | Schema | `app/Schema.php` | Ensure Product schema includes name, description, offers for both products |
| 2.2e | Schema | Product templates | Add FAQ schema for “How much do flood barriers cost?” etc. |

**Suggested Product Meta:**
- modular-flood-barrier: Title `Modular Flood Barriers | Reusable Panels for Homes & Garages`
- garage-dam-kit: Title `Garage Door Flood Barrier | Flood Proof Garage Doors | Install Guide`

---

### 2.3 Review Schema Scaling

**Objective:** Extend review schema to more location and service pages.

| Task | Owner | Files | Deliverable |
|------|-------|-------|-------------|
| 2.3a | Schema | `app/Schema.php` | Add AggregateRating to LocalBusiness/Service where reviews exist |
| 2.3b | Schema | `app/Controllers/PagesController.php` | Pass review data to city page schema |
| 2.3c | Schema | `app/Controllers/LocationController.php` | Add review schema to /fl/{city}/{product} pages |
| 2.3d | Data | `app/Data/reviews.csv` | Verify review data is structured for schema |

**Acceptance Criteria:**
- [ ] St. Pete city page has AggregateRating in schema
- [ ] Top 10 city pages have review schema
- [ ] Product pages have review schema if reviews exist

---

### Phase 2 Checklist

- [x] 2.1 St. Pete neighborhood content live (Shore Acres, Snell Isle, Pinellas Park)
- [x] 2.2 Product pages updated with query-aligned content and schema
- [x] 2.3 Review schema on city pages (AggregateRating)
- [ ] Deploy and request indexing

---

## Phase 3: P2 — Weeks 5–8

### 3.1 Commercial Segment Decision & Execution

**Objective:** Decide whether to pursue commercial queries; if yes, build hub and landing pages.

| Task | Owner | Deliverable |
|------|-------|-------------|
| 3.1a | Strategy | Go/no-go: commercial flood gates, commercial flood barriers |
| 3.1b | Content | Commercial hub page (if go): /commercial-flood-protection |
| 3.1c | Content | Sub-pages: commercial flood gates, industrial barriers |
| 3.1d | Schema | Service/Product schema for commercial pages |
| 3.1e | Internal links | Link from homepage, city pages, product pages |

---

### 3.2 High-CTR Replication

**Objective:** Apply Marco Island / Jupiter / Inverness patterns to 10–15 similar markets.

| Task | Owner | Files | Deliverable |
|------|-------|-------|-------------|
| 3.2a | Analysis | GSC | Identify next 10–15 cities by impression potential |
| 3.2b | Content | `app/Controllers/PagesController.php` | Add cityMetaMap for each |
| 3.2c | Content | Templates | Ensure CTA structure matches Marco Island / Jupiter |
| 3.2d | Internal links | matrix.csv, city pages | Add internal links from high-authority pages |

**Template Pattern (from Marco Island):**
- Strong H1 with city + service
- Local proof above fold
- Clear CTA block
- FAQ section with schema

---

### 3.3 Featured Snippet Strategy

**Objective:** Optimize position-1 pages for featured snippets.

| Task | Owner | Files | Deliverable |
|------|-------|-------|-------------|
| 3.3a | Content | home-flood-barriers/marco-island, inverness | Add definition lists, tables, step lists where relevant |
| 3.3b | Content | FAQ pages | Structure FAQs for FAQPage schema and snippet eligibility |
| 3.3c | Content | Product pages | Add “How much do flood barriers cost?” in table or list format |
| 3.3d | Schema | FAQPage, HowTo | Ensure schema matches on-page structure |

**Snippet Types to Target:**
- Paragraph: “What are flood barriers?”
- List: “Types of flood barriers”
- Table: “Flood barrier cost by type”
- FAQ: “How much do flood barriers cost for commercial buildings?”

---

### Phase 3 Checklist

- [ ] 3.1 Commercial decision made; if go, hub live
- [ ] 3.2 High-CTR pattern applied to 10–15 cities
- [ ] 3.3 Featured snippet optimizations on 5+ pages
- [ ] Deploy and monitor GSC (4-week window)

---

## File Reference Quick Map

| Area | Primary Files |
|------|---------------|
| City meta | `app/Controllers/PagesController.php` (cityMetaMap ~374–430) |
| Matrix meta | `app/SWFLContent.php`, `app/QueryDrivenContent.php`, matrix data |
| Location meta | `app/Controllers/LocationController.php` |
| Product meta | `app/Controllers/ProductController.php` |
| SEO helpers | `app/SEO.php` |
| Schema | `app/Schema.php` |
| Layout / CTA | `app/Templates/layout.php` |
| City template | `app/Templates/city.php` |
| Matrix template | `app/Templates/matrix-page.php` |
| Location template | `app/Templates/location.php` |

---

## Success Metrics

| Metric | Baseline (7d) | Target (4 weeks post-P1) |
|--------|----------------|---------------------------|
| Total clicks | 12 | 25+ |
| CTR | 1.46% | 2.5%+ |
| St. Pete cluster clicks | 0 | 5+ |
| Mobile CTR | 2.87% | 4%+ |
| Position (St. Pete pages) | 13–23 | ≤15 |

---

## Dependencies & Risks

| Risk | Mitigation |
|------|------------|
| View.php overrides canonical | Canonical is self-referencing; meta title/description are passed in $data and respected |
| Matrix CSV bulk edits | Use script or spreadsheet; validate CSV structure before deploy |
| Schema validation errors | Test with Google Rich Results Test before deploy |

---

## Weekly Cadence

| Week | Focus | Key Deliverables |
|------|-------|------------------|
| 1 | Phase 1 | St. Pete CRO, meta refresh, mobile CTA |
| 2 | Phase 2 start | St. Pete neighborhood content, product page audit |
| 3 | Phase 2 | Product pages live, review schema scaling |
| 4 | Phase 2 complete | All P1 tasks done, deploy |
| 5–6 | Phase 3 start | Commercial decision, high-CTR replication |
| 7–8 | Phase 3 | Featured snippets, final deploy |
