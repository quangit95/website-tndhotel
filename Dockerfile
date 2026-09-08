FROM php:8.2-apache

# Install dependencies for GD and Zip extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd zip \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite for .htaccess routing
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy application source code
COPY . /var/www/html/

# Setup entrypoint
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Set initial permissions for storage
RUN chown -R www-data:www-data /var/www/html/storage \
    && chmod -R 775 /var/www/html/storage

EXPOSE 80

CMD ["/usr/local/bin/entrypoint.sh"]
