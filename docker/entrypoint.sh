#!/bin/sh
set -e

cd /var/www/html

# Espera a que el FS esté montado (por si hay volumes) y crea symlink si falta
if [ ! -L public/storage ]; then
  php artisan storage:link || true
fi

# (Opcional) cachear config/routes/views en prod
# php artisan config:cache || true
# php artisan route:cache || true
# php artisan view:cache || true

# Seguí con el comando original (apache/php-fpm)
exec "$@"