
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `commandes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `commandes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `date_creation` datetime DEFAULT NULL,
  `statut` enum('panier','validee','expediee','terminee','annulee') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'panier',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `type_paiement` enum('Paypal','Credit Card') COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `commandes_id_user_foreign` (`id_user`),
  CONSTRAINT `commandes_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `commandes` WRITE;
/*!40000 ALTER TABLE `commandes` DISABLE KEYS */;
INSERT INTO `commandes` (`id`, `id_user`, `date_creation`, `statut`, `total`, `type_paiement`) VALUES (1,2,'2025-12-08 00:07:27','terminee',240.00,'Credit Card'),(2,2,'2026-01-06 00:07:27','validee',59.90,'Paypal'),(3,1,'2026-01-07 00:07:27','expediee',45.00,'Paypal'),(4,2,'2026-01-08 00:07:27','panier',85.00,'Credit Card'),(5,2,'2025-11-09 00:12:17','terminee',240.00,'Paypal'),(6,1,'2025-12-18 00:12:17','terminee',90.00,'Credit Card'),(7,2,'2026-01-04 00:12:17','expediee',29.95,'Credit Card'),(8,1,'2026-01-07 00:12:17','validee',114.95,'Paypal'),(9,2,'2026-01-08 00:12:17','validee',90.00,'Credit Card'),(10,2,'2026-01-08 00:12:17','panier',140.00,NULL),(11,1,'2026-01-08 14:15:11','validee',0.00,NULL),(12,1,'2026-01-08 14:27:05','expediee',12.00,NULL),(13,1,'2026-01-08 14:28:53','terminee',215.99,NULL),(14,1,'2026-01-08 14:33:06','annulee',215.99,NULL),(15,1,'2026-01-08 14:35:15','validee',12.00,NULL),(16,1,'2026-01-08 14:37:02','terminee',90.99,NULL),(17,1,'2026-01-08 14:38:33','terminee',210.99,NULL),(18,3,'2026-01-10 10:00:00','terminee',650.00,'Credit Card'),(19,4,'2026-01-12 11:30:00','expediee',15.00,'Paypal');
/*!40000 ALTER TABLE `commandes` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `extensions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `extensions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `code` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_serie` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `extensions_id_serie_foreign` (`id_serie`),
  CONSTRAINT `extensions_id_serie_foreign` FOREIGN KEY (`id_serie`) REFERENCES `series` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `extensions` WRITE;
