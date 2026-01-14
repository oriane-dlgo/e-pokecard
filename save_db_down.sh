#!/bin/bash

echo "📦 Sauvegarde de la base de données avant fermeture..."
podman exec -e MYSQL_PWD=root sae_mysql mysqldump -u root sae_db > ./app/Database/Seeds/database.sql
podman-compose down
