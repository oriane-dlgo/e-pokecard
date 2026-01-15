<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\CommandesModel;

/**
 * Contrôleur gérant le profil utilisateur et son historique
 */
class Profil extends BaseController
{
    /**
     * Affiche le dashboard utilisateur
     */
    public function index()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/connexion');
        }

        $userId = $session->get('id');
        
        $userModel = new UsersModel();
        $commandeModel = new CommandesModel();

        // Récupération des données encapsulées dans les modèles
        $user = $userModel->find($userId);
        $commandes = $commandeModel->getHistoriqueWithCount($userId);

        $data = [
            'user'      => $user,
            'commandes' => $commandes
        ];

        return view('utilisateur/profil', $data);
    }

    /**
     * Formulaire d'édition de profil
     */
    public function edit()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/connexion');
        }

        $userModel = new UsersModel();
        $user = $userModel->find($session->get('id'));

        if (!$user) {
            $session->destroy();
            return redirect()->to('/connexion');
        }

        return view('utilisateur/modif', ['user' => $user]);
    }

    /**
     * Traitement de la mise à jour
     */
    public function update()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/connexion');
        }

        $userId = $session->get('id');
        $userModel = new UsersModel();

        // 1. Récupération des règles de validation (Gestion email unique complexe)
        $rules = $userModel->getUpdateRules($userId);

        // 2. Validation
        if (!$this->validate($rules)) {
            return view('utilisateur/modif', [
                'user'       => $userModel->find($userId),
                'validation' => $this->validator
            ]);
        }

        // 3. Update
        $dataToUpdate = [
            'nom'     => $this->request->getPost('nom'),
            'prenom'  => $this->request->getPost('prenom'),
            'email'   => $this->request->getPost('email'),
            'adresse' => $this->request->getPost('adresse'),
        ];

        $userModel->update($userId, $dataToUpdate);

        // 4. Mise à jour session & Redirect
        $session->set('user_name', $dataToUpdate['nom']);
        return redirect()->to('/profil')->with('success', 'PROFIL MIS À JOUR AVEC SUCCÈS !');
    }

    /**
     * Affiche le détail d'une commande spécifique
     */
    public function details($idCommande)
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/connexion');
        }

        $userId = $session->get('id');
        $commandeModel = new CommandesModel();
        
        // 1. Sécurité : On vérifie que la commande appartient bien au user connecté
        $commande = $commandeModel->getCommandeUtilisateur($idCommande, $userId);

        if (!$commande) {
            return redirect()->to('/profil')->with('error', 'Commande introuvable ou accès refusé.');
        }

        // 2. Récupération des articles de la commande
        $lignesModel = new \App\Models\LignesCommandeModel();
        $lignes = $lignesModel->getDetailsCommande($idCommande);

        return view('utilisateur/details_commande', [
            'commande' => $commande,
            'lignes'   => $lignes
        ]);
    }
}