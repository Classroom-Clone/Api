FROM ghcr.io/blumilksoftware/php:8.1

ARG XDEBUG_HOST=172.17.0.1
ARG XDEBUG_PORT=9021
ARG XDEBUG_INSTALL=false
ARG XDEBUG_MODE=debug
ARG XDEBUG_START_WITH_REQUEST=yes
ARG XDEBUG_LOG_LEVEL=0

RUN apk --no-cache add zip libzip-dev libpng-dev \
    && docker-php-ext-install zip gd \
    && docker-php-ext-configure zip

RUN if [ ${XDEBUG_INSTALL} = true ]; then \
    apk --no-cache add $PHPIZE_DEPS \
    && pecl install xdebug-3.0.2 \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.client_host=${XDEBUG_HOST}" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_port=${XDEBUG_PORT}" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.mode=${XDEBUG_MODE}" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.start_with_request=${XDEBUG_START_WITH_REQUEST}" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.log_level=${XDEBUG_LOG_LEVEL}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
;fi
