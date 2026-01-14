#!/bin/bash

echo "🚀 Démarrage du projet SAE (Podman)..."

podman-compose down

# 1. On lance les conteneurs
podman-compose up -d --build

echo "📦 Installation des dépendances PHP..."
podman exec -it sae_php_app composer install

# Correction des permissions (on tente, même si ça râle parfois sous Podman)
echo "🔧 Correction des permissions..."
podman exec -it sae_php_app chmod -R 755 /var/www/html || echo "⚠️  Petit souci de permission ignoré"
podman exec -it sae_php_app chmod -R 777 /var/www/html/writable || echo "⚠️  Petit souci de permission ignoré"
podman exec -it sae_php_app chmod -R 777 /var/www/html/public/assets || echo "⚠️  Petit souci de permission ignoré"

# --- PAUSE POUR MYSQL ---
echo "⏳ Attente du démarrage de la Base de Données..."
echo "   (Cela peut prendre jusqu'à 10 secondes pour le premier lancement)"

# Petite boucle d'attente simple (10 secondes)
for i in {1..10}; do
    echo -n "."
    sleep 1
done
echo "" # Saut de ligne

# --- MIGRATIONS ---
echo "🗄️  MIGRATION : Création des tables..."
# On tente la migration. Si ça échoue, on le dit.
podman exec -it sae_php_app php spark migrate --all
if [ $? -eq 0 ]; then
    echo "✅ Tables créées avec succès."
    
    echo "🌱 SEEDER : Remplissage des données..."
    podman exec -it sae_php_app php spark db:seed FullDataSeeder
else
    echo "❌ Erreur : MySQL n'est pas encore prêt ou mal configuré."
    echo "   Essayez de relancer la commande : podman exec -it sae_php_app php spark migrate --all"
fi
# ------------------------------------

echo "✅ SITE ACCESSIBLE : http://localhost:8080"
