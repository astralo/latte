FROM php:7.1-fpm-alpine3.9

RUN apk add --update --no-cache \
    bash zsh curl wget rsync ca-certificates openssl openssh git tzdata openntpd nano mc htop

RUN apk add --update --no-cache \
    libxrender fontconfig libc6-compat \
    mysql-client nodejs npm composer gnupg binutils-gold \
    g++ gcc gnupg libgcc linux-headers make python \
    php7-redis php7-xml php7-simplexml php7-memcached php7-imap php7-pdo_mysql php7-sqlite3
    
RUN docker-php-ext-install bcmath pdo_mysql

RUN apk add --no-cache freetype libpng libjpeg-turbo freetype-dev libpng-dev libjpeg-turbo-dev && \
  docker-php-ext-configure gd \
    --with-gd \
    --with-freetype-dir=/usr/include/ \
    --with-png-dir=/usr/include/ \
    --with-jpeg-dir=/usr/include/ && \
  NPROC=$(grep -c ^processor /proc/cpuinfo 2>/dev/null || 1) && \
  docker-php-ext-install -j${NPROC} gd && \
  apk del --no-cache freetype-dev libpng-dev libjpeg-turbo-dev

RUN apk add --update --no-cache zlib-dev && \
  docker-php-ext-install zip

RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install xdebug-2.6.1 \
    && docker-php-ext-enable xdebug

WORKDIR /app