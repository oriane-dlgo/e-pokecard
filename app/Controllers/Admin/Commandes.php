<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CommandesModel;

class Commandes extends BaseController
{
    /**
     * Liste des commandes avec filtres
     */
    public function index()
    {
        if (session()->get('user_role') !== 'admin') { return redirect()->to('/'); }

        $db = \Config\Database::connect();

        $q = $this->request->getGet('q');
        $statut = $this->request->getGet('statut');

        $builder = $db->table('commandes')
            ->select('commandes.*, users.nom as client_nom, users.email as client_email')
            ->join('users', 'users.id = commandes.id_user')
            ->where('statut !=', 'panier');

        if (!empty($q)) {
            $builder->groupStart()
                ->like('users.nom', $q)
                ->orLike('commandes.id', $q)
                ->groupEnd();
        }

        if (!empty($statut)) {
            $builder->where('statut', $statut);
        }

        $query = $builder->orderBy('commandes.id', 'DESC')->get();

        $data = [
            'commandes' => $query->getResult(),
            'filters'   => ['q' => $q, 'statut' => $statut]
        ];

        return view('admin/commandes_list', $data);
    }

    /**
     * Détail d'une commande
     */
    public function detail($id_commande)
    {
        if (session()->get('user_role') !== 'admin') { return redirect()->to('/'); }

        $db = \Config\Database::connect();

        $commande = $db->table('commandes')
            ->select('commandes.*, users.nom, users.email, users.adresse')
            ->join('users', 'users.id = commandes.id_user')
            ->where('commandes.id', $id_commande)
            ->get()->getRow();

        if (!$commande) {
            return redirect()->to('/admin/commandes');
        }

        $lignes = $db->table('lignes_commande')
            ->select('lignes_commande.*, produits.nom, produits.image_url, produits.type_produit')
            ->join('produits', 'produits.id = lignes_commande.product_id')
            ->where('commande_id', $id_commande)
            ->get()->getResult();

        $data = [
            'c' => $commande,
            'lignes' => $lignes
        ];

        return view('admin/commandes_detail', $data);
    }

    /**
     * Mise à jour du statut avec création de Memento (Undo possible)
     */
    public function updateStatut()
    {
        if (session()->get('user_role') !== 'admin') { return redirect()->to('/'); }

        $model = new CommandesModel();
        $id = $this->request->getPost('id_commande');
        $statut = $this->request->getPost('statut');

        // 1. MEMENTO : On sauvegarde l'état actuel en session avant de modifier
        $model->saveMementoToSession($id);

        // 2. Mise à jour réelle en base de données
        $model->update($id, ['statut' => $statut]);

        // Préparation du message avec bouton d'annulation
        $undoUrl = base_url('admin/commandes/undo/' . $id);
        $message = "STATUT DE LA COMMANDE #$id MIS À JOUR. " .
            "<a href='$undoUrl' style='color:#FFCC00; text-decoration:underline; font-weight:bold; margin-left:10px;'>[ANNULER L'ACTION]</a>";

        return redirect()->back()->with('msg', $message);
    }

    /**
     * Action d'annulation (Restauration du Memento)
     */
    public function undo($id)
    {
        if (session()->get('user_role') !== 'admin') { return redirect()->to('/'); }

        $model = new CommandesModel();

        if ($model->restoreMementoFromSession($id)) {
            return redirect()->back()->with('msg', "ACTION ANNULÉE : La commande #$id a retrouvé son état précédent.");
        }

        return redirect()->back()->with('msg', "ERREUR : Impossible d'annuler (la session a peut-être expiré).");
    }
}