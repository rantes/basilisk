FROM php:8.2-apache as builder

RUN apt update && apt dist-upgrade -y

RUN apt install -y \
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
    nano \
    sudo \
    openssl

RUN docker-php-ext-install gettext && docker-php-ext-enable gettext
RUN docker-php-ext-install pdo_mysql && docker-php-ext-enable pdo_mysql
RUN docker-php-ext-install pdo_sqlite && docker-php-ext-enable pdo_sqlite
RUN pecl install -f xdebug

RUN yes | pecl install ${XDEBUG_VERSION} \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

COPY config/php.ini /usr/local/etc/php/conf.d/local.ini
COPY config/000-default.conf /etc/apache2/sites-enabled/000-default.conf
COPY config/apache2.conf /etc/apache2/apache2.conf

RUN a2enmod ssl
RUN a2enmod socache_shmcb
RUN a2enmod rewrite
RUN a2enmod deflate

FROM builder as dependencies
RUN echo $(php -v)
WORKDIR /
RUN mkdir -p /usr/bin/
RUN cp $(which php) /usr/bin/

WORKDIR /tmp
RUN openssl genrsa -out apache-selfsigned.pem 2048
RUN openssl req \
        -new \
        -sha256 \
        -subj "/emailAddress=email@localhost/C=CO/ST=bogota/L=bogota/O=latuteca/OU=development/CN=localhost" \
        -key apache-selfsigned.pem \
        -out apache-selfsigned.cert
RUN openssl x509 -req -in apache-selfsigned.cert -signkey apache-selfsigned.pem -out apache-selfsigned-full.pem

RUN git clone https://github.com/rantes/DumboPHP.git
WORKDIR /tmp/DumboPHP

RUN php install.php

FROM dependencies as release

COPY --chown=www-data --from=dependencies /tmp/apache-selfsigned.pem /etc/apache2/
COPY --chown=www-data --from=dependencies /tmp/apache-selfsigned-full.pem /etc/apache2/
RUN ls
RUN apache2ctl configtest
RUN apache2ctl start

WORKDIR /var/www/html
USER www-data

EXPOSE 80
EXPOSE 443