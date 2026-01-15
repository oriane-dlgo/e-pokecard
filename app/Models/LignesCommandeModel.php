<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\LignesCommande;

class LignesCommandeModel extends Model
{
    protected $table            = 'lignes_commande';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    
    protected $returnType       = LignesCommande::class;
    
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['commande_id', 'product_id', 'quantite', 'prix_unitaire'];


    /**
     * Récupère les lignes d'une commande AVEC les infos du produit (Image, Nom)
     */
    public function getDetailsCommande($idCommande)
    {
        return $this->select('lignes_commande.*, produits.nom, produits.image_url, produits.prix as prix_actuel')
                    ->join('produits', 'produits.id = lignes_commande.product_id')
                    ->where('commande_id', $idCommande)
                    ->findAll();
    }

    // --- CONFIGURATIONS STANDARDS ---

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}