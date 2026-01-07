<?php

if (! function_exists('view_theme')) {
    function view_theme(string $name, array $data = [], array $options = [])
    {
        $session = session();
        $theme = $session->get('theme_choisi'); // On récupère le choix (ex: 'retro')

        // Si le mode est 'retro', on tente de charger la vue '_retro'
        if ($theme === 'retro') {
            $nomRetro = $name . '_retro';
            
            // On vérifie que le fichier retro existe physiquement pour éviter une erreur 404
            // Si le fichier existe, on change le nom de la vue à charger
            // Note: APPPATH points to the app directory
            if (file_exists(APPPATH . 'Views/' . $nomRetro . '.php')) {
                $name = $nomRetro;
            }
        }

        // On lance la fonction native de CodeIgniter avec le bon nom
        return view($name, $data, $options);
    }
}