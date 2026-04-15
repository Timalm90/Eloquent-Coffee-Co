#!/bin/sh
set -e

# Ensure permissions
chown -R www-data:www-data /var/www || true
chmod -R 775 /var/www/storage /var/www/bootstrap/cache || true

# Generate APP_KEY if missing (only if APP_KEY not provided)
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
  if [ -f /var/www/artisan ]; then
    php /var/www/artisan key:generate --force || true
  fi
fi

# Run migrations if env flag set
if [ "${RUN_MIGRATIONS}" = "true" ]; then
  php /var/www/artisan migrate --force || true
fi

# Cache config/routes/views at runtime so they pick up environment variables
php /var/www/artisan config:cache || true
php /var/www/artisan route:cache || true
php /var/www/artisan view:cache || true

# Start supervisord (starts php-fpm and nginx)
exec /usr/bin/supervisord -n
