ARG TAG_NAME=${TAG_NAME}

FROM registry.gitlab.com/abolabs/constellation/api:${TAG_NAME} as api-build

FROM nginx:1.22

ARG APP_PATH=/var/www/constellation

RUN mkdir -p "$APP_PATH"
COPY --from=api-build $APP_PATH/public $APP_PATH/public
COPY ./nginx.conf /etc/nginx/nginx.conf




