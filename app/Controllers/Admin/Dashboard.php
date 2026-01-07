<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        // On vérifie (redondance de sécurité)
        if (session()->get('user_role') !== 'admin') {
            return redirect()->to('/');
        }

        $db = \Config\Database::connect();

        // Quelques stats pour l'accueil
        $data = [
            'count_produits' => $db->table('produits')->countAll(),
            'count_users'    => $db->table('users')->countAll(),
            'count_orders'   => $db->table('commandes')->countAll(),
            // Commandes en attente (statut 'validee' mais pas encore traitée ?)
            'orders_pending' => $db->table('commandes')->where('statut', 'validee')->countAllResults()
        ];

        return view('admin/dashboard', $data);
    }
}