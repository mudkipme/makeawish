FROM php:8.0-fpm

RUN apt-get update && apt-get install -y supervisor zip imagemagick nginx \
    libpng-dev libsqlite3-dev libxml2-dev libjpeg62-turbo-dev libfreetype6-dev \
    libzip-dev libc-client-dev libkrb5-dev unzip --no-install-recommends \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN curl -fsSL https://deb.nodesource.com/setup_14.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install bcmath exif gd \
    intl zip imap mysqli pdo_mysql \
    soap sockets pcntl

RUN echo '' | pecl install -o -f redis msgpack xmlrpc \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis msgpack xmlrpc

COPY ./docker/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/php.ini /usr/local/etc/php/
COPY ./docker/supervisord.conf /etc/supervisor/supervisord.conf
COPY . /var/www/html

RUN curl https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && cd /var/www/html && composer install --optimize-autoloader --no-dev

RUN npm install && npm run prod && npm cache clean --force && rm -rf node_modules

RUN chown -R www-data:www-data /var/www/html

WORKDIR /var/www/html
EXPOSE 80
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]
