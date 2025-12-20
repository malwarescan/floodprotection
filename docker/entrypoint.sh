#!/bin/sh
# Don't use set -e - we want to see all errors, not exit immediately

# Make Apache listen on Railway's $PORT (fallback 8080 for local runs)
PORT="${PORT:-8080}"
sed -i "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf

# Ensure proper permissions
chown -R www-data:www-data /var/www/html
chmod -R 755 /var/www/html
chmod -R 644 /var/www/html/public/.htaccess

# Verify healthz file exists and is readable
if [ ! -f /var/www/html/public/healthz ]; then
    echo "ERROR: /var/www/html/public/healthz file not found!"
    exit 1
fi

# Verify only one MPM is enabled (CRITICAL)
echo "=== Verifying MPM configuration ==="
MPM_COUNT=$(ls -1 /etc/apache2/mods-enabled/ | grep -c "^mpm_" || echo "0")
if [ "$MPM_COUNT" != "1" ]; then
    echo "ERROR: Multiple MPM modules detected! Found $MPM_COUNT MPM modules:"
    ls -la /etc/apache2/mods-enabled/ | grep "^mpm_" || echo "No MPM modules found"
    echo "Apache requires exactly one MPM. Aborting."
    exit 1
fi
ENABLED_MPM=$(ls -1 /etc/apache2/mods-enabled/ | grep "^mpm_" | head -1)
echo "✓ Only one MPM enabled: $ENABLED_MPM"

# Test Apache configuration
echo "Testing Apache configuration..."
if ! apache2ctl configtest; then
    echo "ERROR: Apache configuration test failed!"
    apache2ctl configtest 2>&1
    echo "=== Checking MPM modules ==="
    ls -la /etc/apache2/mods-enabled/ | grep mpm || echo "No MPM modules found"
    exit 1
fi
echo "Apache configuration test passed!"

# Debug: List directory contents and permissions
echo "=== Directory listing ==="
ls -la /var/www/html/
echo "=== Public directory ==="
ls -la /var/www/html/public/
echo "=== Healthz file ==="
cat /var/www/html/public/healthz
echo "=== Apache config ==="
cat /etc/apache2/sites-available/000-default.conf

# Start Apache in foreground
echo "Starting Apache on port ${PORT}..."
exec apache2-foreground
