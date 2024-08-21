FROM php:8.2-fpm-alpine

WORKDIR /var/www/app

CMD [ "php", "-S", "0.0.0.0:5000" ]