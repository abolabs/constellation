# syntax = docker/dockerfile:1.2

FROM php:8.2-fpm

LABEL maintainer="Alexandre BORDIN <bordin.alexandre@gmail.com>"

# Get user arg
ARG MYUSER=${MYUSER}
ARG GIT_BRANCH=${GIT_BRANCH}
ARG APP_PATH=/var/www/constellation

# Install packages
RUN apt-get update -yqq && \
    apt-get install -yqq git \
                        zip unzip libzip-dev \
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

RUN cd $APP_PATH && rm -r front-app doc cli
RUN chown -R ${MYUSER}:www-data $APP_PATH/api
RUN chown -R www-data: $APP_PATH/api/storage

# Define workdir
WORKDIR $APP_PATH/api
RUN rm -rf !$/.git

# INIT APP
RUN cp .env.example .env
RUN composer  install --no-progress --no-interaction --no-cache --optimize-autoloader
RUN php artisan key:generate

# Expose port
EXPOSE 80 443

# Clean
# Clear cache
RUN apt-get remove git -yqq
RUN apt-get clean && rm -rf /var/lib/apt/lists/*




