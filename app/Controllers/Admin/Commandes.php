<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Commandes extends BaseController
{
    public function index()
    {
        if (session()->get('user_role') !== 'admin') { return redirect()->to('/'); }

        $db = \Config\Database::connect();
        
        // 1. Récupération des filtres
        $q = $this->request->getGet('q');
        $statut = $this->request->getGet('statut');

        // 2. Construction de la requête
        $builder = $db->table('commandes')
                      ->select('commandes.*, users.nom as client_nom, users.email as client_email')
                      ->join('users', 'users.id = commandes.id_user')
                      ->where('statut !=', 'panier'); // On exclut toujours les paniers

        // Filtre Recherche (Nom Client OU ID Commande)
        if (!empty($q)) {
            $builder->groupStart() // Important pour les parenthèses SQL
                    ->like('users.nom', $q)
                    ->orLike('commandes.id', $q) // Permet de chercher "#12" juste en tapant "12"
                    ->groupEnd();
        }

        // Filtre Statut
        if (!empty($statut)) {
            $builder->where('statut', $statut);
        }

        // Tri et Exécution
        $query = $builder->orderBy('commandes.id', 'DESC')->get();

        $data = [
            'commandes' => $query->getResult(),
            'filters'   => ['q' => $q, 'statut' => $statut] // Pour pré-remplir le formulaire
        ];

        return view('admin/commandes_list', $data);
    }

    public function detail($id_commande)
    {
        if (session()->get('user_role') !== 'admin') { return redirect()->to('/'); }

        $db = \Config\Database::connect();

        // 1. Infos de la commande
        $commande = $db->table('commandes')
                       ->select('commandes.*, users.nom, users.email, users.adresse')
                       ->join('users', 'users.id = commandes.id_user')
                       ->where('commandes.id', $id_commande)
                       ->get()->getRow();

        if (!$commande) {
            return redirect()->to('/admin/commandes');
        }

        // 2. Contenu de la commande (Lignes de commande + Infos produits)
        $lignes = $db->table('lignes_commande')
                     ->select('lignes_commande.*, produits.nom, produits.image_url, produits.type_produit')
                     ->join('produits', 'produits.id = lignes_commande.product_id')
                     ->where('commande_id', $id_commande)
                     ->get()->getResult();

        $data = [
            'c' => $commande,
            'lignes' => $lignes
        ];

        return view('admin/commandes_detail', $data);
    }

    public function updateStatut()
    {
        if (session()->get('user_role') !== 'admin') { return redirect()->to('/'); }

        $db = \Config\Database::connect();
        $id = $this->request->getPost('id_commande');
        $statut = $this->request->getPost('statut');

        // Mise à jour
        $db->table('commandes')->where('id', $id)->update(['statut' => $statut]);

        return redirect()->back()->with('msg', 'STATUT DE LA COMMANDE MIS À JOUR.');
    }
}