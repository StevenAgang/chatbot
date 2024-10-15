# Use the official PHP image with Apache
FROM php:7.4.33-php

#Install necessary php extension
RUN docker-ext-php-install
#Setting working directory
WORKDIR /var/www/html

#Copying file into container
COPY . .

#Enable apache mod_rewrite for Codeigniter URL Routing
RUN a2enmod rewrite


# Exposing port 80b to the world\
EXPOSE 80