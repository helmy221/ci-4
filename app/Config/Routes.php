<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'AuthController::index');
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

    // Units
    $routes->group('units', ['filter' => 'jwt', 'cors'], function ($routes) {
        $routes->get('', 'Units\UnitsAPIController::getListUnits'); // list

        $routes->post('add', 'Units\UnitsAPIController::create'); // create
        $routes->put('update/(:num)', 'Units\UnitsAPIController::update/$1'); // update
    });

    // Jabatan
    $routes->group('jabatan', ['filter' => 'jwt', 'cors'], function ($routes) {
        $routes->get('', 'Jabatan\JabatanAPIController::getListJabatan'); // list
    });

    // Transaksi
    $routes->group('transaksi', ['filter' => 'jwt', 'cros'], function ($routes) {
        $routes->get('', 'Transaksi\TransaksiAllDataAPIController::getAllPaketPemenang');
        $routes->post('uploadPengadaan', 'Transaksi\TransaksiAllDataAPIController::uploadPaketPengadaan');
        $routes->get('download/(:any)', 'Transaksi\TransaksiAllDataAPIController::downloaFormuploadPaketPengadaan/$1');
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

    $routes->get('/cari-data-paket-pengadaan', 'TransaksiGetDataByFilterController::hasil');
    $routes->get('/cari-data-pemenang', 'TransaksiGetDataByPemenangController::hasil');
    // AJAX endpoint for paket by pemenang (used by modal)
    $routes->get('/transaksi/pemenang/list', 'TransaksiGetDataByPemenangController::apiListByPemenang');
});
