<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Inscription extends BaseController
{
    /**
     * Affiche le formulaire d'inscription
     */
    public function index()
    {
        // On charge le helper form pour gérer l'affichage des erreurs dans la vue
        helper(['form']);
        return view_theme('inscription');
    }

    /**
     * Traite la soumission du formulaire
     */
    public function register()
    {
        helper(['form']);

        // Définition des règles de validation
        // On s'assure que les données respectent le format attendu
        $rules = [
            'login'    => 'required|min_length[3]|max_length[20]|is_unique[users.login]',
            'password' => 'required|min_length[4]',
            'nom'      => 'required|min_length[2]',
            'prenom'   => 'required|min_length[2]',
            'email'    => 'required|valid_email|is_unique[users.email]',
        ];

        // Si la validation échoue, on recharge la vue avec les erreurs
        if (! $this->validate($rules)) {
            return view_theme('inscription', [
                'validation' => $this->validator
            ]);
        }

        $userModel = new UsersModel();

        try {
            // Construction fluide de l'utilisateur
            $success = $userModel->newUser()
                ->withCredentials(
                    $this->request->getPost('login'),
                    $this->request->getPost('password')
                )
                ->withIdentity(
                    $this->request->getPost('nom'),
                    $this->request->getPost('prenom'),
                    $this->request->getPost('email')
                )
                ->withRole('client') // On définit explicitement le rôle
                ->create();          // Exécute le save() final

            if ($success) {
                // 4. Redirection en cas de succès
                return redirect()->to('/connexion')->with('success', 'Inscription réussie ! Connectez-vous avec vos nouveaux identifiants.');
            } else {
                return redirect()->back()->withInput()->with('msg', 'Une erreur est survenue lors de la création du compte.');
            }

        } catch (\Exception $e) {
            // En cas d'erreur imprévue
            return redirect()->back()->withInput()->with('msg', 'Erreur système : ' . $e->getMessage());
        }
    }
}