<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FullDataSeeder extends Seeder
{
    public function run()
    {
        // On désactive les vérifications de clés étrangères pour pouvoir vider/remplir dans n'importe quel ordre
        $this->db->disableForeignKeyChecks();

        // --------------------------------------------------------
        // NETTOYAGE (TRUNCATE)
        // On vide les tables avant d'insérer pour éviter les doublons
        // --------------------------------------------------------
        $this->db->table('lignes_commande')->truncate();
        $this->db->table('commandes')->truncate();
        $this->db->table('produits')->truncate();
        $this->db->table('extensions')->truncate();
        $this->db->table('promotions')->truncate();
        $this->db->table('series')->truncate();
        $this->db->table('users')->truncate();

        // --------------------------------------------------------
        // INSERTION DES DONNÉES
        // --------------------------------------------------------

        // 1. USERS
        $users = [
            ['id' => 1, 'login' => 'admin', 'password' => '$2y$10$4rvjj9ktrVhOcLwU1F19NuWkgWup118LWKF.0b6MQxm/6r.kdblMG', 'role' => 'admin', 'nom' => 'Administrateur', 'prenom' => NULL, 'email' => NULL, 'adresse' => NULL],
            ['id' => 2, 'login' => 'sacha', 'password' => '$2y$10$KfO2nz9J3H6T34yhLDQI9O1cXYJ1XPXB2YUA2.LTvVlqEYQYHvbUO', 'role' => 'client', 'nom' => 'Ketchum', 'prenom' => NULL, 'email' => NULL, 'adresse' => NULL],
            ['id' => 3, 'login' => 'ronflex', 'password' => '$2y$12$cvF2b8kDjaKsdosEvcrZSOJyMq85nu0grZvepb/ZHZLmmU9s2KUia', 'role' => 'client', 'nom' => 'ronflex', 'prenom' => 'ronflex', 'email' => 'ronflex@ronflex.ronflex', 'adresse' => NULL],
            ['id' => 4, 'login' => 'user1', 'password' => '$2y$12$dY9MFtgpueQc/qok2N20pOO9lY7dnsm.qijn2FELjI8x75g84aMVG', 'role' => 'client', 'nom' => 'user1', 'prenom' => 'user1', 'email' => 'user1@gmail.com', 'adresse' => NULL],
            ['id' => 5, 'login' => 'aze', 'password' => '$2y$12$bG88WHAFfQJh5cJR.hrbdO.L3jVFdqkjo2zCsSGyNIpaNi9z8JvL.', 'role' => 'client', 'nom' => 'azert', 'prenom' => 'azert', 'email' => 'azert@gmail.com', 'adresse' => NULL],
        ];
        $this->db->table('users')->insertBatch($users);

        // 2. SERIES
        $series = [
            ['id' => 1, 'nom' => 'Écarlate et Violet'],
            ['id' => 2, 'nom' => 'Méga-Évolution'],
        ];
        $this->db->table('series')->insertBatch($series);

        // 3. PROMOTIONS
        $promotions = [
            ['idPromo' => 1, 'tauxPromo' => 0.50, 'dateDebut' => '2026-01-08 00:07:27', 'dateFin' => '2026-01-15 00:07:27'],
            ['idPromo' => 2, 'tauxPromo' => 0.20, 'dateDebut' => '2026-01-08 00:10:37', 'dateFin' => '2026-01-15 00:10:37'],
            ['idPromo' => 3, 'tauxPromo' => 0.10, 'dateDebut' => '2026-01-08 00:10:37', 'dateFin' => '2026-01-22 00:10:37'],
            ['idPromo' => 4, 'tauxPromo' => 0.30, 'dateDebut' => '2026-01-08 00:10:37', 'dateFin' => '2026-01-11 00:10:37'],
        ];
        $this->db->table('promotions')->insertBatch($promotions);

        // 4. EXTENSIONS
        $extensions = [
            ['id' => 1, 'nom' => 'Écarlate et Violet', 'code' => 'SVI', 'id_serie' => 1],
            ['id' => 2, 'nom' => 'Évolutions à Paldea', 'code' => 'PAL', 'id_serie' => 1],
            ['id' => 3, 'nom' => 'Flammes Obsidiennes', 'code' => 'OBF', 'id_serie' => 1],
            ['id' => 4, 'nom' => '151', 'code' => 'MEW', 'id_serie' => 1],
            ['id' => 5, 'nom' => 'Faille Paradoxe', 'code' => 'PAR', 'id_serie' => 1],
            ['id' => 6, 'nom' => 'Destinées de Paldea', 'code' => 'PAF', 'id_serie' => 1],
            ['id' => 7, 'nom' => 'Forces Temporelles', 'code' => 'TEF', 'id_serie' => 1],
            ['id' => 8, 'nom' => 'Mascarade Crépusculaire', 'code' => 'TWM', 'id_serie' => 1],
            ['id' => 9, 'nom' => 'Fable Nébuleuse', 'code' => 'SFA', 'id_serie' => 1],
            ['id' => 10, 'nom' => 'Couronne Stellaire', 'code' => 'SCR', 'id_serie' => 1],
            ['id' => 11, 'nom' => 'Étincelles Déferlantes', 'code' => 'SSP', 'id_serie' => 1],
            ['id' => 12, 'nom' => 'Évolutions Prismatiques', 'code' => 'PRE', 'id_serie' => 1],
            ['id' => 13, 'nom' => 'Aventures Ensemble', 'code' => 'JTG', 'id_serie' => 1],
            ['id' => 14, 'nom' => 'Foudre Noire', 'code' => 'BLK', 'id_serie' => 1],
            ['id' => 15, 'nom' => 'Flamme Blanche', 'code' => 'WHT', 'id_serie' => 1],
            ['id' => 16, 'nom' => 'Méga-Évolution', 'code' => 'MEG', 'id_serie' => 2],
            ['id' => 17, 'nom' => 'Flammes Fantasmagoriques', 'code' => 'PFL', 'id_serie' => 2],
        ];
        $this->db->table('extensions')->insertBatch($extensions);

        // 5. PRODUITS
        $produits = [
            ['id' => 1, 'type_produit' => 'carte', 'nom' => 'U.R Pikachu EX', 'description' => '', 'prix' => 85.00, 'image_url' => '1767838626_b07943e156f2381dd456.webp', 'stock' => 8, 'rarete' => 'Ultra Rare', 'numero_carte' => NULL, 'id_extension' => 11, 'id_promo' => NULL, 'nb_ventes' => 2],
            ['id' => 2, 'type_produit' => 'display', 'nom' => 'Display - SCR', 'description' => '', 'prix' => 120.00, 'image_url' => '1767839880_6f5e5eba142eaeac35dc.webp', 'stock' => 2, 'rarete' => '', 'numero_carte' => NULL, 'id_extension' => 10, 'id_promo' => 2, 'nb_ventes' => 4],
            ['id' => 3, 'type_produit' => 'booster', 'nom' => 'Booster - MEW', 'description' => '', 'prix' => 5.99, 'image_url' => '1767838434_43bfaac1b0d6497f80b5.png', 'stock' => 97, 'rarete' => '', 'numero_carte' => NULL, 'id_extension' => 4, 'id_promo' => 1, 'nb_ventes' => 10],
            ['id' => 4, 'type_produit' => 'ETB', 'nom' => 'ETB Ronflex - MEW', 'description' => '', 'prix' => 55.00, 'image_url' => '1767838356_d0f6391031d5eaba9296.png', 'stock' => 20, 'rarete' => '', 'numero_carte' => NULL, 'id_extension' => 4, 'id_promo' => 3, 'nb_ventes' => 0],
            ['id' => 5, 'type_produit' => 'carte', 'nom' => 'Mygavolt EX - SCR', 'description' => '', 'prix' => 45.00, 'image_url' => '1767839602_759efec1779ba55a341e.webp', 'stock' => 15, 'rarete' => 'Alternative', 'numero_carte' => NULL, 'id_extension' => 10, 'id_promo' => NULL, 'nb_ventes' => 1],
            ['id' => 6, 'type_produit' => 'accessoire', 'nom' => 'Classeur Malvalame - PAF', 'description' => '', 'prix' => 35.00, 'image_url' => '1767839498_af2ee85929c67796f529.png', 'stock' => 8, 'rarete' => '', 'numero_carte' => NULL, 'id_extension' => 6, 'id_promo' => NULL, 'nb_ventes' => 0],
            ['id' => 7, 'type_produit' => 'carte', 'nom' => 'AR Kecleon - SSP', 'description' => '', 'prix' => 2.00, 'image_url' => '1767839389_c4d9f9b5e5fc35079a09.webp', 'stock' => 50, 'rarete' => 'Illu. Rare', 'numero_carte' => NULL, 'id_extension' => 11, 'id_promo' => NULL, 'nb_ventes' => 0],
            ['id' => 8, 'type_produit' => 'carte', 'nom' => 'Latias EX - SSP', 'description' => 'Rien', 'prix' => 8.00, 'image_url' => '1767839274_10b9fe2ef7a401766209.webp', 'stock' => 40, 'rarete' => 'Double Rare', 'numero_carte' => NULL, 'id_extension' => 11, 'id_promo' => NULL, 'nb_ventes' => 0],
            ['id' => 9, 'type_produit' => 'booster', 'nom' => 'Booster - SSP', 'description' => '', 'prix' => 5.99, 'image_url' => '1767838189_90a71ddb3a6e5e14c829.png', 'stock' => 149, 'rarete' => '', 'numero_carte' => NULL, 'id_extension' => 11, 'id_promo' => NULL, 'nb_ventes' => 10],
            ['id' => 10, 'type_produit' => 'carte', 'nom' => 'Gold Reshiram EX - WHT', 'description' => 'Rien', 'prix' => 15.00, 'image_url' => '1767838104_219af4cfaca36f662757.webp', 'stock' => 12, 'rarete' => 'Gold', 'numero_carte' => NULL, 'id_extension' => 15, 'id_promo' => NULL, 'nb_ventes' => 0],
            ['id' => 11, 'type_produit' => 'carte', 'nom' => 'Alt Trioxhydre', 'description' => 'Rien', 'prix' => 25.00, 'image_url' => '1767838048_5a61b2a2c21bacc330a4.webp', 'stock' => 5, 'rarete' => 'Alternative', 'numero_carte' => NULL, 'id_extension' => 15, 'id_promo' => NULL, 'nb_ventes' => 0],
            ['id' => 12, 'type_produit' => 'carte', 'nom' => 'Alt Reshiram EX - WHT', 'description' => 'Rien', 'prix' => 0.50, 'image_url' => '1767837957_d6db006764d6698295c2.webp', 'stock' => 200, 'rarete' => 'Commune', 'numero_carte' => NULL, 'id_extension' => 15, 'id_promo' => NULL, 'nb_ventes' => 0],
            ['id' => 13, 'type_produit' => 'carte', 'nom' => 'Alt Dracaufeu EX - OBF', 'description' => 'Rien', 'prix' => 1.00, 'image_url' => '1767837851_da801f645c68f05d8949.webp', 'stock' => 100, 'rarete' => 'Alternative', 'numero_carte' => NULL, 'id_extension' => 3, 'id_promo' => NULL, 'nb_ventes' => 0],
            ['id' => 14, 'type_produit' => 'display', 'nom' => 'Display Flammes Obsidiennes', 'description' => 'Rien', 'prix' => 140.00, 'image_url' => '1767837614_f865395a9478f9611818.jpg', 'stock' => 4, 'rarete' => '', 'numero_carte' => NULL, 'id_extension' => 3, 'id_promo' => 4, 'nb_ventes' => 1],
            ['id' => 15, 'type_produit' => 'carte', 'nom' => 'Phyllali EX - PRE', 'description' => 'Rien', 'prix' => 60.00, 'image_url' => '1767837711_5f499ec12d05c6492032.webp', 'stock' => 24, 'rarete' => 'Alternative', 'numero_carte' => NULL, 'id_extension' => 12, 'id_promo' => NULL, 'nb_ventes' => 0],
            ['id' => 16, 'type_produit' => 'coffret', 'nom' => 'ETB Suicune - TEF', 'description' => 'Rien', 'prix' => 90.00, 'image_url' => '1767839209_1b00fa8de082038d4a1b.png', 'stock' => 0, 'rarete' => '', 'numero_carte' => NULL, 'id_extension' => 7, 'id_promo' => 2, 'nb_ventes' => 2],
            ['id' => 17, 'type_produit' => 'ETB', 'nom' => 'ETB PRE', 'description' => 'Série rétro Méga', 'prix' => 12.00, 'image_url' => '1767837461_6b7d5530f6e79814c209.jpg', 'stock' => 26, 'rarete' => '', 'numero_carte' => NULL, 'id_extension' => 12, 'id_promo' => NULL, 'nb_ventes' => 0],
            ['id' => 18, 'type_produit' => 'carte', 'nom' => 'Rugit-Lune EX - PRE', 'description' => 'Rien', 'prix' => 0.00, 'image_url' => '1767836982_22470c489ca7403584b5.webp', 'stock' => 4, 'rarete' => 'Alternative', 'numero_carte' => NULL, 'id_extension' => 12, 'id_promo' => NULL, 'nb_ventes' => 0],
            ['id' => 19, 'type_produit' => 'carte', 'nom' => 'Voltli EX - PRE', 'description' => 'Rien', 'prix' => 0.00, 'image_url' => '1767836898_f3205d0f35cced1cf64e.webp', 'stock' => 5, 'rarete' => 'Alternative', 'numero_carte' => NULL, 'id_extension' => 12, 'id_promo' => NULL, 'nb_ventes' => 0],
            ['id' => 20, 'type_produit' => 'carte', 'nom' => 'Noctali Ex - PRE', 'description' => 'Rien', 'prix' => 499.99, 'image_url' => '1767836503_24f36d896f89baf1976e.webp', 'stock' => 10, 'rarete' => 'Alternative', 'numero_carte' => NULL, 'id_extension' => 12, 'id_promo' => NULL, 'nb_ventes' => 0],
        ];
        $this->db->table('produits')->insertBatch($produits);

        // 6. COMMANDES
        $commandes = [
            ['id' => 1, 'id_user' => 2, 'date_creation' => '2025-12-08 00:07:27', 'statut' => 'terminee', 'total' => 240.00, 'type_paiement' => 'Credit Card'],
            ['id' => 2, 'id_user' => 2, 'date_creation' => '2026-01-06 00:07:27', 'statut' => 'validee', 'total' => 59.90, 'type_paiement' => 'Paypal'],
            ['id' => 3, 'id_user' => 1, 'date_creation' => '2026-01-07 00:07:27', 'statut' => 'expediee', 'total' => 45.00, 'type_paiement' => 'Paypal'],
            ['id' => 4, 'id_user' => 2, 'date_creation' => '2026-01-08 00:07:27', 'statut' => 'panier', 'total' => 85.00, 'type_paiement' => 'Credit Card'],
            ['id' => 5, 'id_user' => 2, 'date_creation' => '2025-11-09 00:12:17', 'statut' => 'terminee', 'total' => 240.00, 'type_paiement' => 'Paypal'],
            ['id' => 6, 'id_user' => 1, 'date_creation' => '2025-12-18 00:12:17', 'statut' => 'terminee', 'total' => 90.00, 'type_paiement' => 'Credit Card'],
            ['id' => 7, 'id_user' => 2, 'date_creation' => '2026-01-04 00:12:17', 'statut' => 'expediee', 'total' => 29.95, 'type_paiement' => 'Credit Card'],
            ['id' => 8, 'id_user' => 1, 'date_creation' => '2026-01-07 00:12:17', 'statut' => 'validee', 'total' => 114.95, 'type_paiement' => 'Paypal'],
            ['id' => 9, 'id_user' => 2, 'date_creation' => '2026-01-08 00:12:17', 'statut' => 'validee', 'total' => 90.00, 'type_paiement' => 'Credit Card'],
            ['id' => 10, 'id_user' => 2, 'date_creation' => '2026-01-08 00:12:17', 'statut' => 'panier', 'total' => 140.00, 'type_paiement' => NULL],
            ['id' => 11, 'id_user' => 1, 'date_creation' => '2026-01-08 14:15:11', 'statut' => 'validee', 'total' => 0.00, 'type_paiement' => NULL],
            ['id' => 12, 'id_user' => 1, 'date_creation' => '2026-01-08 14:27:05', 'statut' => '', 'total' => 12.00, 'type_paiement' => NULL],
            ['id' => 13, 'id_user' => 1, 'date_creation' => '2026-01-08 14:28:53', 'statut' => '', 'total' => 215.99, 'type_paiement' => NULL],
            ['id' => 14, 'id_user' => 1, 'date_creation' => '2026-01-08 14:33:06', 'statut' => '', 'total' => 215.99, 'type_paiement' => NULL],
            ['id' => 15, 'id_user' => 1, 'date_creation' => '2026-01-08 14:35:15', 'statut' => '', 'total' => 12.00, 'type_paiement' => NULL],
            ['id' => 16, 'id_user' => 1, 'date_creation' => '2026-01-08 14:37:02', 'statut' => '', 'total' => 90.99, 'type_paiement' => NULL],
            ['id' => 17, 'id_user' => 1, 'date_creation' => '2026-01-08 14:38:33', 'statut' => '', 'total' => 210.99, 'type_paiement' => NULL],
        ];
        $this->db->table('commandes')->insertBatch($commandes);

        // 7. LIGNES_COMMANDE
        $lignes_commande = [
            ['id' => 1, 'commande_id' => 1, 'product_id' => 2, 'quantite' => 2, 'prix_unitaire' => 120.00],
            ['id' => 2, 'commande_id' => 2, 'product_id' => 3, 'quantite' => 10, 'prix_unitaire' => 5.99],
            ['id' => 3, 'commande_id' => 3, 'product_id' => 5, 'quantite' => 1, 'prix_unitaire' => 45.00],
            ['id' => 4, 'commande_id' => 4, 'product_id' => 1, 'quantite' => 1, 'prix_unitaire' => 85.00],
            ['id' => 5, 'commande_id' => 5, 'product_id' => 2, 'quantite' => 2, 'prix_unitaire' => 120.00],
            ['id' => 6, 'commande_id' => 6, 'product_id' => 16, 'quantite' => 1, 'prix_unitaire' => 90.00],
            ['id' => 7, 'commande_id' => 7, 'product_id' => 9, 'quantite' => 5, 'prix_unitaire' => 5.99],
            ['id' => 8, 'commande_id' => 8, 'product_id' => 1, 'quantite' => 1, 'prix_unitaire' => 85.00],
            ['id' => 9, 'commande_id' => 8, 'product_id' => 9, 'quantite' => 5, 'prix_unitaire' => 5.99],
            ['id' => 10, 'commande_id' => 9, 'product_id' => 16, 'quantite' => 1, 'prix_unitaire' => 90.00],
            ['id' => 11, 'commande_id' => 10, 'product_id' => 14, 'quantite' => 1, 'prix_unitaire' => 140.00],
            ['id' => 12, 'commande_id' => 11, 'product_id' => 19, 'quantite' => 1, 'prix_unitaire' => 0.00],
            ['id' => 13, 'commande_id' => 12, 'product_id' => 17, 'quantite' => 1, 'prix_unitaire' => 12.00],
            ['id' => 14, 'commande_id' => 12, 'product_id' => 18, 'quantite' => 1, 'prix_unitaire' => 0.00],
            ['id' => 15, 'commande_id' => 13, 'product_id' => 2, 'quantite' => 1, 'prix_unitaire' => 120.00],
            ['id' => 16, 'commande_id' => 13, 'product_id' => 3, 'quantite' => 1, 'prix_unitaire' => 5.99],
            ['id' => 17, 'commande_id' => 13, 'product_id' => 16, 'quantite' => 1, 'prix_unitaire' => 90.00],
            ['id' => 18, 'commande_id' => 14, 'product_id' => 16, 'quantite' => 1, 'prix_unitaire' => 90.00],
            ['id' => 19, 'commande_id' => 14, 'product_id' => 2, 'quantite' => 1, 'prix_unitaire' => 120.00],
            ['id' => 20, 'commande_id' => 14, 'product_id' => 3, 'quantite' => 1, 'prix_unitaire' => 5.99],
            ['id' => 21, 'commande_id' => 15, 'product_id' => 18, 'quantite' => 1, 'prix_unitaire' => 0.00],
            ['id' => 22, 'commande_id' => 15, 'product_id' => 17, 'quantite' => 1, 'prix_unitaire' => 12.00],
            ['id' => 23, 'commande_id' => 15, 'product_id' => 19, 'quantite' => 1, 'prix_unitaire' => 0.00],
            ['id' => 24, 'commande_id' => 16, 'product_id' => 3, 'quantite' => 1, 'prix_unitaire' => 5.99],
            ['id' => 25, 'commande_id' => 16, 'product_id' => 1, 'quantite' => 1, 'prix_unitaire' => 85.00],
            ['id' => 26, 'commande_id' => 17, 'product_id' => 9, 'quantite' => 1, 'prix_unitaire' => 5.99],
            ['id' => 27, 'commande_id' => 17, 'product_id' => 1, 'quantite' => 1, 'prix_unitaire' => 85.00],
            ['id' => 28, 'commande_id' => 17, 'product_id' => 2, 'quantite' => 1, 'prix_unitaire' => 120.00],
        ];
        $this->db->table('lignes_commande')->insertBatch($lignes_commande);

        // On réactive les vérifications
        $this->db->enableForeignKeyChecks();
    }
}