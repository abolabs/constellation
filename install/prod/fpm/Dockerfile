# syntax = docker/dockerfile:1.2

FROM php:8.0-fpm

LABEL maintainer="Alexandre BORDIN <bordin.alexandre@gmail.com>"

# Get user arg
ARG MYUSER=${MYUSER}
ARG GIT_BRANCH=${GIT_BRANCH}
ARG APP_PATH=/var/www/constellation

# Update packages
RUN apt-get update -yqq \
    && apt-get install -yqq gnupg software-properties-common

# Add Node
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash -

# Install libs
RUN apt-get install -yqq git \
                        zip unzip libzip-dev \
                        nodejs \
                        libonig-dev \
                        libcurl4-gnutls-dev \
                        libicu-dev \
                        libmcrypt-dev \
                        libvpx-dev \
                        libjpeg-dev \
                        libpng-dev \
                        libxpm-dev \
                        zlib1g-dev \
                        libfreetype6-dev \
                        libxml2-dev \
                        libexpat1-dev \
                        libbz2-dev \
                        libgmp3-dev \
                        libldap2-dev \
                        unixodbc-dev \
                        libpq-dev \
                        libaspell-dev \
                        libsnmp-dev \
                        libpcre3-dev \
                        libtidy-dev \
                        libfontconfig \
                        libxrender1
# Add user
RUN useradd -ms /bin/bash -G www-data ${MYUSER} || echo "User already exists."

# Install PHP EXTENSIONS
RUN docker-php-ext-install ldap mbstring pdo_mysql curl intl gd xml zip bz2 opcache

# COMPOSER
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# COPY SOURCE
RUN git clone --depth=1 https://gitlab.com/abolabs/constellation.git -b $GIT_BRANCH $APP_PATH

RUN chown -R ${MYUSER}:www-data $APP_PATH
RUN chown -R www-data: $APP_PATH/storage

# Define workdir
WORKDIR $APP_PATH
RUN rm -rf !$/.git

# INIT APP
RUN cp .env.example .env
RUN composer  install --no-progress --no-interaction --no-cache --optimize-autoloader
RUN php artisan key:generate
RUN npm install --force --no-optional && npm run production

# Expose port
EXPOSE 80 443

# Clean
# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*




