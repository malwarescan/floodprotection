# PHP + Apache
FROM php:8.2-apache

# Serve from /public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Enable required Apache modules (NOT MPMs yet)
RUN a2enmod rewrite headers && \
    sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Force exactly ONE MPM: prefork
RUN set -eux; \
    a2dismod mpm_event || true; \
    a2dismod mpm_worker || true; \
    a2enmod mpm_prefork

# Copy Apache vhost AFTER MPMs are locked
COPY docker/apache-config.conf /etc/apache2/sites-available/000-default.conf
RUN a2ensite 000-default

# Copy app
COPY . /var/www/html

# Runtime entrypoint
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Healthcheck file (MUST EXIST)
RUN mkdir -p /var/www/html/public && echo "OK" > /var/www/html/public/healthz

# Permissions
RUN chown -R www-data:www-data /var/www/html \
 && chmod -R 755 /var/www/html \
 && chmod 644 /var/www/html/public/healthz

# Default port Railway uses
EXPOSE 8080

CMD ["/entrypoint.sh"]
