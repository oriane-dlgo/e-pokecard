# Cahier de Recette - Site de Vente Pokémon

## 1. Informations Générales

* **Projet :** Site de vente en ligne de produit pokemon (Cartes, Boosters, Displays, Accessoires)
* **Réalisé par :** Delgado Oriane, Guillard Nhaël, Renard Clara, Semaoune Ryan
* **Framework :** CodeIgniter 4
* **SGBD :** MySQL
* **Environnement de test :** Local
* **Navigateur de test :** Firefox
* **Version PHP :** 8.4.12

---

## 2. Procédure de Lancement (Déploiement)

Pour lancer le site web on utilse un container podman.

1. **Attribution des droits :** Si le script n'est pas exécutable, lancer :
   `chmod +x ./scripts/run_container.sh`
2. **Démarrage :** Exécuter le script de lancement :
   `./scripts/run_container.sh`
   *Ce script gère automatiquement la création des conteneurs, les permissions des dossiers `writable` de CodeIgniter 4 et l'initialisation de la base de données.*

---

## 3. Validation des Fonctionnalités

### 3.1. Partie Client :

| ID | Fonctionnalité | Action de test | Résultat attendu | Statut |
| --- | --- | --- | --- | --- |
| **C_01** | **Authentification** | Inscription puis Connexion. | Création de la session, accès au profil et redirection dynamique. | **OK** |
| **C_02** | **Recherche & Filtres** | Filtrer par type, rareté ou promotion. | Requête SQL optimisée avec clauses `WHERE`. Affichage précis. | **OK** |
| **C_03** | **Détail Produit** | Cliquer sur une carte ou un booster. | Affichage complet des informations et de l'image correspondante. | **OK** |
| **C_04** | **Gestion Panier** | Ajouter, modifier quantité ou vider. | Calcul dynamique en session. Persistance des données. | **OK** |
| **C_05** | **Tunnel d'achat** | Choisir le paiement et valider. | Décrémentation des stocks et création des entrées `commande`. | **OK** |

### 3.2. Partie Administrateur :

| ID | Fonctionnalité | Action de test | Résultat attendu | Statut |
| --- | --- | --- | --- | --- |
| **A_01** | **Gestion Catalogue** | Ajouter, Modifier ou Supprimer un produit. | Mise à jour instantanée de la table `produits` en base de données. | **OK** |
| **A_02** | **Gestion des Promos** | Créer/Appliquer une promotion. | Le prix calculé via le **Pattern Decorator** se met à jour sur le Front. | **OK** |
| **A_03** | **Suivi Commandes** | Modifier l'état (Préparation, Expédié). | Changement de statut répercuté dans l'historique client. | **OK** |
| **A_04** | **Modération User** | Modifier un rôle ou supprimer un compte. | Mise à jour des droits d'accès immédiate (via CI4 Filters). | **OK** |

