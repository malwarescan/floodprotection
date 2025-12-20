#!/bin/sh
set -e

# HARD KILL OTHER MPMs (php-apache re-enables them)
rm -f /etc/apache2/mods-enabled/mpm_event.*
rm -f /etc/apache2/mods-enabled/mpm_worker.*

# ASSERT ONLY prefork REMAINS
COUNT=$(ls /etc/apache2/mods-enabled | grep '^mpm_' | cut -d. -f1 | sort -u | wc -l)
if [ "$COUNT" -ne 1 ]; then
  echo "FATAL: More than one MPM enabled at runtime"
  ls -la /etc/apache2/mods-enabled | grep mpm_
  exit 1
fi

# Railway port
sed -i "s/Listen 80/Listen ${PORT:-80}/" /etc/apache2/ports.conf

exec apache2-foreground
