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

role=${CONTAINER_ROLE:-app}

composer clear-cache
composer update

if [ "$role" = "app" ]; then
    php artisan migrate
    #php artisan db:seed
    php artisan key:generate
    php artisan cache:clear
    php artisan config:clear
    php artisan route:clear
    #php artisan app:cache-database
    php artisan serve --port=$PORT --host=0.0.0.0 --env=.env
    exec docker-php-entrypoint "$@"
elif [ "$role" = "queue" ]; then
    echo "Running the queue ... "
    php /var/www/artisan queue:work --verbose --tries=3 --timeout=180
fi