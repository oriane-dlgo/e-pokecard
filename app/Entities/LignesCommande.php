<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class LignesCommande extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [
        'commande_id'   => 'integer',
        'product_id'    => 'integer',
        'quantite'      => 'integer',
        'prix_unitaire' => 'float',
    ];
}