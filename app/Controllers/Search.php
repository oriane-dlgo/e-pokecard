<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Search extends BaseController
{
    public function index()
    {
$db = \Config\Database::connect();
        $model = new ProductModel();
        
        // --- 1. RÉCUPÉRATION DES PARAMÈTRES ---
        $q      = $this->request->getGet('q');
        $types  = $this->request->getGet('type');
        $raretes= $this->request->getGet('rarete');
        $tri    = $this->request->getGet('tri');
        $promos = $this->request->getGet('promo');
        $exts   = $this->request->getGet('ext');

        $seriesFull = $this->request->getGet('series_full');
        $oldSeriesFull = $this->request->getGet('old_series_full');

        $allPromos     = $this->request->getGet('all_promos');     
        $oldAllPromos  = $this->request->getGet('old_all_promos'); 

        // --- 2. BLINDAGE DES TABLEAUX ---
        if (empty($types)) { $types = []; } elseif (!is_array($types)) { $types = [$types]; }
        if (empty($raretes)) { $raretes = []; } elseif (!is_array($raretes)) { $raretes = [$raretes]; }
        if (empty($promos)) { $promos = []; } elseif (!is_array($promos)) { $promos = [$promos]; }
        if (empty($exts)) { $exts = []; } elseif (!is_array($exts)) { $exts = [$exts]; }
        if (empty($seriesFull)) { $seriesFull = []; } elseif (!is_array($seriesFull)) { $seriesFull = [$seriesFull]; }
        if (empty($oldSeriesFull)) { $oldSeriesFull = []; } elseif (!is_array($oldSeriesFull)) { $oldSeriesFull = [$oldSeriesFull]; }

        // --- LOGIQUE "TOUTES LES PROMOS" (DÉCOCHAGE) ---
        // Si c'était coché avant (old) mais plus maintenant (allPromos est null/vide)
        if (!empty($oldAllPromos) && empty($allPromos)) {
            $promos = []; // On vide la sélection
        }

        // --- LOGIQUE "TOUTES LES PROMOS" (COCHAGE) ---
        if (!empty($allPromos)) {
            // On récupère tous les taux distincts existants en base
            $tousLesTaux = $db->table('promotions')->select('tauxPromo')->distinct()->get()->getResult();
            
            foreach($tousLesTaux as $t) {
                // On ajoute le taux s'il n'est pas déjà dans la liste
                // (string) pour s'assurer que la comparaison fonctionne bien
                if (!in_array((string)$t->tauxPromo, $promos)) {
                    $promos[] = (string)$t->tauxPromo;
                }
            }
        }

        // --- LOGIQUE DE "DÉCOCHAGE" ---
        // On cherche les séries qui étaient cochées (old) mais ne le sont plus (current)
        $seriesUnchecked = array_diff($oldSeriesFull, $seriesFull);
        
        if (!empty($seriesUnchecked)) {
            // On récupère les ID des extensions de ces séries décochées
            $idsToRemove = $db->table('extensions')
                              ->whereIn('id_serie', $seriesUnchecked)
                              ->select('id')
                              ->get()->getResultArray();
            
            // On extrait juste les IDs (tableau simple)
            $idsToRemove = array_column($idsToRemove, 'id');
            
            // On retire ces extensions de la liste des extensions cochées ($exts)
            $exts = array_diff($exts, $idsToRemove);
        }

        // --- LOGIQUE "TOUTE LA SÉRIE" (AJOUT) ---
        if (!empty($seriesFull)) {
            $extensionsDeCesSeries = $db->table('extensions')
                                        ->whereIn('id_serie', $seriesFull)
                                        ->select('id')
                                        ->get()->getResult();
            
            foreach($extensionsDeCesSeries as $e) {
                if (!in_array($e->id, $exts)) {
                    $exts[] = $e->id;
                }
            }
        }

        // --- 3. PRÉPARATION DONNÉES SIDEBAR (Séries & Extensions) ---
        // On récupère toutes les séries
        $rawSeries = $db->table('series')->orderBy('id', 'DESC')->get()->getResult();
        // On récupère toutes les extensions
        $rawExts   = $db->table('extensions')->orderBy('id', 'DESC')->get()->getResult();

        // On organise ça en tableau hiérarchique : Série -> [Extensions]
        $seriesMap = [];
        foreach($rawSeries as $s) {
            $seriesMap[$s->id] = [
                'info' => $s,
                'extensions' => []
            ];
        }
        foreach($rawExts as $e) {
            if(isset($seriesMap[$e->id_serie])) {
                $seriesMap[$e->id_serie]['extensions'][] = $e;
            }
        }

        // --- 4. CONSTRUCTION REQUÊTE PRODUITS ---
        $model->select('produits.*, promotions.tauxPromo');
        $model->join('promotions', 'promotions.idPromo = produits.id_promo', 'left');

        if (!empty($q)) {
            $model->groupStart()->like('nom', $q)->orLike('description', $q)->groupEnd();
        }
        if (!empty($types)) { $model->whereIn('type_produit', $types); }
        if (!empty($raretes)) { $model->whereIn('rarete', $raretes); }
        
        // FILTRE PROMO
        if (!empty($promos)) {
            $model->whereIn('promotions.tauxPromo', $promos);
        }

        // NOUVEAU FILTRE EXTENSION
        if (!empty($exts)) {
            $model->whereIn('id_extension', $exts);
        }

        // --- 5. TRI ---
        switch ($tri) {
            case 'prix_asc': $model->orderBy('prix', 'ASC'); break;
            case 'prix_desc': $model->orderBy('prix', 'DESC'); break;
            case 'pop_desc': $model->orderBy('nb_ventes', 'DESC'); break;
            case 'promo_desc': $model->orderBy('promotions.tauxPromo', 'DESC'); break;
            default: $model->orderBy('produits.id', 'DESC'); break;
        }

        // --- MODIFICATION POUR PAGINATION ---
        // Au lieu de findAll(), on utilise paginate(nombre_par_page)
        // Disons 12 produits par page (c'est un bon chiffre pour des grilles de 3 ou 4 colonnes)
        $data = [
            'results' => $model->paginate(20), // 20 produits par page
            'pager'   => $model->pager,        
            'seriesMap' => $seriesMap,
            'filters' => [
                'q' => $q, 'type' => $types, 'rarete' => $raretes, 'tri' => $tri, 'promo' => $promos, 
                'ext' => $exts, 
                'series_full' => $seriesFull,
                'all_promos' => $allPromos
            ]
        ];

        return view_theme('search_result', $data);
    }

    public function getlistepromotions(){
        $model = new ProductModel();

        // Récupération des filtres GET
        $type = $this->request->getGet('type');
        $tri  = $this->request->getGet('tri');

        // Base query : uniquement les produits en promo
        $model->where('promotion IS NOT NULL')
            ->where('promotion >', 0);

        // Filtre TYPE
        if (!empty($type)) {
            $model->where('type_produit', $type);
        }

        // TRI
        switch ($tri) {
            case 'prix_asc':
                $model->orderBy('prix', 'ASC');
                break;

            case 'prix_desc':
                $model->orderBy('prix', 'DESC');
                break;

            case 'promo_desc':
                $model->orderBy('promotion', 'DESC');
                break;
        }

        $results = $model->findAll();

        return view('promotions', [
            'results' => $results,
            'filters' => [
                'type' => $type,
                'tri'  => $tri
            ]
        ]);
    }


}