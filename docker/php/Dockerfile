FROM php:8.1-apache

RUN docker-php-ext-install mysqli \
    && a2enmod rewrite headers

RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

RUN printf "upload_max_filesize = 64M\npost_max_size = 64M\nmemory_limit = 256M\n" > /usr/local/etc/php/conf.d/uploads.ini
