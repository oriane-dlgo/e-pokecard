-- Désactiver les vérifications de clés étrangères temporairement
SET FOREIGN_KEY_CHECKS = 0;

-- 1. Nettoyage (On repart à zéro)
DROP TABLE IF EXISTS ligne_commandes;
DROP TABLE IF EXISTS commandes;
DROP TABLE IF EXISTS produits;
DROP TABLE IF EXISTS extensions;
DROP TABLE IF EXISTS series;
DROP TABLE IF EXISTS users;

-- 2. Création des tables
CREATE TABLE series (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE extensions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    id_serie INT,
    FOREIGN KEY (id_serie) REFERENCES series(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('client', 'admin') DEFAULT 'client',
    nom VARCHAR(100),
    prenom VARCHAR(100),
    email VARCHAR(150),
    adresse TEXT
) ENGINE=InnoDB;

CREATE TABLE produits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type_produit ENUM('carte', 'booster', 'coffret', 'accessoire') NOT NULL,
    nom VARCHAR(200) NOT NULL,
    description TEXT,
    prix DECIMAL(10, 2) NOT NULL,
    image_url VARCHAR(255),
    stock INT DEFAULT 0,
    rarete VARCHAR(50),
    numero_carte VARCHAR(20),
    id_extension INT,
    FOREIGN KEY (id_extension) REFERENCES extensions(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE commandes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    statut ENUM('panier', 'validee', 'payee', 'expediee') DEFAULT 'panier',
    total DECIMAL(10, 2) DEFAULT 0,
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE ligne_commandes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_commande INT NOT NULL,
    id_produit INT NOT NULL,
    quantite INT NOT NULL,
    prix_unitaire DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (id_commande) REFERENCES commandes(id) ON DELETE CASCADE,
    FOREIGN KEY (id_produit) REFERENCES produits(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 3. Insertion des données de test
INSERT INTO series (nom) VALUES ('Écarlate et Violet'), ('Épée et Bouclier');

INSERT INTO extensions (nom, id_serie) VALUES 
('151', 1), 
('Flammes Obsidiennes', 1),
('Zénith Suprême', 2);

INSERT INTO produits (type_produit, nom, description, prix, rarete, id_extension, image_url) VALUES 
('carte', 'Dracaufeu EX', 'Une carte ultra puissante version Full Art', 150.00, 'Ultra Rare', 2, 'dracaufeu.png'),
('booster', 'Booster 151', 'Paquet de 10 cartes de la série 151', 5.99, NULL, 1, 'booster151.png'),
('coffret', 'Coffret Dresseur d\'Elite', 'Contient 9 boosters et des dés', 55.00, NULL, 1, 'etb151.png');

INSERT INTO users (login, password, role, nom) VALUES 
('admin', 'admin', 'admin', 'Administrateur'),
('sacha', 'pikachu', 'client', 'Ketchum');

-- Réactiver les clés étrangères
SET FOREIGN_KEY_CHECKS = 1;