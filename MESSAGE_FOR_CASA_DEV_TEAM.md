# Message for Casa AI Dev Team

---

**Subject: Flood Barrier Pros Integration Complete — Widget Embedded & NDJSON Enhanced** 🚀

---

Hi Casa team,

We've completed the integration on our side. Here's what's been implemented:

---

## ✅ **What We've Implemented**

### **1. Casa Widget Embed** 
✅ **Status: Live on all pages**

- Widget embedded in `<body>` of all pages on `floodbarrierpros.com`
- Configuration:
  - Domain: `floodbarrierpros.com`
  - Vertical: `flood_protection`

**Implementation:**
```html
<div id="casa-widget"></div>
<script src="https://ourcasa.ai/embed.js"></script>
<script>
  if (typeof CasaEmbed !== 'undefined') {
    CasaEmbed.init({
      domain: 'floodbarrierpros.com',
      vertical: 'flood_protection'
    });
  }
</script>
```

**Location:** `app/Templates/layout.php` (main site layout — appears on all pages)

---

### **2. Enhanced NDJSON Feed** 
✅ **Status: Live with cost/timing data**

**Feed URL:** `https://floodbarrierpros.com/sitemaps/sitemap-ai.ndjson`

**Enhancements added:**
- ✅ `cost_range`: USD price ranges (e.g., "USD 1200-5600")
- ✅ `cost_p50`: Median cost estimate
- ✅ `cost_p90`: 90th percentile cost estimate
- ✅ `best_season`: "April-May (before hurricane season)"
- ✅ `typical_duration`: "1-2 days installation"
- ✅ `location`: City, FL context (e.g., "Naples, FL")

**Data Source:** Enriched from `matrix.csv` which contains product pricing and location data

**Example enriched factlet:**
```json
{
  "@id": "https://floodbarrierpros.com/home-flood-barriers/naples",
  "@type": "WebPage",
  "headline": "...",
  "summary": "...",
  "cost_range": "USD 1200-5600",
  "cost_p50": "USD 3400",
  "cost_p90": "USD 5160",
  "best_season": "April-May (before hurricane season)",
  "typical_duration": "1-2 days installation",
  "location": "Naples, FL",
  "lastModified": "2025-01-15",
  "contentHash": "..."
}
```

**Implementation:** `scripts/build_sibda.php` — enhanced to merge matrix.csv data into NDJSON output

---

## 📊 **Current Status**

| Component | Status | Details |
|-----------|--------|---------|
| **Widget Embed** | ✅ Live | All pages on floodbarrierpros.com |
| **NDJSON Feed** | ✅ Enhanced | Cost/timing data included |
| **Feed URL** | ✅ Accessible | https://floodbarrierpros.com/sitemaps/sitemap-ai.ndjson |
| **Data Coverage** | ✅ Active | Multiple FL cities/locations |

---

## 🔍 **What to Test**

1. **Widget Functionality:**
   - Visit any page on `floodbarrierpros.com`
   - Verify Casa widget appears and functions correctly
   - Test queries related to flood protection

2. **NDJSON Feed:**
   - Fetch: `https://floodbarrierpros.com/sitemaps/sitemap-ai.ndjson`
   - Verify cost/timing fields are present in factlets
   - Check that location data is populated where available

3. **Data Quality:**
   - Verify cost ranges make sense (USD 1200-5600 typical range)
   - Confirm location data matches URL paths (e.g., `/home-flood-barriers/naples` → "Naples, FL")

---

## 🎯 **Expected Behavior**

With the enhanced NDJSON feed, Casa AI responses should now include:

- **Cost estimates:** "Cost: $1,200-$5,600 (median: $3,400)"
- **Timing advice:** "Best installed in April-May before hurricane season"
- **Duration:** "Typical installation: 1-2 days"
- **Location context:** "For homeowners in [City], FL..."

---

## 🤝 **Questions for Casa Team**

1. **Widget:** Is the embed code/configuration correct? Any issues to report?
2. **NDJSON:** Are the new fields (`cost_range`, `cost_p50`, etc.) being parsed and used by Casa?
3. **Data Format:** Do the field names match your expected schema? Should we adjust anything?
4. **Testing:** Can you verify the widget is loading/functioning on your end?
5. **Feedback:** Any improvements you'd like us to make to the data format?

---

## 📝 **Technical Details**

- **Site:** https://floodbarrierpros.com
- **NDJSON Feed:** https://floodbarrierpros.com/sitemaps/sitemap-ai.ndjson
- **Widget Script:** https://ourcasa.ai/embed.js
- **Domain Config:** `floodbarrierpros.com`
- **Vertical Config:** `flood_protection`

**Code Changes:**
- Modified: `app/Templates/layout.php` (added widget)
- Enhanced: `scripts/build_sibda.php` (added cost/timing enrichment)

---

## 🚀 **Next Steps (Your Side)**

1. Test widget embed on our site
2. Verify NDJSON enhancements are being ingested
3. Confirm cost/timing data is appearing in Casa responses
4. Let us know if any adjustments are needed

---

Thanks! Looking forward to seeing how the enhanced data improves Casa's flood protection advice. 🎉

Best,  
Flood Barrier Pros Dev Team

---

**P.S.** If you need us to adjust the data format or widget config, just let us know!




