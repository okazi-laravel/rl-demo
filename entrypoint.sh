#!/bin/bash

set -e

log() {
    echo "$(date +'%Y-%m-%d %H:%M:%S') - $1"
}

log "Starting entrypoint script..."

if [ ! -f "vendor/autoload.php" ]; then
    log "Installing Composer dependencies..."
    composer install --no-progress --no-interaction
fi

if [ ! -f ".env" ]; then
    log "Creating .env file for environment $APP_ENV..."
    cp .env.example .env
else
    log ".env file already exists."
fi

log "Installing Composer dependencies..."
composer install --prefer-dist --no-interaction --no-progress --no-suggest --no-dev

log "Generating application key..."
php artisan key:generate --force

# Wait for MySQL to be ready
echo "Waiting for MySQL to start..."
until mysql -h"${DB_HOST}" -u root -p"${DB_PASSWORD:-}" -e "SELECT 1"; do
    echo "MySQL not available. Retrying..."
    sleep 2
done

echo "MySQL is up! Running migrations..."

log "Creating rl-demo table if it doesn't exist..."
mysql -u root -p"${DB_PASSWORD}" -h "${DB_HOST}" -e "CREATE DATABASE IF NOT EXISTS \`${DB_DATABASE}\`;"

log "Running optimize clear..."
php artisan optimize:clear

log "Running config cache..."
php artisan config:cache

log "Running migrations..."
php artisan migrate --force

log "Running seeders..."
php artisan db:seed --force

log "Creating storage link..."
php artisan storage:link --force

log "Starting PHP-FPM..."
php-fpm
