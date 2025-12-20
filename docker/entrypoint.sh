#!/bin/sh
set -e
# Set Apache to listen on Railway's $PORT (fallback 8080)
PORT="${PORT:-8080}"
sed -i "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf
exec apache2-foreground
