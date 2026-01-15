<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersModel;

/**
 * Contrôleur gérant la création de compte
 */
class Inscription extends BaseController
{
    public function index()
    {
        helper(['form']);
        return view('auth/inscription');
    }

    public function register()
    {
        helper(['form']);
        $userModel = new UsersModel();

        // 1. Récupération des règles centralisées dans le Modèle
        $rules = $userModel->getRegisterRules();
       

        // 2. Création des messages d'erreur personnalisés
        $messages = [
            'login' => [
                'required' => 'Veuillez entrer votre pseudo',
                'min_length' => 'Votre pseudo doit comporter au moins 3 caractères',
                'is_unique' => 'Désolé, ce pseudo est déjà utilisé par un autre joueur.'
            ],
            'prenom' => [
                'required' => 'Veuillez entrer votre prénom',
                'min_length' => 'Votre prénom doit faire au minimum 2 caractères'
            ],
            'nom' => [
                'required' => 'Veuillez entrer votre nom.',
                'min_length' => 'Votre nom doit faire minimum 2 caractères'
            ],
            'email' => [
                'required' => 'Veuillez entrer votre adresse email',
                'valid_email' => 'Adresse email invalide',
                'is_unique' => 'Adresse mail déjà utilisée'
            ],
            'password' => [
                'required' => 'Veuillez entrer votre mot de passe',
                'min_length' => 'Le mot de passe doit faire minimum 6 caractères'
            ],
            'verify_password' => [
                'required' => 'Veuillez vérifier votre mot de passe.',
                'matches'  => 'Les mots de passe ne sont pas identiques'
            ],
            'cgu' => [
                'required' => 'Veuillez accepter les conditions générales d\'utilisation pour finaliser votre inscription.'
            ]
        ];

        // 3. Validation avec les messages
        if (! $this->validate($rules, $messages)) {
            return view('auth/inscription', [
                'validation' => $this->validator
            ]);
        }

        // 4. Validation
        if (! $this->validate($rules)) {
            return view('auth/inscription', [
                'validation' => $this->validator
            ]);
        }

        try {
            // 5. Construction fluide de l'utilisateur
            $success = $userModel->newUser()
                ->withCredentials(
                    $this->request->getPost('login'),
                    $this->request->getPost('password')
                )
                ->withIdentity(
                    $this->request->getPost('nom'),
                    $this->request->getPost('prenom'),
                    $this->request->getPost('email'),
                    $this->request->getPost('adresse')
                )
                ->create();

            if ($success) {
                return redirect()->to('/connexion')->with('success', 'Inscription réussie ! Connectez-vous.');
            } else {
                return redirect()->back()->withInput()->with('msg', 'Erreur lors de la sauvegarde.');
            }

        } catch (\Exception $e) {
            log_message('error', '[INSCRIPTION] ' . $e->getMessage());
            return redirect()->back()->withInput()->with('msg', 'Une erreur technique est survenue.');
        }
    }
}