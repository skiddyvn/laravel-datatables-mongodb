FROM php:8.1-fpm-alpine

WORKDIR /data/laravel-activitylog-mongodb

RUN apk add --no-cache --update --virtual buildDeps autoconf git g++ make
RUN apk add --no-cache --update curl-dev openssl-dev zip libzip-dev gd libpng libpng-dev libxml2-dev libpq-dev
RUN pecl install mongodb && docker-php-ext-enable mongodb
RUN docker-php-ext-install opcache bcmath sockets zip gd xml
RUN pecl config-set php_ini /etc/php.ini \
	&& curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
	&& apk del buildDeps \
	&& rm -rf /var/cache/apk/* \
	&& apk del libpng-dev
