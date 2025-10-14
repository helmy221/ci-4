<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/login', 'AuthController::index');
$routes->post('/doLogin', 'AuthController::doLogin');
$routes->get('/logout', 'AuthController::logout');

//API Routes
$routes->group('api', ['namespace' => 'App\Controllers\API'], function ($routes) {
    $routes->post('login', 'Auth\AuthControllers::login');
    $routes->post('refresh', 'Auth\AuthControllers::refresh');

    // User
    $routes->group('users', ['filter' => 'jwt', 'cors'], function ($routes) {
        $routes->get('', 'Users\UserAPIController::index'); // list
        $routes->get('(:num)', 'Users\UserAPIController::show/$1'); // detail
        $routes->post('(:num)/softdelete', 'Users\UserAPIController::softDeleteUser/$1');
        // $routes->post('', 'Api\UserController::store'); // create
        // $routes->put('(:num)', 'Api\UserController::update/$1'); // update
        // $routes->delete('(:num)', 'Api\UserController::delete/$1'); // delete
    });
});

// Protected Routes
// $routes->get('/dashboard', 'Home::index', ['filter' => 'auth']);

$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/dashboard', 'Home::index');
    $routes->get('/users', 'UserController::index');
    // $routes->get('/users/create', 'Home::create', ['filter' => 'permission:user.create']);

    //transaksi
    $routes->get('/alldata', 'TransaksiAllDataController::index');
});
