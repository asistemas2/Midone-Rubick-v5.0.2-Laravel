#!/bin/sh
# Preparación del contenedor de la aplicación antes de arrancar PHP-FPM.
set -e

cd /var/www/html

# Estructura de storage (el volumen puede venir vacío)
mkdir -p storage/app/public storage/framework/cache/data storage/framework/sessions \
         storage/framework/views storage/logs bootstrap/cache

# Cachés de Laravel fuera de la carpeta del proyecto (modo dev): así el contenedor nunca
# lee los bootstrap/cache/*.php generados por Laragon con rutas de Windows, y viceversa.
if [ -n "$APP_CONFIG_CACHE" ]; then
    mkdir -p "$(dirname "$APP_CONFIG_CACHE")"
    chown -R www-data:www-data "$(dirname "$APP_CONFIG_CACHE")"
fi
if [ -n "$VIEW_COMPILED_PATH" ]; then
    mkdir -p "$VIEW_COMPILED_PATH"
    chown -R www-data:www-data "$VIEW_COMPILED_PATH"
fi

chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true

# Producción: cachés de configuración, rutas y vistas al arrancar (usan el .env.docker vigente)
if [ "$APP_ENV" = "production" ]; then
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

exec "$@"
