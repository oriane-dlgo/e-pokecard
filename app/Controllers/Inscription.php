<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Inscription extends BaseController
{
    public function index()
    {
        // On charge le helper form pour gérer les erreurs proprement
        helper(['form']);
        return view_theme('inscription');
    }

    public function register()
    {
        helper(['form']);
        
        // 1. Définition des règles de validation
        $rules = [
            'login'    => 'required|min_length[3]|max_length[20]|is_unique[users.login]',
            'password' => 'required|min_length[4]|max_length[255]',
            'nom'      => 'required|min_length[2]',
            'prenom'   => 'required|min_length[2]',
            'email'    => 'required|valid_email|is_unique[users.email]',
        ];

        // 2. Si la validation échoue
        if (! $this->validate($rules)) {
            // On renvoie vers la vue avec les erreurs
            return view_theme('inscription', [
                'validation' => $this->validator
            ]);
        }

        // 3. Si tout est bon, on sauvegarde
        $userModel = new UsersModel();

        $newData = [
            'login'    => $this->request->getPost('login'),
            'password' => $this->request->getPost('password'), // Note: En prod, on utiliserait password_hash() ici
            'nom'      => $this->request->getPost('nom'),
            'prenom'   => $this->request->getPost('prenom'),
            'email'    => $this->request->getPost('email'),
            'role'     => 'client' // Par défaut, tout le monde est client
        ];

        $userModel->save($newData);

        // 4. Redirection vers la connexion avec un message de succès
        $session = session();
        $session->setFlashdata('success', 'Inscription réussie ! Connectez-vous.');
        
        return redirect()->to('/connexion')->with('success', 'Inscription réussie ! Connectez-vous.');
    }
}