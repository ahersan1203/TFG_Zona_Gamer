FROM php:8.2-apache

RUN apt-get update && apt-get install -y unzip git libzip-dev libpq-dev && \
    docker-php-ext-install pdo pdo_mysql pdo_pgsql zip && \
    docker-php-ext-enable pdo_mysql pdo_pgsql

RUN a2enmod rewrite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY TFG/backend/ .

ENV APP_ENV=production
ENV APP_KEY=base64:placeholder==

RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

RUN mkdir -p storage/framework/views storage/framework/cache storage/framework/sessions bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

RUN printf '#!/bin/sh\nchmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache\nphp artisan migrate:fresh --force\nphp artisan db:seed --force\napache2-foreground\n' > /start.sh && \
    chmod +x /start.sh

CMD ["/start.sh"]