# Utiliser l'image PHP avec Apache
FROM php:apache

# Installer des extensions PHP
RUN docker-php-ext-install pdo pdo_mysql

# Installer Node.js
RUN apt-get update && apt-get install -y gnupg
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash -
RUN apt-get install -y nodejs

# Installer les dépendances nécessaires pour générer une clé SSH
RUN apt-get update && apt-get install -y openssh-client

# Générer une clé SSH (remplacer 'your_email@example.com' par votre email)
RUN ssh-keygen -t rsa -b 4096 -C "tatuefom@3il.fr" -f /root/.ssh/id_rsa -N ''
RUN eval "$(ssh-agent -s)" ssh-add ~/.ssh/id_rsa

# Copier les fichiers de l'application dans le conteneur
COPY . /var/www/html

# Donner les permissions appropriées
RUN chown -R www-data:www-data /var/www/html
EXPOSE 80
