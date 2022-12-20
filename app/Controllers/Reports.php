<?php

namespace App\Controllers;

use App\Models\DesignModel;
use App\Models\MaterialModel;
use App\Models\SellingModel;
use App\Models\ProductModel;
use App\Models\LogModel;
use App\Models\ShippingModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Reports extends BaseController
{   

    protected $materialModel = "";
    protected $productModel = "";
    protected $logModel = "";
    protected $shippingModel = "";
    protected $designModel = "";
    protected $sellingModel = "";
    
    public function __construct() { 
        $userId = session()->get('user_id');
        if (is_null($userId)) {            
            header('Location: '.base_url('/'));
            exit(); 
        }
        $this->materialModel = new MaterialModel();
        $this->productModel = new ProductModel();
        $this->logModel = new LogModel();
        $this->shippingModel = new ShippingModel();
        $this->designModel = new DesignModel();
        $this->sellingModel = new SellingModel();
    }

    public function index() {
        $materials = $this->materialModel->getAllMaterial();
        $models = $this->designModel->getAllModel();
        $polaOut = $this->materialModel->getAllPolaOut();        
        $polaIn = $this->materialModel->getAllPolaIn();
        $productsIn = $this->productModel->getAllProductIn();
        $productsOut = $this->productModel->getAllProductOut();
        $cuttings = $this->materialModel->getAllCuttingData();
        $shippings = $this->shippingModel
            ->orderBy('qrcode', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

            
        $data = array(
            'title' => 'Laporan',
            'materials' => $materials,
            'productsIn' => $productsIn,
            'productsOut' => $productsOut,
            'polaIn' => $polaIn,
            'polaOut' => $polaOut,
            'cuttings' => $cuttings,
            'shippings' => $shippings,
            'models' => $models

        );
        return view('admin/reports', $data);    
    }

    public function log() {
        $dailyLogs = $this->logModel->getDailyLogs();
        $logs = $this->logModel->getAllLogs();
        $data = array(
            'title' => 'Logs',
            'dailyLogs' => $dailyLogs,
            'logs' => $logs
        );
        return view('admin/logs', $data);
    }

    public function reportGesit() {   
        $date = $this->request->getVar('dates');
        $dates = $this->request->getVar('dates');
        $date1 = null;
        $date2 = null;
        $picCutting = $this->materialModel->getAllPICCutting();
        $getAllTimGelar = $this->materialModel->getAllTimGelar();
        if (!is_null($date)) {
            $date = explode("-",$date);            
            $date1 = date('Y-m-d H:i:s', strtotime($date[0]));
            $date2 = date('Y-m-d H:i:s', strtotime($date[1]));
            $materials = $this->materialModel->getAllMaterial($date1, $date2);
            $models = $this->designModel->getAllModel();
            $polaOut = $this->materialModel->getAllPolaOut($date1, $date2);        
            $polaIn = $this->materialModel->getAllPolaIn($date1, $date2);
            $productsIn = $this->productModel->getAllProductInHistory($date1, $date2);
            $productsOut = $this->productModel->getAllProductOut($date1, $date2);
            $productReject = $this->productModel->getAllProductReject($date1, $date2);
            $cuttings = $this->materialModel->getAllCuttingData2($date1, $date2);
            $rejectedSold = $this->productModel->rejectedSold($date1. $date2);
            $kainRetur = $this->materialModel
                ->select('materials.*, material_vendors.vendor, material_types.type, colors.color')
                ->join('material_types', 'materials.material_type = material_types.id')
                ->join('colors', 'colors.id = materials.color_id')
                ->join('material_vendors', 'material_vendors.id = materials.vendor_id')  
                ->where('materials.status', '0')
                ->where('materials.created_at BETWEEN "'.$date1.'" AND "'.$date2.'"  ')
                ->orderBy('materials.created_at', 'DESC')
                ->get();
            $data = array(
                'title' => 'Laporan',
                'materials' => $materials,
                'productsIn' => $productsIn,
                'productsOut' => $productsOut,
                'polaIn' => $polaIn,
                'polaOut' => $polaOut,
                'cuttings' => $cuttings,
                'productReject' => $productReject,
                'models' => $models,
                'rejectedSold' => $rejectedSold,
                'date1' => $date1,
                'date2' => $date2,
                'dates' => $dates,
                'picCutting' => $picCutting,
                'timGelars' => $getAllTimGelar,
                'kainRetur' => $kainRetur,
            );
        } else {
            $materials = $this->materialModel->getAllMaterial();
            $models = $this->designModel->getAllModel();
            $polaOut = $this->materialModel->getAllPolaOut();        
            $polaIn = $this->materialModel->getAllPolaIn();
            $productsIn = $this->productModel->getAllProductInHistory();
            $productsOut = $this->productModel->getAllProductOut();
            $cuttings = $this->materialModel->getAllCuttingData2();
            $productReject = $this->productModel->getAllProductReject();
            $rejectedSold = $this->productModel->rejectedSold();
            $kainRetur = $this->materialModel
                ->select('materials.*, material_vendors.vendor, material_types.type, colors.color')
                ->join('material_types', 'materials.material_type = material_types.id')
                ->join('colors', 'colors.id = materials.color_id')
                ->join('material_vendors', 'material_vendors.id = materials.vendor_id')  
                ->where('materials.status', '0')
                ->orderBy('materials.created_at', 'DESC')
                ->get();
            $data = array(
                'title' => 'Laporan',
                'materials' => $materials,
                'productsIn' => $productsIn,
                'productsOut' => $productsOut,
                'polaIn' => $polaIn,
                'polaOut' => $polaOut,
                'cuttings' => $cuttings,
                'productReject' => $productReject,
                'models' => $models,
                'rejectedSold' => $rejectedSold,
                'date1' => $date1,
                'date2' => $date2,
                'dates' => $dates,
                'picCutting' => $picCutting,
                'timGelars' => $getAllTimGelar,
                'kainRetur' => $kainRetur,
            );
        }
       
        return view('gudang_gesit/reports', $data);    
    }

    public function reportGudang() {
        $date = $this->request->getVar('dates');
        $dates = $this->request->getVar('dates');
        if (is_null($date)) {
            $models = $this->designModel->getAllModel();
            $colors = $this->materialModel->getAllColors();
            $vendors = $this->productModel->getAllVendorPenjualan();
            $products = $this->productModel->getAllStockProductLovish();
         
            $penjualan = $this->sellingModel
                ->select('sellings.*')
                ->join('models', 'models.id = sellings.model_id')
                ->join('colors', 'colors.id = sellings.color_id')            
                ->get();        
            $stok = array();        
            $sisaStok = $this->productModel
                    ->select('models.hpp, products.id, products.hpp_jual, products.model_id, products.color_id, products.size, models.jenis as product_name, model_name, color, products.size, product_barcodes.updated_at, stok_masuk, penjualan, stok_retur, pengiriman, stok')
                    ->join('models', 'models.id = products.model_id')
                    ->join('colors', 'colors.id = products.color_id')
                    ->join('product_barcodes', 'product_barcodes.product_id = products.id')
                    ->join('(SELECT history_stok.model_id, history_stok.color_id, updated_at, SUM(history_stok.qty) as stok FROM history_stok WHERE jenis="sisa_pengiriman" AND status = 0 GROUP BY model_id, color_id, size) as a','products.model_id = a.model_id AND a.color_id = products.color_id', 'left') 
                    ->join('(SELECT history_stok.model_id, history_stok.color_id, updated_at, SUM(history_stok.qty) as stok_masuk FROM history_stok WHERE jenis="in" AND status = 0 GROUP BY model_id, color_id, size) as m', 'm.model_id = products.model_id AND m.color_id = products.color_id', 'left')
                    ->join('(SELECT history_stok.model_id, history_stok.color_id, updated_at, SUM(history_stok.qty) as penjualan FROM history_stok WHERE jenis="penjualan" AND status = 0 GROUP BY model_id, color_id, size) as k', 'k.model_id = products.model_id AND k.color_id = products.color_id', 'left')                
                    ->join('(SELECT history_stok.model_id, history_stok.color_id, updated_at, SUM(history_stok.qty) as stok_retur FROM history_stok WHERE jenis="retur" AND status = 0 GROUP BY model_id, color_id, size) as r', 'r.model_id = products.model_id AND r.color_id = products.color_id', 'left')
                    ->join('(SELECT history_stok.model_id, history_stok.color_id, updated_at, SUM(history_stok.qty) as pengiriman FROM history_stok WHERE jenis="pengiriman" AND status = 0 GROUP BY model_id, color_id, size) as s', 's.model_id = products.model_id AND s.color_id = products.color_id', 'left')
                    ->groupBy('models.id, colors.id, products.size')
                    ->get();                
            $selling = 0;             
            $stokIn = $this->productModel
                ->where('status', '2')
                ->get();
            $toIn = 0;
            if ($sisaStok->getNumRows() > 0) {
                foreach ($sisaStok->getResultObject() as $product) {                
                    if ($penjualan->getNumRows() > 0) {                          
                        foreach ($stokIn->getResultObject() as $in) {                                        
                            if (($in->model_id == $product->model_id) && ($in->color_id == $product->color_id) && ($in->size == $product->size)) {
                                $toIn = $toIn + $in->qty;                         
                            }    
                        }
                        $sisa = ($toIn + $product->stok + $product->stok_masuk + $product->stok_retur - ($product->penjualan + $selling)) ;
                        $sisa_gudang = ($toIn + $product->stok + $product->stok_masuk + $product->stok_retur - $product->pengiriman) ;                                                            
                        array_push($stok, [
                            'id' => $product->id,
                            'model_id' => $product->model_id,
                            'product_name' => $product->product_name,
                            'model_name' => $product->model_name,
                            'color' => $product->color,
                            'size' => $product->size,
                            'stok' => ($product->stok + $toIn),
                            'stok_masuk' => $product->stok_masuk,
                            'penjualan' => $selling + $product->penjualan,
                            'pengiriman' => $product->pengiriman,
                            'stok_retur' => $product->stok_retur,
                            'sisa' => $sisa,
                            'sisa_gudang' => $sisa_gudang,
                            'hpp' => $product->hpp,
                            'hpp_jual' => $product->hpp_jual,
                        ]);
                        $selling = 0;
                        $toIn = 0;
                    } else {
                        
                        foreach ($stokIn->getResultObject() as $in) {                                        
                            if (($in->model_id == $product->model_id) && ($in->color_id == $product->color_id) && ($in->size == $product->size)) {
                                $toIn = $toIn + $in->qty;                         
                            }    
                        }
                        $sisa = ($toIn + $product->stok + $product->stok_masuk + $product->stok_retur - ($product->penjualan + $selling)) ;
                        $sisa_gudang = ($toIn + $product->stok + $product->stok_masuk + $product->stok_retur - $product->pengiriman) ;                                                            
                        array_push($stok, [
                            'id' => $product->id,
                            'model_id' => $product->model_id,
                            'product_name' => $product->product_name,
                            'model_name' => $product->model_name,
                            'color' => $product->color,
                            'size' => $product->size,
                            'stok' => ($product->stok + $toIn),
                            'stok_masuk' => $product->stok_masuk,
                            'penjualan' => $product->penjualan,
                            'pengiriman' => $product->pengiriman,
                            'stok_retur' => $product->stok_retur,
                            'sisa' => $sisa,
                            'sisa_gudang' => $sisa_gudang,
                            'hpp' => $product->hpp,
                            'hpp_jual' => $product->hpp_jual,
                        ]);
                        $toIn = 0;
                    }
                }
            } else {
                if ($penjualan->getNumRows() > 0) {
                    
                }
            }

            $shippings = $this->shippingModel
                ->select('shippings.*, shipping_details.product_id')
                ->join('shipping_details', 'shipping_details.shipping_id = shippings.id')                
                ->orderBy('qrcode', 'asc')
                ->orderBy('created_at', 'desc')
                ->groupBy('shippings.id')
                ->get();
                    
            $data = array(
                'title' => 'Stock Produk',
                'models' => $models,
                'stokProduk' => $stok,
                'shippings' => $shippings,
                'colors' => $colors,
                'vendors' => $vendors,
                'date1' => null
            );
        } else {
            $date = explode("-",$date);   
            $date1 = date('Y-m-d H:i:s', strtotime($date[0]));
            $date2 = date('Y-m-d H:i:s', strtotime($date[1]));
            $models = $this->designModel->getAllModel();
            $colors = $this->materialModel->getAllColors();
            $vendors = $this->productModel->getAllVendorPenjualan();
            $products = $this->productModel->getAllStockProductLovish();
         
            $penjualan = $this->sellingModel
                ->select('sellings.*')
                ->join('models', 'models.id = sellings.model_id')
                ->join('colors', 'colors.id = sellings.color_id')            
                ->where('sellings.created_at BETWEEN "'.$date1.'" AND "'.$date2.'"  ')
                ->get();        
            $stok = array();        
            $sisaStok = $this->productModel
                    ->select('models.hpp, products.id, products.hpp_jual, products.model_id, products.color_id, products.size, models.jenis as product_name, model_name, color, products.size, product_barcodes.updated_at, stok_masuk, penjualan, stok_retur, pengiriman, (IFNULL(stok_masuk, 0) + IFNULL(stok, 0) + IFNULL(stok_retur, 0) - (IFNULL(penjualan, 0) + IFNULL(pengiriman, 0)) ) as sisa, stok')
                    ->join('models', 'models.id = products.model_id')
                    ->join('colors', 'colors.id = products.color_id')
                    ->join('product_barcodes', 'product_barcodes.product_id = products.id')
                    ->join('(SELECT history_stok.model_id, history_stok.color_id, updated_at, SUM(history_stok.qty) as stok FROM history_stok WHERE jenis="sisa_pengiriman" AND (created_at BETWEEN "'.$date1.'" AND "'.$date2.'") GROUP BY model_id, color_id, size) as a','products.model_id = a.model_id AND a.color_id = products.color_id', 'left') 
                    ->join('(SELECT history_stok.model_id, history_stok.color_id, updated_at, SUM(history_stok.qty) as stok_masuk FROM history_stok WHERE jenis="in" AND (created_at BETWEEN "'.$date1.'" AND "'.$date2.'") GROUP BY model_id, color_id, size) as m', 'm.model_id = products.model_id AND m.color_id = products.color_id', 'left')
                    ->join('(SELECT history_stok.model_id, history_stok.color_id, updated_at, SUM(history_stok.qty) as penjualan FROM history_stok WHERE jenis="penjualan" AND (created_at BETWEEN "'.$date1.'" AND "'.$date2.'") GROUP BY model_id, color_id, size) as k', 'k.model_id = products.model_id AND k.color_id = products.color_id', 'left')                
                    ->join('(SELECT history_stok.model_id, history_stok.color_id, updated_at, SUM(history_stok.qty) as stok_retur FROM history_stok WHERE jenis="retur" AND (created_at BETWEEN "'.$date1.'" AND "'.$date2.'") GROUP BY model_id, color_id, size) as r', 'r.model_id = products.model_id AND r.color_id = products.color_id', 'left')
                    ->join('(SELECT history_stok.model_id, history_stok.color_id, updated_at, SUM(history_stok.qty) as pengiriman FROM history_stok WHERE jenis="pengiriman" AND (created_at BETWEEN "'.$date1.'" AND "'.$date2.'") GROUP BY model_id, color_id, size) as s', 's.model_id = products.model_id AND s.color_id = products.color_id', 'left')
                    ->groupBy('models.id, colors.id, products.size')
                    ->get();
            $selling = 0;             
            $stokIn = $this->productModel
                ->where('status', '2')
                ->where('created_at BETWEEN "'.$date1.'" AND "'.$date2.'"  ')
                ->get();
            $toIn = 0;
            if ($sisaStok->getNumRows() > 0) {
                foreach ($sisaStok->getResultObject() as $product) {                
                    if ($penjualan->getNumRows() > 0) {                          
                        foreach ($stokIn->getResultObject() as $in) {                                        
                            if (($in->model_id == $product->model_id) && ($in->color_id == $product->color_id) && ($in->size == $product->size)) {
                                $toIn = $toIn + $in->qty;   
                            }    
                        }
                        $sisa = ($toIn + $product->stok + $product->stok_masuk + $product->stok_retur - ($product->penjualan + $selling)) ;
                        $sisa_gudang = ( $toIn + $product->stok + $product->stok_masuk + $product->stok_retur - $product->pengiriman) ;                                                            
                        array_push($stok, [
                            'id' => $product->id,
                            'model_id' => $product->model_id,
                            'product_name' => $product->product_name,
                            'model_name' => $product->model_name,
                            'color' => $product->color,
                            'size' => $product->size,
                            'stok' => ($product->stok + $toIn),
                            'stok_masuk' => $product->stok_masuk,
                            'penjualan' => $selling + $product->penjualan,
                            'pengiriman' => $product->pengiriman,
                            'stok_retur' => $product->stok_retur,
                            'sisa' => $sisa,
                            'sisa_gudang' => $sisa_gudang,
                            'hpp' => $product->hpp,
                            'hpp_jual' => $product->hpp_jual,
                        ]);
                        $selling = 0;
                        $toIn = 0;
                    } else {
                        
                        foreach ($stokIn->getResultObject() as $in) {                                        
                            if (($in->model_id == $product->model_id) && ($in->color_id == $product->color_id) && ($in->size == $product->size)) {
                                $toIn = $toIn + $product->stok + 1;                         
                            }    
                        }
                        $sisa = ($toIn + $product->stok + $product->stok_masuk + $product->stok_retur - ($product->penjualan + $selling)) ;
                        $sisa_gudang = ($toIn + $product->stok + $product->stok_masuk + $product->stok_retur - $product->pengiriman) ;                                                            
                        array_push($stok, [
                            'id' => $product->id,
                            'model_id' => $product->model_id,
                            'product_name' => $product->product_name,
                            'model_name' => $product->model_name,
                            'color' => $product->color,
                            'size' => $product->size,
                            'stok' => $toIn,
                            'stok_masuk' => $product->stok_masuk,
                            'penjualan' => $product->penjualan,
                            'pengiriman' => $product->pengiriman,
                            'stok_retur' => $product->stok_retur,
                            'sisa' => $sisa,
                            'sisa_gudang' => $sisa_gudang,
                            'hpp' => $product->hpp,
                            'hpp_jual' => $product->hpp_jual,
                        ]);
                        $toIn = 0;
                    }
                }
            } else {
                if ($penjualan->getNumRows() > 0) {
                    
                }
            }
            $shippings = $this->shippingModel
                ->select('shippings.*, shipping_details.product_id')
                ->join('shipping_details', 'shipping_details.shipping_id = shippings.id')
                ->where('shippings.created_at BETWEEN "'.$date1.'" AND "'.$date2.'"  ')
                ->orderBy('qrcode', 'asc')
                ->orderBy('created_at', 'desc')
                ->groupBy('shippings.id')
                ->get();
                    
            $data = array(
                'title' => 'Reports',
                'models' => $models,
                'stokProduk' => $stok,
                'colors' => $colors,
                'shippings' => $shippings,
                'vendors' => $vendors,
                'dates' => $dates,
                'date1' => $date1,
                'date2' => $date2,
            );
        }
        return view('gudang_lovish/reports', $data);    
    }

    public function uploadMaterialType() {
        $file = $this->request->getFile('file');
    
        $ext = $file->getClientExtension();
        if ($ext == 'xls') {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
        $spreadsheet = $render->load($file);
        $data = $spreadsheet->getActiveSheet()->toArray();
        foreach ($data as $idx => $row) {
            if ($idx > 0) {                
                $data = $row[1];
                $harga = $row[2];
                $this->materialModel->importMaterial($data, $harga);
            }
        } 
        return redirect()->back()->with('create', 'Kain berhasil diimport');
    }

    public function uploadModelType() {
        $file = $this->request->getFile('file');
    
        $ext = $file->getClientExtension();
        if ($ext == 'xls') {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
        $spreadsheet = $render->load($file);
        $data = $spreadsheet->getActiveSheet()->toArray();
        foreach ($data as $idx => $row) {
            if ($idx > 0) {       
                $brand = $row[1];
                $jenis = $row[2];         
                $data = $row[3];
                $jahit = $row[4];
                $hpp = $row[5];
                $this->materialModel->importModel($brand, $jenis, $data, $jahit, $hpp);
            }
        } 
        return redirect()->back()->with('create', 'Model berhasil diimport');
    }
    public function uploadProductType() {
        $file = $this->request->getFile('file');
    
        $ext = $file->getClientExtension();
        if ($ext == 'xls') {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
        $spreadsheet = $render->load($file);
        $data = $spreadsheet->getActiveSheet()->toArray();
        foreach ($data as $idx => $row) {
            if ($idx > 0) {                
                $data = $row[1];
                $this->materialModel->importProduk($data);
            }
        } 
        return redirect()->back()->with('create', 'Produk berhasil diimport');
    }
    public function uploadColor() {
        $file = $this->request->getFile('file');
    
        $ext = $file->getClientExtension();
        if ($ext == 'xls') {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
        $spreadsheet = $render->load($file);
        $data = $spreadsheet->getActiveSheet()->toArray();
        foreach ($data as $idx => $row) {
            if ($idx > 0) {                
                $data = $row[1];
                $this->materialModel->importColor($data);
            }
        } 
        return redirect()->back()->with('create', 'Kain berhasil diimport');
    }
    public function uploadVendorSupplier() {
        $file = $this->request->getFile('file');
    
        $ext = $file->getClientExtension();
        if ($ext == 'xls') {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
        $spreadsheet = $render->load($file);
        $data = $spreadsheet->getActiveSheet()->toArray();
        foreach ($data as $idx => $row) {
            if ($idx > 0) {                
                $data = $row[1];
                $this->materialModel->importVendorSupp($data);
            }
        } 
        return redirect()->back()->with('create', 'Vendor berhasil diimport');
    }
    public function uploadVendorSeller() {
        $file = $this->request->getFile('file');
    
        $ext = $file->getClientExtension();
        if ($ext == 'xls') {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
        $spreadsheet = $render->load($file);
        $data = $spreadsheet->getActiveSheet()->toArray();
        foreach ($data as $idx => $row) {
            if ($idx > 0) {                
                $data = $row[1];
                $this->materialModel->importVendorSell($data);
            }
        } 
        return redirect()->back()->with('create', 'Vendor berhasil diimport');
    }

    public function uploadVendorPola() {
        $file = $this->request->getFile('file');
    
        $ext = $file->getClientExtension();
        if ($ext == 'xls') {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
        $spreadsheet = $render->load($file);
        $data = $spreadsheet->getActiveSheet()->toArray();
        foreach ($data as $idx => $row) {
            if ($idx > 0) {                
                $data = $row[1];
                $this->materialModel->saveVendorPola($data);
            }
        } 
        return redirect()->back()->with('create', 'Vendor berhasil diimport');
    }

    public function uploadTimGelar() {
        $file = $this->request->getFile('file');
    
        $ext = $file->getClientExtension();
        if ($ext == 'xls') {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
        $spreadsheet = $render->load($file);
        $data = $spreadsheet->getActiveSheet()->toArray();
        foreach ($data as $idx => $row) {
            if ($idx > 0) {                
                $data = $row[1];
                $this->materialModel->saveTimGelar($data);
            }
        } 
        return redirect()->back()->with('create', 'Tim berhasil diimport');
    }
  
    public function uploadTimCutting() {
        $file = $this->request->getFile('file');
    
        $ext = $file->getClientExtension();
        if ($ext == 'xls') {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
        $spreadsheet = $render->load($file);
        $data = $spreadsheet->getActiveSheet()->toArray();
        foreach ($data as $idx => $row) {
            if ($idx > 0) {                
                $data = $row[1];
                $this->materialModel->saveTimCutting($data);
            }
        } 
        return redirect()->back()->with('create', 'Tim berhasil diimport');
    }

    public function getReport() {
        $dates = $this->request->getVar('dates');
        dd($dates);
    }

}
