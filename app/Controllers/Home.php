<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Home extends BaseController
{
    public function index()
    {
        try {
            // On tente d'appeler le modèle
            $model = new ProductModel();
            // On tente de récupérer les données
           $lesProduits = $model->findAll();

        // Coffrets uniquement
        $lesCoffrets = $model->where('type_produit', 'coffret')->findAll();
        $lesBoosters = $model->where('type_produit', 'booster')->findAll();
        $lesCartes = $model->where('type_produit', 'carte')->findAll();

        // Préparer le tableau pour la vue
        $data = [
            'lesProduits' => $lesProduits,
            'lesCoffrets' => $lesCoffrets,
            'lesBoosters'=>$lesBoosters,
            'lesCartes'=>$lesCartes
        ];

        //return view('accueil', $data);
            // On tente d'afficher la vue
             return view_theme('accueil', $data);

        } catch (\Throwable $e) {
            // EN CAS D'ERREUR, on l'affiche ici :
            echo "<div style='color:red; font-weight:bold; padding:20px; border:2px solid red;'>";
            echo "ERREUR : " . $e->getMessage() . "<br><br>";
            echo "Fichier : " . $e->getFile() . " à la ligne " . $e->getLine();
            echo "</div>";
            
            // Pour voir si c'est un problème de classe non trouvée
            if (!class_exists('App\Models\ProductModel')) {
                echo "<br>ASTUCE : La classe App\Models\ProductModel est introuvable. Vérifiez le nom du fichier et le namespace.";
            }
        }
    } 
    
    public function find(int $id)
    {
        $model = new ProductModel();
        $product = $model->find($id);
    
        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    
        $data = [
            'product' => $product
        ];

        return view_theme('detail', $data);
    }   

    public function switchTheme($mode)
    {
        $session = session();
        
        // On enregistre le choix : 'retro' ou 'standard'
        if ($mode === 'retro') {
            $session->set('theme_choisi', 'retro');
        } else {
            $session->set('theme_choisi', 'standard'); // ou on supprime la variable
        }

        // On redirige vers la page d'où l'on vient (refresh)
        return redirect()->back();
    }
}