FROM php:8.2-apache

RUN apt-get update && \
    apt-get install -y zip unzip libxml2-dev libonig-dev

RUN docker-php-ext-install dom xml pdo mbstring
RUN docker-php-ext-install xml

RUN usermod -u 1000 www-data

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

COPY . .

RUN composer install

COPY --chown=www-data:www-data ./storage/logs /var/www/html/storage/logs
COPY --chown=www-data:www-data ./bootstrap/cache /var/www/html/bootstrap/cache

COPY docker/apache/laravel.conf /etc/apache2/sites-available/

RUN a2enmod rewrite

RUN a2ensite laravel.conf

USER www-data

EXPOSE 80