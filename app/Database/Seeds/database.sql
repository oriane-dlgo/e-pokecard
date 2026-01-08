-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : mysql
-- Généré le : jeu. 08 jan. 2026 à 02:58
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
                             `total` decimal(10,2) DEFAULT '0.00',
                             `type_paiement` enum('Paypal','Credit Card')
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`id`, `id_user`, `date_creation`, `statut`, `total`,`type_paiement`) VALUES
                                                                                                  (1, 2, '2025-12-08 00:07:27', 'terminee', 240.00,'Credit Card'),
                                                                                                  (2, 2, '2026-01-06 00:07:27', 'validee', 59.90,'Paypal'),
                                                                                                  (3, 1, '2026-01-07 00:07:27', 'expediee', 45.00,'Paypal'),
                                                                                                  (4, 2, '2026-01-08 00:07:27', 'panier', 85.00,'Credit Card'),
                                                                                                  (5, 2, '2025-11-09 00:12:17', 'terminee', 240.00,'Paypal'),
                                                                                                  (6, 1, '2025-12-18 00:12:17', 'terminee', 90.00,'Credit Card'),
                                                                                                  (7, 2, '2026-01-04 00:12:17', 'expediee', 29.95,'Credit Card'),
                                                                                                  (8, 1, '2026-01-07 00:12:17', 'validee', 114.95,'Paypal'),
                                                                                                  (9, 2, '2026-01-08 00:12:17', 'validee', 90.00,'Credit Card'),
                                                                                                  (10, 2, '2026-01-08 00:12:17', 'panier', 140.00,NULl);

-- --------------------------------------------------------

--
-- Structure de la table `extensions`
--

