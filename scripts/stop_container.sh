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
FILENAME="backup_STOP_$DATE.sql"

echo " Arrêt des conteneurs demandé."

# ==============================================================================
# SAUVEGARDE & CONVERSION
# ==============================================================================

read -p " Voulez-vous générer un Seeder PHP (avec Backup SQL) avant de fermer ? (y/N) " response

if [[ "$response" =~ ^[yY]([eE][sS])?$ ]]; then
    
    # 1. Vérifications
    if [ ! -f "$CONVERTER_SCRIPT" ]; then
        echo " Erreur : Le fichier '$CONVERTER_SCRIPT' est introuvable."
        exit 1
    fi
    
    mkdir -p "$BACKUP_DIR"
    mkdir -p "$OUTPUT_TXT_DIR"

    echo " [1/2] Sauvegarde SQL temporaire..."
    
    # 2. Dump SQL vers le dossier backups
    podman exec $CONTAINER_DB mysqldump -u $DB_USER -p$DB_PASS --complete-insert --skip-comments $DB_NAME > "$BACKUP_DIR/$FILENAME"
    
    if [ -s "$BACKUP_DIR/$FILENAME" ]; then
        echo " [2/2] Conversion en code PHP..."
        
        # A. On envoie le SQL dans le dossier /tmp du conteneur (ZONE SÛRE)
        cat "$BACKUP_DIR/$FILENAME" | podman exec -i $CONTAINER_PHP sh -c 'cat > /tmp/temp_dump.sql'
        
        # B. On copie l'outil PHP dans /tmp du conteneur
        podman cp "$CONVERTER_SCRIPT" $CONTAINER_PHP:/tmp/convert_dump.php
        
        # C. Exécution du script PHP (depuis /tmp)
        podman exec $CONTAINER_PHP sh -c 'cd /tmp && php convert_dump.php' > "$OUTPUT_TXT_DIR/code_seeder_$DATE.txt"
        
        # D. Nettoyage sécurisé (uniquement dans /tmp)
        podman exec $CONTAINER_PHP rm /tmp/convert_dump.php /tmp/temp_dump.sql

        if [ -s "$OUTPUT_TXT_DIR/code_seeder_$DATE.txt" ]; then
            echo " Code Seeder généré : $OUTPUT_TXT_DIR/code_seeder_$DATE.txt"
        else
            echo "  Le fichier généré est vide."
        fi
    else
        echo " Erreur : Le dump SQL a échoué."
    fi
else
    echo " Sauvegarde ignorée."
fi

# ==============================================================================
# ARRÊT DES SERVICES
# ==============================================================================

echo ""
echo " Arrêt des services..."
# On se place à la racine pour être sûr que podman-compose trouve le fichier yml
cd "$PROJECT_ROOT" && podman-compose down

echo " Terminé."