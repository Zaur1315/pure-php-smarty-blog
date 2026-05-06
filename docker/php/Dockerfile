FROM php:8.2-apache

RUN apt-get update \
    && apt-get install -y \
        git \
        unzip \
        zip \
        libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip \
    && a2enmod rewrite

COPY docker/php/apache.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html