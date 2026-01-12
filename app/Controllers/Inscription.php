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

        // 2. Validation
        if (! $this->validate($rules)) {
            return view('auth/inscription', [
                'validation' => $this->validator
            ]);
        }

        try {
            // 3. Construction fluide de l'utilisateur
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
                ->create();

            if ($success) {
                return redirect()->to('/connexion')->with('success', 'Inscription réussie ! Connectez-vous.');
            } else {
                return redirect()->back()->withInput()->with('msg', 'Erreur lors de la sauvegarde.');
            }

        } catch (\Exception $e) {
            // 4. Log serveur pour débogage et message générique pour l'user
            log_message('error', '[INSCRIPTION] ' . $e->getMessage());
            return redirect()->back()->withInput()->with('msg', 'Une erreur technique est survenue.');
        }
    }
}