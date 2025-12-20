# PHP + Apache
FROM php:8.2-apache

# Serve from /public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Enable mod_rewrite and point vhost to /public
# Note: MPM enforcement happens AFTER all configs are applied (see below)
RUN a2enmod rewrite && \
    a2enmod headers && \
    sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Copy custom Apache configuration
COPY docker/apache-config.conf /etc/apache2/sites-available/000-default.conf

# Enable the site
RUN a2ensite 000-default

# CRITICAL: Final MPM enforcement - must be LAST after all configs are applied
# This prevents mpm_event from being re-enabled by site activation or config includes
RUN set -eux; \
    a2dismod mpm_event || true; \
    a2dismod mpm_worker || true; \
    a2enmod mpm_prefork

# Assertion: Fail build if more than one MPM is enabled
RUN test "$(ls /etc/apache2/mods-enabled | grep '^mpm_' | wc -l)" = "1"

# Runtime entrypoint will switch Apache to $PORT
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Ensure healthz file exists (static, not PHP) - created before app copy to ensure it's present
RUN echo "OK" > /var/www/html/public/healthz || mkdir -p /var/www/html/public && echo "OK" > /var/www/html/public/healthz

# Copy app
COPY . /var/www/html/

# Fix permissions for Apache
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html && \
    chmod -R 644 /var/www/html/public/.htaccess && \
    chmod 644 /var/www/html/public/healthz

# Default port Railway uses
EXPOSE 8080

CMD ["/entrypoint.sh"]
