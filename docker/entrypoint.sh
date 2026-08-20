#!/bin/sh
set -e

cd /var/www/html

echo "Starting Burs360 Laravel application..."

mkdir -p \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

php artisan package:discover --ansi || true

php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

if [ -L public/storage ]; then
    echo "Storage link already exists."
else
    php artisan storage:link || true
fi

echo "Starting PHP-FPM..."
php-fpm -D

echo "Starting Nginx..."
exec nginx -g "daemon off;"
