# Use PHP 8.3 FPM image
FROM php:8.3-fpm

# Install system dependencies and required libraries
RUN apt-get update && apt-get install -y \
    nginx \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    curl \
    git \
    pkg-config \
    libonig-dev \
    libpq-dev

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip gd mbstring

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application code
COPY . /var/www/html

# Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Optimize Laravel and publish Swagger assets
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan vendor:publish --provider="L5Swagger\L5SwaggerServiceProvider" --tag=assets --force \
    && php artisan l5-swagger:generate

# Copy Nginx configuration
COPY ./nginx.conf /etc/nginx/nginx.conf

# Expose HTTP port
EXPOSE 80

# Start Nginx and PHP-FPM
CMD ["bash", "-c", "php-fpm -D && nginx -g 'daemon off;'"]
