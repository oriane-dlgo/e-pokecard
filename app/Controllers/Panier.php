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

        return view('panier', $data);
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
}