FROM php:8.3-fpm

RUN apt update && apt upgrade -y && \
    apt install -y unzip mlocate vim && \
    updatedb

# Composer
COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

# Xdebug
RUN pecl install xdebug-3.3.1 && docker-php-ext-enable xdebug

WORKDIR /app