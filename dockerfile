FROM php:8.2-apache
WORKDIR /app
COPY . /var/www/html/
RUN apt-get update && apt-get install -y \
    libssl-dev \
    zlib1g-dev \
    && docker-php-ext-install pdo pdo_mysql