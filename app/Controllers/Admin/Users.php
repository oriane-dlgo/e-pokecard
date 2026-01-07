<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UsersModel;

class Users extends BaseController
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
        $data['users'] = $builder->orderBy('id', 'DESC')->findAll();
        
        $data['filters'] = ['q' => $q, 'role' => $role];

        return view('admin/user_list', $data);
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
}