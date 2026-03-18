FROM php:8.3-fpm-bookworm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    sudo \
    cron \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libsqlite3-dev \
    libpq-dev \
    nano \
    libsodium-dev \
    libssl-dev \
    libzip-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libwebp-dev \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
    && docker-php-ext-install \
        gd \
        mbstring \
        exif \
        pcntl \
        bcmath \
        sockets \
        sodium \
        zip \
        soap \
        pdo_pgsql \
        pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

COPY docker/php/php-ini-overrides.ini /usr/local/etc/php/conf.d/

COPY src/ ./

RUN mkdir -p runtime web/assets && chmod -R 775 runtime web/assets

EXPOSE 9000

CMD ["php-fpm"]