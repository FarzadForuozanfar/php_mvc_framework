FROM php:8.2-fpm-alpine

WORKDIR /var/www/html

RUN apk add --no-cache --virtual .build-deps \
      build-base autoconf libzip-dev \
 && apk add --no-cache \
      libzip zlib mysql-client zip \
 && docker-php-ext-install pdo pdo_mysql zip opcache \
 && pecl install redis apcu \
 && docker-php-ext-enable redis apcu opcache

COPY docker/php/ $PHP_INI_DIR/conf.d/
COPY docker/php-fpm/www.conf /usr/local/etc/php-fpm.d/zz-www.conf

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock ./
RUN composer install --no-interaction --no-plugins --no-scripts --no-dev --ignore-platform-reqs -o
COPY . .

RUN chown -R www-data:www-data /var/www/html

RUN apk del .build-deps \
 && rm -rf /tmp/pear /var/cache/apk/*

EXPOSE 9000
CMD ["php-fpm"]