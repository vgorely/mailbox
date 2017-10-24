FROM php:7.1-fpm-alpine

# Install packages
RUN apk add \
    nginx \
    php7-xdebug \
    postgresql-client \
    postgresql-dev \
    supervisor \
    --repository=http://dl-cdn.alpinelinux.org/alpine/edge/community \
    --no-cache \
    --update

# Install PHP extensions
RUN docker-php-ext-install bcmath opcache pdo_pgsql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Enable Xdebug
RUN mv /usr/lib/php7/modules/xdebug.so /usr/local/lib/php/extensions/no-debug-non-zts-20160303

# Create folders
RUN mkdir -p \
    /run/supervisord /var/log/supervisord \
    /run/nginx \
    /var/log/mailbox
RUN chown www-data /var/log/mailbox

# Replace configuration files
COPY ./docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY ./docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf
COPY ./docker/php/php.ini /usr/local/etc/php/php.ini
COPY ./docker/php/conf.d/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

WORKDIR /server/http

# Start supervisord
ENTRYPOINT ["/usr/bin/supervisord"]
CMD ["-c", "/etc/supervisor/conf.d/supervisord.conf"]
