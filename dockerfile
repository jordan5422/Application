# Utiliser une image de PHP avec Apache
FROM php:8.2.12-apache

# Définir le répertoire de travail dans le conteneur
WORKDIR /var/www/html

# Copier les fichiers locaux dans le conteneur
COPY . /var/www/html/

# Installer les dépendances (si nécessaire)
RUN composer install

# Exposer le port sur lequel le serveur web Apache écoute
EXPOSE 80
