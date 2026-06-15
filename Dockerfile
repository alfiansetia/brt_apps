# 1. Gunakan composer untuk build
FROM composer:latest AS composer-builder

# 2. Gunakan PHP 8.3 Alpine (Sesuai kebutuhan lock file kamu)
FROM php:8.3-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    bash \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    freetype-dev \
    libjpeg-turbo-dev \
    libzip-dev

# Install & Configure PHP Extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql bcmath gd zip

# Copy composer dari stage builder
COPY --from=composer-builder /usr/bin/composer /usr/bin/composer

# Setup working directory
WORKDIR /var/www/html

# Copy source code
COPY . .

# Run composer (Sekarang tidak akan error karena PHP dan ekstensi sudah sesuai)
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Set permission
RUN chown -R www-data:www-data /var/www/html

EXPOSE 9000
CMD ["php-fpm"]