/*!40000 ALTER TABLE `extensions` DISABLE KEYS */;
INSERT INTO `extensions` (`id`, `nom`, `code`, `id_serie`) VALUES (1,'Écarlate et Violet','SVI',1),(2,'Évolutions à Paldea','PAL',1),(3,'Flammes Obsidiennes','OBF',1),(4,'151','MEW',1),(5,'Faille Paradoxe','PAR',1),(6,'Destinées de Paldea','PAF',1),(7,'Forces Temporelles','TEF',1),(8,'Mascarade Crépusculaire','TWM',1),(9,'Fable Nébuleuse','SFA',1),(10,'Couronne Stellaire','SCR',1),(11,'Étincelles Déferlantes','SSP',1),(12,'Évolutions Prismatiques','PRE',1),(13,'Aventures Ensemble','JTG',1),(14,'Foudre Noire','BLK',1),(15,'Flamme Blanche','WHT',1),(16,'Méga-Évolution','MEG',2),(17,'Flammes Fantasmagoriques','PFL',2),(18,'Évolution Céleste','EVS',3),(19,'Stars Étincelantes','BRS',3),(20,'Zénith Suprême','CRZ',3),(21,'Origine Perdue','LOR',3),(22,'Destinées Occultes','HIF',4),(23,'Duo de Choc','TEU',4),(24,'Set de Base','BS',5);
/*!40000 ALTER TABLE `extensions` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `lignes_commande`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lignes_commande` (
  `id` int NOT NULL AUTO_INCREMENT,
  `commande_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantite` int NOT NULL,
  `prix_unitaire` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lignes_commande_commande_id_foreign` (`commande_id`),
  KEY `lignes_commande_product_id_foreign` (`product_id`),
  CONSTRAINT `lignes_commande_commande_id_foreign` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `lignes_commande_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `produits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `lignes_commande` WRITE;
/*!40000 ALTER TABLE `lignes_commande` DISABLE KEYS */;
INSERT INTO `lignes_commande` (`id`, `commande_id`, `product_id`, `quantite`, `prix_unitaire`) VALUES (1,1,2,2,120.00),(2,2,3,10,5.99),(3,3,5,1,45.00),(4,4,1,1,85.00),(5,5,2,2,120.00),(6,6,16,1,90.00),(7,7,9,5,5.99),(8,8,1,1,85.00),(9,8,9,5,5.99),(10,9,16,1,90.00),(11,10,14,1,140.00),(12,11,19,1,0.00),(13,12,17,1,12.00),(14,12,18,1,0.00),(15,13,2,1,120.00),(16,13,3,1,5.99),(17,13,16,1,90.00),(18,14,16,1,90.00),(19,14,2,1,120.00),(20,14,3,1,5.99),(21,15,18,1,0.00),(22,15,17,1,12.00),(23,15,19,1,0.00),(24,16,3,1,5.99),(25,16,1,1,85.00),(26,17,9,1,5.99),(27,17,1,1,85.00),(28,17,2,1,120.00),(29,18,21,1,650.00),(30,19,23,1,15.00);
/*!40000 ALTER TABLE `lignes_commande` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES (1,'2026-01-14-091822','App\\Database\\Migrations\\InitFullDatabase','default','App',1768549565,1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `produits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produits` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type_produit` enum('carte','booster','coffret','display','ETB','accessoire') COLLATE utf8mb4_general_ci NOT NULL,
  `nom` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `prix` decimal(10,2) NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `stock` int NOT NULL DEFAULT '1',
  `rarete` enum('Commune','Unco','Holo','Double Rare','Illu. Rare','Ultra Rare','Alternative','Gold') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `numero_carte` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_extension` int DEFAULT NULL,
  `id_promo` int DEFAULT NULL,
  `nb_ventes` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `produits_id_extension_foreign` (`id_extension`),
  KEY `produits_id_promo_foreign` (`id_promo`),
  CONSTRAINT `produits_id_extension_foreign` FOREIGN KEY (`id_extension`) REFERENCES `extensions` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `produits_id_promo_foreign` FOREIGN KEY (`id_promo`) REFERENCES `promotions` (`idPromo`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `produits` WRITE;
/*!40000 ALTER TABLE `produits` DISABLE KEYS */;
INSERT INTO `produits` (`id`, `type_produit`, `nom`, `description`, `prix`, `image_url`, `stock`, `rarete`, `numero_carte`, `id_extension`, `id_promo`, `nb_ventes`) VALUES (1,'carte','U.R Pikachu EX','Une carte électrique surpuissante.',85.00,'1767838626_b07943e156f2381dd456.webp',800,'Ultra Rare','001/190',11,NULL,2),(2,'display','Display - SCR','Boîte de 36 boosters Couronne Stellaire.',120.00,'1767839880_6f5e5eba142eaeac35dc.webp',200,'',NULL,10,2,4),(3,'booster','Booster - MEW','Un booster de la série mythique 151.',5.99,'1767838434_43bfaac1b0d6497f80b5.png',970,'',NULL,4,1,10),(4,'ETB','ETB Ronflex - MEW','Coffret Dresseur délite 151 à leffigie de Ronflex.',55.00,'1767838356_d0f6391031d5eaba9296.png',200,'',NULL,4,3,0),(5,'carte','Mygavolt EX - SCR','',45.00,'1767839602_759efec1779ba55a341e.webp',150,'Alternative','120/142',10,NULL,1),(6,'accessoire','Classeur Malvalame','Protégez vos cartes avec style.',35.00,'1767839498_af2ee85929c67796f529.png',800,'',NULL,6,NULL,0),(7,'carte','AR Kecleon - SSP','',2.00,'1767839389_c4d9f9b5e5fc35079a09.webp',500,'Illu. Rare',NULL,11,NULL,0),(8,'carte','Latias EX - SSP','',8.00,'1767839274_10b9fe2ef7a401766209.webp',400,'Double Rare',NULL,11,NULL,0),(9,'booster','Booster - SSP','',5.99,'1767838189_90a71ddb3a6e5e14c829.png',149,'',NULL,11,NULL,10),(10,'carte','Gold Reshiram EX','Version dorée magnifique.',15.00,'1767838104_219af4cfaca36f662757.webp',120,'Gold',NULL,15,NULL,0),(11,'carte','Alt Trioxhydre','',25.00,'1767838048_5a61b2a2c21bacc330a4.webp',500,'Alternative',NULL,15,NULL,0),(12,'carte','Reshiram EX - WHT','Le légendaire blanc.',199.99,'1767837957_d6db006764d6698295c2.webp',200,'Commune',NULL,15,NULL,0),(13,'carte','Alt Dracaufeu EX','Le roi des flammes en version alternative.',125.00,'1767837851_da801f645c68f05d8949.webp',300,'Alternative','223/197',3,NULL,0),(14,'display','Display Flammes Obs','36 boosters pour tenter de trouver le Dracaufeu.',140.00,'1767837614_f865395a9478f9611818.jpg',400,'',NULL,3,4,1),(15,'carte','Phyllali EX - PRE','',60.00,'1767837711_5f499ec12d05c6492032.webp',240,'Alternative',NULL,12,NULL,0),(16,'coffret','ETB Suicune - TEF','Coffret Forces Temporelles.',90.00,'1767839209_1b00fa8de082038d4a1b.png',100,'',NULL,7,2,2),(17,'ETB','ETB PRE','Série rétro Méga',12.00,'1767837461_6b7d5530f6e79814c209.jpg',260,'',NULL,12,NULL,0),(18,'carte','Rugit-Lune EX - PRE','',10.00,'1767836982_22470c489ca7403584b5.webp',400,'Alternative',NULL,12,NULL,0),(19,'carte','Voltli EX - PRE','',8.50,'1767836898_f3205d0f35cced1cf64e.webp',500,'Alternative',NULL,12,NULL,0),(20,'carte','Noctali Ex - PRE','',499.99,'1767836503_24f36d896f89baf1976e.webp',100,'Alternative',NULL,12,NULL,0),(21,'carte','Noctali VMAX (Alt Art','',347.00,'1768550311_5290ca44837f8884627f.webp',100,'',NULL,10,NULL,0),(22,'carte','Rayquaza VMAX (Alt Art','',96.25,'1768550346_e32d7a6c5271ef0b29a3.webp',100,'',NULL,13,NULL,0),(23,'booster','Booster Évolution Céleste','Peut contenir un Noctali !',15.00,'booster151.png',500,'',NULL,18,NULL,5),(24,'display','Display Évolution Céleste','Scellé, ultra rare.',450.00,'etb151.png',100,'',NULL,18,NULL,0),(25,'carte','Giratina VSTAR (Gold','',32.95,'1768550374_28724fd32d0749735be7.webp',100,'',NULL,8,NULL,0),(26,'carte','Arceus VSTAR (Gold','',78.99,'1768550405_b2e704b4c01a37bb2432.png',100,'',NULL,8,NULL,0),(27,'ETB','ETB Zénith Suprême Lucario','Contient 10 boosters et la carte promo Lucario.',65.00,'1768550443_ad8179f969d939d50621.jpg',120,'',NULL,20,NULL,0),(28,'carte','Dracaufeu V (Alt Art','',22.51,'1768554539_a13dd0dcffe8148517e4.png',100,'',NULL,6,NULL,0),(29,'carte','Giratina V (Alt Art','',102.32,'1768550374_28724fd32d0749735be7.webp',100,'',NULL,6,NULL,0),(30,'carte','Pikachu VMAX (TG','',326.64,'1768550140_4a97624aeddf1a701ca7.png',100,'',NULL,3,NULL,0),(31,'carte','Dracaufeu GX Shiny','Le graal de Soleil et Lune.',350.00,'dracaufeu.png',100,'','SV49/SV94',22,NULL,0),(32,'coffret','Coffret Mewtwo & Mew GX','Coffret collection premium.',120.00,'1768550104_7f2dbb58170f8fcd1df5.jpg',200,'',NULL,22,NULL,0),(33,'carte','Latias & Latios GX (Alt Art','',345.32,'1768550050_0be9f86d01de1403a5db.webp',100,'',NULL,4,NULL,0),(34,'carte','Dracaufeu (Base Set','',120.00,'1768554500_821f88062524304c7d62.jpg',100,'Holo',NULL,24,NULL,0),(35,'carte','Tortank (Base Set','',120.00,'1768549987_36cd9ad390abddff18ef.webp',100,'Holo',NULL,24,NULL,0),(36,'carte','Florizarre (Base Set','',120.00,'1768549924_cec0398d3d1be006d57b.webp',100,'Unco',NULL,24,NULL,0),(37,'accessoire','Sleeves Pikachu (65 pcs','',15.95,'1768549897_64431a7d10bc263c0894.webp',100,'',NULL,NULL,NULL,0),(38,'accessoire','Deck Box Ultra Pro','Boîte de rangement noire.',4.50,'1768549865_e86ac59691ae049bd321.webp',500,'',NULL,1,NULL,15);
/*!40000 ALTER TABLE `produits` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `promotions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `promotions` (
  `idPromo` int NOT NULL AUTO_INCREMENT,
  `tauxPromo` decimal(5,2) NOT NULL,
  `dateDebut` datetime NOT NULL,
  `dateFin` datetime NOT NULL,
  PRIMARY KEY (`idPromo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `promotions` WRITE;
/*!40000 ALTER TABLE `promotions` DISABLE KEYS */;
INSERT INTO `promotions` (`idPromo`, `tauxPromo`, `dateDebut`, `dateFin`) VALUES (1,0.50,'2026-01-08 00:07:27','2026-01-15 00:07:27'),(2,0.20,'2026-01-08 00:10:37','2026-01-15 00:10:37'),(3,0.10,'2026-01-08 00:10:37','2026-01-22 00:10:37'),(4,0.30,'2026-01-08 00:10:37','2026-01-11 00:10:37');
/*!40000 ALTER TABLE `promotions` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `series`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `series` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `series` WRITE;
/*!40000 ALTER TABLE `series` DISABLE KEYS */;
INSERT INTO `series` (`id`, `nom`) VALUES (1,'Écarlate et Violet'),(2,'Méga-Évolution'),(3,'Épée et Bouclier'),(4,'Soleil et Lune'),(5,'Wizards (Vintage)');
/*!40000 ALTER TABLE `series` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `login` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('client','admin') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'client',
  `nom` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prenom` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `adresse` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `login`, `password`, `role`, `nom`, `prenom`, `email`, `adresse`) VALUES (1,'admin','$2y$10$4rvjj9ktrVhOcLwU1F19NuWkgWup118LWKF.0b6MQxm/6r.kdblMG','admin','Administrateur',NULL,NULL,NULL),(2,'sacha','$2y$10$KfO2nz9J3H6T34yhLDQI9O1cXYJ1XPXB2YUA2.LTvVlqEYQYHvbUO','client','Ketchum',NULL,NULL,NULL),(3,'ronflex','$2y$12$cvF2b8kDjaKsdosEvcrZSOJyMq85nu0grZvepb/ZHZLmmU9s2KUia','client','ronflex','ronflex','ronflex@ronflex.ronflex',NULL),(4,'pierre','$2y$12$dY9MFtgpueQc/qok2N20pOO9lY7dnsm.qijn2FELjI8x75g84aMVG','client','Rochard','Pierre','pierre@argent.com',NULL),(5,'ondine','$2y$12$bG88WHAFfQJh5cJR.hrbdO.L3jVFdqkjo2zCsSGyNIpaNi9z8JvL.','client','Azuria','Ondine','ondine@eau.com',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

