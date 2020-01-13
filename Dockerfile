FROM php:7.4.1-fpm-alpine

RUN apk update
RUN apk add --no-cache openssl bash nodejs npm postgresql-dev
RUN docker-php-ext-install pdo pdo_pgsql

ADD . /var/www
RUN chown -R www-data:www-data /var/www

# Add a non-root user to prevent files being created with root permissions on host machine.
ENV USER=laravel
ARG UID=1000
ENV UID ${UID}
ARG GID=1000
ENV GID ${GID}

RUN addgroup --gid "$GID" "$USER" \
    && adduser \
    --disabled-password \
    --gecos "" \
    --home "$(pwd)" \
    --ingroup "$USER" \
    --no-create-home \
    --uid "$UID" \
    "$USER"

WORKDIR /var/www

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/usr/bin --filename=composer

COPY .docker/nginx/nginx.conf /etc/nginx/conf.d/

EXPOSE 80
ENTRYPOINT ["php-fpm"]
