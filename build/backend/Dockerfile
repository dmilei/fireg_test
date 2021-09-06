# ------------------------- BASE (common) ENVIRONMENT ---------------------------------
FROM php:7.4-apache AS base

# Set working directory and ENV
WORKDIR /var/www/html
ENV APACHE_DOCUMENT_ROOT /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    unzip \
    cron \
    libonig-dev libzip-dev \
    curl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*  /tmp/* /var/tmp/* /usr/share/doc/*

# Copy config files
COPY build/backend/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY build/backend/php.ini /usr/local/etc/php/conf.d/php.ini

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd
RUN a2enmod rewrite

ARG UID=1000
ARG GID=1000

RUN usermod -u $UID www-data \
    && groupmod -g $GID www-data \
    && usermod -g $GID www-data

CMD ["apache2-foreground"]

# -------------- LOCAL ----------------
FROM base as local

# Install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

CMD php artisan serve --host=0.0.0.0 --port=9000
EXPOSE 9000
