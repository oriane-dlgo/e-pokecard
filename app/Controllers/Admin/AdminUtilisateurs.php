<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UsersModel;

class AdminUtilisateurs extends BaseController
{
    public function index()
    {
        if (session()->get('user_role') !== 'admin') { return redirect()->to('/'); }

        $model = new UsersModel();
        
        // 1. Récupération des filtres
        $q = $this->request->getGet('q');
        $role = $this->request->getGet('role');

        // 2. Construction de la requête
        $builder = $model->select('*'); // On prend tout

        // Filtre Recherche (Nom OU Prénom OU Email)
        if (!empty($q)) {
            $builder->groupStart()
                    ->like('nom', $q)
                    ->orLike('prenom', $q)
                    ->orLike('email', $q)
                    ->groupEnd();
        }

        // Filtre Rôle
        if (!empty($role)) {
            $builder->where('role', $role);
        }

        // 3. Tri et Exécution
        $data['users'] = $builder->orderBy('id', 'DESC')->paginate(10);
        $data['pager'] = $builder->pager;
        
        $data['filters'] = ['q' => $q, 'role' => $role];

        return view('admin/Utilisateurs/index', $data);
    }

    public function updateRole()
    {
        if (session()->get('user_role') !== 'admin') { return redirect()->to('/'); }

        $model = new UsersModel();
        $id = $this->request->getPost('user_id');
        $new_role = $this->request->getPost('role');

        // Sécurité : On empêche de modifier son propre rôle pour ne pas s'auto-exclure
        if ($id == session()->get('id')) {
            return redirect()->back()->with('error', 'IMPOSSIBLE DE MODIFIER VOTRE PROPRE RÔLE.');
        }

        $model->update($id, ['role' => $new_role]);

        return redirect()->back()->with('msg', 'RÔLE UTILISATEUR MIS À JOUR.');
    }

    public function delete($id)
    {
        if (session()->get('role') !== 'admin') { return redirect()->to('/'); }
        
        // Sécurité : On ne peut pas se supprimer soi-même
        if ($id == session()->get('user_id')) {
            return redirect()->back()->with('error', 'IMPOSSIBLE DE SUPPRIMER VOTRE PROPRE COMPTE ICI.');
        }

        $model = new UsersModel();
        $model->delete($id);

        return redirect()->back()->with('msg', 'UTILISATEUR SUPPRIMÉ DE LA BASE DE DONNÉES.');
    }

    /**
     * Affiche le formulaire d'ajout d'un utilisateur
     */
    public function ajouter()
    {
        if (session()->get('user_role') !== 'admin') { return redirect()->to('/'); }
        // La vue sera créée plus tard
        return view('admin/Utilisateurs/creation');
    }

    /**
     * Traite l'ajout d'un nouvel utilisateur
     */
    public function save()
    {
        if (session()->get('user_role') !== 'admin') { return redirect()->to('/'); }

        $validationRules = [
            'login'    => 'required|min_length[3]|is_unique[users.login]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'nom'      => 'required',
            'prenom'   => 'required',
            'role'     => 'required|in_list[client,admin]'
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $model = new UsersModel();
        
        // Hachage du mot de passe
        $passwordHash = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

        $data = [
            'login'    => $this->request->getPost('login'),
            'password' => $passwordHash,
            'email'    => $this->request->getPost('email'),
            'nom'      => $this->request->getPost('nom'),
            'prenom'   => $this->request->getPost('prenom'),
            'adresse'  => $this->request->getPost('adresse'),
            'cp'       => $this->request->getPost('cp'),
            'ville'    => $this->request->getPost('ville'),
            'role'     => $this->request->getPost('role')
        ];

        $model->insert($data);

        return redirect()->to('/admin/users')->with('msg', 'UTILISATEUR CRÉÉ AVEC SUCCÈS.');
    }
}