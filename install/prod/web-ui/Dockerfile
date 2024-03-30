# syntax = docker/dockerfile:1.2

FROM node:20 AS builder

ARG GIT_BRANCH=${GIT_BRANCH}

RUN git clone --depth=1 https://gitlab.com/abolabs/constellation.git -b "$GIT_BRANCH" /tmp/constellation
# Copy Front
WORKDIR /tmp/constellation/web-ui
RUN npm install --ignore-scripts && \
    ./node_modules/.bin/vite build
RUN mv /tmp/constellation/web-ui/build /var/www

WORKDIR /var/www
RUN rm -r /tmp/constellation

FROM nginx:1.25

LABEL maintainer="Alexandre BORDIN <bordin.alexandre@gmail.com>"

# Get user arg
ARG MYUSER=${MYUSER}
ARG APP_PATH=/var/www/constellation

# Add user
RUN useradd -ms /bin/bash -G www-data ${MYUSER} || echo "User already exists."

# Copy sources
COPY --from=builder /var/www /var/www

RUN chown -R ${MYUSER}:www-data /var/www

# Define workdir
WORKDIR /var/www

COPY ./nginx.conf /etc/nginx/nginx.conf
COPY ./default.conf /etc/nginx/conf.d/default.conf

# Expose port
EXPOSE 80 443
