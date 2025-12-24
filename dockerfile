# ---------- Composer deps ----------
FROM php:8.2-cli AS vendor

RUN apt-get update && apt-get install -y \
    git unzip zip \
    libzip-dev \
    libicu-dev \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j$(nproc) pdo pdo_mysql zip intl gd bcmath \
 && rm -rf /var/lib/apt/lists/*

# Composer bin
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader --no-scripts

# ---------- Vite build ----------
FROM node:20-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json* ./
RUN npm ci || npm install
COPY . .
RUN npm run build

# ---------- Runtime ----------
FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libzip-dev \
    libicu-dev \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
 && a2enmod rewrite headers \
 && sed -i 's#/var/www/html#/var/www/html/public#g' /etc/apache2/sites-available/000-default.conf \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j$(nproc) pdo pdo_mysql zip intl gd bcmath \
 && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html
COPY . .
COPY --from=vendor /app/vendor ./vendor
COPY --from=assets /app/public/build ./public/build

RUN mkdir -p storage bootstrap/cache \
 && chown -R www-data:www-data storage bootstrap/cache

COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]
CMD ["apache2-foreground"]