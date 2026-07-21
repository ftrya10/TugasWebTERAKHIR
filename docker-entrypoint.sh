#!/bin/sh
set -e

# Sanitize APP_URL (remove newlines, CR, tabs, spaces)
if [ -n "$APP_URL" ]; then
    APP_URL=$(echo "$APP_URL" | tr -d '\r\n\t ')
    export APP_URL
else
    export APP_URL="https://globaltrade-insight.onrender.com"
fi

# Ensure database directory and database file exist for SQLite
mkdir -p /var/www/html/database
touch /var/www/html/database/database.sqlite
chmod -R 777 /var/www/html/database

# Clear any cached configuration
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Run migrations & seeders
echo "Running migrations and seeders..."
php artisan migrate --force
php artisan db:seed --force || true

# Determine port (Render assigns PORT dynamically, default 8080)
PORT="${PORT:-8080}"

echo "Starting Laravel application on port $PORT..."
exec php artisan serve --host=0.0.0.0 --port="$PORT"
