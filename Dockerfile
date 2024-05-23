FROM php:8.2 as php

RUN apt-get update -y
RUN apt-get install -y unzip libpq-dev libcurl4-gnutls-dev cron
RUN docker-php-ext-install pdo pdo_mysql bcmath

RUN apt-get update -y \
    && apt-get install -y build-essential libmemcached-dev zlib1g-dev \
    && pecl install memcached \
    && docker-php-ext-enable memcached

RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

WORKDIR /var/www
COPY . .
    
COPY --from=composer:2.3.5 /usr/bin/composer /usr/bin/composer
    
ENV PORT=8000

#RUN chmod -R 777 /var/www

ENTRYPOINT [ "Docker/entrypoint.sh" ]
