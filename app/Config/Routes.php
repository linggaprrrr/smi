<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

// AUTH
$routes->get('/', 'Auth::index');
$routes->post('/login-proccess', 'Auth::loginProccess');
$routes->get('/logout', 'Users::logout');

// ADMIN PAGE
$routes->get('/admin/dashboard', 'Home::index');
$routes->get('/admin/produk', 'Products::index');
$routes->get('/admin/material', 'Materials::index');
$routes->get('/admin/qr-generator-kain', 'QRCodeGenerator::QRGeneratorMaterial');
$routes->get('/admin/qr-generator-produk-masuk', 'QRCodeGenerator::QRGeneratorProductIn');
$routes->get('/admin/qr-scanner', 'QRCodeGenerator::QRScanner');
$routes->get('/admin/laporan', 'Reports::index');
$routes->get('/admin/user', 'Users::index');
$routes->get('/admin/settings', 'Users::settings');

// ADMIN PROCESS
$routes->post('/simpan-produk', 'Products::saveProduct');
$routes->post('/update-produk', 'Products::updateProduct');
$routes->post('/simpan-model', 'Products::saveModel');
$routes->post('/update-model', 'Products::updateModel');
$routes->post('/generate-qr', 'QRCodeGenerator::generateQR');
$routes->post('/generate-qr-produk', 'QRCodeGenerator::generateQRProduct');

// ADMIN API
$routes->get('/get-product', 'Products::getProduct');
$routes->post('/delete-product', 'Products::deleteProduct');
$routes->get('/get-model', 'Products::getModel');
$routes->post('/delete-model', 'Products::deleteModel');
$routes->post('/product-in-scanning', 'QRCodeGenerator::scanningProductIn');


// GUDANG
$routes->get('/gudang/dashboard', 'Home::gudang');


// GLOBAL API

// test
$routes->get('/test', 'QRCodeGenerator::test');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
