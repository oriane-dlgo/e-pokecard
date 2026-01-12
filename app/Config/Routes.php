<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --------------------------------------------------------------------
// 1. ROUTES PUBLIQUES & GÉNÉRALES
// --------------------------------------------------------------------
$routes->get('/', 'Home::index');
$routes->get('theme/(:segment)', 'Home::switchTheme/$1'); // Changement de thème
$routes->get('recherche', 'Search::index'); // Recherche globale
$routes->get('detail/(:num)', 'Home::find/$1'); // Détail produit

// Pages Légales
$routes->get('mentions-legales', 'Legal::mentions');
$routes->get('cgv', 'Legal::cgv');
$routes->get('confidentialite', 'Legal::privacy');


// --------------------------------------------------------------------
// 2. AUTHENTIFICATION (Connexion / Inscription)
// --------------------------------------------------------------------
$routes->get('connexion', 'Connexion::index');
$routes->post('connexion/auth', 'Connexion::auth');
$routes->get('deconnexion', 'Connexion::deconnexion');

$routes->get('inscription', 'Inscription::index');
$routes->post('inscription/register', 'Inscription::register');


// --------------------------------------------------------------------
// 3. ESPACE CLIENT (Profil, Panier, Paiement)
// --------------------------------------------------------------------
// Profil
$routes->get('profil', 'Profil::index');
$routes->get('profil/edit', 'Profil::edit');
$routes->post('profil/update', 'Profil::update');

// Panier
$routes->get('panier', 'Panier::index');
$routes->post('panier/ajouter', 'Panier::ajouter');
$routes->get('panier/supprimer/(:num)', 'Panier::supprimer/$1');
$routes->get('panier/vider', 'Panier::vider');
$routes->get('panier/valider', 'Panier::valider');

// Paiement & Commande (Côté Client)
$routes->get('paiement/choix/(:num)', 'Paiement::choix/$1');
$routes->post('paiement/process', 'Paiement::process');
$routes->get('commande/confirmation/(:num)', 'Commande::confirmation/$1');


// --------------------------------------------------------------------
// 4. ESPACE ADMINISTRATION (Sécurisé)
// --------------------------------------------------------------------
// Tout ce qui est ici aura automatiquement le préfixe "/admin"
// Et passera par le filtre "authAdmin" (vérification du rôle)
$routes->group('admin', ['filter' => 'authAdmin'], function($routes) {
    
    // Dashboard
    $routes->get('dashboard', 'Admin\AdminDashboard::index');

    // --- Gestion des Produits ---
    $routes->get('produits', 'Admin\AdminProduits::index');
    $routes->get('produits/ajouter', 'Admin\AdminProduits::ajouter');
    $routes->post('produits/save', 'Admin\AdminProduits::save');
    $routes->get('produits/edit/(:num)', 'Admin\AdminProduits::edit/$1');
    $routes->post('produits/update', 'Admin\AdminProduits::update');
    $routes->get('produits/delete/(:num)', 'Admin\AdminProduits::delete/$1');

    // --- Gestion des Promotions ---
    $routes->get('promotions', 'Admin\AdminPromotions::index');
    $routes->get('promotions/ajouter', 'Admin\AdminPromotions::ajouter');
    $routes->post('promotions/save', 'Admin\AdminPromotions::save');
    $routes->get('promotions/edit/(:num)', 'Admin\AdminPromotions::edit/$1');
    $routes->post('promotions/update', 'Admin\AdminPromotions::update');
    $routes->get('promotions/delete/(:num)', 'Admin\AdminPromotions::delete/$1');

    // --- Gestion des Commandes ---
    $routes->get('commandes', 'Admin\AdminCommandes::index');
    $routes->get('commandes/detail/(:num)', 'Admin\AdminCommandes::detail/$1');
    $routes->get('commandes/ajouter', 'Admin\AdminCommandes::ajouter');
    $routes->post('commandes/save', 'Admin\AdminCommandes::save');
    $routes->post('commandes/updateStatut', 'Admin\AdminCommandes::updateStatut');
    $routes->get('commandes/undo/(:num)', 'Admin\AdminCommandes::undo/$1'); // Pattern Memento

    // --- Gestion des Utilisateurs ---
    $routes->get('users', 'Admin\AdminUtilisateurs::index');
    $routes->get('users/ajouter', 'Admin\AdminUtilisateurs::ajouter');
    $routes->post('users/save', 'Admin\AdminUtilisateurs::save');
    $routes->post('users/updateRole', 'Admin\AdminUtilisateurs::updateRole');
    $routes->get('users/delete/(:num)', 'Admin\AdminUtilisateurs::delete/$1');
});