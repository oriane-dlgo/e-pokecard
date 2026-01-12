<?php

namespace App\Controllers;

use App\Models\ProductModel;

use App\Libraries\ProductDecorator\ConcreteProduct;
use App\Libraries\ProductDecorator\PromoDecorator;

/**
 * Contrôleur de la page d'accueil (Vitrine)
 */
class Home extends BaseController
{
    /**
     * Affiche l'accueil avec Nouveautés, Promos et Best-Sellers
     */
    public function index()
    {
        $model = new ProductModel();
        $data = [];

        // --- A. LES NOUVEAUTÉS ---
        $rawNouveautes = $model->getAvecDetails()
                               ->orderBy('produits.id', 'DESC')
                               ->findAll(4);
        // On applique le décorateur pour gérer l'affichage du prix
        $data['nouveautes'] = $this->applyDecorator($rawNouveautes);


        // --- B. LES PROMOTIONS ---
        $rawPromotions = $model->getAvecDetails()
                               ->where('produits.id_promo IS NOT NULL')
                               ->findAll(3);
        $data['promotions'] = $this->applyDecorator($rawPromotions);


        // --- C. LES BEST-SELLERS ---
        $filter = $this->request->getGet('filter');

        if ($filter === 'week') {
            $rawBestsellers = $model->getBestSellersSemaine(4);
        } else {
            $rawBestsellers = $model->getAvecDetails()
                                    ->orderBy('nb_ventes', 'DESC')
                                    ->findAll(4);
        }
        $data['bestsellers'] = $this->applyDecorator($rawBestsellers);

        $data['current_filter'] = $filter;

        return view('magasin/accueil', $data);
    } 
    
    /**
     * Affiche le détail d'un produit
     */
    public function find(int $id)
    {
        $model = new ProductModel();
        $product = $model->find($id); // Attention: find() de base n'a pas les promos jointes ici
        
        // Pour le détail, il vaut mieux utiliser ta méthode getAvecDetails() pour avoir le tauxPromo
        // Sinon le décorateur ne saura pas qu'il y a une promo
        $productWithDetails = $model->getAvecDetails()->find($id);
    
        if (!$productWithDetails) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // On décore aussi le produit unique
        $decoratedArray = $this->applyDecorator([$productWithDetails]);
        
        return view('magasin/produit', ['product' => $decoratedArray[0]]);
    }   


    // -------------------------------------------------------------------------
    // MÉTHODE PRIVÉE POUR APPLIQUER LE PATTERN
    // -------------------------------------------------------------------------
    
    /**
     * Applique le Pattern Decorator sur une liste de produits.
     * Cette méthode injecte une propriété 'prix_html' dans chaque objet produit.
     * * @param array $products Liste d'objets produits
     * @return array Liste modifiée
     */
    private function applyDecorator(array $products): array
    {
        foreach ($products as $p) {
            // 1. On crée le composant de base (ConcreteProduct)
            $component = new ConcreteProduct($p);

            // 2. Si le produit a un taux de promo, on l'emballe dans le PromoDecorator
            // (C'est ici que la magie du pattern opère : on change le comportement dynamiquement)
            if (!empty($p->tauxPromo) && $p->tauxPromo > 0) {
                $component = new PromoDecorator($component, (float)$p->tauxPromo);
            }

            // 3. On demande au composant (décoré ou non) de nous donner le HTML du prix
            // On injecte ce HTML dans une nouvelle propriété temporaire de l'objet
            $p->prix_html = $component->getHtmlDisplay();
        }

        return $products;
    }
}