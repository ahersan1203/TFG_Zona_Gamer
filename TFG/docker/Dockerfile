FROM php:8.2-apache

# Instalar herramientas y extensiones necesarias
RUN apt-get update && apt-get install -y unzip git libzip-dev && \
    docker-php-ext-install pdo pdo_mysql zip && \
    docker-php-ext-enable pdo_mysql

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /var/www/html

RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf