# Merchant Return Policy Fix - Google Search Console Issue

## ✅ Issue Fixed

**GSC Issue**: Missing field "applicableCountry" (in "offers.hasMerchantReturnPolicy")

**Affected URLs**:
- `https://floodbarrierpros.com/testimonials`
  - Doorway Flood Panel
  - Garage Door Flood Dam Kit
  - Modular Flood Barrier System

## Solution Implemented

Added `hasMerchantReturnPolicy` with `applicableCountry: 'US'` to all product offers across the site.

### Changes Made

1. **Created Helper Function** (`app/Schema.php`)
   - Added `getMerchantReturnPolicy()` method that returns standardized return policy schema
   - Includes all required fields:
     - `applicableCountry`: 'US' ✅ (This was the missing field)
     - `returnPolicyCategory`: 'https://schema.org/MerchantReturnFiniteReturnWindow'
     - `merchantReturnDays`: 30
     - `returnMethod`: 'https://schema.org/ReturnByMail'
     - `returnFees`: 'https://schema.org/FreeReturn'

2. **Updated Product Schema Functions**
   - `productWithReviews()` - Added return policy to both Offer and AggregateOffer
   - `canonicalProduct()` - Added return policy to both Offer and AggregateOffer
   - `reviewItemList()` - Added return policy to:
     - Canonical products (already had it, verified)
     - `itemReviewed` offers in Review schema

### Return Policy Schema

```json
{
  "@type": "MerchantReturnPolicy",
  "applicableCountry": "US",
  "returnPolicyCategory": "https://schema.org/MerchantReturnFiniteReturnWindow",
  "merchantReturnDays": 30,
  "returnMethod": "https://schema.org/ReturnByMail",
  "returnFees": "https://schema.org/FreeReturn"
}
```

## Files Modified

- `app/Schema.php`
  - Added `getMerchantReturnPolicy()` helper method
  - Updated `productWithReviews()` to include return policy
  - Updated `canonicalProduct()` to include return policy
  - Updated `reviewItemList()` itemReviewed offers to include return policy

## Verification

All product offers now include:
```json
"offers": {
  "@type": "Offer",
  ...
  "hasMerchantReturnPolicy": {
    "@type": "MerchantReturnPolicy",
    "applicableCountry": "US",
    ...
  }
}
```

## Testing

Test the testimonials page:
```bash
curl http://localhost:8000/testimonials | grep -A 8 "hasMerchantReturnPolicy"
```

Expected: All products should have `applicableCountry: "US"` in their return policy.

## Next Steps

1. **Request Re-crawl** in Google Search Console for:
   - `/testimonials`
   - All product pages

2. **Monitor** GSC for resolution (typically 1-2 weeks)

3. **Verify** using Google's Rich Results Test:
   - https://search.google.com/test/rich-results

## Status

✅ **FIXED** - All product offers now include `applicableCountry: 'US'` in `hasMerchantReturnPolicy`

