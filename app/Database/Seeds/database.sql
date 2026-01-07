-- Désactiver les vérifications de clés étrangères temporairement
SET FOREIGN_KEY_CHECKS = 0;

-- 1. Nettoyage (On repart à zéro)
DROP TABLE IF EXISTS ligne_commande;
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
    stock INT DEFAULT 1,
    rarete ENUM('Commune','Peu Commune','Rare','EX','AR','FA','SAR','Gold'),
    numero_carte VARCHAR(20),
    id_extension INT,
    promotion DECIMAL(2,2),
    FOREIGN KEY (id_extension) REFERENCES extensions(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE commandes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    statut ENUM('panier', 'validee', 'payee') DEFAULT 'panier',
    total DECIMAL(10, 2) DEFAULT 0,
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE lignes_commande (
    id INT AUTO_INCREMENT PRIMARY KEY,
    commande_id INT NOT NULL,
    product_id INT NOT NULL,
    quantite INT NOT NULL,
    prix_unitaire DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (commande_id) REFERENCES commandes(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES produits(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 3. Insertion des données de test
INSERT INTO series (nom) VALUES 
('Écarlate et Violet'),('Épée et Bouclier'),('Wizards'),('EX'),('Diamant & Perle'),
('Platine'),('HeartGold & SoulSilver'),('Noir & Blanc'),('XY'),('Soleil et Lune'),('Méga-Évolution');

INSERT INTO extensions (nom, id_serie) VALUES 
-- Séries Écarlate et Violet (id_serie = 1)
('Écarlate et Violet', 1),
('Écarlate et Violet – Evolutions à Paldea', 1),
('Écarlate et Violet – Flammes Obsidiennes', 1),
('Écarlate et Violet 151', 1),
('Écarlate et Violet – Faille Paradoxe', 1),
('Écarlate et Violet – Destinées de Paldea', 1),
('Écarlate et Violet – Forces Temporelles', 1),
('Écarlate et Violet – Mascarade Crépusculaire', 1),
('Écarlate et Violet – Fable Nébuleuse', 1),
('Écarlate et Violet – Couronne Stellaire', 1),
('Écarlate et Violet – Étincelles Déferlantes', 1),
('Écarlate et Violet – Evolutions Prismatiques', 1),
('Écarlate et Violet – Aventures Ensemble', 1),
('Écarlate et Violet – Rivalités Destinées', 1),
('Écarlate et Violet – Foudre Noire / Flamme Blanche', 1),

-- Séries Épée et Bouclier (id_serie = 2)
('Épée et Bouclier', 2),
('Clash des Rebelles', 2),
('Ténèbres Embrasées', 2),
('Voltage Éclatant', 2),
('Styles de Combat', 2),
('Règne de Glace', 2),
('Évolution Céleste', 2),
('Poing de Fusion', 2),
('Stars Étincelantes', 2),
('Astres Radieux', 2),
('Origine Perdue', 2),
('Tempête Argentée', 2),
('Zénith Suprême', 2),

-- Séries Wizards (id_serie = 3)
('Set de Base', 3),
('Jungle', 3),
('Fossile', 3),
('Team Rocket', 3),
('Neo Genesis', 3),
('Neo Discovery', 3),
('Neo Revelation', 3),
('Neo Destiny', 3),
('Expedition', 3),
('Aquapolis', 3),
('Skyridge', 3),

-- Séries EX (id_serie = 4)
('EX Rubis & Saphir', 4),
('EX Tempête de Sable', 4),
('EX Dragon', 4),
('EX Rouge Feu & Vert Feuille', 4),
('EX Team Magma VS Team Aqua', 4),
('EX Légendes Oubliées', 4),
('EX Forces Cachées', 4),
('EX Espèces Delta', 4),
('EX Créateurs de Légendes', 4),
('EX Fantômes Holon', 4),
('EX Gardiens de Cristal', 4),
('EX Île des Dragons', 4),
('EX Gardiens du Pouvoir', 4),

-- Séries Diamant & Perle (id_serie = 5)
('Diamant & Perle', 5),
('Diamant & Perle – Trésors Mystérieux', 5),
('Diamant & Perle – Merveilles Secrètes', 5),
('Diamant & Perle – Duels au Sommet', 5),
('Diamant & Perle – Aube Majestueuse', 5),
('Diamant & Perle – Eveil des Légendes', 5),
('Diamant & Perle – Tempête', 5),

-- Séries Platine (id_serie = 6)
('Platine', 6),
('Platine – Rivaux Émergeants', 6),
('Platine – Vainqueurs Suprêmes', 6),
('Platine – Arceus', 6),

-- Séries HeartGold & SoulSilver (id_serie = 7)
('HeartGold & SoulSilver', 7),
('HS Déchaînement', 7),
('HS Indomptable', 7),
('HS Triomphe', 7),
('L''Appel des Légendes', 7),

-- Séries Noir & Blanc (id_serie = 8)
('Noir & Blanc', 8),
('Noir & Blanc – Pouvoirs Émergents', 8),
('Noir & Blanc – Nobles Victoires', 8),
('Noir & Blanc – Destinées Futures', 8),
('Noir & Blanc – Explorateurs Obscurs', 8),
('Noir & Blanc – Coffre des Dragons', 8),
('Noir & Blanc – Dragons Exaltés', 8),
('Noir & Blanc – Frontières Franchies', 8),
('Noir & Blanc – Tempête Plasma', 8),
('Noir & Blanc – Glaciation Plasma', 8),
('Noir & Blanc – Explosion Plasma', 8),

-- Séries XY (id_serie = 9)
('XY – Bienvenue à Kalos', 9),
('XY', 9),
('XY – Étincelles', 9),
('XY – Générations', 9),
('XY – Offensive Vapeur', 9),
('XY – Rupture Turbo', 9),
('XY – Impulsion Turbo', 9),
('XY – Ciel Rugissant', 9),
('XY – Poings Furieux', 9),
('XY – Origines Antiques', 9),
('XY – Double Danger', 9),

-- Séries Soleil et Lune (id_serie = 10)
('Soleil et Lune', 10),
('Soleil et Lune – Ultra Prisme', 10),
('Soleil et Lune – Tempête Céleste', 10),
('Soleil et Lune – Lumière Interdite', 10),
('Soleil et Lune – Harmonie des Esprits', 10),
('Soleil et Lune – Alliance Infaillible', 10),
('Soleil et Lune – Duo de Choc', 10),
('Soleil et Lune – Destinées Occultes', 10),
('Soleil et Lune – Eclipse Cosmique', 10),

-- Séries Méga-Évolution (id_serie = 11)
('Méga-Évolution', 11),
('Méga-Évolution – Flammes Fantasmagoriques', 11),
('Méga-Évolution – Héros Transcendants', 11);


INSERT INTO produits (type_produit, nom, description, prix, rarete, id_extension, image_url) VALUES 
('carte', 'Dracaufeu EX', 'Une carte ultra puissante version Full Art', 150.00, 'FA', 2, 'dracaufeu.png'),
('booster', 'Booster 151', 'Paquet de 10 cartes de la série 151', 5.99, NULL, 1, 'booster151.png'),
('coffret', 'Coffret Dresseur d''Elite', 'Contient 9 boosters et des dés', 55.00, NULL, 1, 'etb151.png');

INSERT INTO users (login, password, role, nom) VALUES 
('admin', 'admin', 'admin', 'Administrateur'),
('sacha', 'pikachu', 'client', 'Ketchum');

-- Réactiver les clés étrangères
SET FOREIGN_KEY_CHECKS = 1;
