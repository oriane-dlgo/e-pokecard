<?php

namespace App\Models;

use CodeIgniter\Model;
// --- CORRECTION : Orthographe exacte de la classe Entité ---
use App\Entities\LignesCommande;

class LignesCommandeModel extends Model
{
    protected $table            = 'lignes_commande';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    
    // On utilise bien l'Entité comme type de retour
    protected $returnType       = LignesCommande::class;
    
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['commande_id', 'product_id', 'quantite', 'prix_unitaire'];

    // ... (Reste de la config inchangée) ...

    /**
     * Récupère les lignes d'une commande AVEC les infos du produit (Image, Nom)
     */
    public function getDetailsCommande($idCommande)
    {
        // CodeIgniter est assez intelligent : 
        // Même si le returnType est LignesCommande, il va injecter 
        // les colonnes jointes (nom, image_url) dynamiquement dans l'entité.
        return $this->select('lignes_commande.*, produits.nom, produits.image_url, produits.prix as prix_actuel')
                    ->join('produits', 'produits.id = lignes_commande.product_id')
                    ->where('commande_id', $idCommande)
                    ->findAll();
    }
}