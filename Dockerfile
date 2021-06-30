FROM php:8-fpm

RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    curl \
    zip \
    dos2unix

RUN curl -s https://getcomposer.org/installer | php

RUN mv composer.phar /usr/local/bin/composer

RUN rm /etc/nginx/sites-enabled/default

COPY docker/server.conf /etc/nginx/conf.d

COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN rm /usr/local/etc/php-fpm.d/zz-docker.conf

COPY . /var/www/html

RUN composer install

RUN sed -i \
    -e "s/listen = 127.0.0.1:9000/listen = \/var\/run\/php-fpm.sock/g" \
    -e "s/;listen.group = www-data/listen.group = www-data/g" \
    -e "s/;listen.owner = www-data/listen.owner = www-data/g" \
    /usr/local/etc/php-fpm.d/www.conf

EXPOSE 80

CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/conf.d/supervisord.conf"]