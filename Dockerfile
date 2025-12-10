# syntax=docker/dockerfile:1.4
FROM php:8.4-apache

# 1. Installation des dépendances système nécessaires pour les extensions PHP
# libicu-dev est requis pour l'extension 'intl' de CodeIgniter
RUN apt-get update && apt-get install -y \
    libicu-dev \
    unzip \
    zip \
    git \
    && rm -rf /var/lib/apt/lists/*

# 2. Installation des extensions PHP via l'outil officiel Docker
# CodeIgniter a besoin de : intl, mysql
RUN docker-php-ext-configure intl \
    && docker-php-ext-install intl pdo pdo_mysql mysqli

# 3. Activation du module de réécriture d'URL Apache (Indispensable pour CodeIgniter)
RUN a2enmod rewrite

# 4. Modification de la racine du serveur vers /public
# CodeIgniter sécurise l'app en mettant le point d'entrée dans /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 5. Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 6. Dossier de travail
WORKDIR /var/www/html
