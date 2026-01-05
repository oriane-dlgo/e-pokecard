<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Quand l'URL est /connexion, utilise la méthode index() du contrôleur Connexion
$routes->get('connexion', 'Connexion::index');
$routes->post('connexion/auth', 'Connexion::auth');
$routes->get('deconnexion', 'Connexion::deconnexion');

// Incription
$routes->get('inscription', 'Inscription::index');
$routes->post('inscription/register', 'Inscription::register');


// Profil
$routes->get('profil', 'Profil::index');

// Gestion du Panier
$routes->get('panier', 'Panier::index');                // Voir le panier
$routes->post('panier/ajouter', 'Panier::ajouter');     // Ajouter (via un formulaire caché)
$routes->get('panier/supprimer/(:num)', 'Panier::supprimer/$1'); // Supprimer un item
$routes->get('panier/vider', 'Panier::vider');          // Tout vider


$routes->get('detail/(:num)', 'Home::find/$1');
