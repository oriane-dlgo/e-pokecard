<?php

namespace App\Controllers;

use App\Models\UsersModel;

/**
 * Contrôleur gérant l'authentification (Login / Logout)
 */
class Connexion extends BaseController
{
    /**
     * Affiche le formulaire de connexion
     */
    public function index()
    {
        // UX : Si déjà connecté, on redirige vers l'accueil
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        return view('auth/connexion');
    }

    /**
     * Traite la soumission du formulaire de connexion
     */
    public function auth()
    {
        $session = session();
        
        // 1. Validation des champs pour économiser une requête SQL
        $rules = [
            'login'    => 'required',
            'password' => 'required'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('msg', 'Veuillez remplir tous les champs.');
        }

        // 2. Récupération de l'utilisateur via le Modèle
        $model = new UsersModel();
        $user = $model->getUserByLogin($this->request->getPost('login'));

        // 3. Vérification du mot de passe haché
        if ($user && password_verify($this->request->getPost('password'), $user->password)) {

            // Sauvegarde du panier actuel 
            $panierSauvegarde = $session->get('panier');
            
            // 4. Initialisation de la session
            $ses_data = [
                'id'         => $user->id,
                'user_name'  => $user->nom,
                'user_role'  => $user->role,
                'isLoggedIn' => true
            ];
            $session->set($ses_data);

            // Si l'invité avait un panier, on le réinject dans la session
            if (!empty($panierSauvegarde)) {
                $session->set('panier', $panierSauvegarde);
            }

            // Redirection spécifique pour les admins
            if($user->role === 'admin') {
                return redirect()->to('/admin/dashboard')->with('success', 'Bonjour Administrateur ' . $user->prenom);
            }

            return redirect()->to('/')->with('success', 'Ravi de vous revoir, ' . $user->prenom . ' !');
            
        } else {
            // 5. Échec de connexion
            $session->setFlashdata('msg', 'Identifiant ou mot de passe incorrect.');
            return redirect()->to('/connexion')->withInput();
        }
    }

    /**
     * Déconnecte l'utilisateur et détruit la session
     */
    public function deconnexion()
    {
        session()->destroy();
        return redirect()->to('/')->with('success', 'Vous avez été déconnecté avec succès.');
    }
}