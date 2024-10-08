ARG php_version

FROM php:${php_version}
ARG php_version
FROM jkaninda/laravel-php-fpm:${php_version}
# Copy laravel project files
COPY ./www /var/www/html
# Storage Volume
VOLUME /var/www/html/storage

WORKDIR /var/www/html

# Custom cache invalidation / optional
#ARG CACHEBUST=1
# Run composer install / Optional
#RUN composer install
# Fix permissions
RUN chown -R www-data:www-data /var/www/html

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# install nodejs
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash -
RUN apt-get install -y nodejs

# install composer modules
RUN composer install
RUN php artisan key:generate

# Migration and seed
RUN php artisan migrate --seed

# install npm modules
RUN npm install
RUN npm run build

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# install nodejs
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash -
RUN apt-get install -y nodejs

# install composer modules
RUN composer install
RUN php artisan key:generate

# Migration and seed
RUN php artisan migrate --seed

# install npm modules
RUN npm install
RUN npm run build

