# 🛒 Projet SAE 3.01 - Boutique Pokémon

Ce projet est une application e-commerce développée avec CodeIgniter 4 et Docker.

## 🚀 Guide d'installation rapide


### 1. Cloner le dépot 
Tout d'abord, lancer la commande suivante via un terminal dans un dossier vide : 

```bash
git clone https://gitlab.univ-nantes.fr/pub/but/but2/sae/groupe4/eq_4_04_delgado-oriane_guillard-nhael_renard-clara_semaoune-ryan.git
```

### 2. Lancer l'environnement (Docker/Podman)
Le projet est conteneurisé. Lancez la commande suivante à la racine :

```bash
# Si vous êtes sur une machine personnelle
docker-compose up -d --build
# Si vous êtes sur les machines de l'IUT (Podman)
podman-compose up -d --build
```
> **Note** : 
Si on vous demande de choisir une image.
> - A l'IUT : sélectionnez l'option 1 (miroir local de l'université) pour plus de rapidité. 
> - Hors de l'IUT : sélectionnez docker.io

### 3. Installation des dépendances & Configuration

Une fois le conteneur lancé, il faut initialiser le framework. Exécutez ces commandes (depuis votre terminal hôte) :

```Bash
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
```


### 4. Base de Données
L'application nécessite une base de données MySQL initialisée.

- Accédez à phpMyAdmin : http://localhost:8081
    - Serveur : *mysql (ou sae_mysql)*
    - User : *root*
    - Password : *root*

- Sélectionnez la base de données *sae_db*.

-  Allez dans l'onglet *Importer*.

-   Chargez le fichier *database.sql* situé à la racine du projet.

### 5. Accès au site

L'application est accessible ici : 👉 http://localhost:8080  
La base de donnée est accessible ici (*sae_db*): 👉 http://localhost:8081 

## 📦 Gestion du Git (Workflow quotidien)

Pour éviter les conflits et ne pas perdre de travail, voici la procédure à suivre à chaque séance.
### 1. Avant de commencer à coder (Le matin)
Toujours récupérer le travail des autres pour être à jour.
```bash
git pull origin dev
```
>(Si un conflit apparaît, VSCode vous proposera de choisir entre "Current Change" et "Incoming Change").

### 2. Sauvegarder son travail (Le Commit)
Ceci enregistre vos modifications sur votre ordinateur uniquement.

```Bash
# 1. Ajouter les fichiers modifiés (Mise en carton)
git add .
# 2. Valider la version (Fermer le carton)
git commit -m "Description claire de ce que j'ai fait (ex: Ajout page Panier)"
```
### 3. Envoyer le travail au groupe (Le Push)
C'est l'étape obligatoire pour que les autres voient votre travail et pour le sauvegarder sur le serveur.
```Bash
# Envoyer le carton au serveur
git push origin dev
```
> Note : Si VSCode indique "Outgoing Changes" ou "Modifications sortantes", c'est que vous avez oublié cette étape !

## 🛑 Arrêter le projet proprement

Lorsque vous avez fini de travailler, n'éteignez pas brutalement le terminal ou VSCode. Arrêtez les conteneurs pour libérer les ressources.
```Bash
# Arrête et supprime les conteneurs (Vos données BDD sont conservées)
podman-compose down
```
(Ou docker-compose down sur machine perso).