# Stage 1: Build assets with Node
FROM node:20-alpine AS node-builder
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: PHP Runtime - Staying on 8.2
FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libwebp-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    icu-dev \
    oniguruma-dev \
    libxml2-dev

# Install PHP extensions with precise configuration for GD
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp && \
    docker-php-ext-install pdo_mysql gd zip intl bcmath mbstring xml

# Set working directory
WORKDIR /var/www/html

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .
COPY --from=node-builder /app/public/build ./public/build

# Install PHP dependencies (Ignoring requirements to allow 8.2 install)
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Setup Permissions
RUN chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data /var/www/html

# Copy Nginx configuration
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# Expose port 80
EXPOSE 80

ENV APP_ENV=production

# Final startup command
CMD php artisan migrate --force && php-fpm -D && nginx -g 'daemon off;'
