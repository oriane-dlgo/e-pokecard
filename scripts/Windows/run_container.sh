#!/bin/bash

echo " Démarrage du projet SAE (Docker sur Windows)..."

# Détection de la version de Docker Compose
if docker compose version >/dev/null 2>&1; then
    COMPOSE_CMD="docker compose"
else
    COMPOSE_CMD="docker-compose"
fi

# 1. On lance les conteneurs
echo " Lancement avec $COMPOSE_CMD..."
$COMPOSE_CMD up -d --build

# Petite pause pour laisser le temps au conteneur de s'initialiser
sleep 2

echo " Installation des dépendances PHP..."
# On utilise -i (interactive) mais pas -t (tty) pour éviter les glitchs sous Git Bash parfois
docker exec -i sae_php_app composer install

# Vérification et création du fichier .env s'il n'existe pas
if [ ! -f .env ]; then
    echo " Création du fichier .env à partir de env.example..."
    cp env.example .env
fi

# Correction des permissions
# Note : Sous Windows/Docker Desktop, les permissions sont souvent gérées par l'OS hôte,
# mais on laisse ces commandes pour s'assurer que le conteneur a les droits en écriture interne.
echo " Correction des permissions..."
docker exec -i sae_php_app chmod -R 755 /var/www/html || echo "  Petit souci de permission ignoré"
docker exec -i sae_php_app chmod -R 777 /var/www/html/writable || echo "  Ignoré sous Windows"
docker exec -i sae_php_app chmod -R 777 /var/www/html/public/assets || echo "  Ignoré sous Windows"

# --- PAUSE POUR MYSQL ---
echo " Attente du démarrage de la Base de Données..."
echo "   (Cela peut prendre jusqu'à 30 secondes pour le premier lancement)"

# Boucle d'attente
for i in {1..30}; do
    echo -n "."
    sleep 1
done
echo "" # Saut de ligne

# --- MIGRATIONS ---
echo "  MIGRATION : Création des tables..."
# On tente la migration.
docker exec -i sae_php_app php spark migrate --all

if [ $? -eq 0 ]; then
    echo " Tables créées avec succès."
    
    echo " SEEDER : Remplissage des données..."
    docker exec -i sae_php_app php spark db:seed FullDataSeeder
else
    echo " Erreur : MySQL n'est pas encore prêt ou mal configuré."
    echo "   Essayez de relancer la commande : docker exec -it sae_php_app php spark migrate --all"
fi
# ------------------------------------

# Dis à Git : "Arrête de surveiller si un fichier est exécutable ou non, je suis sous Windows, je m'en fiche."
git config core.filemode false
# Dis à Git : "Gére intelligemment les conversions ou ignore les."
git config core.autocrlf true


echo " SITE ACCESSIBLE : http://localhost:8080"