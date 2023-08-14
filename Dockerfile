FROM php:8.2-apache as builder

# RUN mkdir -p /var/www
# WORKDIR /var/www

RUN apt update && apt dist-upgrade -y

RUN apt install -y \
#    php-xdebug \
    git \
    curl \
    zip \
    sqlite3 \
    libbz2-dev \
    libsqlite3-dev \
    libssl-dev \
    libcurl4-openssl-dev \
    libjpeg-dev \
    libonig-dev \
    libreadline-dev \
    libtidy-dev \
    libxslt-dev \
    libzip-dev \
    net-tools \
    iputils-ping \
    nano

# RUN apk add --update --no-cache --virtual .build-deps \
#             autoconf g++ make \
#             curl \
#             git \
#             zip \
#             libxml2-dev \
#             libzip-dev \
#             sqlite \
#             sqlite-dev \
#             icu-dev \
#             gettext-dev \
#             nano

# RUN docker-php-ext-install intl && docker-php-ext-enable intl
RUN docker-php-ext-install gettext && docker-php-ext-enable gettext
RUN docker-php-ext-install pdo_mysql && docker-php-ext-enable pdo_mysql
RUN docker-php-ext-install pdo_sqlite && docker-php-ext-enable pdo_sqlite
# RUN docker-php-ext-install sockets && docker-php-ext-enable sockets
RUN pecl install -f xdebug
# RUN docker-php-ext-enable xdebug

RUN yes | pecl install ${XDEBUG_VERSION} \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

COPY config/php.ini /usr/local/etc/php/conf.d/local.ini

RUN a2enmod rewrite
RUN a2enmod deflate

RUN apachectl -M

FROM builder as dependencies
RUN echo $(php -v)
WORKDIR /
RUN mkdir -p /usr/bin/
RUN cp $(which php) /usr/bin/

WORKDIR /tmp

RUN git clone https://github.com/rantes/DumboPHP.git
WORKDIR /tmp/DumboPHP

RUN php install.php

FROM dependencies as release
WORKDIR /var/www/html
USER www-data

RUN echo 'Running migrations...'
RUN php /usr/local/bin/dumbo migration run all
RUN echo 'Running sowing seeds...'
RUN php /usr/local/bin/dumbo migration sow

EXPOSE 80

# CMD ["sh", "./docker-startup.sh"]
