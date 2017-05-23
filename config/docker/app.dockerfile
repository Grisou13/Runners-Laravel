FROM php:7.0.4-fpm
WORKDIR /var/www
RUN apt-get update && apt-get install -y libmcrypt-dev \
    mysql-client libmagickwand-dev --no-install-recommends \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && docker-php-ext-install mcrypt pdo_mysql json

RUN echo "" > /var/www/.env
#RUN cd /var/www && php artisan key:generate
