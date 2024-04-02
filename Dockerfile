FROM php:8.2-apache

RUN apt-get update && \
    apt-get install -y zip unzip libxml2-dev libonig-dev && \
    docker-php-ext-install dom xml pdo mbstring && \
    usermod -u 1000 www-data

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copie os arquivos do projeto
COPY . .

# Copie os arquivos com permissões adequadas
COPY --chown=www-data:www-data ./storage/logs /var/www/html/storage/logs
COPY --chown=www-data:www-data ./bootstrap/cache /var/www/html/bootstrap/cache

COPY docker/apache/laravel.conf /etc/apache2/sites-available/
RUN a2enmod rewrite && \
    a2ensite laravel.conf

USER www-data

COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh

USER root
RUN chmod +x /usr/local/bin/entrypoint.sh

USER www-data

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
