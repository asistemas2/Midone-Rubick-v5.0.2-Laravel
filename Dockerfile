# syntax=docker/dockerfile:1
#
# Gestión ZFP — imagen Docker (ver README, sección "Docker").
#
#   assets → compila Vite (public/build)
#   base   → PHP 8.1-FPM + extensiones + Composer
#   dev    → desarrollo: el código se monta desde la carpeta del proyecto
#   prod   → despliegue: código, vendor sin dev y assets dentro de la imagen
#   web    → Nginx con los archivos públicos de prod

# ---------------------------------------------------------------- assets
FROM node:18-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY vite.config.js tailwind.config.js postcss.config.js ./
COPY resources ./resources
RUN npm run build

# ---------------------------------------------------------------- base
FROM php:8.1-fpm-alpine AS base

# Mismas extensiones que usa el proyecto en Laragon (pdo_pgsql, gd, zip, intl, bcmath, exif)
RUN apk add --no-cache libpq-dev libzip-dev icu-dev libpng-dev libjpeg-turbo-dev freetype-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" pdo_pgsql pgsql zip intl gd bcmath exif opcache

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY docker/php/php.ini /usr/local/etc/php/conf.d/zz-app.ini
COPY docker/entrypoint.sh /usr/local/bin/entrypoint
# Desde Windows el script llega sin permiso de ejecución
RUN chmod +x /usr/local/bin/entrypoint

WORKDIR /var/www/html
ENTRYPOINT ["entrypoint"]
CMD ["php-fpm"]

# ---------------------------------------------------------------- dev
FROM base AS dev
# Sin código: docker-compose.dev.yml monta la carpeta del proyecto en /var/www/html

# ---------------------------------------------------------------- prod
FROM base AS prod

# Dependencias primero (capa reutilizable mientras composer.lock no cambie)
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction

COPY . .
COPY --from=assets /app/public/build ./public/build

RUN composer dump-autoload --optimize --no-dev \
    && mkdir -p storage/app/public storage/framework/cache/data storage/framework/sessions \
                storage/framework/views storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# ---------------------------------------------------------------- web
FROM nginx:1.27-alpine AS web
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY --from=prod /var/www/html/public /var/www/html/public
