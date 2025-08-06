FROM focker.ir/php:8.2-apache
WORKDIR /var/www/html
COPY . /var/www/html
RUN docker-php-ext-install pdo_mysql mysqli
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader --ignore-platform-req=ext-mysqli
RUN chown -R www-data:www-data /var/www/html
RUN a2enmod rewrite
EXPOSE 80
