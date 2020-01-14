FROM php:7.4.1-fpm

RUN docker-php-ext-install mysqli pdo pdo_mysql
