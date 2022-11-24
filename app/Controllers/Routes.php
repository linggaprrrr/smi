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
$routes->post('/import-vendor-pola', 'Reports::importVendorPola');
$routes->post('/simpan-vendor-pola', 'Materials::saveVendorPola');
$routes->post('/update-vendor-pola', 'Materials::updateVendorPola');
$routes->post('/simpan-gelar', 'Materials::saveGelar');
$routes->post('/update-gelar', 'Materials::updateGelar');
$routes->post('/simpan-cutting', 'Materials::saveCutting');
$routes->post('/update-cutting', 'Materials::updateCutting');


$routes->post('/generate-qr', 'QRCodeGenerator::generateQR');
$routes->post('/generate-qr-produk', 'QRCodeGenerator::generateQRProduct');
$routes->post('/generate-qr-produk-reject', 'QRCodeGenerator::generateQRProductReject');
$routes->get('/export-data-kain', 'Materials::exportData');
$routes->get('/export-data-kain/(:any)/(:any)', 'Materials::exportData/$1/$2');
$routes->get('/export-produk-reject', 'Products::exportProductReject');
$routes->get('/export-produk-reject/(:any)/(:any)', 'Products::exportProductReject/$1/$2');
$routes->post('/simpan-user', 'Users::saveUser');
$routes->post('/update-user', 'Users::updateUser');

$routes->post('/tambah-produk', 'Products::addProduct');
$routes->post('/tambah-produk-lovish', 'Products::addProductLovish');
$routes->get('/get-produk-detail', 'Products::getProductDetail');
$routes->post('/update-produk-detail', 'Products::updateProductDetail');
$routes->post('/tambah-kain', 'Materials::addMaterial');
$routes->get('/get-kain-detail', 'Materials::getMaterialDetail');
$routes->post('/update-kain-detail', 'Materials::updateMaterialDetail');

$routes->post('/upload-jenis-kain', 'Reports::uploadMaterialType');
$routes->post('/upload-jenis-model', 'Reports::uploadModelType');
$routes->post('/upload-jenis-produk', 'Reports::uploadProductType');
$routes->post('/upload-warna', 'Reports::uploadColor');
$routes->post('/upload-vendor-supplier', 'Reports::uploadVendorSupplier');
$routes->post('/upload-vendor-penjualan', 'Reports::uploadVendorSeller');
$routes->post('/upload-vendor-pola', 'Reports::uploadVendorPola');
$routes->post('/upload-gelar', 'Reports::uploadTimGelar');
$routes->post('/upload-cutting', 'Reports::uploadTimCutting');

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
$routes->post('/delete-product-detail-lovish', 'Products::deleteProductDetail');
$routes->get('/get-model', 'Products::getModel');
$routes->post('/delete-model', 'Products::deleteModel');
$routes->post('/delete-model-detail', 'Products::deleteModelDetail');
$routes->get('/get-warna', 'Materials::getColor');
$routes->post('/delete-warna', 'Materials::deleteColor');
$routes->get('/get-vendor-supplier', 'Materials::getVendorSupplier');
$routes->post('/update-vendor-supplier', 'Materials::updateVendorSupplier');
$routes->post('/delete-vendor-supplier', 'Materials::deleteVendorSupplier');
$routes->get('/get-vendor-penjualan', 'Materials::getVendorSelling');
$routes->get('/get-vendor-pola', 'Materials::getVendorPola');
$routes->post('/update-vendor-penjualan', 'Materials::updateVendorSelling');
$routes->post('/delete-vendor-penjualan', 'Materials::deleteVendorSelling');
$routes->post('/delete-vendor-pola', 'Materials::deleteVendorPola');
$routes->post('/delete-gelar', 'Materials::deleteGelar');
$routes->post('/delete-cutting', 'Materials::deleteCutting');
$routes->get('/get-pengiriman-detail', 'Shippings::getShippingDetail');
$routes->get('/get-vendor-kain', 'Materials::getVendor');
$routes->post('/update-coa', 'Materials::updateCOA');
$routes->get('/get-coa', 'Materials::getCOA');



