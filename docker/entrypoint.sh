#!/bin/sh
# Make Apache listen on Railway's $PORT (fallback 8080 for local runs)
PORT="${PORT:-8080}"
sed -i "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf

# Ensure proper permissions
chown -R www-data:www-data /var/www/html
chmod -R 755 /var/www/html
chmod -R 644 /var/www/html/public/.htaccess

# Debug: List directory contents and permissions
echo "=== Directory listing ==="
ls -la /var/www/html/
echo "=== Public directory ==="
ls -la /var/www/html/public/
echo "=== Apache config ==="
cat /etc/apache2/sites-available/000-default.conf

# Start Apache
exec apache2-foreground
