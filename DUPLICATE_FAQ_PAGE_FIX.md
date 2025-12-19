# Duplicate FAQPage Schema Fix

## Issue
Google Search Console reported "Duplicate field 'FAQPage'" error for:
- `https://www.floodbarrierpros.com/home-flood-barriers/fort-myers`

## Root Cause
The page had **two FAQPage schemas**:
1. **JSON-LD schema** (from controller/SWFLContent) - ✅ Correct
2. **Microdata schema** (from template) - ❌ Duplicate

Google doesn't allow both JSON-LD and microdata for the same schema type on the same page.

## Solution
Removed microdata FAQPage schema from `app/Templates/matrix-page.php` since we're already using JSON-LD everywhere.

### Changes Made

**File:** `app/Templates/matrix-page.php`

**Before:**
```html
<div class="space-y-4" itemscope itemtype="https://schema.org/FAQPage">
    <div itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
        <h3 itemprop="name">...</h3>
        <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
            <div itemprop="text">...</div>
        </div>
    </div>
</div>
```

**After:**
```html
<!-- Note: FAQPage schema is provided via JSON-LD in the page head, not microdata -->
<div class="space-y-4">
    <div>
        <h3>...</h3>
        <div>
            <div>...</div>
        </div>
    </div>
</div>
```

## Verification

### Test Results
✅ **Microdata FAQPage:** 0 (removed)
✅ **JSON-LD FAQPage:** 1 (only one instance)

### Test Commands
```bash
# Check for microdata FAQPage (should be 0)
curl -s "http://localhost:8000/home-flood-barriers/fort-myers" | grep -c "itemscope.*FAQPage"
# Result: 0

# Check for JSON-LD FAQPage (should be 1)
curl -s "http://localhost:8000/home-flood-barriers/fort-myers" | grep -o '"@type":\s*"FAQPage"' | wc -l
# Result: 1
```

## Impact

### Pages Affected
- All matrix pages (`/home-flood-barriers/{city}`, `/residential-flood-panels/{city}`, etc.)
- Both SWFL and non-SWFL city pages

### Schema Strategy
- ✅ **JSON-LD only** - Cleaner, easier to maintain
- ❌ **No microdata** - Prevents duplicates
- ✅ **Single FAQPage per page** - Google compliant

## Status
✅ **FIXED**

The duplicate FAQPage schema issue has been resolved. All pages now use only JSON-LD for FAQPage schema, eliminating the duplicate field error.

## Next Steps
1. ✅ Fix applied
2. ✅ Verified locally
3. ⏳ Wait for Google to recrawl (typically 1-2 weeks)
4. ⏳ Monitor GSC for error resolution