CREATE TABLE `extensions` (
                              `id` int NOT NULL,
                              `nom` varchar(100) NOT NULL,
                              `code` varchar(10) DEFAULT NULL,
                              `id_serie` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `extensions`
--

INSERT INTO `extensions` (`id`, `nom`, `code`, `id_serie`) VALUES
                                                               (1, 'Écarlate et Violet', 'SVI', 1),
                                                               (2, 'Évolutions à Paldea', 'PAL', 1),
                                                               (3, 'Flammes Obsidiennes', 'OBF', 1),
                                                               (4, '151', 'MEW', 1),
                                                               (5, 'Faille Paradoxe', 'PAR', 1),
                                                               (6, 'Destinées de Paldea', 'PAF', 1),
                                                               (7, 'Forces Temporelles', 'TEF', 1),
                                                               (8, 'Mascarade Crépusculaire', 'TWM', 1),
                                                               (9, 'Fable Nébuleuse', 'SFA', 1),
                                                               (10, 'Couronne Stellaire', 'SCR', 1),
                                                               (11, 'Étincelles Déferlantes', 'SSP', 1),
                                                               (12, 'Évolutions Prismatiques', 'PRE', 1),
                                                               (13, 'Aventures Ensemble', 'JTG', 1),
                                                               (14, 'Foudre Noire', 'BLK', 1),
                                                               (15, 'Flamme Blanche', 'WHT', 1),
                                                               (16, 'Méga-Évolution', 'MEG', 2),
                                                               (17, 'Flammes Fantasmagoriques', 'PFL', 2);

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
                                                                                                   (1, 1, 2, 2, 120.00),
                                                                                                   (2, 2, 3, 10, 5.99),
                                                                                                   (3, 3, 5, 1, 45.00),
                                                                                                   (4, 4, 1, 1, 85.00),
                                                                                                   (5, 5, 2, 2, 120.00),
                                                                                                   (6, 6, 16, 1, 90.00),
                                                                                                   (7, 7, 9, 5, 5.99),
                                                                                                   (8, 8, 1, 1, 85.00),
                                                                                                   (9, 8, 9, 5, 5.99),
                                                                                                   (10, 9, 16, 1, 90.00),
                                                                                                   (11, 10, 14, 1, 140.00);

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
                            `id` int NOT NULL,
                            `type_produit` enum('carte','booster','coffret','display','ETB','accessoire') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
                            `nom` varchar(200) NOT NULL,
                            `description` text,
                            `prix` decimal(10,2) NOT NULL,
                            `image_url` varchar(255) DEFAULT NULL,
                            `stock` int DEFAULT '1',
                            `rarete` enum('Commune','Unco','Holo','Double Rare','Illu. Rare','Ultra Rare','Alternative','Gold') DEFAULT NULL,
                            `numero_carte` varchar(20) DEFAULT NULL,
                            `id_extension` int DEFAULT NULL,
                            `id_promo` int DEFAULT NULL,
                            `nb_ventes` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `type_produit`, `nom`, `description`, `prix`, `image_url`, `stock`, `rarete`, `numero_carte`, `id_extension`, `id_promo`, `nb_ventes`) VALUES
                                                                                                                                                                         (1, 'carte', 'U.R Pikachu EX', '', 85.00, '1767838626_b07943e156f2381dd456.webp', 10, 'Ultra Rare', NULL, 11, NULL, 2),
                                                                                                                                                                         (2, 'display', 'Display - SCR', '', 120.00, '1767839880_6f5e5eba142eaeac35dc.webp', 5, '', NULL, 10, 2, 4),
                                                                                                                                                                         (3, 'booster', 'Booster - MEW', '', 5.99, '1767838434_43bfaac1b0d6497f80b5.png', 100, '', NULL, 4, 1, 10),
                                                                                                                                                                         (4, 'ETB', 'ETB Ronflex - MEW', '', 55.00, '1767838356_d0f6391031d5eaba9296.png', 20, '', NULL, 4, 3, 0),
                                                                                                                                                                         (5, 'carte', 'Mygavolt EX - SCR', '', 45.00, '1767839602_759efec1779ba55a341e.webp', 15, 'Alternative', NULL, 10, NULL, 1),
                                                                                                                                                                         (6, 'accessoire', 'Classeur Malvalame - PAF', '', 35.00, '1767839498_af2ee85929c67796f529.png', 8, '', NULL, 6, NULL, 0),
                                                                                                                                                                         (7, 'carte', 'AR Kecleon - SSP', '', 2.00, '1767839389_c4d9f9b5e5fc35079a09.webp', 50, 'Illu. Rare', NULL, 11, NULL, 0),
                                                                                                                                                                         (8, 'carte', 'Latias EX - SSP', 'Rien', 8.00, '1767839274_10b9fe2ef7a401766209.webp', 40, 'Double Rare', NULL, 11, NULL, 0),
                                                                                                                                                                         (9, 'booster', 'Booster - SSP', '', 5.99, '1767838189_90a71ddb3a6e5e14c829.png', 150, '', NULL, 11, NULL, 10),
                                                                                                                                                                         (10, 'carte', 'Gold Reshiram EX - WHT', 'Rien', 15.00, '1767838104_219af4cfaca36f662757.webp', 12, 'Gold', NULL, 15, NULL, 0),
                                                                                                                                                                         (11, 'carte', 'Alt Trioxhydre', 'Rien', 25.00, '1767838048_5a61b2a2c21bacc330a4.webp', 5, 'Alternative', NULL, 15, NULL, 0),
                                                                                                                                                                         (12, 'carte', 'Alt Reshiram EX - WHT', 'Rien', 0.50, '1767837957_d6db006764d6698295c2.webp', 200, 'Commune', NULL, 15, NULL, 0),
                                                                                                                                                                         (13, 'carte', 'Alt Dracaufeu EX - OBF', 'Rien', 1.00, '1767837851_da801f645c68f05d8949.webp', 100, 'Alternative', NULL, 3, NULL, 0),
                                                                                                                                                                         (14, 'display', 'Display Flammes Obsidiennes', 'Rien', 140.00, '1767837614_f865395a9478f9611818.jpg', 4, '', NULL, 3, 4, 1),
                                                                                                                                                                         (15, 'carte', 'Phyllali EX - PRE', 'Rien', 60.00, '1767837711_5f499ec12d05c6492032.webp', 24, 'Alternative', NULL, 12, NULL, 0),
                                                                                                                                                                         (16, 'coffret', 'ETB Suicune - TEF', 'Rien', 90.00, '1767839209_1b00fa8de082038d4a1b.png', 2, '', NULL, 7, 2, 2),
                                                                                                                                                                         (17, 'ETB', 'ETB PRE', 'Série rétro Méga', 12.00, '1767837461_6b7d5530f6e79814c209.jpg', 30, '', NULL, 12, NULL, 0),
                                                                                                                                                                         (18, 'carte', 'Rugit-Lune EX - PRE', 'Rien', 0.00, '1767836982_22470c489ca7403584b5.webp', 10, 'Alternative', NULL, 12, NULL, 0),
                                                                                                                                                                         (19, 'carte', 'Voltli EX - PRE', 'Rien', 0.00, '1767836898_f3205d0f35cced1cf64e.webp', 15, 'Alternative', NULL, 12, NULL, 0),
                                                                                                                                                                         (20, 'carte', 'Noctali Ex - PRE', 'Rien', 499.99, '1767836503_24f36d896f89baf1976e.webp', 14, 'Alternative', NULL, 12, NULL, 0);

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
                                                                              (1, 0.50, '2026-01-08 00:07:27', '2026-01-15 00:07:27'),
                                                                              (2, 0.20, '2026-01-08 00:10:37', '2026-01-15 00:10:37'),
                                                                              (3, 0.10, '2026-01-08 00:10:37', '2026-01-22 00:10:37'),
                                                                              (4, 0.30, '2026-01-08 00:10:37', '2026-01-11 00:10:37');

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
                                       (2, 'Méga-Évolution');

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
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `extensions`
--
ALTER TABLE `extensions`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `lignes_commande`
--
ALTER TABLE `lignes_commande`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `promotions`
--
ALTER TABLE `promotions`
    MODIFY `idPromo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `series`
--
ALTER TABLE `series`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
