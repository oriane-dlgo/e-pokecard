<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Home extends BaseController
{
    public function index()
    {
        // // 1. On appelle le modèle
        // $model = new ProductModel();

        // // 2. On récupère tous les produits (équivalent du SELECT * FROM...)
        // $data['lesProduits'] = $model->findAll();

        // // 3. On envoie ces données à la Vue (l'affichage)
        // // 'accueil' sera le nom de votre fichier dans app/Views
        // return view('accueil', $data);

        try {
            // On tente d'appeler le modèle
            $model = new ProductModel();
            // On tente de récupérer les données
            $data['lesProduits'] = $model->findAll();
            
            // On tente d'afficher la vue
            return view('accueil2', $data);

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
}