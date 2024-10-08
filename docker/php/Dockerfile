ARG php_version

FROM php:${php_version}

# prepare install
RUN apt-get update --fix-missing
RUN apt-get install -y build-essential libssl-dev zlib1g-dev libpng-dev libjpeg-dev libfreetype6-dev

# install mysql extension
RUN docker-php-ext-install mysqli pdo pdo_mysql

# install Ctype extension
RUN docker-php-ext-install ctype
# install curls php extension
RUN apt-get install -y libcurl4-openssl-dev
RUN docker-php-ext-install curl
#install dom php extension
RUN apt-get install -y libxml2-dev
RUN docker-php-ext-install dom
# install fileinfo php extension
RUN docker-php-ext-install fileinfo
# install Filter php extebsion
RUN docker-php-ext-install filter
# install Hash, Mbstring, OpenSSL, PCRE, PDO, Session, Tokenizer and XML php extension
RUN docker-php-ext-install hash mbstring openssl pcre session tokenizer xml



RUN a2enmod rewrite
RUN a2enmod headers

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

