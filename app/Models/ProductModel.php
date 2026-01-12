<?php


namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Produit;

class ProductModel extends Model
{
    protected $table            = 'produits';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'App\Entities\Produit';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'nom', 
        'type_produit', 
        'prix', 
        'stock', 
        'description', 
        'rarete', 
        'id_extension', 
        'image_url', 
        'id_promo',    
        'nb_ventes'    
    ];
    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    /**
     * Retourne le builder pré-configuré avec les jointures (Extensions, Séries, Promos)
     * Cela évite de réécrire les JOIN partout.
     */
    public function getAvecDetails()
    {
        // $this correspond ici au builder de la table 'produits'
        return $this->select('produits.*, extensions.nom as nom_extension, extensions.code as code_extension, series.nom as nom_serie, promotions.tauxPromo')
                    ->join('extensions', 'extensions.id = produits.id_extension', 'left')
                    ->join('series', 'series.id = extensions.id_serie', 'left')
                    ->join('promotions', 'promotions.idPromo = produits.id_promo', 'left');
    }

    /**
     * Récupère les best-sellers de la semaine (Logique complexe)
     */
    public function getBestSellersSemaine($limit = 4)
    {
        // Pour les requêtes très complexes impliquant des tables tiers (commandes),
        // on peut utiliser le db connect interne du model
        $db = \Config\Database::connect();
        
        return $db->table('lignes_commande')
            ->select('produits.*, extensions.nom as nom_extension, extensions.code as code_extension, series.nom as nom_serie, SUM(lignes_commande.quantite) as ventes_hebdo, promotions.tauxPromo')
            ->join('produits', 'produits.id = lignes_commande.product_id')
            ->join('commandes', 'commandes.id = lignes_commande.commande_id')
            ->join('extensions', 'extensions.id = produits.id_extension', 'left')
            ->join('series', 'series.id = extensions.id_serie', 'left')
            ->join('promotions', 'promotions.idPromo = produits.id_promo', 'left')
            ->where('commandes.date_creation >=', date('Y-m-d H:i:s', strtotime('-7 days')))
            ->groupBy('produits.id')
            ->orderBy('ventes_hebdo', 'DESC')
            ->limit($limit)
            ->get()->getResult();
    }

    /**
     * [SEARCH] Construit la map Séries -> Extensions pour la sidebar
     */
    public function getSeriesMap()
    {
        $db = \Config\Database::connect();
        
        $series = $db->table('series')->orderBy('id', 'DESC')->get()->getResult();
        $extensions = $db->table('extensions')->orderBy('id', 'DESC')->get()->getResult();

        $map = [];
        foreach ($series as $s) {
            $map[$s->id] = [
                'info' => $s,
                'extensions' => []
            ];
        }

        foreach ($extensions as $e) {
            if (isset($map[$e->id_serie])) {
                $map[$e->id_serie]['extensions'][] = $e;
            }
        }

        return $map;
    }

    /**
     * [SEARCH] Récupère les IDs des extensions appartenant aux séries données
     */
    public function getExtensionIdsBySeries(array $seriesIds)
    {
        if (empty($seriesIds)) return [];
        
        $db = \Config\Database::connect();
        $results = $db->table('extensions')
                      ->whereIn('id_serie', $seriesIds)
                      ->select('id')
                      ->get()->getResultArray(); // Retourne un tableau associatif

        return array_column($results, 'id'); // On ne veut que les ID [1, 5, 8...]
    }

    /**
     * [SEARCH] Récupère tous les taux de promo distincts
     */
    public function getAllPromoRates()
    {
        $db = \Config\Database::connect();
        $results = $db->table('promotions')
                      ->select('tauxPromo')
                      ->distinct()
                      ->get()->getResult();
        
        // On retourne un tableau de strings simple
        return array_map(fn($r) => (string)$r->tauxPromo, $results);
    }

    /**
     * [SEARCH] Moteur de recherche principal
     */
    public function searchProducts(array $filters, int $perPage = 20)
    {
        // 1. Base de la requête
        $this->select('produits.*, promotions.tauxPromo, extensions.nom as nom_extension, extensions.code as code_extension, series.nom as nom_serie')
             ->join('promotions', 'promotions.idPromo = produits.id_promo', 'left')
             ->join('extensions', 'extensions.id = produits.id_extension', 'left')
             ->join('series', 'series.id = extensions.id_serie', 'left');
        
        // 2. Application des filtres
        if (!empty($filters['q'])) {
            $this->groupStart()
                 ->like('nom', $filters['q'])
                 ->orLike('description', $filters['q'])
                 ->groupEnd();
        }

        if (!empty($filters['type'])) {
            $this->whereIn('type_produit', $filters['type']);
        }

        if (!empty($filters['rarete'])) {
            $this->whereIn('rarete', $filters['rarete']);
        }

        if (!empty($filters['promo'])) {
            $this->whereIn('promotions.tauxPromo', $filters['promo']);
        }

        if (!empty($filters['ext'])) {
            $this->whereIn('id_extension', $filters['ext']);
        }

        // 3. Tri
        switch ($filters['tri'] ?? '') {
            case 'prix_asc':   $this->orderBy('prix', 'ASC'); break;
            case 'prix_desc':  $this->orderBy('prix', 'DESC'); break;
            case 'pop_desc':   $this->orderBy('nb_ventes', 'DESC'); break;
            case 'promo_desc': $this->orderBy('promotions.tauxPromo', 'DESC'); break;
            default:           $this->orderBy('produits.id', 'DESC'); break;
        }

        // 4. Pagination
        return $this->paginate($perPage);
    }


    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
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