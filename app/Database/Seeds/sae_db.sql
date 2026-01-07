-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : mysql
-- Généré le : mer. 07 jan. 2026 à 16:55
-- Version du serveur : 8.0.44
-- Version de PHP : 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sae_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `id` int NOT NULL,
  `id_user` int NOT NULL,
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `statut` enum('panier','validee','expediee','terminee','annulee') DEFAULT 'panier',
  `total` decimal(10,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`id`, `id_user`, `date_creation`, `statut`, `total`) VALUES
(1, 1, '2026-01-07 14:28:41', 'validee', 55.00);

-- --------------------------------------------------------

--
-- Structure de la table `extensions`
--

CREATE TABLE `extensions` (
  `id` int NOT NULL,
  `nom` varchar(100) NOT NULL,
  `id_serie` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `extensions`
--

INSERT INTO `extensions` (`id`, `nom`, `id_serie`) VALUES
(1, 'Écarlate et Violet', 1),
(2, 'Écarlate et Violet – Evolutions à Paldea', 1),
(3, 'Écarlate et Violet – Flammes Obsidiennes', 1),
(4, 'Écarlate et Violet 151', 1),
(5, 'Écarlate et Violet – Faille Paradoxe', 1),
(6, 'Écarlate et Violet – Destinées de Paldea', 1),
(7, 'Écarlate et Violet – Forces Temporelles', 1),
(8, 'Écarlate et Violet – Mascarade Crépusculaire', 1),
(9, 'Écarlate et Violet – Fable Nébuleuse', 1),
(10, 'Écarlate et Violet – Couronne Stellaire', 1),
(11, 'Écarlate et Violet – Étincelles Déferlantes', 1),
(12, 'Écarlate et Violet – Evolutions Prismatiques', 1),
(13, 'Écarlate et Violet – Aventures Ensemble', 1),
(14, 'Écarlate et Violet – Rivalités Destinées', 1),
(15, 'Écarlate et Violet – Foudre Noire / Flamme Blanche', 1),
(16, 'Épée et Bouclier', 2),
(17, 'Clash des Rebelles', 2),
(18, 'Ténèbres Embrasées', 2),
(19, 'Voltage Éclatant', 2),
(20, 'Styles de Combat', 2),
(21, 'Règne de Glace', 2),
(22, 'Évolution Céleste', 2),
(23, 'Poing de Fusion', 2),
(24, 'Stars Étincelantes', 2),
(25, 'Astres Radieux', 2),
(26, 'Origine Perdue', 2),
(27, 'Tempête Argentée', 2),
(28, 'Zénith Suprême', 2),
(29, 'Set de Base', 3),
(30, 'Jungle', 3),
(31, 'Fossile', 3),
(32, 'Team Rocket', 3),
(33, 'Neo Genesis', 3),
(34, 'Neo Discovery', 3),
(35, 'Neo Revelation', 3),
(36, 'Neo Destiny', 3),
(37, 'Expedition', 3),
(38, 'Aquapolis', 3),
(39, 'Skyridge', 3),
(40, 'EX Rubis & Saphir', 4),
(41, 'EX Tempête de Sable', 4),
(42, 'EX Dragon', 4),
(43, 'EX Rouge Feu & Vert Feuille', 4),
(44, 'EX Team Magma VS Team Aqua', 4),
(45, 'EX Légendes Oubliées', 4),
(46, 'EX Forces Cachées', 4),
(47, 'EX Espèces Delta', 4),
(48, 'EX Créateurs de Légendes', 4),
(49, 'EX Fantômes Holon', 4),
(50, 'EX Gardiens de Cristal', 4),
(51, 'EX Île des Dragons', 4),
(52, 'EX Gardiens du Pouvoir', 4),
(53, 'Diamant & Perle', 5),
(54, 'Diamant & Perle – Trésors Mystérieux', 5),
(55, 'Diamant & Perle – Merveilles Secrètes', 5),
(56, 'Diamant & Perle – Duels au Sommet', 5),
(57, 'Diamant & Perle – Aube Majestueuse', 5),
(58, 'Diamant & Perle – Eveil des Légendes', 5),
(59, 'Diamant & Perle – Tempête', 5),
(60, 'Platine', 6),
(61, 'Platine – Rivaux Émergeants', 6),
(62, 'Platine – Vainqueurs Suprêmes', 6),
(63, 'Platine – Arceus', 6),
(64, 'HeartGold & SoulSilver', 7),
(65, 'HS Déchaînement', 7),
(66, 'HS Indomptable', 7),
(67, 'HS Triomphe', 7),
(68, 'L\Appel des Légendes', 7),
(69, 'Noir & Blanc', 8),
(70, 'Noir & Blanc – Pouvoirs Émergents', 8),
(71, 'Noir & Blanc – Nobles Victoires', 8),
(72, 'Noir & Blanc – Destinées Futures', 8),
(73, 'Noir & Blanc – Explorateurs Obscurs', 8),
(74, 'Noir & Blanc – Coffre des Dragons', 8),
(75, 'Noir & Blanc – Dragons Exaltés', 8),
(76, 'Noir & Blanc – Frontières Franchies', 8),
(77, 'Noir & Blanc – Tempête Plasma', 8),
(78, 'Noir & Blanc – Glaciation Plasma', 8),
(79, 'Noir & Blanc – Explosion Plasma', 8),
(80, 'XY – Bienvenue à Kalos', 9),
(81, 'XY', 9),
(82, 'XY – Étincelles', 9),
(83, 'XY – Générations', 9),
(84, 'XY – Offensive Vapeur', 9),
(85, 'XY – Rupture Turbo', 9),
(86, 'XY – Impulsion Turbo', 9),
(87, 'XY – Ciel Rugissant', 9),
(88, 'XY – Poings Furieux', 9),
(89, 'XY – Origines Antiques', 9),
(90, 'XY – Double Danger', 9),
(91, 'Soleil et Lune', 10),
(92, 'Soleil et Lune – Ultra Prisme', 10),
(93, 'Soleil et Lune – Tempête Céleste', 10),
(94, 'Soleil et Lune – Lumière Interdite', 10),
(95, 'Soleil et Lune – Harmonie des Esprits', 10),
(96, 'Soleil et Lune – Alliance Infaillible', 10),
(97, 'Soleil et Lune – Duo de Choc', 10),
(98, 'Soleil et Lune – Destinées Occultes', 10),
(99, 'Soleil et Lune – Eclipse Cosmique', 10),
(100, 'Méga-Évolution', 11),
(101, 'Méga-Évolution – Flammes Fantasmagoriques', 11),
(102, 'Méga-Évolution – Héros Transcendants', 11);

-- --------------------------------------------------------

--
-- Structure de la table `lignes_commande`
--

CREATE TABLE `lignes_commande` (
  `id` int NOT NULL,
  `commande_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantite` int NOT NULL,
  `prix_unitaire` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `lignes_commande`
--

INSERT INTO `lignes_commande` (`id`, `commande_id`, `product_id`, `quantite`, `prix_unitaire`) VALUES
(1, 1, 3, 1, 55.00);

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id` int NOT NULL,
  `type_produit` enum('carte','booster','coffret','accessoire') NOT NULL,
  `nom` varchar(200) NOT NULL,
  `description` text,
  `prix` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `stock` int DEFAULT '1',
  `rarete` enum('Commune','Peu Commune','Rare','EX','AR','FA','SAR','Gold') DEFAULT NULL,
  `numero_carte` varchar(20) DEFAULT NULL,
  `id_extension` int DEFAULT NULL,
  `id_promo` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `type_produit`, `nom`, `description`, `prix`, `image_url`, `stock`, `rarete`, `numero_carte`, `id_extension`, `id_promo`) VALUES
(1, 'carte', 'Dracaufeu EX', 'Une carte ultra puissante version Full Art', 150.00, 'dracaufeu.png', 1, 'FA', NULL, 2, NULL),
(2, 'booster', 'Booster 151', 'Paquet de 10 cartes de la série 151', 5.99, 'booster151.png', 1, NULL, NULL, 1, 1),
(3, 'coffret', 'Coffret Dresseur d\'Elite', 'Contient 9 boosters et des dés', 55.00, 'etb151.png', 0, NULL, NULL, 1, NULL),
(5, 'coffret', 'Coffret Dresseur d\'Élite EV08 Étincelles Déferlantes : Pikachu ex ', 'Contenu :\r\n\r\n    9 boosters de 10 cartes d\'Écarlate et Violet - Étincelles Déferlantes du JCC Pokémon\r\n    1 carte promo brillante entièrement illustrée de Magnéton\r\n    65 protèges-cartes\r\n    45 cartes Énergie du JCC Pokémon\r\n    1 guide de jeu de l\'extension Écarlate et Violet - Étincelles Déferlantes\r\n    6 dés marqueurs de dégâts\r\n    1 dé lancer de pièce autorisé en compétition\r\n    2 marqueurs d\'États Spéciaux en plastique\r\n    1 coffret de collection avec 4 séparateurs\r\n    1 carte à code pour le Jeu de Cartes à Collectionner Pokémon Live\r\n\r\nSoit 91 cartes au total dans ce Coffret Dresseur d\'Élite !', 200.00, '1767798673_e81998d4426cfddba18c.png', 15, 'Peu Commune', NULL, 11, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `promotions`
--

CREATE TABLE `promotions` (
  `idPromo` int NOT NULL,
  `tauxPromo` decimal(5,2) NOT NULL,
  `dateDebut` datetime NOT NULL,
  `dateFin` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `promotions`
--

INSERT INTO `promotions` (`idPromo`, `tauxPromo`, `dateDebut`, `dateFin`) VALUES
(1, 0.50, '2026-01-07 16:11:13', '2026-01-14 16:11:13'),
(2, 0.20, '2026-01-07 16:11:13', '2026-01-14 16:11:13');

-- --------------------------------------------------------

--
-- Structure de la table `series`
--

CREATE TABLE `series` (
  `id` int NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `series`
--

INSERT INTO `series` (`id`, `nom`) VALUES
(1, 'Écarlate et Violet'),
(2, 'Épée et Bouclier'),
(3, 'Wizards'),
(4, 'EX'),
(5, 'Diamant & Perle'),
(6, 'Platine'),
(7, 'HeartGold & SoulSilver'),
(8, 'Noir & Blanc'),
(9, 'XY'),
(10, 'Soleil et Lune'),
(11, 'Méga-Évolution');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('client','admin') DEFAULT 'client',
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `adresse` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `role`, `nom`, `prenom`, `email`, `adresse`) VALUES
(1, 'admin', 'admin', 'admin', 'Administrateur', NULL, NULL, NULL),
(2, 'sacha', 'pikachu', 'client', 'Ketchum', NULL, NULL, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Index pour la table `extensions`
--
ALTER TABLE `extensions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_serie` (`id_serie`);

--
-- Index pour la table `lignes_commande`
--
ALTER TABLE `lignes_commande`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commande_id` (`commande_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_extension` (`id_extension`),
  ADD KEY `fk_promo` (`id_promo`);

--
-- Index pour la table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`idPromo`);

--
-- Index pour la table `series`
--
ALTER TABLE `series`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `extensions`
--
ALTER TABLE `extensions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT pour la table `lignes_commande`
--
ALTER TABLE `lignes_commande`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `idPromo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `series`
--
ALTER TABLE `series`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `extensions`
--
ALTER TABLE `extensions`
  ADD CONSTRAINT `extensions_ibfk_1` FOREIGN KEY (`id_serie`) REFERENCES `series` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `lignes_commande`
--
ALTER TABLE `lignes_commande`
  ADD CONSTRAINT `lignes_commande_ibfk_1` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lignes_commande_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `produits` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `produits`
--
ALTER TABLE `produits`
  ADD CONSTRAINT `fk_promo` FOREIGN KEY (`id_promo`) REFERENCES `promotions` (`idPromo`) ON DELETE SET NULL,
  ADD CONSTRAINT `produits_ibfk_1` FOREIGN KEY (`id_extension`) REFERENCES `extensions` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
