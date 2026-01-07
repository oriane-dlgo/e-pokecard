<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Commande extends BaseController
{
    public function confirmation($idCommande)
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/connexion');
        }

        $db = \Config\Database::connect();
        
        // 1. Récupérer les infos de la commande
        $commande = $db->table('commandes')
                       ->where('id', $idCommande)
                       ->where('id_user', $session->get('id')) // Sécurité : on vérifie que c'est bien SA commande
                       ->get()
                       ->getRow();

        if (!$commande) {
            return redirect()->to('/profil')->with('msg', 'Commande introuvable.');
        }

        // 2. Récupérer les lignes (produits)
        $lignes = $db->table('lignes_commande')
                     ->join('produits', 'produits.id = lignes_commande.product_id')
                     ->where('commande_id', $idCommande)
                     ->get()
                     ->getResult();

        $data = [
            'commande' => $commande,
            'lignes'   => $lignes
        ];

        return view_theme('confirmation', $data);
    }
}