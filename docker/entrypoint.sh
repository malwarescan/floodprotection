#!/bin/sh
set -e

# Set Apache to Railway port
sed -i "s/Listen 80/Listen ${PORT:-80}/" /etc/apache2/ports.conf

exec apache2-foreground
