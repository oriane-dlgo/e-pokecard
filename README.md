🛒 Projet SAE 3.01 - Boutique Pokémon

Ce projet est une application e-commerce développée avec CodeIgniter 4 et Docker.
🚀 Guide d'installation rapide

Ce guide suppose que vous avez cloné le dépôt et que vous êtes à la racine du projet.
1. Lancer l'environnement (Docker/Podman)

Le projet est conteneurisé. Lancez la commande suivante à la racine :
Bash

# Si vous êtes sur une machine personnelle
docker-compose up -d --build

# Si vous êtes sur les machines de l'IUT (Podman)
podman-compose up -d --build

    Note IUT : Si on vous demande de choisir une image, sélectionnez l'option 1 (miroir local de l'université) pour plus de rapidité.

2. Installation des dépendances & Configuration

Une fois le conteneur lancé, il faut initialiser le framework. Exécutez ces commandes (depuis votre terminal hôte) :
Bash

# 1. Installer les librairies CodeIgniter (dossier vendor)
podman exec -it sae_php_app composer install

# 2. Configurer l'environnement
# Copiez le fichier d'exemple pour créer votre configuration locale
cp env.example .env
# (Ou créez un fichier .env manuellement avec CI_ENVIRONMENT = development)

# 3. Fixer les permissions (Crucial sous Linux/IUT)
# Cette commande corrige les erreurs 403 Forbidden et les problèmes d'écriture
podman exec -it sae_php_app chmod -R 755 /var/www/html
podman exec -it sae_php_app chmod -R 777 /var/www/html/writable

3. Base de Données

L'application nécessite une base de données MySQL initialisée.

    Accédez à phpMyAdmin : http://localhost:8081

        Serveur : mysql (ou sae_mysql)

        User : root

        Password : root

    Sélectionnez la base de données sae_db.

    Allez dans l'onglet Importer.

    Chargez le fichier database.sql situé à la racine du projet.

4. Accès au site

L'application est accessible ici : 👉 http://localhost:8080