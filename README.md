

# --- Projet SAE 3.01 - Boutique Pokémon (E-POKECARD)

Bienvenue sur le dépôt de notre application E-Commerce développée avec **CodeIgniter 4** et **Docker/Podman**.

###  Auteurs (Équipe 4)

* Oriane DELGADO
* Nhael GUILLARD
* Clara RENARD
* Ryan SEMAOUNE

---

## --- Guide de Lancement Rapide (IUT & Personnel)

Nous avons automatisé l'installation via des scripts shell pour simplifier le déploiement, que vous soyez sur les machines de l'IUT (Linux/Podman) ou sur une machine personnelle (Windows/Docker).

### 1. Récupération du projet

Ouvrez un terminal et lancez les commandes suivantes :

```bash
# 1. Cloner le dépôt
git clone https://gitlab.univ-nantes.fr/pub/but/but2/sae/groupe4/eq_4_04_delgado-oriane_guillard-nhael_renard-clara_semaoune-ryan.git

# 2. Entrer dans le dossier
cd eq_4_04_delgado-oriane_guillard-nhael_renard-clara_semaoune-ryan

# 3. Se placer sur la branche de développement (Code stable)
git checkout dev

```

### 2. Démarrage Automatisé

Choisissez la méthode correspondant à votre environnement.

#### Option A : Sur les machines de l'IUT (Linux / Podman)

Nous avons préparé un script qui gère : le lancement des conteneurs, l'installation des dépendances (Composer), la configuration du `.env`, les permissions et l'initialisation de la Base de Données.

```bash
# 1. Donner les droits d'exécution au script
chmod +x scripts/run_container.sh

# 2. Lancer l'installation complète
./scripts/run_container.sh

```

> **Note :** Le script vous demandera peut-être de confirmer l'utilisation de l'image `docker.io` ou du miroir local. À l'IUT, choisissez le miroir local si proposé, sinon `docker.io`.

#### Option B : Sur Windows (Docker Desktop)

Utilisez PowerShell pour lancer le script équivalent :

```powershell
# Exécuter le script d'installation Windows
.\scripts\Windows\run_container.sh

```

---

## --- Accès à l'application

Une fois le script terminé (message "--- Installation terminée !"), accédez aux services :

* **Boutique (Site Web) :** [http://localhost:8080](https://www.google.com/search?q=http://localhost:8080)
* **Base de Données (PhpMyAdmin) :** [http://localhost:8081](https://www.google.com/search?q=http://localhost:8081)
