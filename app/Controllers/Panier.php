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

        $userId = $session->get('id');
        $db = \Config\Database::connect();
        $userExists = $db->table('users')->where('id', $userId)->countAllResults();

        if ($userExists == 0) {
            $session->destroy();
            return redirect()->to('/connexion')->with('msg', 'Session expirée, veuillez vous reconnecter.');
        }

        // 2. Vérifier si panier vide
        $panier = $session->get('panier');
        if (empty($panier)) {
            return redirect()->to('/panier');
        }

        $productModel = new ProductModel();

        // Vérification des stocks
        foreach ($panier as $idProduit => $qty) {
            $produit = $productModel->find($idProduit);
            $stockActuel = is_array($produit) ? $produit['stock'] : $produit->stock;
            $nomProduit  = is_array($produit) ? $produit['nom'] : $produit->nom;

            if ($qty > $stockActuel) {
                $session->setFlashdata('msg', "Stock insuffisant pour : $nomProduit (Restant : $stockActuel)");
                return redirect()->to('/panier');
            }
        }

        $db->transStart();

        try {
            $total = 0;
            $lignesAInserer = [];

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
            // IMPORTANT : Ici on met statut 'attente' car le paiement n'est pas encore fait
            $dataCommande = [
                'id_user' => $session->get('id'),
                'total'   => $total,
                'statut'  => 'attente'
            ];

            $db->table('commandes')->insert($dataCommande);
            $commandeId = $db->insertID();

            // 5. Insertion Lignes ET Mise à jour du Stock
            foreach ($lignesAInserer as $ligne) {
                $dataLigne = [
                    'commande_id'   => $commandeId,
                    'product_id'    => $ligne['product_id'],
                    'quantite'      => $ligne['quantite'],
                    'prix_unitaire' => $ligne['prix_unitaire']
                ];
                $db->table('lignes_commande')->insert($dataLigne);

                $db->table('produits')
                    ->where('id', $ligne['product_id'])
                    ->decrement('stock', $ligne['quantite']);
            }

            $db->transComplete();

            // --- LE CHANGEMENT EST ICI ---
            // 6. Nettoyage et Redirection vers le CHOIX du paiement
            $session->remove('panier');

            // On ne va pas à la confirmation, on va vers la page de paiement
            return redirect()->to('/paiement/choix/' . $commandeId);

        } catch (\Exception $e) {
            return redirect()->to('/panier')->with('msg', 'Erreur technique lors de la commande.');
        }
    }
}