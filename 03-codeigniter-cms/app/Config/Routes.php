<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index');

$routes->get('/cart', 'CartController::index');
$routes->post('/cart/add/(:num)', 'CartController::add/$1');
$routes->post('/cart/update/(:num)', 'CartController::update/$1');
$routes->get('/cart/remove/(:num)', 'CartController::remove/$1');
$routes->get('/cart/increase/(:num)', 'CartController::increase/$1');
$routes->get('/cart/decrease/(:num)', 'CartController::decrease/$1');
$routes->get('/cart/clear', 'CartController::clear');
$routes->get('cart/delete-selected', 'CartController::deleteSelected');

$routes->get('/checkout', 'CheckoutController::index');
$routes->post('/checkout/process', 'CheckoutController::process');

$routes->get('/payment/(:num)', 'PaymentController::index/$1');
$routes->post('/payment/process/(:num)', 'PaymentController::process/$1');

$routes->post('/payment/paid/(:num)', 'PaymentController::paid/$1');
$routes->get('/payment/success/(:num)', 'PaymentController::success/$1');

$routes->get('/history', 'HistoryController::index');
$routes->get('/history/(:num)', 'HistoryController::detail/$1');


$routes->group('admin', function ($routes) {

    $routes->get('dashboard', 'Admin\DashboardController::index');

    $routes->get('products', 'Admin\ProductController::index');
    $routes->get('products/create', 'Admin\ProductController::create');
    $routes->post('products/store', 'Admin\ProductController::store');

    $routes->get('products/edit/(:num)', 'Admin\ProductController::edit/$1');
    $routes->post('products/update/(:num)', 'Admin\ProductController::update/$1');

    $routes->get('products/delete/(:num)', 'Admin\ProductController::delete/$1');
});
