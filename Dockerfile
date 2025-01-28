# Utilisation de l'image PHP officielle avec Apache
FROM php:8.2-apache

# Installation des extensions nécessaires
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip sqlite3 libsqlite3-dev mariadb-client libmariadb-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite \
    && a2enmod rewrite

# Copie des fichiers de l'application
COPY . /var/www/html

# Définir le répertoire de travail
WORKDIR /var/www/html

# Configuration des permissions pour les fichiers et dossiers
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Copie de la configuration Apache pour Laravel
COPY apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Installation de Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Installation des dépendances Laravel et génération de la clé
RUN composer install \
    && cp .env.example .env \
    && php artisan key:generate

# Commande de démarrage d'Apache
CMD ["apache2-foreground"]
