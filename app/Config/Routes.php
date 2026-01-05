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

