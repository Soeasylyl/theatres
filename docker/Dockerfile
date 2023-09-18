FROM php:8.2-fpm

ARG WWWGROUP
ARG WWWUSER

ENV WWWGROUP=$WWWGROUP
ENV WWWUSER=$WWWUSER

RUN apt-get update \
    && apt-get install nginx -y

RUN apt-get update \
    && apt-get install -y libpq-dev curl zip unzip git supervisor cron \
    && docker-php-ext-install pdo pdo_pgsql pgsql

RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet

RUN groupadd --force -g $WWWGROUP sail
RUN useradd -g sail -u $WWWUSER sail

RUN rm -f /etc/nginx/sites-enabled/*

COPY ./nginx/default.conf /etc/nginx/conf.d/default.conf

COPY ./php.ini /usr/local/etc/php/conf.d/
COPY ./supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY crontasks /etc/cron.d/crontasks

RUN chmod 0644 /etc/cron.d/crontasks &&\
    crontab /etc/cron.d/crontasks \

WORKDIR /var/www/html

EXPOSE 80

COPY ./start-container /usr/local/bin/start-container
RUN chmod +x /usr/local/bin/start-container

ENTRYPOINT ["start-container"]

