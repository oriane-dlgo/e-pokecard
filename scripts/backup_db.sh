#!/bin/bash

# ==============================================================================
# CONFIGURATION
# ==============================================================================
CONTAINER_DB="sae_mysql"
CONTAINER_PHP="sae_php_app"
DB_USER="root"
DB_PASS="root"
DB_NAME="sae_db"

# Détection automatique du dossier où se trouve ce script
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )"
# Racine du projet (on remonte d'un cran car le script est dans /scripts)
PROJECT_ROOT="$SCRIPT_DIR/.." 

# Dossiers de sortie
BACKUP_DIR="$PROJECT_ROOT/backups"
OUTPUT_TXT_DIR="$SCRIPT_DIR/codePHP_SQL"

# Outil de conversion (doit être dans le dossier scripts/)
CONVERTER_SCRIPT="$SCRIPT_DIR/convert_dump.php"

# Nom des fichiers
DATE=$(date +"%Y-%m-%d_%H-%M-%S")
FILENAME="backup_$DATE.sql"

# ==============================================================================
# 1. PRÉPARATION
# ==============================================================================

mkdir -p "$BACKUP_DIR"
mkdir -p "$OUTPUT_TXT_DIR"

echo "📍 Script lancé depuis : $(pwd)"
echo "📂 Dossier des scripts : $SCRIPT_DIR"

# ==============================================================================
# 2. SAUVEGARDE SQL
# ==============================================================================

echo ""
echo "📦 [1/2] Sauvegarde de la base de données..."

podman exec $CONTAINER_DB mysqldump -u $DB_USER -p$DB_PASS --complete-insert --skip-comments $DB_NAME > "$BACKUP_DIR/$FILENAME"

if [ -s "$BACKUP_DIR/$FILENAME" ]; then
    echo "✅ Sauvegarde réussie : $BACKUP_DIR/$FILENAME"
else
    echo "❌ Erreur : Le fichier de backup est vide."
    exit 1
fi

# ==============================================================================
# 3. GÉNÉRATION DU CODE SEEDER (Optionnel)
# ==============================================================================

echo ""
read -p "⚡ [2/2] Voulez-vous générer le code PHP pour le Seeder ? (y/N) " response

if [[ "$response" =~ ^[yY]([eE][sS])?$ ]]; then
    
    if [ ! -f "$CONVERTER_SCRIPT" ]; then
        echo "❌ Erreur : Le fichier '$CONVERTER_SCRIPT' est introuvable."
        exit 1
    fi

    echo "🔄 Conversion en cours..."
    
    # A. On copie le SQL dans le dossier /tmp du conteneur (ZONE SÛRE)
    #    On utilise `cat` et `podman exec` pour écrire directement dans /tmp sans passer par un volume monté
    cat "$BACKUP_DIR/$FILENAME" | podman exec -i $CONTAINER_PHP sh -c 'cat > /tmp/temp_dump.sql'
    
    # B. On copie l'outil PHP dans /tmp du conteneur
    podman cp "$CONVERTER_SCRIPT" $CONTAINER_PHP:/tmp/convert_dump.php
    
    # C. Exécution du script PHP (depuis /tmp)
    #    On se déplace dans /tmp avant d'exécuter pour qu'il trouve le fichier sql
    podman exec $CONTAINER_PHP sh -c 'cd /tmp && php convert_dump.php' > "$OUTPUT_TXT_DIR/code_seeder_$DATE.txt"
    
    # D. Nettoyage sécurisé (uniquement dans /tmp)
    podman exec $CONTAINER_PHP rm /tmp/convert_dump.php /tmp/temp_dump.sql

    if [ -s "$OUTPUT_TXT_DIR/code_seeder_$DATE.txt" ]; then
        echo "✅ Code PHP généré avec succès !"
        echo "📄 Fichier : $OUTPUT_TXT_DIR/code_seeder_$DATE.txt"
    else
        echo "⚠️  Attention : Le fichier généré semble vide."
    fi
fi

echo ""
echo "👋 Terminé."