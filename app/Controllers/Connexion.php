<?php

namespace App\Controllers;

class Connexion extends BaseController
{
    public function index()
    {
        // Charge le fichier qui est dans app/Views/connexion.php
        return view('connexion'); 
    }
}