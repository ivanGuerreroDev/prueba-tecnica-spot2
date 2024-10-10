ARG php_version

FROM php:${php_version}-fpm AS build
# Install common php extension dependencies
RUN apt-get update && apt-get install -y \
    libfreetype-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    zlib1g-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install zip \
    && docker-php-ext-install pdo \
    && docker-php-ext-install pdo_mysql

# Set the working directory

COPY ../../www /var/www/app
WORKDIR /var/www/app

RUN chown -R www-data:www-data /var/www/app \
    && chmod -R 775 /var/www/app/storage
# install composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY --from=build ../../www/composer.json ./
RUN composer install
RUN php artisan key:generate
# install nodejs
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash -
RUN apt-get update && apt-get install -y nodejs

# install npm modules
RUN npm install
RUN npx vite build

COPY --from=build ../../www/vendor ./vendor
COPY --from=build ../../www/node_modules ./node_modules
COPY --from=build ../../www/public ./public

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
