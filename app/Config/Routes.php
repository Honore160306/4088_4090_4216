<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AcceuilController::liste_livres');   
$routes->get('/register', 'AcceuilController::register');   
$routes->post('/createUser', 'AcceuilController::createUser');   
$routes->get('/fiche_livre/(:num)', 'AcceuilController::fiche_livre/$1');
