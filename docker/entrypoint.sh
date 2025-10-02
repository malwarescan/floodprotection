#!/bin/sh
# Make Apache listen on Railway's $PORT (fallback 8080 for local runs)
PORT="${PORT:-8080}"
sed -i "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf
exec apache2-foreground
