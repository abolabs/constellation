FROM php:8.0-fpm

LABEL maintainer="Alexandre BORDIN <bordin.alexandre@gmail.com>"

# Get user arg
ARG MYUSER=${MYUSER}

# Update packages
RUN apt-get update -yqq

RUN apt-get install -yqq gnupg software-properties-common

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
                        libsqlite3-dev \
                        libaspell-dev \
                        libsnmp-dev \
                        libpcre3-dev \
                        libtidy-dev \
                        libfontconfig \
                        libxrender1

# Install PHP EXTENSIONS
RUN docker-php-ext-install ldap mbstring pdo_mysql curl intl gd xml zip bz2 opcache

# Install dev tools
RUN apt-get install -yqq nano mariadb-client

# XDEBUG
#RUN pecl install xdebug
#RUN docker-php-ext-enable xdebug

# COMPOSER
RUN curl --silent --show-error https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer


# Add user
RUN useradd -ms /bin/bash -G www-data ${MYUSER}

# Expose port
EXPOSE 80 443

# Define workdir
WORKDIR /var/www




