<?php

namespace App\Controllers;

use App\Models\UserModel;

class Connexion extends BaseController
{
    public function index()
    {
        // Charge le fichier qui est dans app/Views/connexion.php
        return view('connexion'); 
    }

    public function auth() {

        // 1. IMPORTANT : On démarre le service de session
        $session = session();

        // 1. On récupère les données du formulaire
        // Note: 'login' et 'password' sont les noms (name="") de tes input HTML
        $login = $this->request->getPost('login');
        $password = $this->request->getPost('password');

        // 2. DEBUG TEMPORAIRE : On affiche ce qu'on a reçu
        echo "<h1>Traitement de la connexion</h1>";
        echo "Login reçu : " . esc($login) . "<br>";
        echo "Mot de passe reçu : " . esc($password). "<br>";
        
        $model = new UserModel();
        // On cherche l'utilisateur en BDD
        $user = $model->where('login', $login)->first();

        // Si l'utilisateur existe ET que le mot de passe est bon
        if ($user && $user->password === $password) {
            
            // 2. On prépare les données à garder en mémoire
            $ses_data = [
                'id'    => $user->id,
                'user_name'=> $user->nom,
                'user_role'=> $user->role, // 'admin' ou 'client'
                'isLoggedIn' => true
            ];

            // 3. On écrit dans la session
            $session->set($ses_data);

            // 4. On redirige vers l'accueil (ou le tableau de bord)
            return redirect()->to('/');
        } else {
            // 5. Si c'est raté : on renvoie à la connexion avec une erreur
            $session->setFlashdata('msg', 'Mauvais identifiant ou mot de passe');
            return redirect()->to('/connexion');
        }

    }
}