<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Route pour changer de thème (ex: /theme/retro ou /theme/standard)
$routes->get('theme/(:segment)', 'Home::switchTheme/$1');


$routes->get('/connexion', 'Connexion::index');
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
$routes->get('panier/valider', 'Panier::valider');


$routes->get('detail/(:num)', 'Home::find/$1');

// Retro routes
$routes->get('connexion_retro', 'Connexion::index');
$routes->post('connexion_retro/auth', 'Connexion::auth');
$routes->get('deconnexion_retro', 'Connexion::deconnexion');

$routes->get('inscription_retro', 'Inscription::index');
$routes->post('inscription_retro/register', 'Inscription::register');

$routes->get('profil_retro', 'Profil::index');
$routes->get('profil/edit', 'Profil::edit');       // Afficher le formulaire
$routes->post('profil/update', 'Profil::update');  // Sauvegarder les changements

$routes->get('panier_retro', 'Panier::index');                // Voir le panier
$routes->post('panier_retro/ajouter', 'Panier::ajouter');     // Ajouter (via un formulaire caché)
$routes->get('panier_retro/supprimer/(:num)', 'Panier::supprimer/$1'); // Supprimer un item
$routes->get('panier_retro/vider', 'Panier::vider');          // Tout vider
$routes->get('panier_retro/valider', 'Panier::valider');

$routes->get('detail_retro/(:num)', 'Home::find/$1');

$routes->get('commande/confirmation/(:num)', 'Commande::confirmation/$1');

$routes->get('recherche', 'Search::index');

// --- ESPACE ADMINISTRATION ---
$routes->group('admin', ['filter' => 'authAdmin'], function($routes) {
    
    // Dashboard
    $routes->get('/', 'Admin\Dashboard::index');

    // Gestion Produits
    $routes->get('produits', 'Admin\Produits::index');           // Liste
    $routes->get('produits/ajouter', 'Admin\Produits::ajouter'); // Formulaire Ajout
    $routes->post('produits/save', 'Admin\Produits::save');      // Action Sauvegarde
    $routes->get('produits/edit/(:num)', 'Admin\Produits::edit/$1'); // Formulaire Edit
    $routes->post('produits/update', 'Admin\Produits::update');  // Action Update
    $routes->get('produits/delete/(:num)', 'Admin\Produits::delete/$1'); // Suppression

    // Gestion Commandes
    $routes->get('commandes', 'Admin\Commandes::index');
    $routes->post('commandes/updateStatut', 'Admin\Commandes::updateStatut');
});

$routes->get('admin', 'Admin\Dashboard::index');

$routes->get('admin/produits', 'Admin\Produits::index');
$routes->get('admin/produits/delete/(:num)', 'Admin\Produits::delete/$1');
$routes->get('admin/produits/ajouter', 'Admin\Produits::ajouter');
$routes->post('admin/produits/save', 'Admin\Produits::save');
$routes->get('admin/produits/edit/(:num)', 'Admin\Produits::edit/$1');
$routes->post('admin/produits/update', 'Admin\Produits::update');


$routes->get('admin/commandes', 'Admin\Commandes::index');
$routes->get('admin/commandes/detail/(:num)', 'Admin\Commandes::detail/$1');
$routes->post('admin/commandes/updateStatut', 'Admin\Commandes::updateStatut');

$routes->get('admin/users', 'Admin\Users::index');
$routes->post('admin/users/updateRole', 'Admin\Users::updateRole');
$routes->get('admin/users/delete/(:num)', 'Admin\Users::delete/$1');

$routes->get('promotions','Search::getlistepromotions');


$routes->get('paiement/choix/(:num)', 'Paiement::choix/$1');
$routes->post('paiement/process', 'Paiement::process');
$routes->get('admin/commandes/undo/(:num)', 'Admin\Commandes::undo/$1');