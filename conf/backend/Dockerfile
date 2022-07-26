FROM php:8.1.8-apache-buster

COPY php.ini /usr/local/etc/php/
COPY *.conf /etc/apache2/sites-enabled/

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN apt -y update && \
    apt -y upgrade && \
    apt -y install  \
            git \
            unzip \
            zip

RUN docker-php-ext-install pdo_mysql

RUN a2enmod rewrite

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html