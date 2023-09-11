FROM php:8.1.4-fpm

RUN apt-get update \
    && apt-get install nginx -y
#    && service nginx start

#    && rm -rf /var/lib/apt/lists/* \
#    && echo '\ndaemon off;'>> /etc/nginx/nginx.conf \
#    && chown -R www-data:www-data /var/lib/nginx

RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql

RUN apt-get install -y curl zip unzip git supervisor

#RUN pecl install -o -f redis \
#    && rm -rf /tmp/pear \
#    && docker-php-ext-enable redis \

RUN apt-get update && apt-get install -y --no-install-recommends --no-install-suggests supervisor

RUN mkdir -p /var/lock/apache2 /var/run/apache2 /var/run/sshd /var/log/supervisor

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet

#COPY supervisovisord.conf /etc/supervisor/conf.d/supervisord.conf

COPY ./nginx/default.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www/html

#CMD ["php-fpm"]
#
#EXPOSE 80
#
#CMD ["nginx", "-g", "daemon off;"]

