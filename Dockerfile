FROM php:7.4-apache

# install dependencies
RUN apt-get update && apt-get install -y \
    zip \
    curl \
    sudo \
    unzip \
    libicu-dev \
    libbz2-dev \
    libpng-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libreadline-dev \
    libfreetype6-dev \
    g++ \
    libzip-dev \
    git \
    sqlite3 \
    libsqlite3-dev

# copy application to /var/www/html
COPY ./ /var/www/html

# install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# install npm
COPY --from=node:12 /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=node:12 /usr/local/bin/node /usr/local/bin/node
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

# set public directory
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# enable apache mod_rewrite and mod_headers
RUN a2enmod rewrite headers

# use development php.ini
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# enable install PHP extensions
RUN docker-php-ext-install \
    bz2 \
    iconv \
    bcmath \
    opcache \
    pdo_mysql \
    pdo_sqlite \
    zip

# install dependencies and set permissions
WORKDIR /var/www/html
RUN composer install --no-cache \
    && npm -f ci \
    && npm run production \
    && cp /var/www/html/.env.example /var/www/html/.env \
    && sed -ri -e 's!DB_CONNECTION=mysql!DB_CONNECTION=sqlite!g' /var/www/html/.env \
    && sed -ri -e 's!DB_DATABASE=homestead!DB_DATABASE=/var/www/html/database.sqlite!g' /var/www/html/.env \
    && sed -ri -e 's!LOG_CHANNEL=stack!LOG_CHANNEL=stderr!g' /var/www/html/.env \
    && touch /var/www/html/database.sqlite \
    && chown -R www-data:root /var/www/html \
    && sudo -u www-data php artisan key:generate \
    && sudo -u www-data vendor/bin/phpunit \
    && sudo -u www-data php artisan migrate \
    && sudo -u www-data php artisan db:seed
