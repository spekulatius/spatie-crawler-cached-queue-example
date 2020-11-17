#
# Based on https://github.com/kamerk22/laravel-alpine
#
# docker build -t crawler-example -f ./Dockerfile .
# docker run -p 8080:80 --rm crawler-example
#

# Base image
FROM kamerk22/laravel-alpine:7.4-mysql-nginx

# PHP extensions: zip and exif 
RUN apk add libzip-dev && docker-php-ext-configure zip && docker-php-ext-install zip
RUN docker-php-ext-install exif

# Copy composer files in.
COPY composer.json composer.json
COPY composer.lock composer.lock

# Copy code to container. You can mount dir
ADD --chown=www-data:www-data . .

# Then finally update required package
RUN composer install --prefer-dist --no-scripts --no-autoloader && rm -rf /root/.composer

# Fix required permission for cache and storage
RUN chgrp -R www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

RUN composer dump-autoload --no-scripts --optimize
RUN ln -s /var/www/storage/app/ /var/www/public/storage
