FROM php:7.2-apache 
RUN apt-get update \
    && apt-get install -y git libcurl4-gnutls-dev curl
RUN docker-php-ext-install mysqli curl mbstring
RUN a2enmod rewrite
RUN a2enmod headers
#Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=. --filename=composer
RUN mv composer /usr/local/bin/
COPY src/ /var/www/html/
RUN composer install
RUN mkdir -p /var/www/html/application/logs
RUN chmod -R 777 /var/www/html/application/logs
EXPOSE 80
