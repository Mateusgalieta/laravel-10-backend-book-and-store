FROM php:8.2-fpm-alpine

# Install common php extension dependencies
RUN apk --update add wget \
    curl \
    git \
    grep \
    build-base \
    libmemcached-dev \
    libmcrypt-dev \
    libxml2-dev \
    imagemagick-dev \
    openssl-dev \
    pcre-dev \
    libtool \
    make \
    autoconf \
    g++ \
    cyrus-sasl-dev \
    libgsasl-dev \
    supervisor \
    linux-headers

RUN docker-php-ext-install mysqli pdo pdo_mysql xml
RUN pecl channel-update pecl.php.net \
    && pecl install memcached \
    && pecl install imagick \
    && docker-php-ext-enable memcached \
    && docker-php-ext-enable imagick

RUN apk add --update nodejs \
    && apk add --update npm

RUN rm /var/cache/apk/*

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory
COPY . /var/www/html
WORKDIR /var/www/html

COPY ./.docker/php/run.sh /tmp/run.sh
RUN chmod +x /tmp/run.sh

# Set entrypoint script and the default command to run php-fpm
EXPOSE 9000
ENTRYPOINT ["/tmp/run.sh", "php-fpm"]
