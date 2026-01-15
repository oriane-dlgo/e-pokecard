<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InitFullDatabase extends Migration
{
    public function up()
    {
        // Désactiver les clés étrangères temporairement pour éviter les erreurs lors de la création
        $this->db->query('SET FOREIGN_KEY_CHECKS=0;');

        // ---------------------------------------------------------------------
        // 1. TABLE USERS
        // ---------------------------------------------------------------------
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'login' => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => true],
            'password' => ['type' => 'VARCHAR', 'constraint' => 255],
            'role' => ['type' => 'ENUM', 'constraint' => ['client', 'admin'], 'default' => 'client'],
            'nom' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'prenom' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'email' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'adresse' => ['type' => 'TEXT', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('users', true);

        // ---------------------------------------------------------------------
        // 2. TABLE SERIES
        // ---------------------------------------------------------------------
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'nom' => ['type' => 'VARCHAR', 'constraint' => 100],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('series', true);

        // ---------------------------------------------------------------------
        // 3. TABLE PROMOTIONS
        // ---------------------------------------------------------------------
        $this->forge->addField([
            'idPromo' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'tauxPromo' => ['type' => 'DECIMAL', 'constraint' => '5,2'],
            'dateDebut' => ['type' => 'DATETIME'],
            'dateFin' => ['type' => 'DATETIME'],
        ]);
        $this->forge->addPrimaryKey('idPromo');
        $this->forge->createTable('promotions', true);

        // ---------------------------------------------------------------------
        // 4. TABLE EXTENSIONS (Dépend de SERIES)
        // ---------------------------------------------------------------------
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'nom' => ['type' => 'VARCHAR', 'constraint' => 100],
            'code' => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'id_serie' => ['type' => 'INT', 'constraint' => 11, 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('id_serie', 'series', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('extensions', true);

        // ---------------------------------------------------------------------
        // 5. TABLE PRODUITS (Dépend de EXTENSIONS et PROMOTIONS)
        // ---------------------------------------------------------------------
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'type_produit' => ['type' => 'ENUM', 'constraint' => ['carte', 'booster', 'coffret', 'display', 'ETB', 'accessoire']],
            'nom' => ['type' => 'VARCHAR', 'constraint' => 200],
            'description' => ['type' => 'TEXT', 'null' => true],
            'prix' => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'image_url' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'stock' => ['type' => 'INT', 'default' => 1],
            'rarete' => ['type' => 'ENUM', 'constraint' => ['Commune', 'Unco', 'Holo', 'Double Rare', 'Illu. Rare', 'Ultra Rare', 'Alternative', 'Gold'], 'null' => true],
            'numero_carte' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'id_extension' => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'id_promo' => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'nb_ventes' => ['type' => 'INT', 'default' => 0],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('id_extension', 'extensions', 'id', 'SET NULL', 'SET NULL');
        $this->forge->addForeignKey('id_promo', 'promotions', 'idPromo', 'SET NULL', 'SET NULL');
        $this->forge->createTable('produits', true);

        // ---------------------------------------------------------------------
        // 6. TABLE COMMANDES (Dépend de USERS)
        // ---------------------------------------------------------------------
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'id_user' => ['type' => 'INT', 'constraint' => 11],
            'date_creation' => ['type' => 'DATETIME', 'null' => true], // Default handled by DB or PHP
            'statut' => ['type' => 'ENUM', 'constraint' => ['panier', 'validee', 'expediee', 'terminee', 'annulee'], 'default' => 'panier'],
            'total' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => '0.00'],
            'type_paiement' => ['type' => 'ENUM', 'constraint' => ['Paypal', 'Credit Card'], 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('commandes', true);

        // ---------------------------------------------------------------------
        // 7. TABLE LIGNES_COMMANDE (Dépend de COMMANDES et PRODUITS)
        // ---------------------------------------------------------------------
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'commande_id' => ['type' => 'INT', 'constraint' => 11],
            'product_id' => ['type' => 'INT', 'constraint' => 11],
            'quantite' => ['type' => 'INT'],
            'prix_unitaire' => ['type' => 'DECIMAL', 'constraint' => '10,2'],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('commande_id', 'commandes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('product_id', 'produits', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('lignes_commande', true);

        $this->db->query('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function down()
    {
        $this->db->query('SET FOREIGN_KEY_CHECKS=0;');
        $this->forge->dropTable('lignes_commande', true);
        $this->forge->dropTable('commandes', true);
        $this->forge->dropTable('produits', true);
        $this->forge->dropTable('extensions', true);
        $this->forge->dropTable('promotions', true);
        $this->forge->dropTable('series', true);
        $this->forge->dropTable('users', true);
        $this->db->query('SET FOREIGN_KEY_CHECKS=1;');
    }
}