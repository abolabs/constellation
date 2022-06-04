ARG TAG_NAME=${TAG_NAME}

FROM registry.gitlab.com/abolabs/constellation/fpm:${TAG_NAME} as fpm-build

FROM nginx:1.22

ARG APP_PATH=/var/www/constellation

RUN mkdir -p "$APP_PATH"
COPY --from=fpm-build $APP_PATH/public $APP_PATH/public
COPY ./nginx.conf /etc/nginx/nginx.conf




