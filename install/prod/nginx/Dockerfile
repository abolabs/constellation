ARG TAG_NAME=${TAG_NAME}

FROM registry.gitlab.com/abolabs/constellation/fpm:${TAG_NAME} as fpm-build

FROM nginx:latest

COPY --from=fpm-build /var/www/public /var/www/public




