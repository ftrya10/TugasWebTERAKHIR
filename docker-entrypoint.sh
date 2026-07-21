#!/bin/sh
set -e

# Ensure database directory and database file exist for SQLite
mkdir -p /var/www/html/database
touch /var/www/html/database/database.sqlite
chmod -R 777 /var/www/html/database

# Cache config & routes
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Run migrations & seeders
echo "Running migrations and seeders..."
php artisan migrate --force
php artisan db:seed --force || true

# Determine port (Render assigns PORT dynamically, default 8080)
PORT="${PORT:-8080}"

echo "Starting Laravel application on port $PORT..."
exec php artisan serve --host=0.0.0.0 --port="$PORT"
