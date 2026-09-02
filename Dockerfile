FROM php:8.4-cli

RUN apt-get update \
    && apt-get install --yes --no-install-recommends $PHPIZE_DEPS git libonig-dev libsqlite3-dev libzip-dev unzip \
    && docker-php-ext-install mbstring pdo_sqlite zip \
    && pecl install pcov \
    && docker-php-ext-enable pcov \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
