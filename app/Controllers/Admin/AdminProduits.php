<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;

class AdminProduits extends BaseController
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

        return view('admin/Produits/index', $data);
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

        
        $data['existing_images'] = $this->getExistingImages();


        return view('admin/Produits/creation', $data);
    }

    public function save()
    {
        if (session()->get('user_role') !== 'admin') { return redirect()->to('/'); }

        // --- VALIDATION ---
        $type = $this->request->getPost('type_produit');
        $rarete = $this->request->getPost('rarete');
        $stock = (int)$this->request->getPost('stock');

        $error = $this->validateProductData($type, $rarete, $stock);
        if ($error) {
            // On renvoie avec les anciennes données (withInput) pour ne pas tout retaper
            return redirect()->back()->withInput()->with('error', $error);
        }
        // ------------------


        $model = new ProductModel();

        // --- GESTION INTELLIGENTE DE L'IMAGE ---
        $nomImage = 'default.png';
        
        // 1. Est-ce qu'on a sélectionné une image existante ?
        $existingImg = $this->request->getPost('existing_image');
        
        // 2. Est-ce qu'on a uploadé un fichier ?
        $uploadImg = $this->request->getFile('image');

        if ($uploadImg && $uploadImg->isValid() && !$uploadImg->hasMoved()) {
            // Priorité à l'upload : Si on envoie un fichier, c'est lui qu'on prend
            $nomImage = $uploadImg->getRandomName();
            $path = FCPATH . 'assets/produits';
            if (!is_dir($path)) { mkdir($path, 0777, true); }
            $uploadImg->move($path, $nomImage);
        } elseif (!empty($existingImg)) {
            // Sinon, si on a choisi une image existante, on prend son nom
            $nomImage = $existingImg;
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

        return redirect()->to('/admin/produits')->with('msg', 'NOUVEAU PRODUIT AJOUTÉ À LA BASE DE DONNÉES.');
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
            'promotions' => $promotions,
            'existing_images' => $this->getExistingImages()
        ];

        return view('admin/Produits/edit', $data);
    }

    public function update()
    {
        // ... vérifications session ...
        if (session()->get('user_role') !== 'admin') { return redirect()->to('/'); }

        // --- VALIDATION ---
        $type = $this->request->getPost('type_produit');
        $rarete = $this->request->getPost('rarete');
        $stock = (int)$this->request->getPost('stock');

        $error = $this->validateProductData($type, $rarete, $stock);
        if ($error) {
            return redirect()->back()->withInput()->with('error', $error);
        }
        // ------------------


        $model = new ProductModel();
        $id = $this->request->getPost('id');

        // ... validation type/rarete ...
         $type = $this->request->getPost('type_produit');
        $rarete = $this->request->getPost('rarete');
        if ($type !== 'carte' && !empty($rarete)) {
            return redirect()->back()->withInput()->with('error', 'ERREUR LOGIQUE : Pas de rareté pour ce type.');
        }

        $oldProduct = $model->find($id);

        // --- GESTION INTELLIGENTE IMAGE UPDATE ---
        $nomImage = $oldProduct->image_url; // Par défaut, on garde l'ancienne
        
        $existingImg = $this->request->getPost('existing_image');
        $uploadImg = $this->request->getFile('image');

        if ($uploadImg && $uploadImg->isValid() && !$uploadImg->hasMoved()) {
            // 1. Upload prioritaire
            $nomImage = $uploadImg->getRandomName();
            $path = FCPATH . 'assets/produits';
            if (!is_dir($path)) { mkdir($path, 0777, true); }
            $uploadImg->move($path, $nomImage);
        } elseif (!empty($existingImg)) {
            // 2. Sélection existante
            $nomImage = $existingImg;
        }
        // Sinon on garde $nomImage initial (l'ancienne)

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
            'id_promo'     => $id_promo, 
            'image_url'    => $nomImage,
        ];

        $model->update($id, $data);

        return redirect()->to('/admin/produits')->with('msg', 'ITEM MIS À JOUR AVEC SUCCÈS.');
    }



    // --- NOUVELLE FONCTION UTILITAIRE ---
    private function getExistingImages() {
        $path = FCPATH . 'assets/produits/';
        $images = [];
        if (is_dir($path)) {
            $files = scandir($path);
            foreach ($files as $file) {
                // On filtre pour ne garder que les vraies images (jpg, png, etc.)
                if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    $images[] = $file;
                }
            }
        }
        return $images;
    }

    // --- NOUVELLE FONCTION DE VALIDATION CENTRALE ---
    private function validateProductData($type, $rarete, $stock) {
        // Règle 1 : Stock Négatif
        if ($stock < 0) {
            return "ERREUR : Le stock ne peut pas être négatif !";
        }

        // Règle 2 : Rareté sur un produit qui n'est pas une carte
        if ($type !== 'carte' && !empty($rarete)) {
            return "ERREUR LOGIQUE : Un produit de type '".strtoupper($type)."' ne peut pas avoir de rareté ! Veuillez sélectionner '--- Aucune ---'.";
        }

        return null; // Pas d'erreur
    }
}