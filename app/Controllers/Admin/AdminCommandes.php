<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CommandesModel;

class AdminCommandes extends BaseController
{
    /**
     * Liste des commandes avec filtres
     */
    public function index()
    {
        $model = new CommandesModel();

        // Récupération des filtres depuis l'URL
        $filters = [
            'q'      => $this->request->getGet('q'),
            'statut' => $this->request->getGet('statut')
        ];

        $data = [
            // 1. Appel de la méthode du modèle (qui fait les JOIN)
            // 2. Tri par date décroissante
            // 3. Pagination (10 par page)
            'commandes' => $model->getCommandesAvecClient($filters)
                                 ->orderBy('commandes.date_creation', 'DESC')
                                 ->paginate(10),
                                 
            'pager'     => $model->pager,
            'filters'   => $filters
        ];

        return view('admin/Commandes/index', $data);
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

        return view('admin/Commandes/details', $data);
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

    /**
     * Affiche le formulaire de création de commande
     */
    public function ajouter()
    {
        if (session()->get('user_role') !== 'admin') { return redirect()->to('/'); }
        
        // On aura besoin de la liste des utilisateurs pour choisir le client
        $userModel = new \App\Models\UsersModel();
        $data['users'] = $userModel->findAll();

        return view('admin/Commandes/creation', $data);
    }

    /**
     * Enregistre une nouvelle commande (Simplifiée pour l'instant)
     */
    public function save()
    {
        if (session()->get('user_role') !== 'admin') { return redirect()->to('/'); }

        $db = \Config\Database::connect();
        $model = new CommandesModel();

        $id_user = $this->request->getPost('id_user');
        $total = $this->request->getPost('total');
        
        // Création de la commande
        $data = [
            'id_user' => $id_user,
            'date_creation' => date('Y-m-d H:i:s'),
            'statut' => 'validee', // Par défaut validée si créée par admin
            'total' => $total
        ];

        $model->insert($data);
        
        // Note: L'ajout des lignes de produits se ferait ici dans une version complète
        
        return redirect()->to('/admin/commandes')->with('msg', 'COMMANDE CRÉÉE MANUELLEMENT.');
    }
}