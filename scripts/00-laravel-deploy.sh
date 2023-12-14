#!/usr/bin/env bash
echo "Running composer"
cp /etc/secrets/.env .env
composer global require hirak/prestissimo

echo "cleaning dump-autoload"
composer dump-autoload --working-dir=/var/www/html

echo "Running composer install"
composer install --no-scripts
composer update --no-scripts

composer require laravel/framework

echo "Clearing caches..."
php artisan optimize:clear

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force

echo "done deploying"
