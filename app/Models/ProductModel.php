<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table      = 'produits';      // Nom de votre table
    protected $primaryKey = 'id';            // La clé primaire

    // Champs que l'on a le droit de modifier (sécurité)
    protected $allowedFields = [
        'type_produit', 'nom', 'description', 'prix', 
        'image_url', 'stock', 'rarete', 'numero_carte', 'id_extension'
    ];

    // Pour récupérer automatiquement les produits sous forme d'objets et non de tableaux
    protected $returnType = 'object';
}