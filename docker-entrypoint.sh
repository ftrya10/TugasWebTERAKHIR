#!/bin/sh
set -e

# Sanitize APP_URL (remove newlines, CR, tabs, spaces)
if [ -n "$APP_URL" ]; then
    APP_URL=$(echo "$APP_URL" | tr -d '\r\n\t ')
    export APP_URL
fi

# Ensure storage and bootstrap directories are writable
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/storage/framework/cache
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/bootstrap/cache
chmod -R 777 /var/www/html/storage
chmod -R 777 /var/www/html/bootstrap/cache

# Ensure database directory and database file exist for SQLite
mkdir -p /var/www/html/database
touch /var/www/html/database/database.sqlite
chmod -R 777 /var/www/html/database

# Ensure APP_KEY is set or generate one
if [ -z "$APP_KEY" ]; then
    echo "APP_KEY is not set. Generating application key..."
    APP_KEY=$(php artisan key:generate --show --no-interaction)
fi

# Write .env file fresh from environment variables
cat > /var/www/html/.env << EOF
APP_NAME="GlobalTrade Insight"
APP_ENV=${APP_ENV:-production}
APP_KEY=${APP_KEY}
APP_DEBUG=${APP_DEBUG:-false}
APP_URL=${APP_URL:-https://tugaswebterakhir.onrender.com}
LOG_CHANNEL=stderr
DB_CONNECTION=sqlite
DB_DATABASE=/var/www/html/database/database.sqlite
SESSION_DRIVER=file
SESSION_LIFETIME=120
QUEUE_CONNECTION=sync
CACHE_STORE=file
EOF

echo "Generated .env file successfully."

# Clear existing cache
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Ensure storage link exists
php artisan storage:link || true

# Run database migrations & seeders
echo "Running migrations..."
php artisan migrate --force
echo "Running seeders..."
php artisan db:seed --force || true

# Cache routes and views in production
if [ "${APP_ENV}" = "production" ]; then
    echo "Caching routes and views for production..."
    php artisan route:cache || true
    php artisan view:cache || true
fi

# Determine port
PORT="${PORT:-8080}"
echo "Starting Laravel application on port $PORT..."
exec php artisan serve --host=0.0.0.0 --port="$PORT"

