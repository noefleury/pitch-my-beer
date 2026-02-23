# use PHP 8.5
FROM php:8.5.3-apache-trixie

# install pdo_mysql driver
RUN docker-php-ext-install pdo_mysql
