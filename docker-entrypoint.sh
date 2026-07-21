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

# Write .env file fresh from environment variables
cat > /var/www/html/.env << EOF
APP_NAME="GlobalTrade Insight"
APP_ENV=${APP_ENV:-production}
APP_KEY=${APP_KEY:-base64:7f9Q8+uV/8N0g1KxL9mX2sQ3vR4wT5yU6zI7oP8aB9c=}
APP_DEBUG=${APP_DEBUG:-false}
APP_URL=${APP_URL:-https://project-final-uas-globaltrade-insight.onrender.com}
LOG_CHANNEL=stderr
DB_CONNECTION=sqlite
DB_DATABASE=/var/www/html/database/database.sqlite
SESSION_DRIVER=file
SESSION_LIFETIME=120
QUEUE_CONNECTION=sync
CACHE_STORE=file
EOF

echo "Generated .env file:"
cat /var/www/html/.env

# Clear any cached configuration
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Run migrations & seeders
echo "Running migrations..."
php artisan migrate --force
echo "Running seeders..."
php artisan db:seed --force || true

# Determine port
PORT="${PORT:-8080}"
echo "Starting Laravel application on port $PORT..."
exec php artisan serve --host=0.0.0.0 --port="$PORT"
