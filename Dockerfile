FROM php:8.3-cli

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libzip-dev \
    libicu-dev \
    && docker-php-ext-install zip intl pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

CMD php -S 0.0.0.0:8000 -t public