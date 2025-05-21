FROM php:8.3-fpm

# ARG + ENV for flexibility
ARG BUILD_ARGUMENT_ENV=dev
ENV APP_HOME /var/www/html
ENV COMPOSER_ALLOW_SUPERUSER 1

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    nano \
    sudo \
    cron \
    fish \
    procps \
    bash-completion \
    libicu-dev \
    libonig-dev \
    libzip-dev \
    libpq-dev \
    libxml2-dev \
    zlib1g-dev \
    libreadline-dev \
    librabbitmq-dev \
    libxslt-dev \
    libldap2-dev \
    libssl-dev \
    supervisor \
 && pecl install amqp \
 && docker-php-ext-configure intl \
 && docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
 && docker-php-ext-install \
      intl \
      zip \
      pdo_mysql \
      sockets \
      opcache \
 && docker-php-ext-enable amqp \
 && apt-get clean \
 && rm -rf /var/lib/apt/lists/*

# Install Composer from the official Composer image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN chmod +x /usr/bin/composer && \
    composer completion bash > /etc/bash_completion.d/composer

# Create app directory
WORKDIR $APP_HOME

# Copy project files and install dependencies
COPY . .

# Install PHP dependencies (prod)
# Install PHP dependencies (auto-switch between dev and prod)
RUN if [ "$BUILD_ARGUMENT_ENV" = "prod" ]; then \
      composer install --no-dev --optimize-autoloader; \
    else \
      composer install --prefer-dist --no-interaction; \
    fi

# Set permissions
RUN mkdir -p var && chown -R www-data:www-data var

# Install APCu (Optional, for caching)
RUN mkdir -p /usr/src/php/ext/apcu && \
    curl -fsSL https://pecl.php.net/get/apcu | tar xvz -C "/usr/src/php/ext/apcu" --strip 1 && \
    docker-php-ext-install apcu

# Install Xdebug (for development)
RUN pecl install xdebug-3.3.1 && \
    docker-php-ext-enable xdebug

# Expose PHP-FPM port
EXPOSE 9000

CMD ["php-fpm"]
