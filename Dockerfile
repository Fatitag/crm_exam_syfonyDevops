FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libicu-dev \
    libonig-dev \
    libzip-dev \
    libpq-dev \
    libxml2-dev \
    curl \
    && docker-php-ext-install intl pdo pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

RUN composer install --no-dev --optimize-autoloader || true

RUN mkdir -p var && chown -R www-data:www-data var

EXPOSE 9000

CMD ["php-fpm"]
