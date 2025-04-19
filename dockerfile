FROM php:8.2-apache
WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    libssl-dev \
    zlib1g-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . .

RUN composer install --no-interaction --prefer-dist --optimize-autoloader --ignore-platform-req=ext-mysqli --ignore-platform-req=ext-gd

RUN chown -R www-data:www-data /var/www/html
