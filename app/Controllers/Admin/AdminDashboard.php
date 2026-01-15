<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class AdminDashboard extends BaseController
{
    public function index()
    {
        if (session()->get('user_role') !== 'admin') { return redirect()->to('/'); }

        $db = \Config\Database::connect();

        // 1. STATS GLOBALES
        // Total des ventes (somme des commandes validées/expédiées/terminées)
        $ca = $db->table('commandes')
                 ->whereIn('statut', ['validee', 'expediee', 'terminee'])
                 ->selectSum('total')
                 ->get()->getRow()->total;

        // Commandes en attente (Urgent)
        $pending = $db->table('commandes')
                      ->where('statut', 'validee')
                      ->countAllResults();

        // Produits en rupture ou stock faible (< 3)
        $lowStock = $db->table('produits')
                       ->where('stock <', 3)
                       ->countAllResults();

        // Nombre total d'utilisateurs
        $usersCount = $db->table('users')->countAllResults();

        // 2. 5 DERNIÈRES COMMANDES
        $latestOrders = $db->table('commandes')
                           ->select('commandes.*, users.nom as client_nom')
                           ->join('users', 'users.id = commandes.id_user')
                           ->orderBy('id', 'DESC')
                           ->limit(5)
                           ->get()->getResult();

        $data = [
            'ca' => $ca ?? 0,
            'pending' => $pending,
            'lowStock' => $lowStock,
            'usersCount' => $usersCount,
            'latestOrders' => $latestOrders
        ];

        return view('admin/Dashboard/index', $data);
    }
}