<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Connexion extends BaseController
{
    public function index()
    {
        // Affiche la vue de connexion (Retro ou standard selon ton dossier)
        return view_theme('connexion');
    }

    /**
     * Gère la tentative de connexion
     */
    public function auth()
    {
        $session = session();
        $model = new UsersModel();

        // 1. Récupération des identifiants
        $login    = $this->request->getPost('login');
        $password = $this->request->getPost('password');

        // 2. Recherche de l'utilisateur par son login
        $user = $model->where('login', $login)->first();

        // 3. Vérification de sécurité
        // password_verify déchiffre le hash stocké en BDD pour le comparer au texte saisi
        if ($user && password_verify($password, $user->password)) {

            // 4. Préparation des données de session (isLoggedIn est crucial)
            $ses_data = [
                'id'         => $user->id,
                'user_name'  => $user->nom,
                'user_role'  => $user->role, // 'admin' ou 'client'
                'isLoggedIn' => true
            ];

            $session->set($ses_data);

            // 5. Redirection vers l'accueil ou le tableau de bord
            return redirect()->to('/')->with('success', 'Ravi de vous revoir, ' . $user->prenom . ' !');
        } else {
            // 6. Échec : on renvoie à la connexion avec un message flash
            $session->setFlashdata('msg', 'Identifiant ou mot de passe incorrect.');
            return redirect()->to('/connexion')->withInput();
        }
    }

    /**
     * Déconnexion propre
     */
    public function deconnexion()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/')->with('success', 'Vous avez été déconnecté avec succès.');
    }
}