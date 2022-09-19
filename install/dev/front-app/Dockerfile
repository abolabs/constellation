FROM nginx:latest

LABEL maintainer="Alexandre BORDIN <bordin.alexandre@gmail.com>"

# Get user arg
ARG MYUSER=${MYUSER}

# Update packages
RUN apt-get update -yqq

RUN apt-get install -yqq gnupg software-properties-common

# Add Node
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash -

RUN apt install nodejs

# Add user
RUN useradd -ms /bin/bash -G www-data ${MYUSER} || echo "User already exists."

# Expose port
EXPOSE 80 443

# Define workdir
WORKDIR /var/www




