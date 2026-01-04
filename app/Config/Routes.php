<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Quand l'URL est /connexion, utilise la méthode index() du contrôleur Connexion
$routes->get('connexion', 'Connexion::index');
