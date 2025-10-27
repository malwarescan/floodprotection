# Google Publisher Center & Reader Revenue Manager Setup

## Steps to Enable Google News

### 1. Complete Onboarding in Publisher Center
- Go to https://publishercenter.google.com
- Complete all onboarding steps
- Add your publication information

### 2. Add Publication Policies
- **Privacy Policy URL:** https://floodbarrierpros.com/privacy-policy
- **Terms of Service URL:** https://floodbarrierpros.com/terms-of-service
- **Age Restrictions:** None (content suitable for all ages)

### 3. Add Reader Revenue Manager Code Snippet

#### To get the code snippet:
1. In Google Publisher Center, go to the "CMS Sync" tab
2. Copy the Reader Revenue Manager code snippet they provide

#### To add it to your site:
1. Edit `app/Config.php`
2. Find line 27 where it says: `'google_publisher_code' => ''`
3. Paste the code snippet from Google Publisher Center between the quotes
4. The code will automatically be added to every page in the `<head>` section

#### Example:
```php
'google_publisher_code' => '<script>/* Your code snippet from Google Publisher Center */</script>'
```

### 4. Verify the Code is Added
- Visit any page on your site
- View page source (right-click → "View Page Source")
- Search for your code snippet to verify it's in the `<head>` section

### 5. Submit for Review
- In Google Publisher Center, submit your site for review
- Google will crawl your site and verify the code is installed
- Review process typically takes 1-3 business days

## Important Notes

### About AMP
- This site does NOT use Accelerated Mobile Pages (AMP)
- No AMP compatibility concerns
- Code snippet will work on all pages

### About WordPress Plugins
- This is NOT a WordPress site
- It's a PHP-based application
- The code snippet has been integrated directly into the layout template

## Files Modified
- `app/Config.php` - Added `google_publisher_code` configuration
- `app/Templates/layout.php` - Added code snippet output in `<head>` section

## Next Steps After Adding Code
1. Add the code snippet to `Config.php`
2. Push changes to git
3. Wait for deployment
4. Verify code is live on site
5. Return to Google Publisher Center
6. Click "Verify" or "Publish" in the CMS Sync tab
