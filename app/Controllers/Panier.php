<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Panier extends BaseController
{
    public function index()
    {
        $session = session();
        // On récupère le panier (ou un tableau vide s'il n'existe pas)
        $panier = $session->get('panier') ?? [];

        $productModel = new ProductModel();
        $articles = [];
        $total = 0;

        // Si le panier n'est pas vide, on récupère les infos de chaque produit
        if (!empty($panier)) {
            foreach ($panier as $idProduit => $quantite) {
                // On cherche le produit en BDD
                $produit = $productModel->find($idProduit);
                
                if ($produit) {
                    // On calcule le sous-total pour cet article
                    $prixLigne = $produit->prix * $quantite;
                    $total += $prixLigne;

                    // On prépare les données pour la vue
                    $articles[] = [
                        'produit' => $produit,
                        'quantite' => $quantite,
                        'total_ligne' => $prixLigne
                    ];
                }
            }
        }

        $data = [
            'articles' => $articles,
            'total_global' => $total
        ];

        return view_theme('panier', $data);
    }

    public function ajouter()
    {
        $session = session();
        $panier = $session->get('panier') ?? [];

        // On récupère l'ID envoyé par le formulaire
        $id = $this->request->getPost('id_produit');
        
        // Logique : Si existe déjà, on augmente la quantité, sinon on crée à 1
        if (isset($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        // On sauvegarde
        $session->set('panier', $panier);
        
        // Petit message de succès
        $session->setFlashdata('msg', 'Produit ajouté au panier !');

        // On reste sur la même page (ou on va au panier)
        return redirect()->back();
    }

    public function supprimer($id)
    {
        $session = session();
        $panier = $session->get('panier');

        if (isset($panier[$id])) {
            unset($panier[$id]); // On retire l'élément du tableau
            $session->set('panier', $panier);
        }

        return redirect()->to('/panier');
    }

    public function vider()
    {
        session()->remove('panier');
        return redirect()->to('/panier');
    }

    public function valider()
    {
        $session = session();
        
        // 1. Vérifier si connecté
        if (!$session->get('isLoggedIn')) {
            $session->setFlashdata('msg', 'Veuillez vous connecter pour passer commande.');
            return redirect()->to('/connexion');
        }

        // --- AJOUT DE SECURITÉ ICI ---
        $userId = $session->get('id');
        // On vérifie si cet ID existe VRAIMENT encore en BDD
        $db = \Config\Database::connect();
        $userExists = $db->table('users')->where('id', $userId)->countAllResults();

        if ($userExists == 0) {
            // L'utilisateur n'existe plus en base (suite au reset)
            $session->destroy(); // On force la déco
            return redirect()->to('/connexion')->with('msg', 'Session expirée, veuillez vous reconnecter.');
        }
        // -----------------------------

        // 2. Vérifier si panier vide
        $panier = $session->get('panier');
        if (empty($panier)) {
            return redirect()->to('/panier');
        }

        $productModel = new ProductModel();
        // --- NOUVEAU : ETAPE DE VERIFICATION DES STOCKS (Avant de faire quoi que ce soit) ---
        foreach ($panier as $idProduit => $qty) {
            $produit = $productModel->find($idProduit);
            
            // On gère le cas Objet ou Tableau (sécurité)
            $stockActuel = is_array($produit) ? $produit['stock'] : $produit->stock;
            $nomProduit  = is_array($produit) ? $produit['nom'] : $produit->nom;

            // Si le client veut plus que ce qu'on a
            if ($qty > $stockActuel) {
                // On annule tout et on renvoie au panier avec une erreur rouge
                $session->setFlashdata('msg', "Stock insuffisant pour : $nomProduit (Restant : $stockActuel)");
                return redirect()->to('/panier');
            }
        }
        // ------------------------------------------------------------------------------------



        // On ouvre une "Transaction" (Sécurité BDD : soit tout marche, soit rien ne marche)
        $db->transStart();

        try {
            $total = 0;
            $lignesAInserer = [];

            // Calcul et Préparation
            foreach ($panier as $idProduit => $qty) {
                $produit = $productModel->find($idProduit);
                $prix = is_array($produit) ? $produit['prix'] : $produit->prix;
                
                $total += $prix * $qty;
                
                $lignesAInserer[] = [
                    'product_id'    => $idProduit,
                    'prix_unitaire' => $prix,
                    'quantite'      => $qty
                ];
            }

            // 4. Insertion Commande
            $dataCommande = [
                'id_user' => $session->get('id'),
                'total'   => $total,
                'statut'  => 'validee'
            ];
            
            $db->table('commandes')->insert($dataCommande);
            $commandeId = $db->insertID();

            // 5. Insertion Lignes ET Mise à jour du Stock
            foreach ($lignesAInserer as $ligne) {
                // A. On insère la ligne de commande
                $dataLigne = [
                    'commande_id'   => $commandeId,
                    'product_id'    => $ligne['product_id'],
                    'quantite'      => $ligne['quantite'],
                    'prix_unitaire' => $ligne['prix_unitaire']
                ];
                $db->table('lignes_commande')->insert($dataLigne);

                // B. --- NOUVEAU : ON DECREMENTE LE STOCK ---
                // On utilise une requête SQL directe pour être efficace : "stock = stock - x"
                $db->table('produits')
                   ->where('id', $ligne['product_id'])
                   ->decrement('stock', $ligne['quantite']);
                // -------------------------------------------
            }

            // On valide la transaction (Tout est bon !)
            $db->transComplete();

            // 6. Nettoyage et succès
            $session->remove('panier');
            $session->setFlashdata('success', 'COMMANDE VALIDÉE ! MERCI DRESSEUR !');
            
            return redirect()->to('/commande/confirmation/' . $commandeId);

        } catch (\Exception $e) {
            // En cas de pépin technique
            return redirect()->to('/panier')->with('msg', 'Erreur technique lors de la commande.');
        }
    }
}