// GUDANG Gesit
$routes->get('/gudang-gesit/dashboard', 'Home::gudangGesit');
$routes->get('/gudang-gesit/produk', 'Products::gudangGesitProduk');
$routes->get('/gudang-gesit/kain', 'Materials::gudangGesitKain');
$routes->get('/gudang-gesit/qr-generator-kain', 'QRCodeGenerator::QRGeneratorMaterialGesit');
$routes->get('/gudang-gesit/qr-generator-produk-masuk', 'QRCodeGenerator::QRGeneratorProductInGesit');
$routes->get('/gudang-gesit/qr-scanner-in', 'QRCodeGenerator::scannerMaterialIn');
$routes->get('/gudang-gesit/qr-scanner-pola-in', 'QRCodeGenerator::scannerPolaIn');
$routes->get('/gudang-gesit/qr-scanner-pola-out', 'QRCodeGenerator::scannerPolaOut');
$routes->get('/gudang-gesit/qr-scanner-retur', 'QRCodeGenerator::scannerMaterialRetur');
$routes->get('/gudang-gesit/qr-scanner-produk-in', 'QRCodeGenerator::scannerProductIn');
$routes->get('/gudang-gesit/qr-scanner-cutting', 'QRCodeGenerator::scannerCutting');
$routes->get('/gudang-gesit/qr-scanner-reject', 'QRCodeGenerator::scannerReject');
$routes->get('/gudang-gesit/qr-scanner-penjualan-reject', 'QRCodeGenerator::scannerSellingReject');
$routes->get('/gudang-gesit/laporan', 'Reports::reportGesit');
$routes->get('/gudang-gesit/laporan/(:any)', 'Reports::reportGesit/$1');
$routes->get('/gudang-gesit/gudang-reject', 'Products::gudangReject');
$routes->get('export-data-pola-in', 'Materials::exportDataPolaIn');
$routes->get('export-data-pola-in/(:any)/(:any)', 'Materials::exportDataPolaIn/$1/$2');
$routes->get('export-data-pola-out', 'Materials::exportDataPolaOut');
$routes->get('export-data-pola-out/(:any)/(:any)', 'Materials::exportDataPolaOut/$1/$2');
$routes->get('export-produk-gesit', 'Products::exportDataGesit');
$routes->get('export-produk-gesit/(:any)/(:any)', 'Products::exportDataGesit/$1/$2');
$routes->get('export-produk-masuk-lovish', 'Products::exportDataLovishIn');
$routes->get('export-produk-masuk-lovish/(:any)/(:any)', 'Products::exportDataLovishIn/$1/$2');
$routes->get('export-pengiriman', 'Shippings::exportShipments');
$routes->get('export-data-cutting', 'Materials::exportDataCutting');
$routes->get('export-data-cutting/(:any)/(:any)', 'Materials::exportDataCutting/$1/$2');
$routes->get('export-data-stok-produk', 'Products::exportDataStokProduct');

// produk gesit
$routes->post('on-change-product-type', 'Products::onChangeProductType');
$routes->post('on-change-model-name', 'Products::onChangeModelName');
$routes->post('on-change-product-qty', 'Products::onChangeProductQty');
$routes->post('on-change-product-weight', 'Products::onChangeProductWeight');
$routes->post('on-change-product-color', 'Products::onChangeProductColor');
$routes->post('on-change-product-hpp', 'Products::onChangeProductHPP');
$routes->get('get-hpp-product', 'Products::getHPP');
$routes->get('/get-jenis-kain', 'Materials::getJenisKain');
$routes->post('/simpan-reject', 'Products::simpanReject');
$routes->post('/jual-reject', 'Products::jualReject');

$routes->post('/on-change-cutting-product-type', 'Materials::onChangeCuttingProductType');
$routes->post('/on-change-cutting-product-type-pola', 'Materials::onChangeCuttingProductTypePola');
$routes->post('/on-change-cutting-qty', 'Materials::onChangeCuttingQty');
$routes->post('/on-change-cutting-qty-pola', 'Materials::onChangeCuttingQtyPola');
$routes->post('/on-change-jumlah-pola-out', 'Materials::onChangeJumlahPola');
$routes->post('/on-change-vendor-pola-out', 'Materials::onChangeVendorPola');
$routes->post('/on-change-reject', 'Materials::onChangeReject');

$routes->post('/on-change-jumlah-setor-pola-in', 'Materials::onChangeJumlahSetor');
$routes->get('/get-cutting', 'Materials::getCutting');
$routes->post('/save-pola-keluar', 'Materials::savePolaKeluar');
$routes->post('/save-pola-masuk', 'Materials::savePolaMasuk');
$routes->get('/get-pola-out', 'Materials::getPolaOut');

// produk lovish
$routes->post('on-change-product-type-lovish', 'Products::onChangeProductType');
$routes->post('on-change-model-name-lovish', 'Products::onChangeModelName');
$routes->post('on-change-product-qty-lovish', 'Products::onChangeProductQty');
$routes->post('on-change-product-weight-lovish', 'Products::onChangeProductWeight');
$routes->post('on-change-product-color-lovish', 'Products::onChangeProductColor');
$routes->post('on-change-product-hpp-lovish', 'Products::onChangeProductHPP');
$routes->get('get-hpp-product-lovish', 'Products::getHPP');


