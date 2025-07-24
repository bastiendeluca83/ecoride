FROM php:8.2-apache

# Installation de l'extension pdo_mysql
RUN docker-php-ext-install pdo pdo_mysql

# Copie des fichiers PHP dans le dossier web
COPY src/ /var/www/html/
# Configuration des permissions
RUN chown -R www-data:www-data /var/www/html