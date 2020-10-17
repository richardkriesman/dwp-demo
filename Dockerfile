FROM php:7.4-apache

# copy source files
COPY . /var/www/html
RUN cp /var/www/html/.env.docker /var/www/html/.env
RUN chmod -R 777 /var/www/html

# set apache document root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# install pdo_mysql
RUN docker-php-ext-install pdo_mysql && docker-php-ext-enable pdo_mysql

# enable mod_rewrite
RUN a2enmod rewrite
