-- 1. On désactive la vérification des clés étrangères (Le mode Bulldozer)
SET FOREIGN_KEY_CHECKS = 0;

-- 2. On supprime toutes les tables (dans n'importe quel ordre, grâce à la ligne du dessus)
DROP TABLE IF EXISTS lignes_commande;   -- Ta version PHP
DROP TABLE IF EXISTS ligne_commandes;   -- Ta version SQL précédente (au cas où)
DROP TABLE IF EXISTS commandes;
DROP TABLE IF EXISTS produits;
DROP TABLE IF EXISTS extensions;
DROP TABLE IF EXISTS series;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS promotions;
DROP TABLE IF EXISTS ci_sessions;       -- Si tu utilises la session en BDD

-- 3. On réactive la sécurité
SET FOREIGN_KEY_CHECKS = 1;

-- 4. Petit message pour dire que c'est fini (Optionnel)
SELECT "Base de données entièrement vidée avec succès !" AS Message;
