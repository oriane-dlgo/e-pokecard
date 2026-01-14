<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CommandesModel;
use App\Models\UsersModel;

use App\Libraries\OrderChain\Handlers\OrderCreationHandler;
use App\Libraries\OrderChain\Handlers\StockCheckHandler;
use App\Libraries\OrderChain\Handlers\StockUpdateHandler;

/**
 * Contrôleur gérant le Panier (Session) et la transformation en Commande
 */
class Panier extends BaseController
{
    /**
     * Affiche le panier
     * FORMAT ATTENDU SESSION : [id_produit => quantite, id_produit => quantite]
     */
    public function index()
    {
        $session = session();
        $panier = $session->get('panier') ?? [];
        
        // --- 1. NETTOYAGE / MIGRATION DU FORMAT (Sécurité) ---
        // Si jamais on a un vieux format (liste simple [0 => id]), on le convertit
        if (!empty($panier) && array_values($panier) === $panier) {
             $newPanier = [];
             foreach($panier as $id) {
                 $newPanier[$id] = ($newPanier[$id] ?? 0) + 1;
             }
             $panier = $newPanier;
             $session->set('panier', $panier);
        }

        $articles = []; // Renommé pour correspondre à la Vue ($articles)
        $total_global = 0; // Renommé pour correspondre à la Vue ($total_global)

        $productModel = new ProductModel();
        
        // On récupère les clés (les IDs des produits)
        $ids = array_keys($panier);
        
        if (!empty($ids)) {
            // Requête SQL optimisée
            $produits = $productModel->getAvecDetails()
                                     ->whereIn('produits.id', $ids)
                                     ->findAll();

            // Construction du tableau pour la VUE
            foreach ($produits as $produit) {
                // On récupère la quantité depuis la session (dictionnaire)
                $qty = (int)($panier[$produit->id] ?? 1);

                // Gestion du prix (Promo ou Normal)
                $prixUnitaire = $produit->prix;
                if (!empty($produit->tauxPromo)) {
                    $prixUnitaire = $produit->prix * (1 - $produit->tauxPromo);
                }
                
                $totalLigne = $prixUnitaire * $qty;
                $total_global += $totalLigne;

                // STRUCTURE STRICTE ATTENDUE PAR TA VUE
                $articles[] = [
                    'produit'     => $produit,     // Pour $item['produit']->nom
                    'quantite'    => $qty,          // Pour $item['quantite']
                    'tva'         => round($totalLigne/1.2*0.2, 2),  // Pour afficher la TVA       
                    'total_ligne' => $totalLigne   // Pour $item['total_ligne']
                ];
            }
        }

        // On passe les variables avec les noms EXACTS de la vue
        return view('magasin/panier', [
            'articles'     => $articles,
            'total_global' => $total_global
        ]);
    }

    /**
     * Ajoute un produit au panier
     * FORMAT CIBLE : [id => qte]
     */
    public function ajouter()
    {
        $id = (int)$this->request->getPost('id_produit');
        $qty = (int)$this->request->getPost('quantite');
        if ($qty <= 0) $qty = 1;

        $session = session();
        $panier = $session->get('panier');

        // Initialisation ou conversion si format incorrect
        if (!is_array($panier) || ( !empty($panier) && array_values($panier) === $panier )) {
            $panier = []; 
            // Note: Si tu veux migrer les anciens paniers ici, tu peux, 
            // mais le plus simple est de repartir sur une base propre [id=>qty]
        }

        // Logique Dictionnaire : [ID => QTE]
        if (isset($panier[$id])) {
            $panier[$id] += $qty;
        } else {
            $panier[$id] = $qty;
        }

        $session->set('panier', $panier);

        return redirect()->to('/panier')->with('success', 'Produit ajouté !');
    }

    /**
     * Met à jour la quantité
     */
    public function update()
    {
        // On force le typage int pour être sûr des clés
        $id = (int)$this->request->getPost('id'); 
        $action = $this->request->getPost('action');
        
        $session = session();
        $panier = $session->get('panier');

        if (isset($panier[$id])) {
            if ($action === 'increase') {
                $panier[$id]++;
            } elseif ($action === 'decrease') {
                $panier[$id]--;
                if ($panier[$id] <= 0) {
                    unset($panier[$id]); // Suppression du dictionnaire
                }
            }
        }

        $session->set('panier', $panier);
        return redirect()->to('/panier');
    }

    /**
     * Supprime un article
     */
    public function supprimer($id)
    {
        $id = (int)$id; // Sécurité
        $session = session();
        $panier = $session->get('panier');

        // Suppression dans le dictionnaire
        if (isset($panier[$id])) {
            unset($panier[$id]);
        }

        $session->set('panier', $panier);
        return redirect()->to('/panier');
    }
    
    /**
     * Vide le panier
     */
    public function vider()
    {
        session()->remove('panier');
        return redirect()->to('/panier');
    }

    /**
     * Transforme le panier en Commande
     */
    public function valider()
    {
        $session = session();

        // 1. Vérifications
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/connexion')->with('msg', 'Veuillez vous connecter pour passer commande.');
        }
        
        $panier = $session->get('panier');
        if (empty($panier)) {
            return redirect()->to('/panier');
        }

        // 2. Vérification Session User
        $userModel = new UsersModel();
        if (!$userModel->find($session->get('id'))) {
            $session->destroy();
            return redirect()->to('/connexion')->with('msg', 'Session expirée.');
        }

        // 3. Vérification Préliminaire des Stocks
        $productModel = new ProductModel();
        
        // ICI : La boucle fonctionne bien car $panier est [id => qty]
        foreach ($panier as $idProduit => $qty) {
            $produit = $productModel->find($idProduit);
            if (!$produit || $qty > $produit->stock) {
                return redirect()->to('/panier')->with('msg', "Stock insuffisant pour : " . ($produit->nom ?? 'Produit inconnu'));
            }
        }

        // 4. Transaction SQL via Chain of Responsibility
        try {
            $stockCheck = new StockCheckHandler();
            $orderCreate = new OrderCreationHandler();
            $stockUpdate = new StockUpdateHandler();
    
            $stockCheck->setNext($orderCreate)->setNext($stockUpdate);
    
            $context = [
                'userId' => session()->get('id'),
                'panier' => $panier // On passe le dictionnaire complet
            ];
            
            $resultContext = $stockCheck->handle($context); 
            $commandeId = $resultContext['commandeId'];
    
            session()->remove('panier');
            return redirect()->to('/paiement/choix/' . $commandeId);
    
        } catch (\Exception $e) {
            return redirect()->to('/panier')->with('msg', 'Erreur : ' . $e->getMessage());
        }
    }
}