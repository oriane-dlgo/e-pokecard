#!/bin/bash

echo " Démarrage du projet SAE..."
echo " Build des container"
podman-compose up -d --build
echo "Installation des dependance pour CI4"
podman exec -it sae_php_app composer install
echo "ajout des permissions"
podman exec -it sae_php_app chmod -R 755 /var/www/html
podman exec -it sae_php_app chmod -R 777 /var/www/html/writable
podman exec -it sae_php_app chmod -R 777 /var/www/html/public/assets/
