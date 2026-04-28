<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Auth routes
$routes->get('/', 'AuthController::login');
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::doLogin');
$routes->get('/register', 'AuthController::register');
$routes->post('/register', 'AuthController::doRegister');
$routes->get('/logout', 'AuthController::logout');

// Home routes
$routes->get('/home', 'HomeController::index');
$routes->post('/swipe', 'HomeController::swipe');
$routes->get('/get-foods', 'HomeController::getFoods');

// Add food routes
$routes->get('/add-food', 'AddFoodController::index');
$routes->post('/add-food', 'AddFoodController::add');

// Stats routes
$routes->get('/stats', 'StatsController::index');
$routes->get('/get-stats', 'StatsController::getStats');

// Legacy routes (keep for compatibility)
$routes->get('/fiche_livre/(:num)', 'AcceuilController::fiche_livre/$1');
