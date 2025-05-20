# Utilise l'image officielle PHP FPM
FROM php:8.2-fpm

# Installe les dépendances système nécessaires
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

# Installe Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier le projet Symfony dans l'image
# COPY crm_exam/ ./

# Installer les dépendances PHP (sans les dépendances dev)
RUN composer install --no-dev --optimize-autoloader || true

# Donne les bons droits au dossier var (cache et logs)
RUN mkdir -p var && chown -R www-data:www-data var

# Exposer le port utilisé par php-fpm
EXPOSE 9000

# Lancer php-fpm
CMD ["php-fpm"]
