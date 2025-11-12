FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN mkdir -p /var/www/src/storage /var/www/src/bootstrap/cache \
    && chown -R www-data:www-data /var/www/src \
    && chmod -R 775 /var/www/src/storage /var/www/src/bootstrap/cache

WORKDIR /var/www/src
