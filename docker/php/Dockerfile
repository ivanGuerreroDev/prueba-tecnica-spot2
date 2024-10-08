FROM composer:1.10 AS composer

COPY composer.json /app
COPY composer.lock /app

RUN composer install        \
    --ignore-platform-reqs  \
    --no-ansi               \
    --no-autoloader         \
    --no-interaction        \
    --no-scripts
RUN php artisan key:generate
RUN php artisan migrate --seed
COPY ./www /app/
RUN composer dump-autoload --optimize --classmap-authoritative

### Composer
########################################################################
### NodeJS

FROM node:14.17.0-alpine3.12 AS node

WORKDIR /app

COPY package.json           /app
COPY package-lock.json      /app
COPY vite.config.js         /app
COPY /resources             /app/resources

RUN npm install && npm run build

### NodeJS
########################################################################
### PHP

FROM php:8.2

RUN apk update && apk add --no-cache \
    libpng-dev                       \
    freetype-dev                     \
    oniguruma-dev                    \
    libxml2-dev

RUN rm -rf /var/lib/apt/lists/* && rm -rf /var/cache/apk/*
RUN docker-php-ext-configure gd --enable-gd --with-freetype
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

COPY ./www /var/www
COPY --from=composer /app/vendor                /var/www/html/vendor
COPY --from=node     /app/public                /var/www/html/public/


RUN addgroup -g 1000 -S www && \
    adduser -u 1000 -S www -G www-data

COPY --chown=www:www-data . /var/www

WORKDIR /var/www