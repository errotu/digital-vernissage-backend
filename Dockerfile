FROM php:7.0-apache
COPY php.ini /usr/local/etc/php/
COPY src/ /var/www/html/