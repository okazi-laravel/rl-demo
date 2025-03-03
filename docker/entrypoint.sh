#!/bin/bash

if [ ! -f "vendor/autoload.php" ]; then
    composer install --no-progress --no-interaction
fi

if [ ! -f ".env" ]; then
    echo "Creating env file for env $APP_ENV"
    cp .env.example .env
else
    echo "env file exists."
fi

# Install dependencies
composer install --prefer-dist --no-interaction --no-progress --no-suggest --no-dev

# generate application key
php artisan key:generate --force

# Run Optimize clear
php artisan optimize:clear

# Run config cache
php artisan config:cache

# Run Laravel storage link
php artisan storage:link --force

php-fpm
