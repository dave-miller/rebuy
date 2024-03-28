FROM php:8.2-fpm-alpine3.17

WORKDIR /var/www

ENV COMPOSER_ALLOW_SUPERUSER 1

# Get latest Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# install roadrunner
COPY --from=ghcr.io/roadrunner-server/roadrunner:2023 /usr/bin/rr /var/www

# install ext-installer
# COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN --mount=type=bind,from=mlocati/php-extension-installer:1.5,source=/usr/bin/install-php-extensions,target=/usr/local/bin/install-php-extensions \
     install-php-extensions pdo_mysql opcache zip xsl dom exif intl pcntl pcov bcmath sockets && \
     apk del --no-cache ${PHPIZE_DEPS} ${BUILD_DEPENDS}


# RUN install-php-extensions intl pdo_mysql \    
    # bcmath \
    # sockets \
    # pcntl \
    # pcov \
    # zip \
    # redis
    # opcache 

# update base image
RUN apk update && apk upgrade \
    && apk add nodejs npm figlet

# copy required files
COPY ./docker/app/php.ini "$PHP_INI_DIR/php.ini"
COPY ./docker/app/pcov.ini $PHP_INI_DIR/conf.d/docker-php-ext-pcov.ini
COPY ./docker/app/entrypoint.sh /usr/local/bin/


# COPY composer.lock composer.json ./
# RUN composer validate --no-check-all --no-check-publish
# RUN composer config -g github-oauth.github.com 8b19ac6a9fd10addf1686052213d20add05fa2bb
# RUN composer --version \
#     && composer install --no-scripts --no-autoloader --no-progress --ignore-platform-reqs

COPY . .

# RUN composer dump-autoload --optimize || true

RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

CMD ["php-fpm"]
