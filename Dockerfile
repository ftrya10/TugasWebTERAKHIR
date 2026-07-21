# Stage 1: Build Frontend Assets (Vite)
FROM node:20-alpine AS node-builder
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# Stage 2: PHP Application
FROM php:8.2-cli-alpine

# Install system dependencies & PHP extensions
RUN apk add --no-cache \
    sqlite-dev \
    libpng-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    oniguruma-dev

RUN docker-php-ext-install pdo pdo_sqlite mbstring xml zip bcmath

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy application files
COPY . .

# Copy built frontend assets from Node builder stage
COPY --from=node-builder /app/public/build ./public/build

# Install PHP dependencies
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Set permissions for storage & cache
RUN chmod -R 777 storage bootstrap/cache

# Expose port for Render
EXPOSE 8080

# Copy and setup entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint

ENTRYPOINT ["docker-entrypoint"]
