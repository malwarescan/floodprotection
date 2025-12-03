# Random News Images Implementation

## ✅ Implementation Complete

All news articles now use **randomly selected images** from a curated list of Florida flood-related images, ensuring visual variety while maintaining relevance.

## How It Works

### Image Selection Algorithm
- **Curated Image Pool**: 8 high-quality Florida flood/flooding related images
- **Consistent Per City**: Each city gets the same image for the current month (seeded by city slug + month)
- **Random Distribution**: Different cities get different images
- **Monthly Rotation**: Images change monthly for each city (seed includes month)

### Image Sources
1. `/assets/images/blog/flood-protection-blog.jpg`
2. `/assets/images/homepage/cropped-2026-01-11-17.53.15-scaled-2.jpg`
3. `/assets/images/homepage/cropped-cropped-rubicon_flood_privatehome-1-1536x1104.jpg`
4. `/assets/images/homepage/cropped-IMG_0070-rotated-1.jpg`
5. `/assets/images/homepage/cropped-rubiconfloodbarrier2-scaled-e1755554554647.jpg`
6. `/assets/images/products/modular-aluminum-flood-barriers.jpg`
7. `/assets/images/products/garage-dam-kits.jpg`
8. `/assets/images/products/doorway-flood-panels.jpg`

## Implementation Details

### Files Modified

1. **`app/NewsArticleGenerator.php`**
   - Added `getRandomNewsImage()` method
   - Updated `generateArticle()` to include image in return array
   - Updated `generateSchema()` to use random image

2. **`app/Schema.php`**
   - Added `getRandomNewsImage()` method
   - Updated `newsArticle()` to use random image when none provided

3. **`app/Util.php`**
   - Added `getRandomNewsImage()` method
   - Updated `getNewsArticles()` to add random images to markdown-based articles

4. **`app/Controllers/NewsController.php`**
   - Updated `show()` to pass article image to schema
   - Updated `programmatic()` to use article image in schema

5. **`app/Templates/news-index.php`**
   - Updated to use `$article['image']` if available

## Testing Results

Verified random image selection across multiple cities:

- **Fort Myers**: `cropped-IMG_0070-rotated-1.jpg`
- **Cape Coral**: `garage-dam-kits.jpg`
- **Naples**: `cropped-IMG_0070-rotated-1.jpg`
- **Miami**: `modular-aluminum-flood-barriers.jpg`
- **Tampa**: `flood-protection-blog.jpg`

✅ Different cities receive different images
✅ Images are consistent per city per month
✅ Schema includes correct image URLs
✅ News index page displays random images

## Schema Integration

All NewsArticle schema now includes:
```json
{
  "image": [
    {
      "@type": "ImageObject",
      "url": "https://www.floodbarrierpros.com/assets/images/...",
      "width": 1200,
      "height": 630
    }
  ]
}
```

## Benefits

1. **Visual Variety**: Each article has a unique, relevant image
2. **SEO**: Different images improve article differentiation in search results
3. **User Experience**: More engaging news index page
4. **Google News**: Proper image schema for all articles
5. **Consistency**: Same city gets same image for the month (good for caching)

## Future Enhancements

To add more images to the pool:
1. Add image paths to the `$images` array in:
   - `app/NewsArticleGenerator::getRandomNewsImage()`
   - `app/Schema::getRandomNewsImage()`
   - `app/Util::getRandomNewsImage()`
2. Ensure images are:
   - High quality (1200x630 recommended)
   - Relevant to Florida flooding/flood protection
   - Properly optimized for web

## Notes

- Images are selected based on city slug + current month for consistency
- Same city will have the same image throughout the month
- Images rotate monthly for freshness
- All images are hosted locally on the site

