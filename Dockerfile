# PHP + Apache
FROM php:8.2-apache

# Serve from /public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Enable mod_rewrite and point vhost to /public
RUN a2enmod rewrite && \
    a2enmod headers && \
    sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Copy custom Apache configuration
COPY docker/apache-config.conf /etc/apache2/sites-available/000-default.conf

# Runtime entrypoint will switch Apache to $PORT
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

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
