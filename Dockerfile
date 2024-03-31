FROM php:8.2-apache

RUN apt-get update && \
    apt-get install -y zip unzip libxml2-dev libonig-dev

RUN docker-php-ext-install dom xml pdo mbstring
RUN docker-php-ext-install xml

RUN usermod -u 1000 www-data

WORKDIR /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY --chown=www-data:www-data ./storage/logs /var/www/storage/logs
COPY --chown=www-data:www-data ./bootstrap/cache /var/www/bootstrap/cache

USER www-data

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0