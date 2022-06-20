FROM php:8.0-fpm
RUN docker-php-ext-install pdo_mysql
RUN apt update && apt install
RUN apt install -y git
#RUN pecl install -f raphf 
#RUN docker-php-ext-enable raphf
#RUN apt install -y libicu-dev libssl-dev zlib1g-dev libpng-dev libcurl4-openssl-dev
#RUN pecl install -f pecl_intl pecl_http
#RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
#RUN composer require guzzlehttp/guzzle:^7.0
WORKDIR /var/www/public
VOLUME /usr/local/etc/php