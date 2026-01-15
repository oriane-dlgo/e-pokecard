#!/bin/bash

# ==============================================================================
# CONFIGURATION
# ==============================================================================
CONTAINER_DB="sae_mysql"
CONTAINER_PHP="sae_php_app"
DB_USER="root"
DB_PASS="root"
DB_NAME="sae_db"

SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )"
PROJECT_ROOT="$SCRIPT_DIR/.." 

BACKUP_DIR="$PROJECT_ROOT/backups"
OUTPUT_TXT_DIR="$SCRIPT_DIR/codePHP_SQL"
CONVERTER_SCRIPT="$SCRIPT_DIR/convert_dump.php"

DATE=$(date +"%Y-%m-%d_%H-%M-%S")
FILENAME="backup_STOP_$DATE.sql"

echo " Arrêt des conteneurs demandé."

# ==============================================================================
# SAUVEGARDE & CONVERSION
# ==============================================================================

read -p " Voulez-vous générer un Seeder PHP (avec Backup SQL) avant de fermer ? (y/N) " response

if [[ "$response" =~ ^[yY]([eE][sS])?$ ]]; then
    
    if [ ! -f "$CONVERTER_SCRIPT" ]; then
        echo " Erreur : Le fichier '$CONVERTER_SCRIPT' est introuvable."
        exit 1
    fi
    
    mkdir -p "$BACKUP_DIR"
    mkdir -p "$OUTPUT_TXT_DIR"

    echo " [1/2] Sauvegarde SQL temporaire..."
    
    docker exec $CONTAINER_DB mysqldump -u $DB_USER -p$DB_PASS --complete-insert --skip-comments $DB_NAME > "$BACKUP_DIR/$FILENAME"
    
    if [ -s "$BACKUP_DIR/$FILENAME" ]; then
        echo " [2/2] Conversion en code PHP..."
        
        # A. Copie sécurisée vers /tmp
        cat "$BACKUP_DIR/$FILENAME" | docker exec -i $CONTAINER_PHP sh -c 'cat > /tmp/temp_dump.sql'
        
        # B. Copie de l'outil PHP
        docker cp "$CONVERTER_SCRIPT" $CONTAINER_PHP:/tmp/convert_dump.php
        
        # C. Exécution
        docker exec $CONTAINER_PHP sh -c 'cd /tmp && php convert_dump.php' > "$OUTPUT_TXT_DIR/code_seeder_$DATE.txt"
        
        # D. Nettoyage
        docker exec $CONTAINER_PHP rm /tmp/convert_dump.php /tmp/temp_dump.sql

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

# Détection de la commande compose
if docker compose version >/dev/null 2>&1; then
    COMPOSE_CMD="docker compose"
else
    COMPOSE_CMD="docker-compose"
fi

echo ""
echo " Arrêt des services..."
cd "$PROJECT_ROOT" && $COMPOSE_CMD down

echo " Terminé."