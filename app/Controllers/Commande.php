<?php

namespace App\Controllers;

use App\Models\CommandesModel;
use App\Models\LignesCommandeModel;
use App\Models\UsersModel;

/**
 * Contrôleur gérant l'affichage post-commande
 */
class Commande extends BaseController
{
    /**
     * Affiche la page de confirmation d'une commande spécifique.
     * Accessible uniquement si l'utilisateur est connecté et propriétaire de la commande.
     *
     * @param int $idCommande
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     */
    public function confirmation($idCommande)
    {
        $session = session();

        // 1. Sécurité : Connexion requise
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/connexion');
        }

        $commandeModel = new CommandesModel();
        $lignesModel = new LignesCommandeModel();
        $userModel = new UsersModel();


        // Récupération adresse
        $user = $userModel->find($session->get('id'));
        $adresse = $user->adresse;

        // 2. Récupérer la commande (Vérification propriétaire incluse dans le modèle)
        $commande = $commandeModel->getCommandeUtilisateur($idCommande, $session->get('id'));

        if (!$commande) {
            return redirect()->to('/profil')->with('msg', 'Commande introuvable ou accès refusé.');
        }

        // 3. Récupérer le détail des produits achetés
        $lignes = $lignesModel->getDetailsCommande($idCommande);

        // Frais livraison
        $frais = 3.00;
        $data = [
            'commande' => $commande,
            'lignes' => $lignes,
            'adresse' => $adresse,
            'frais' => $frais
        ];

        return view('confirmation/confirmation', $data);
    }
}
