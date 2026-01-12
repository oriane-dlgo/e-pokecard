<?php

namespace App\Controllers;

use App\Models\ProductModel;

use App\Libraries\ProductDecorator\ConcreteProduct;
use App\Libraries\ProductDecorator\PromoDecorator;

/**
 * Contrôleur du moteur de recherche avancé
 */
class Search extends BaseController
{
    public function index()
    {
        $model = new ProductModel();

        // --- 1. RÉCUPÉRATION DES PARAMÈTRES ---
        $q            = $this->request->getGet('q');
        $tri          = $this->request->getGet('tri');
        
        // Normalisation en tableau pour gérer les cases multiples
        $types        = $this->normalizeArray($this->request->getGet('type'));
        $raretes      = $this->normalizeArray($this->request->getGet('rarete'));
        $promos       = $this->normalizeArray($this->request->getGet('promo'));
        $exts         = $this->normalizeArray($this->request->getGet('ext'));
        
        // Paramètres de gestion d'état (Cocher/Décocher tout)
        $seriesFull   = $this->normalizeArray($this->request->getGet('series_full'));
        $oldSeriesFull= $this->normalizeArray($this->request->getGet('old_series_full'));
        $allPromos    = $this->request->getGet('all_promos');
        $oldAllPromos = $this->request->getGet('old_all_promos');

        // --- 2. LOGIQUE INTELLIGENTE (Calcul des filtres à appliquer) ---
        
        // A. Gestion Promos (Coche/Décoche global)
        if (!empty($oldAllPromos) && empty($allPromos)) {
            $promos = []; 
        } elseif (!empty($allPromos)) {
            $tousLesTaux = $model->getAllPromoRates();
            $promos = array_unique(array_merge($promos, $tousLesTaux));
        }

        // B. Gestion Séries (Retrait des extensions si série décochée)
        $seriesUnchecked = array_diff($oldSeriesFull, $seriesFull);
        if (!empty($seriesUnchecked)) {
            $idsToRemove = $model->getExtensionIdsBySeries($seriesUnchecked);
            $exts = array_diff($exts, $idsToRemove);
        }

        // C. Gestion Séries (Ajout des extensions si série cochée)
        if (!empty($seriesFull)) {
            $idsToAdd = $model->getExtensionIdsBySeries($seriesFull);
            $exts = array_unique(array_merge($exts, $idsToAdd));
        }

        // --- 3. RECHERCHE ---
        $filters = [
            'q' => $q, 
            'type' => $types, 
            'rarete' => $raretes, 
            'promo' => $promos, 
            'ext' => $exts, 
            'tri' => $tri
        ];

        $data = [
            'results'   => $model->searchProducts($filters, 18),
            'pager'     => $model->pager,
            'seriesMap' => $model->getSeriesMap(), // Pour la sidebar
            'filters'   => array_merge($filters, [
                'series_full'    => $seriesFull,
                'old_series_full'=> $seriesFull,
                'all_promos'     => $allPromos,
                'old_all_promos' => $allPromos
            ])
        ];

        return view('magasin/recherche', $data);
    }

    /**
     * Helper : Assure qu'une entrée GET est toujours un tableau
     */
    private function normalizeArray($input): array
    {
        if (empty($input)) return [];
        return is_array($input) ? $input : [$input];
    }
}