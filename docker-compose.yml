version: '3.8'

services:
  web:
    image: php:8.2-apache
    container_name: north-pole-dlr
    ports:
      - "80:80"
    volumes:
      - ./:/var/www/html
    environment:
      - APACHE_DOCUMENT_ROOT=/var/www/html
    command: >
      bash -c "a2enmod rewrite && 
      apache2-foreground"
