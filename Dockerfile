# PHP + Apache - using Ubuntu-based image for better reliability
FROM ubuntu:22.04

# Install PHP and Apache
RUN apt-get update && apt-get install -y \
    apache2 \
    php8.2 \
    php8.2-cli \
    php8.2-common \
    php8.2-mysql \
    php8.2-zip \
    php8.2-gd \
    php8.2-mbstring \
    php8.2-curl \
    php8.2-xml \
    php8.2-bcmath \
    libapache2-mod-php8.2 \
    && rm -rf /var/lib/apt/lists/*

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
    chmod -R 644 /var/www/html/public/.htaccess

# Default port Railway uses
EXPOSE 8080

CMD ["/entrypoint.sh"]
