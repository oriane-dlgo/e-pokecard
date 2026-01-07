<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Search extends BaseController
{
    public function index()
    {
        $model = new ProductModel();
        
        // 1. Récupération des filtres depuis l'URL (GET)
        $search   = $this->request->getGet('q');
        $type     = $this->request->getGet('type');
        $rarete   = $this->request->getGet('rarete');
        $tri      = $this->request->getGet('tri'); // prix_asc, prix_desc
        
        // 2. Construction de la requête
        // On commence par "tout sélectionner"
        $model->select('*');

        // Filtre par nom (Recherche textuelle)
        if (!empty($search)) {
            $model->like('nom', $search);
        }

        // Filtre par Type (Carte, Booster, etc.)
        if (!empty($type)) {
            $model->where('type_produit', $type);
        }

        // Filtre par Rareté
        if (!empty($rarete)) {
            $model->where('rarete', $rarete);
        }

        // Tri
        if ($tri === 'prix_asc') {
            $model->orderBy('prix', 'ASC');
        } elseif ($tri === 'prix_desc') {
            $model->orderBy('prix', 'DESC');
        } else {
            $model->orderBy('id', 'DESC'); // Par défaut : les plus récents
        }

        // 3. Exécution
        $results = $model->findAll();

        // 4. On renvoie les données à la vue
        $data = [
            'results' => $results,
            'filters' => [ // On renvoie les filtres pour pré-remplir le formulaire
                'q' => $search,
                'type' => $type,
                'rarete' => $rarete,
                'tri' => $tri
            ]
        ];

        return view_theme('search_result', $data);
    }
}