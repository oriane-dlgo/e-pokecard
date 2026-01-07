<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Profil extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/connexion');
        }

        $userModel = new UsersModel();
        $db = \Config\Database::connect(); // Connexion directe pour les requêtes simples

        $userId = $session->get('id');
        
        // 1. Infos User
        $data['user'] = $userModel->find($userId);

        // 2. Récupérer les commandes (Du plus récent au plus vieux)
        // On récupère aussi le nombre d'articles par commande pour l'affichage
        $query = $db->table('commandes')
                    ->select('commandes.*, COUNT(lignes_commande.id) as nb_articles')
                    ->join('lignes_commande', 'lignes_commande.commande_id = commandes.id', 'left')
                    ->where('id_user', $userId)
                    ->groupBy('commandes.id')
                    ->orderBy('date_creation', 'DESC')
                    ->get();

        $data['commandes'] = $query->getResult(); // On renvoie un tableau d'objets

        return view_theme('display_profil', $data);
    }

    public function edit()
    {
        $session = session();
        
        // 1. Sécurité : Si pas connecté, oust !
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/connexion');
        }

        $userModel = new UsersModel();
        $userId = $session->get('id');

        // 2. On récupère les infos actuelles de l'utilisateur
        // C'est indispensable pour que les champs 'value' du formulaire soient remplis
        $user = $userModel->find($userId);

        // Petite sécurité si l'user n'existe plus en BDD
        if (!$user) {
            return redirect()->to('/deconnexion');
        }

        $data = [
            'user' => $user
        ];

        // 3. On affiche la vue d'édition
        // Note : J'utilise view() standard comme dans ta fonction update()
        return view_theme('edit_profil', $data);
    }

    public function update()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/connexion');
        }

        $userModel = new UsersModel();
        $userId = $session->get('id');

        // 1. Validation (Email unique sauf si c'est le mien)
        // L'astuce "is_unique[users.email,id,{id}]" permet de garder son propre email
        $rules = [
            'nom'      => 'required|min_length[2]',
            'prenom'   => 'required|min_length[2]',
            'email'    => "required|valid_email|is_unique[users.email,id,$userId]",
            'adresse'  => 'permit_empty|min_length[5]'
        ];

        if (!$this->validate($rules)) {
            // Si erreur, on retourne au formulaire avec les erreurs
            return view_theme('edit_profil', [
                'user' => $userModel->find($userId),
                'validation' => $this->validator
            ]);
        }

        // 2. Préparation des données
        $data = [
            'id'      => $userId, // Important pour que save() fasse un update
            'nom'     => $this->request->getPost('nom'),
            'prenom'  => $this->request->getPost('prenom'),
            'email'   => $this->request->getPost('email'),
            'adresse' => $this->request->getPost('adresse'),
        ];

        // 3. Sauvegarde
        $userModel->save($data);

        // 4. Mise à jour de la Session (Si le nom a changé, le Header doit changer)
        $session->set('user_name', $data['nom']);
        
        // 5. Redirection avec message vert
        $session->setFlashdata('success', 'PROFIL MIS À JOUR AVEC SUCCÈS !');
        return redirect()->to('/profil');
    }
}