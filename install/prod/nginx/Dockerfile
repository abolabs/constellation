ARG TAG_NAME=${TAG_NAME}
ARG APP_PATH=/var/www/constellation

FROM registry.gitlab.com/abolabs/constellation/fpm:${TAG_NAME} as fpm-build

FROM nginx:latest

RUN mkdir -p "$APP_PATH"
COPY --from=fpm-build $APP_PATH/public $APP_PATH/public
COPY ./nginx.conf /etc/nginx/nginx.conf




