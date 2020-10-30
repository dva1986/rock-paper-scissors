FROM php:7.4-fpm-alpine

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

COPY . /app

WORKDIR /app

#COPY composer.json composer.lock /app/

RUN composer install --no-scripts --no-autoloader


RUN composer dump-autoload --optimize && \
	composer run-script post-install-cmd

RUN PATH=$PATH:/app/vendor/bin:bin