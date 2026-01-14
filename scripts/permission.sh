echo "ajout des permissions"
podman exec -it sae_php_app chmod -R 755 /var/www/html
podman exec -it sae_php_app chmod -R 777 /var/www/html/writable
podman exec -it sae_php_app chmod -R 777 /var/www/html/public/assets/