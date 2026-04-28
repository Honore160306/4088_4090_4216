<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AcceuilController::liste_livres');   
$routes->get('/fiche_livre/(:num)', 'AcceuilController::fiche_livre/$1');
