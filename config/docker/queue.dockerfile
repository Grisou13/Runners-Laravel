FROM php:7.0.4-fpm

RUN apt-get update && apt-get install -y libmcrypt-dev \
    mysql-client libmagickwand-dev --no-install-recommends \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && docker-php-ext-install mcrypt pdo_mysql json


copy queue.sh /opt/bin/entrypoint.sh
RUN chmod +x /opt/bin/entrypoint.sh
CMD ["/opt/bin/entrypoint.sh"]
