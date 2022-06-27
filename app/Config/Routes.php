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
$routes->get('/admin/datamaster', 'Materials::datamaster');
$routes->get('/admin/logs', 'Reports::log');
$routes->get('/admin/pengiriman', 'Shippings::index');

// ADMIN PROCESS
$routes->post('/simpan-kain', 'Materials::saveMaterial');
$routes->post('/update-kain', 'Materials::updateMaterial');
$routes->post('/simpan-produk', 'Products::saveProduct');
$routes->post('/update-produk', 'Products::updateProduct');
$routes->post('/simpan-model', 'Products::saveModel');
$routes->post('/update-model', 'Products::updateModel');
$routes->post('/simpan-warna', 'Materials::saveWarna');
$routes->post('/update-warna', 'Materials::updateWarna');
$routes->post('/simpan-vendor-supplier', 'Materials::saveVendorSupplier');
$routes->post('/update-vendor-supplier', 'Materials::updateVendorSupplier');
$routes->post('/simpan-vendor-penjualan', 'Materials::saveVendorPenjualan');

$routes->post('/generate-qr', 'QRCodeGenerator::generateQR');
$routes->post('/generate-qr-produk', 'QRCodeGenerator::generateQRProduct');
$routes->get('/export-data-kain', 'Materials::exportData');
$routes->post('/simpan-user', 'Users::saveUser');
$routes->post('/update-user', 'Users::updateUser');

$routes->post('/tambah-produk', 'Products::addProduct');
$routes->post('/tambah-produk-lovish', 'Products::addProductLovish');
$routes->get('/get-produk-detail', 'Products::getProductDetail');
$routes->post('/update-produk-detail', 'Products::updateProductDetail');
$routes->post('/tambah-kain', 'Materials::addMaterial');
$routes->get('/get-kain-detail', 'Materials::getMaterialDetail');
$routes->post('/update-kain-detail', 'Materials::updateMaterialDetail');

// ADMIN API
$routes->get('/get-user', 'Users::getUser');
$routes->post('/delete-user', 'Users::deleteUser');
$routes->get('/get-kain', 'Materials::getMaterial');
$routes->post('/delete-kain', 'Materials::deleteMaterial');
$routes->post('/delete-kain-detail', 'Materials::deleteMaterialDetail');
$routes->get('/get-produk', 'Products::getProduct');
$routes->get('/get-produk-detail', 'Products::getProductDetail');
$routes->post('/delete-product', 'Products::deleteProduct');
$routes->post('/delete-product-detail', 'Products::deleteProductDetail');
$routes->get('/get-model', 'Products::getModel');
$routes->post('/delete-model', 'Products::deleteModel');
$routes->post('/delete-model-detail', 'Products::deleteModelDetail');
$routes->get('/get-warna', 'Materials::getColor');
$routes->post('/delete-warna', 'Materials::deleteColor');
$routes->get('/get-vendor-supplier', 'Materials::getVendorSupplier');
$routes->post('/update-vendor-supplier', 'Materials::updateVendorSupplier');
$routes->post('/delete-vendor-supplier', 'Materials::deleteVendorSupplier');
$routes->get('/get-vendor-penjualan', 'Materials::getVendorSelling');
$routes->post('/update-vendor-penjualan', 'Materials::updateVendorSelling');
$routes->post('/delete-vendor-penjualan', 'Materials::deleteVendorSelling');
$routes->get('/get-pengiriman-detail', 'Shippings::getShippingDetail');
$routes->get('/get-vendor-kain', 'Materials::getVendor');



// GUDANG Gesit
$routes->get('/gudang-gesit/dashboard', 'Home::gudangGesit');
$routes->get('/gudang-gesit/produk', 'Products::gudangGesitProduk');
$routes->get('/gudang-gesit/kain', 'Materials::gudangGesitKain');
$routes->get('/gudang-gesit/qr-generator-kain', 'QRCodeGenerator::QRGeneratorMaterialGesit');
$routes->get('/gudang-gesit/qr-generator-produk-masuk', 'QRCodeGenerator::QRGeneratorProductInGesit');
$routes->get('/gudang-gesit/qr-scanner-in', 'QRCodeGenerator::scannerMaterialIn');
$routes->get('/gudang-gesit/qr-scanner-pola-in', 'QRCodeGenerator::scannerPolaIn');
$routes->get('/gudang-gesit/qr-scanner-pola-out', 'QRCodeGenerator::scannerPolaOut');
$routes->get('/gudang-gesit/qr-scanner-produk-in', 'QRCodeGenerator::scannerProductIn');
$routes->get('/gudang-gesit/laporan', 'Reports::reportGesit');
$routes->get('export-data-pola-in', 'Materials::exportDataPolaIn');
$routes->get('export-data-pola-out', 'Materials::exportDataPolaOut');
$routes->get('export-produk-gesit', 'Products::exportDataGesit');
$routes->get('export-produk-masuk-lovish', 'Products::exportDataLovishIn');

// GUDANG Lovish
$routes->get('/gudang-lovish/dashboard', 'Home::gudangLovish');
$routes->get('/gudang-lovish/produk', 'Products::gudangLovishProduk');
$routes->get('/gudang-lovish/qr-scanner-product-out', 'QRCodeGenerator::scannerProductOut');
$routes->get('/gudang-lovish/qr-scanner-product-in', 'QRCodeGenerator::scannerProductRetur');
$routes->get('/gudang-lovish/qr-scanner-shipment', 'QRCodeGenerator::scannerShipment');
$routes->get('/gudang-lovish/cetak-pengiriman', 'Shippings::shipmentLovish');
$routes->get('/get-pengiriman-resi', 'Shippings::getResi');
$routes->post('/update-resi', 'Shippings::updateResi');
$routes->post('/tambah-pengiriman', 'Shippings::addShipping');
$routes->post('/generate-qr-shipment', 'QRCodeGenerator::generateQRShipment');


// GLOBAL API
$routes->post('/material-in-scanning', 'QRCodeGenerator::scanningMaterialIn');
$routes->post('/material-out-scanning', 'QRCodeGenerator::scanningMaterialOut');
$routes->post('/product-in-scanning', 'QRCodeGenerator::scanningProductIn');
$routes->post('/product-out-scanning', 'QRCodeGenerator::scanningProductOut');
$routes->post('/product-retur-scanning', 'QRCodeGenerator::scanningProductRetur');
$routes->post('/box-check-scanning', 'QRCodeGenerator::scanningBox');

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