// kain
$routes->post('on-change-material-type', 'Materials::onChangeMaterialType');
$routes->post('on-change-material-color', 'Materials::onChangeMaterialColor');
$routes->post('on-change-material-weight', 'Materials::onChangeMaterialWeight');
$routes->post('on-change-material-vendor', 'Materials::onChangeMaterialVendor');
$routes->post('on-change-material-price', 'Materials::onChangeMaterialPrice');
$routes->post('on-change-material-gudang', 'Materials::onChangeMaterialGudang');
$routes->post('on-change-material-pic-cutting', 'Materials::onChangeMaterialCutting');
$routes->post('on-change-material-pic-gelar1', 'Materials::onChangeMaterialGelar1');
$routes->post('on-change-material-pic-gelar2', 'Materials::onChangeMaterialGelar2');
$routes->post('on-change-material-tgl-cutting', 'Materials::onChangeMaterialTglCutting');
$routes->post('on-change-material-vendor-pola', 'Materials::onChangeMaterialVendorPola');
$routes->post('/delete-cutting-pola', 'Materials::deleteCuttingPola');
$routes->post('/create-produk', 'Products::createProduct');

// GUDANG
$routes->get('/operasional/dashboard', 'Home::gudangLovish');
$routes->get('/operasional/produk', 'Products::gudangProduk');
$routes->get('/operasional/stok-produk', 'Products::gudangLovishStokProduk');
$routes->get('/operasional/qr-scanner-product-out', 'QRCodeGenerator::scannerProductOut');
$routes->get('/operasional/qr-scanner-product-retur', 'QRCodeGenerator::scannerProductRetur');
$routes->get('/operasional/qr-scanner-product-in', 'QRCodeGenerator::scannerProductIn');
$routes->get('/operasional/qr-scanner-product-so', 'QRCodeGenerator::scannerProductSO');
$routes->get('/operasional/qr-scanner-product-so-bulanan', 'QRCodeGenerator::scannerProductSOMonth');
$routes->get('/operasional/qr-scanner-product-so-replace', 'QRCodeGenerator::scannerProductSOReplace');
$routes->get('/operasional/qr-scanner-shipment', 'QRCodeGenerator::scannerShipment');
$routes->get('/operasional/cetak-pengiriman', 'Shippings::shipmentLovish');
$routes->get('/operasional/laporan', 'Reports::reportGudang');
$routes->get('/operasional/stock-opname', 'Products::stockOpname');
$routes->get('/operasional/laporan/(:any)', 'Reports::reportGudang/$1');
$routes->get('/get-pengiriman-resi', 'Shippings::getResi');
$routes->post('/update-resi', 'Shippings::updateResi');
$routes->post('/tambah-pengiriman', 'Shippings::addShipping');
$routes->post('/generate-qr-shipment', 'QRCodeGenerator::generateQRShipment');
$routes->post('/import-product', 'Products::importProduct');
$routes->get('/operasional/penjualan', 'Sellings::index');
$routes->post('/import-penjualan', 'Sellings::importSelling');
$routes->post('/update-hpp-jual', 'Sellings::updateHPPJual');

// GLOBAL API
$routes->post('/material-in-scanning', 'QRCodeGenerator::scanningMaterialIn');
$routes->post('/material-out-scanning', 'QRCodeGenerator::scanningMaterialOut');
$routes->post('/product-in-scanning', 'QRCodeGenerator::scanningProductIn');
$routes->post('/product-out-scanning', 'QRCodeGenerator::scanningProductOut');
$routes->post('/product-so-scanning', 'QRCodeGenerator::scanningProductSO');
$routes->post('/product-so-month-scanning', 'QRCodeGenerator::scanningProductSO');
$routes->post('/product-so-scanning-replace', 'QRCodeGenerator::scanningProductSOReplace');
$routes->post('/product-retur-scanning', 'QRCodeGenerator::scanningProductRetur');
$routes->post('/box-check-scanning', 'QRCodeGenerator::scanningBox');
$routes->post('/cut-in-scanning', 'QRCodeGenerator::scanningCutting');
$routes->post('/reject-in-scanning', 'QRCodeGenerator::scanningReject');
$routes->post('/reject-in-sold-scanning', 'QRCodeGenerator::scanningRejectSold');
$routes->post('/reject-in', 'Products::rejectIn');
$routes->post('/reject-permanent', 'Products::rejectPermanent');
$routes->post('/update-harga-jual', 'Products::updateHargaJualReject');


// test
$routes->get('/test', 'QRCodeGenerator::test');

// API 
$routes->post('/kirim-qr', 'Api::kirimQR');

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
