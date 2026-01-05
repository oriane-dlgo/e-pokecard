<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';      // Nom de votre table
    protected $primaryKey = 'id';            // La clé primaire

    // Champs que l'on a le droit de modifier (sécurité)
    protected $allowedFields = [
        'login','password','role',
        'nom','prenom','email','adresse'
    ];

    // Pour récupérer automatiquement les produits sous forme d'objets et non de tableaux
    protected $returnType = 'object';
}