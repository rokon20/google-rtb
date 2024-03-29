# Use the official PHP 8 image as base
FROM php:8-apache

# Copy the PHP script into the container
COPY . /var/www/html/

# Expose port 80
EXPOSE 80
