<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profil extends BaseController
{
    public function index()
    {
        $session = session();

        // 1. Sécurité : Si le mec n'est pas connecté, on le vire
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/connexion');
        }

        // 2. Récupération des infos fraiches depuis la BDD
        // (On ne se fie pas qu'à la session, car l'utilisateur a pu changer son nom entre temps)
        $userModel = new UserModel();
        $userId = $session->get('id');
        
        $data['user'] = $userModel->find($userId);

        // 3. (Optionnel pour plus tard) On récupérera ici les commandes
        // $commandeModel = new CommandeModel();
        // $data['commandes'] = $commandeModel->where('id_user', $userId)->findAll();

        return view('display_profil', $data);
    }
}