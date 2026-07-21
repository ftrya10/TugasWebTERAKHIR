#!/bin/sh
set -e

# Sanitize APP_URL (remove newlines, CR, tabs, spaces)
if [ -n "$APP_URL" ]; then
    APP_URL=$(echo "$APP_URL" | tr -d '\r\n\t ')
    export APP_URL
else
    export APP_URL="https://globaltrade-insight.onrender.com"
fi

# Ensure .env file exists
if [ ! -f /var/www/html/.env ]; then
    if [ -f /var/www/html/.env.example ]; then
        cp /var/www/html/.env.example /var/www/html/.env
    else
        touch /var/www/html/.env
    fi
fi

# Generate APP_KEY into .env if not present
if ! grep -q "APP_KEY=base64:" /var/www/html/.env 2>/dev/null; then
    php artisan key:generate --force || true
fi

# Ensure APP_KEY environment variable is exported
export APP_KEY="${APP_KEY:-base64:7f9Q8+uV/8N0g1KxL9mX2sQ3vR4wT5yU6zI7oP8aB9c=}"

# Ensure database directory and database file exist for SQLite
mkdir -p /var/www/html/database
touch /var/www/html/database/database.sqlite
chmod -R 777 /var/www/html/database
chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache

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
