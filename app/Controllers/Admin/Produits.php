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
        
        // 1. Récupération des filtres
        $q     = $this->request->getGet('q');
        $type  = $this->request->getGet('type');
        $stock = $this->request->getGet('stock'); // Nouveau : filtre par état du stock

        // 2. Construction de la requête
        // On commence la requête, mais on ne fait pas le findAll tout de suite
        $model->select('*');

        if (!empty($q)) {
            $model->like('nom', $q);
        }

        if (!empty($type)) {
            $model->where('type_produit', $type);
        }

        // Filtre intelligent pour le stock
        if ($stock === 'rupture') {
            $model->where('stock', 0);
        } elseif ($stock === 'faible') {
            $model->where('stock >', 0)->where('stock <', 5);
        }

        // 3. Exécution (avec le tri par ID décroissant)
        $data['produits'] = $model->orderBy('id', 'DESC')->findAll();

        // 4. On renvoie les filtres à la vue pour pré-remplir les champs
        $data['filters'] = [
            'q' => $q,
            'type' => $type,
            'stock' => $stock
        ];

        return view('admin/produits', $data);
    }

    public function delete($id)
    {
        if (session()->get('user_role') !== 'admin') { return redirect()->to('/'); }

        $model = new ProductModel();
        
        // Suppression
        $model->delete($id);

        return redirect()->to('/admin/produits')->with('msg', 'PRODUIT SUPPRIMÉ DE LA BASE DE DONNÉES.');
    }

    public function ajouter()
    {
        if (session()->get('user_role') !== 'admin') { return redirect()->to('/'); }

        $db = \Config\Database::connect();
        
        // On récupère les extensions pour le menu déroulant
        $data['extensions'] = $db->table('extensions')->orderBy('nom', 'ASC')->get()->getResult();

        return view('admin/produits_add', $data);
    }

    public function save()
    {
        if (session()->get('user_role') !== 'admin') { return redirect()->to('/'); }

        $model = new ProductModel();

        // 1. Gestion de l'Image
        $img = $this->request->getFile('image');
        $nomImage = 'default.png'; // Valeur par défaut si pas d'image

        if ($img && $img->isValid() && !$img->hasMoved()) {
            // On génère un nom aléatoire pour éviter les conflits (ex: 12345_dracaufeu.png)
            $nomImage = $img->getRandomName();
            
            // --- AJOUT DE SÉCURITÉ ICI ---
            $path = FCPATH . 'assets/produits';
        
            // Si le dossier n'existe pas, on le crée avec les droits d'écriture
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
            // -----------------------------


            // On déplace l'image dans public/assets/produits
            $img->move(FCPATH . 'assets/produits', $nomImage);
        }

        // 2. Préparation des données
        $data = [
            'nom'          => $this->request->getPost('nom'),
            'type_produit' => $this->request->getPost('type_produit'),
            'prix'         => $this->request->getPost('prix'),
            'stock'        => $this->request->getPost('stock'),
            'description'  => $this->request->getPost('description'),
            'rarete'       => $this->request->getPost('rarete'),
            'id_extension' => $this->request->getPost('id_extension'),
            'image_url'    => $nomImage, // On sauvegarde le nom du fichier
            // 'promotion' => ... (si tu veux gérer ça plus tard)
        ];

        // 3. Insertion
        $model->insert($data);

        return redirect()->to('/admin/produits')->with('msg', 'NOUVEL ITEM AJOUTÉ À LA BASE DE DONNÉES.');
    }

    public function edit($id)
    {
        if (session()->get('user_role') !== 'admin') { return redirect()->to('/'); }

        $model = new ProductModel();
        $db = \Config\Database::connect();

        // 1. On récupère le produit
        $produit = $model->find($id);

        if (!$produit) {
            return redirect()->to('/admin/produits')->with('msg', 'PRODUIT INTROUVABLE.');
        }

        // 2. On récupère les extensions (pour la liste déroulante)
        $extensions = $db->table('extensions')->orderBy('nom', 'ASC')->get()->getResult();

        $data = [
            'p' => $produit,
            'extensions' => $extensions
        ];

        return view('admin/produits_edit', $data);
    }

    public function update()
    {
        if (session()->get('user_role') !== 'admin') { return redirect()->to('/'); }

        $model = new ProductModel();
        $id = $this->request->getPost('id');

        // Récupération de l'ancien produit pour avoir le nom de l'ancienne image
        $oldProduct = $model->find($id);

        // 1. Gestion de l'Image (Si une nouvelle est envoyée)
        $img = $this->request->getFile('image');
        $nomImage = $oldProduct->image_url; // Par défaut, on garde l'ancienne

        if ($img && $img->isValid() && !$img->hasMoved()) {
            // Nouvelle image détectée !
            $nomImage = $img->getRandomName();
            
            $path = FCPATH . 'assets/produits';
            if (!is_dir($path)) { mkdir($path, 0777, true); }
            
            $img->move($path, $nomImage);

            // Optionnel : Supprimer l'ancienne image du serveur pour gagner de la place
            // if ($oldProduct->image_url != 'default.png' && file_exists($path . '/' . $oldProduct->image_url)) {
            //    unlink($path . '/' . $oldProduct->image_url);
            // }
        }

        // 2. Préparation des données
        $data = [
            'nom'          => $this->request->getPost('nom'),
            'type_produit' => $this->request->getPost('type_produit'),
            'prix'         => $this->request->getPost('prix'),
            'stock'        => $this->request->getPost('stock'),
            'description'  => $this->request->getPost('description'),
            'rarete'       => $this->request->getPost('rarete'),
            'id_extension' => $this->request->getPost('id_extension'),
            'image_url'    => $nomImage, // Nouvelle ou Ancienne
        ];

        // 3. Update
        $model->update($id, $data);

        return redirect()->to('/admin/produits')->with('msg', 'ITEM MIS À JOUR AVEC SUCCÈS.');
    }
}