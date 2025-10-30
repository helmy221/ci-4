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
        $routes->get('', 'Users\UserAPIController::getListUser'); // list
        // $routes->get('(:num)', 'Users\UserAPIController::show/$1'); // detail
        $routes->post('(:num)/softdelete', 'Users\UserAPIController::softDeleteUser/$1');
        $routes->post('add', 'Users\UserAPIController::create'); // create
        $routes->put('update/(:num)', 'Users\UserAPIController::update/$1'); // update
        // $routes->delete('(:num)', 'Api\UserController::delete/$1'); // delete
    });

    // Roles
    $routes->group('roles', ['filter' => 'jwt', 'cors'], function ($routes) {
        $routes->get('', 'Roles\RolesAPIController::getListRoles'); // list
    });

    // Unist
    $routes->group('units', ['filter' => 'jwt', 'cors'], function ($routes) {
        $routes->get('', 'Units\UnitsAPIController::getListUnits'); // list
    });

    // Jabatan
    $routes->group('jabatan', ['filter' => 'jwt', 'cors'], function ($routes) {
        $routes->get('', 'Jabatan\JabatanAPIController::getListJabatan'); // list
    });
});

// Protected Routes
// $routes->get('/dashboard', 'Home::index', ['filter' => 'auth']);

$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/dashboard', 'Home::index');
    $routes->get('/profile', 'Profile::index');

    //master
    $routes->get('/users', 'UserController::index');
    // $routes->get('/users/create', 'Home::create', ['filter' => 'permission:user.create']);
    $routes->get('/masterunitorganisasi', 'MasterUnitOrganisasiController::index');
    $routes->get('/masterjenispekerjaan', 'MasterJenisPekerjaanController::index');
    $routes->get('/masterlokasipekerjaan', 'MasterLokasiPekerjaanController::index');

    //transaksi
    $routes->get('/alldata', 'TransaksiAllDataController::index');
    $routes->get('/getdatafilter', 'TransaksiGetDataByFilterController::index');
    $routes->get('/getdatapemenang', 'TransaksiGetDataByPemenangController::index');
});
