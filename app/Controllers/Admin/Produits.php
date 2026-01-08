<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;

class Produits extends BaseController
{
    public function index() 
    {
        if (session()->get('user_role') !== 'admin') { return redirect()->to('/'); }

        $model = new ProductModel();
        
        // 1. Récupération des filtres de recherche
        $q     = $this->request->getGet('q');
        $type  = $this->request->getGet('type');
        $stock = $this->request->getGet('stock');

        // 2. Récupération des paramètres de TRI (Nouveau !)
        $sort  = $this->request->getGet('sort') ?? 'id'; // Par défaut tri par ID
        $order = $this->request->getGet('order') ?? 'DESC'; // Par défaut décroissant

        // Sécurité pour éviter les injections SQL dans le tri
        $allowedSorts = ['id', 'nom', 'prix', 'stock', 'nb_ventes', 'type_produit'];
        if (!in_array($sort, $allowedSorts)) { $sort = 'id'; }
        if (!in_array(strtoupper($order), ['ASC', 'DESC'])) { $order = 'DESC'; }

        // 3. Construction de la requête
        $model->select('*');

        if (!empty($q)) {
            $model->like('nom', $q);
        }
        if (!empty($type)) {
            $model->where('type_produit', $type);
        }
        if ($stock === 'rupture') {
            $model->where('stock', 0);
        } elseif ($stock === 'faible') {
            $model->where('stock >', 0)->where('stock <', 5);
        }

        // Application du tri
        $model->orderBy($sort, $order);

        $data['produits'] = $model->findAll();

        // On renvoie les filtres à la vue pour garder la mémoire
        $data['filters'] = [
            'q' => $q, 'type' => $type, 'stock' => $stock, 
            'sort' => $sort, 'order' => $order
        ];

        return view('admin/produits', $data);
    }

    public function delete($id)
    {
        if (session()->get('user_role') !== 'admin') { return redirect()->to('/'); }
        $model = new ProductModel();
        $model->delete($id);
        return redirect()->to('/admin/produits')->with('msg', 'ITEM SUPPRIMÉ.');
    }

    public function ajouter()
    {
        if (session()->get('user_role') !== 'admin') { return redirect()->to('/'); }

        $db = \Config\Database::connect();
        
        // On récupère les extensions AVEC le nom de la série (Join)
        $data['extensions'] = $db->table('extensions')
                                 ->select('extensions.*, series.nom as nom_serie')
                                 ->join('series', 'series.id = extensions.id_serie')
                                 ->orderBy('series.id', 'DESC')
                                 ->orderBy('extensions.id', 'DESC')
                                 ->get()->getResult();
        
        $data['promotions'] = $db->table('promotions')
                                 ->orderBy('tauxPromo', 'DESC')
                                 ->get()->getResult();


        return view('admin/produits_add', $data);
    }

    public function save()
    {
        if (session()->get('user_role') !== 'admin') { return redirect()->to('/'); }

        $model = new ProductModel();

        // 1. Gestion de l'Image
        $img = $this->request->getFile('image');
        $nomImage = 'default.png';

        if ($img && $img->isValid() && !$img->hasMoved()) {
            $nomImage = $img->getRandomName();
            $path = FCPATH . 'assets/produits';
            if (!is_dir($path)) { mkdir($path, 0777, true); }
            $img->move($path, $nomImage);
        }

        // 2. Nettoyage des données (NULL si vide)
        $id_promo = $this->request->getPost('id_promo');
        if (empty($id_promo)) { $id_promo = null; }

        $id_extension = $this->request->getPost('id_extension');
        if (empty($id_extension)) { $id_extension = null; }

        $rarete = $this->request->getPost('rarete');
        if (empty($rarete)) { $rarete = null; }

        // 3. Préparation
        $data = [
            'nom'          => $this->request->getPost('nom'),
            'type_produit' => $this->request->getPost('type_produit'),
            'prix'         => $this->request->getPost('prix'),
            'stock'        => $this->request->getPost('stock'),
            'description'  => $this->request->getPost('description'),
            'rarete'       => $rarete,
            'id_extension' => $id_extension,
            'id_promo'     => $id_promo,
            'image_url'    => $nomImage,
        ];

        // 4. Insertion
        $model->insert($data);

        return redirect()->to('/admin/produits')->with('msg', 'NOUVEL ITEM AJOUTÉ À LA BASE DE DONNÉES.');
    }

    public function edit($id)
    {
        if (session()->get('user_role') !== 'admin') { return redirect()->to('/'); }

        $model = new ProductModel();
        $db = \Config\Database::connect();

        $produit = $model->find($id);
        if (!$produit) {
            return redirect()->to('/admin/produits')->with('msg', 'PRODUIT INTROUVABLE.');
        }

        // Récupération des extensions ET des promotions pour les listes déroulantes
        $extensions = $db->table('extensions')
                         ->select('extensions.*, series.nom as nom_serie') // On sélectionne le nom de la série
                         ->join('series', 'series.id = extensions.id_serie') // On fait le lien
                         ->orderBy('series.id', 'DESC') // On trie par série récente d'abord (optionnel, ou par nom)
                         ->orderBy('extensions.id', 'DESC')
                         ->get()->getResult();
        $promotions = $db->table('promotions')->orderBy('tauxPromo', 'DESC')->get()->getResult();

        $data = [
            'p' => $produit,
            'extensions' => $extensions,
            'promotions' => $promotions
        ];

        return view('admin/produits_edit', $data);
    }

    public function update()
    {
        if (session()->get('user_role') !== 'admin') { return redirect()->to('/'); }

        $model = new ProductModel();
        $id = $this->request->getPost('id');

        // --- NOUVELLE VALIDATION LOGIQUE ---
        $type = $this->request->getPost('type_produit');
        $rarete = $this->request->getPost('rarete');

        // Si ce n'est PAS une carte ET qu'une rareté est sélectionnée
        if ($type !== 'carte' && !empty($rarete)) {
            // On renvoie en arrière avec les données saisies (withInput) et un message d'erreur rouge
            return redirect()->back()->withInput()->with('error', 'ERREUR LOGIQUE : Un produit de type "'.strtoupper($type).'" ne peut pas avoir de rareté ! Veuillez sélectionner "--- Aucune ---".');
        }
        // -----------------------------------

        $oldProduct = $model->find($id);

        // Gestion Image
        $img = $this->request->getFile('image');
        $nomImage = $oldProduct->image_url;

        if ($img && $img->isValid() && !$img->hasMoved()) {
            $nomImage = $img->getRandomName();
            $path = FCPATH . 'assets/produits';
            if (!is_dir($path)) { mkdir($path, 0777, true); }
            $img->move($path, $nomImage);
        }

        // Gestion de la Promo (Si vide, on met NULL)
        $id_promo = $this->request->getPost('id_promo');
        if (empty($id_promo)) { $id_promo = null; }
        $id_extension = $this->request->getPost('id_extension');
        if (empty($id_extension)) { $id_extension = null; }

        $data = [
            'nom'          => $this->request->getPost('nom'),
            'type_produit' => $this->request->getPost('type_produit'),
            'prix'         => $this->request->getPost('prix'),
            'stock'        => $this->request->getPost('stock'),
            'description'  => $this->request->getPost('description'),
            'rarete'       => $this->request->getPost('rarete'),
            'id_extension' => $id_extension,
            'id_promo'     => $id_promo, // AJOUT IMPORTANT
            'image_url'    => $nomImage,
        ];

        $model->update($id, $data);

        return redirect()->to('/admin/produits')->with('msg', 'ITEM MIS À JOUR AVEC SUCCÈS.');
    }
}