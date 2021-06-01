FROM php:8-apache
COPY . /var/www/html/
WORKDIR /var/www/html/

ENV APACHE_DOCUMENT_ROOT /var/www/html

EXPOSE 80
