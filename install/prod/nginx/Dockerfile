# syntax = docker/dockerfile:1.2
FROM nginx:1.23

LABEL maintainer="Alexandre BORDIN <bordin.alexandre@gmail.com>"

# Get user arg
ARG MYUSER=${MYUSER}
ARG GIT_BRANCH=${GIT_BRANCH}
ARG APP_PATH=/var/www/constellation

RUN apt-get update -yqq \
    && apt-get install -yqq git
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash - && apt-get -yqq install nodejs

# Add user
RUN useradd -ms /bin/bash -G www-data ${MYUSER} || echo "User already exists."

# Clean
# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy sources
RUN git clone --depth=1 https://gitlab.com/abolabs/constellation.git -b $GIT_BRANCH /tmp/

# Copy Front
RUN cd /tmp/front-app && \
    mv .env.example .env && \
    npm install && \
    npm run build
RUN mv /tmp/front-app/build /var/www

RUN chown -R ${MYUSER}:www-data /var/www
RUN rm -r /tmp/*

# Define workdir
WORKDIR /var/www

COPY ./nginx.conf /etc/nginx/nginx.conf
COPY default.conf /etc/nginx/conf.d/

# Expose port
EXPOSE 80 443
