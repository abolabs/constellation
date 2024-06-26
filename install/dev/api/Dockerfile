FROM php:8.2-fpm as base-api

LABEL maintainer="Alexandre BORDIN <bordin.alexandre@gmail.com>"

# Get user arg
ARG MYUSER=${MYUSER}

# Add user
RUN useradd -ms /bin/bash -G www-data ${MYUSER} || echo "User already exists."

# Install libs
RUN apt-get update -yqq && apt-get install --no-install-recommends -yqq \
    git \
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
    libsqlite3-dev \
    libaspell-dev \
    libsnmp-dev \
    libpcre3-dev \
    libtidy-dev \
    libfontconfig \
    libxrender1 \
    libyaml-dev \
    # Dev tools
    nano \
    mariadb-client \
    && apt-get clean

# Install PHP EXTENSIONS
RUN docker-php-ext-install ldap mbstring pdo_mysql curl intl gd xml zip bz2 opcache

RUN pecl install yaml && docker-php-ext-enable yaml

FROM base-api

# XDEBUG
#RUN pecl install xdebug
#RUN docker-php-ext-enable xdebug

# COMPOSER
RUN curl --silent --show-error https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Add user
RUN useradd -ms /bin/bash -G www-data ${MYUSER} || echo "User already exists."

# Expose port
EXPOSE 80 443

# Define workdir
WORKDIR /var/www





