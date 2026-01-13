<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CommandesModel;
use App\Models\UsersModel;

/**
 * Contrôleur gérant le Panier (Session) et la transformation en Commande
 */
class Panier extends BaseController
{
    /**
     * Affiche le contenu du panier
     */
    public function index()
    {
        $session = session();
        $panier = $session->get('panier') ?? [];
        $items = [];
        $total = 0;

        $productModel = new ProductModel();

        // 1. OPTIMISATION : On récupère tous les IDs d'un coup
        $ids = array_keys($panier);

        if (!empty($ids)) {
            // 2. UNE SEULE REQUÊTE SQL (WHERE id IN (1, 5, 12...))
            // On utilise getAvecDetails() pour avoir les promos et infos séries
            $produits = $productModel->getAvecDetails()
                                     ->whereIn('produits.id', $ids)
                                     ->findAll();

            // 3. ALGORITHME DE MAPPING (PHP)
            // On associe chaque produit trouvé à sa quantité en session
            foreach ($produits as $produit) {
                // On récupère la quantité depuis la session grâce à l'ID du produit
                if (isset($panier[$produit->id])) {
                    $qty = $panier[$produit->id];
                    
                    // On injecte la quantité directement dans l'objet (propriété dynamique)
                    $produit->quantite = $qty;

                    // Calcul du prix (gestion promo incluse via ton décorateur ou logique simple)
                    $prix = $produit->prix;
                    if (!empty($produit->tauxPromo)) {
                        $prix = $produit->prix * (1 - $produit->tauxPromo);
                    }
                    
                    $total += $prix * $qty;
                    $items[] = $produit;
                }
            }
        }

        // On passe les données à la vue
        return view('magasin/panier', [
            'items' => $items,
            'total' => $total
        ]);
    }

    /**
     * Ajoute un article au panier (Session)
     */
    public function ajouter()
    {
        $session = session();
        $panier = $session->get('panier') ?? [];
        $id = $this->request->getPost('id_produit');
        
        // Incrémentation ou initialisation
        if (isset($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        $session->set('panier', $panier);
        $session->setFlashdata('msg', 'Produit ajouté au panier !');

        return redirect()->back();
    }

    public function supprimer($id)
    {
        $session = session();
        $panier = $session->get('panier');

        if (isset($panier[$id])) {
            unset($panier[$id]);
            $session->set('panier', $panier);
        }

        return redirect()->to('/panier');
    }

    public function vider()
    {
        session()->remove('panier');
        return redirect()->to('/panier');
    }

    /**
     * Transforme le panier en Commande (Statut: Attente)
     * Vérifie les stocks et délègue la transaction SQL au Modèle
     */
    public function valider()
    {
        $session = session();

        // 1. Vérifications (Auth & Panier vide)
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/connexion')->with('msg', 'Veuillez vous connecter pour passer commande.');
        }
        
        $panier = $session->get('panier');
        if (empty($panier)) {
            return redirect()->to('/panier');
        }

        // 2. Vérification Session User (Au cas où l'user a été supprimé)
        $userModel = new UsersModel();
        if (!$userModel->find($session->get('id'))) {
            $session->destroy();
            return redirect()->to('/connexion')->with('msg', 'Session expirée.');
        }

        // 3. Vérification Préliminaire des Stocks (Feedback UX)
        $productModel = new ProductModel();
        foreach ($panier as $idProduit => $qty) {
            $produit = $productModel->find($idProduit);
            if ($qty > $produit->stock) {
                return redirect()->to('/panier')->with('msg', "Stock insuffisant pour : {$produit->nom} (Restant : {$produit->stock})");
            }
        }

        // 4. Transaction SQL via le Modèle
        $commandeModel = new CommandesModel();

        try {
            // 1. Initialisation de la chaîne
            $stockCheck = new StockCheckHandler();
            $orderCreate = new OrderCreationHandler();
            $stockUpdate = new StockUpdateHandler();
    
            // 2. Chaînage : Stock -> Création -> Update Stock
            $stockCheck->setNext($orderCreate)->setNext($stockUpdate);
    
            // 3. Lancement
            $context = [
                'userId' => session()->get('id'),
                'panier' => session()->get('panier')
            ];
            
            // Le résultat contient le contexte enrichi avec commandeId
            $resultContext = $stockCheck->handle($context); 
            $commandeId = $resultContext['commandeId'];
    
            // 4. Succès
            session()->remove('panier');
            return redirect()->to('/paiement/choix/' . $commandeId);
    
        } catch (\Exception $e) {
            return redirect()->to('/panier')->with('msg', 'Erreur : ' . $e->getMessage());
        }
    }
}