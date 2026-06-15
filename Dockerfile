FROM php:8.2-fpm-alpine

# Install system dependencies & PHP extensions yang dibutuhkan Laravel
RUN apk add --no-cache \
    bash \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip

RUN docker-php-ext-install pdo_mysql bcmath

# Setup working directory
WORKDIR /var/www/html

# Copy source code aplikasi
COPY . .

# Set permission dasar untuk user www-data (bawaan php-fpm alpine)
RUN chown -R www-data:www-data /var/www/html

EXPOSE 9000
CMD ["php-fpm"]
