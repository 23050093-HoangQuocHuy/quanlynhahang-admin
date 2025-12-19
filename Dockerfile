FROM php:8.2-apache

# Cài system packages
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl

# PHP extensions cho Laravel
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd

# Enable rewrite
RUN a2enmod rewrite

# Set document root về public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf

# Copy source
WORKDIR /var/www/html
COPY . .

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader

# Permission
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80
RUN php artisan migrate --force || true
RUN php artisan config:clear || true
RUN php artisan route:clear || true
RUN php artisan view:clear || true
