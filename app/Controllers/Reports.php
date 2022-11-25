<?php

namespace App\Controllers;

use App\Models\DesignModel;
use App\Models\MaterialModel;
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
        $date1 = null;
        $date2 = null;
        $picCutting = $this->materialModel->getAllPICCutting();
        $getAllTimGelar = $this->materialModel->getAllTimGelar();
        if (!is_null($date)) {
            $date = explode("-",$date);            
            $date1 = date('Y-m-d 00:00:00', strtotime($date[0]));
            $date2 = date('Y-m-d 00:00:00', strtotime($date[1]));
            $materials = $this->materialModel->getAllMaterial($date1, $date2);
            $models = $this->designModel->getAllModel();
            $polaOut = $this->materialModel->getAllPolaOut($date1, $date2);        
            $polaIn = $this->materialModel->getAllPolaIn($date1, $date2);
            $productsIn = $this->productModel->getAllProductInHistory($date1, $date2);
            $productsOut = $this->productModel->getAllProductOut($date1, $date2);
            $productReject = $this->productModel->getAllProductReject($date1, $date2);
            $cuttings = $this->materialModel->getAllCuttingData2($date1, $date2);
            $rejectedSold = $this->productModel->rejectedSold($date1. $date2);
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
                'date1' => $date[0],
                'date2' => $date[1],
                'picCutting' => $picCutting,
                'timGelars' => $getAllTimGelar,
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
                'picCutting' => $picCutting,
                'timGelars' => $getAllTimGelar,
            );
        }
       
        return view('gudang_gesit/reports', $data);    
    }

    public function reportGudang() {
        $date = $this->request->getVar('dates');
        $date1 = null;
        $date2 = null;
            
        
        if (!is_null($date)) {
            $date = explode("-",$date);            
            $date1 = date('Y-m-d H:i:s', strtotime($date[0]));
            $date2 = date('Y-m-d H:i:s', strtotime($date[1]));

            $materials = $this->materialModel->getAllMaterial($date1, $date2);
            $models = $this->designModel->getAllModel();
            $polaOut = $this->materialModel->getAllPolaOut($date1, $date2);        
            $polaIn = $this->materialModel->getAllPolaIn($date1, $date2);
            $productsIn = $this->productModel->getAllProductIn($date1, $date2);
            $productsOut = $this->productModel->getAllProductOut($date1, $date2);
            $cuttings = $this->materialModel->getAllCuttingData($date1, $date2); 
            $stokProduk = $this->productModel->getAllStockProductLovish($date1, $date2);
            $getStok = $this->productModel->getAllStockProductLovish($date1, $date2);
            $sisaStok = $this->productModel
                ->select('models.hpp, products.id, products.hpp_jual, products.model_id, models.jenis as product_name, model_name, color, size, product_barcodes.updated_at, stok_masuk, penjualan, stok_retur, pengiriman, (IFNULL(stok_masuk, 0) + IFNULL(stok, 0) + IFNULL(stok_retur, 0) - (IFNULL(penjualan, 0) + IFNULL(pengiriman, 0)) ) as sisa, stok')
                ->join('models', 'models.id = products.model_id')
                ->join('colors', 'colors.id = products.color_id')
                ->join('product_barcodes', 'product_barcodes.product_id = products.id')
                ->join('(SELECT id, SUM(qty) as stok FROM products WHERE status= 2 GROUP BY model_id, color_id, size) as a','products.id = a.id', 'left') 
                ->join('(SELECT product_barcodes.product_id, COUNT(product_barcodes.id) as stok_masuk FROM product_barcodes JOIN products ON products.id = product_barcodes.product_id WHERE product_barcodes.status != "0" AND product_barcodes.status != "1" GROUP BY model_id, color_id, size) as m', 'm.product_id = products.id', 'left')
                ->join('(SELECT product_barcodes.product_id, SUM(product_logs.qty) as penjualan FROM product_logs JOIN product_barcodes ON product_barcodes.id = product_logs.product_id JOIN products ON products.id = product_barcodes.product_id WHERE product_logs.status = 3 GROUP BY model_id, color_id, size) as k', 'k.product_id = products.id', 'left')
                ->join('(SELECT product_barcodes.product_id, SUM(product_logs.qty) as stok_retur FROM product_logs JOIN product_barcodes ON product_barcodes.id = product_logs.product_id JOIN products ON products.id = product_barcodes.product_id  WHERE product_logs.status = 4 GROUP BY model_id, color_id, size) as r', 'r.product_id = products.id', 'left')
                ->join('(SELECT product_barcodes.product_id, SUM(product_logs.qty) as pengiriman FROM product_logs JOIN product_barcodes ON product_barcodes.id = product_logs.product_id JOIN products ON products.id = product_barcodes.product_id  WHERE product_logs.status = 5 GROUP BY model_id, color_id, size) as s', 's.product_id = products.id', 'left')
                ->where('products.updated_at BETWEEN "'.$date1.'" AND "'.$date2.'"  ')
                
                ->groupBy('models.id, colors.id, products.size')
                ->get();
            $penjualan = $this->productModel->penjualan();
            $stok = array();
            $selling = 0;        
            
            if ($getStok->getNumRows() > 0) {
                foreach ($getStok->getResultObject() as $product) {                
                    if ($penjualan->getNumRows() > 0) {
                        foreach ($penjualan->getResultObject() as $sell) {                
                            
                            if (($sell->model_id == $product->model_id) && ($sell->color_id == $product->color_id) && ($sell->size == $product->size)) {
                                $selling = $selling + $sell->qty;                         
                            }
                        }        
                        $sisa = ($product->stok + $product->stok_masuk - ($selling - $product->stok_retur)) ;                                                            
                        array_push($stok, [
                            'id' => $product->id,
                            'model_id' => $product->model_id,
                            'product_name' => $product->product_name,
                            'model_name' => $product->model_name,
                            'color' => $product->color,
                            'size' => $product->size,
                            'stok' => $product->stok,
                            'stok_masuk' => $product->stok_masuk,
                            'penjualan' => $selling,
                            'scan_in' => $product->scan_in,
                            'stok_retur' => $product->stok_retur,
                            'sisa' => $sisa,
                            'hpp' => $product->hpp,
                            'hpp_jual' => $product->hpp_jual,
                        ]);
                        $selling = 0;
                    } else {
                        $sisa = ($product->stok + $product->stok_masuk - ($selling - $product->stok_retur)) ;                                                            
                        array_push($stok, [
                            'id' => $product->id,
                            'model_id' => $product->model_id,
                            'product_name' => $product->product_name,
                            'model_name' => $product->model_name,
                            'color' => $product->color,
                            'size' => $product->size,
                            'stok' => $product->stok,
                            'stok_masuk' => $product->stok_masuk,
                            'penjualan' => $selling,
                            'scan_in' => $product->scan_in,
                            'stok_retur' => $product->stok_retur,
                            'sisa' => $sisa,
                            'hpp' => $product->hpp,
                            'hpp_jual' => $product->hpp_jual,
                        ]);
                    }
                }
            }
            $shippings = $this->shippingModel
                ->where('created_at BETWEEN "'.$date1.'" AND "'.$date2.'" ')        
                ->orderBy('qrcode', 'asc')
                ->orderBy('created_at', 'desc')
                ->get();
                $date1 = date('m/d/Y', strtotime($date1));
                $date2 = date('m/d/Y', strtotime($date2));
            $data = array(
                'title' => 'Laporan',
                'materials' => $materials,
                'productsIn' => $productsIn,
                'productsOut' => $productsOut,
                'polaIn' => $polaIn,
                'polaOut' => $polaOut,
                'cuttings' => $cuttings,
                'models' => $models,
                'stokProduk' => $stok,
                'shippings' => $shippings,
                'date1' => $date1,  
                'date2' => $date2,
            );
        } else {

            $materials = $this->materialModel->getAllMaterial();
            $models = $this->designModel->getAllModel();
            $polaOut = $this->materialModel->getAllPolaOut();        
            $polaIn = $this->materialModel->getAllPolaIn();
            $productsIn = $this->productModel->getAllProductIn();
            $productsOut = $this->productModel->getAllProductOut();
            $cuttings = $this->materialModel->getAllCuttingData(); 
            $getStok = $this->productModel->getAllStockProductLovish();
            $penjualan = $this->productModel->penjualan();
             $sisaStok = $this->productModel
                ->select('models.hpp, products.id, products.hpp_jual, products.model_id, models.jenis as product_name, model_name, color, size, product_barcodes.updated_at, stok_masuk, penjualan, stok_retur, pengiriman, (IFNULL(stok_masuk, 0) + IFNULL(stok, 0) + IFNULL(stok_retur, 0) - (IFNULL(penjualan, 0) + IFNULL(pengiriman, 0)) ) as sisa, stok')
                ->join('models', 'models.id = products.model_id')
                ->join('colors', 'colors.id = products.color_id')
                ->join('product_barcodes', 'product_barcodes.product_id = products.id')
                ->join('(SELECT id, SUM(qty) as stok FROM products WHERE status= 2 GROUP BY model_id, color_id, size) as a','products.id = a.id', 'left') 
                ->join('(SELECT product_barcodes.product_id, COUNT(product_barcodes.id) as stok_masuk FROM product_barcodes JOIN products ON products.id = product_barcodes.product_id WHERE product_barcodes.status != "0" AND product_barcodes.status != "1" GROUP BY model_id, color_id, size) as m', 'm.product_id = products.id', 'left')
                ->join('(SELECT product_barcodes.product_id, SUM(product_logs.qty) as penjualan FROM product_logs JOIN product_barcodes ON product_barcodes.id = product_logs.product_id JOIN products ON products.id = product_barcodes.product_id WHERE product_logs.status = 3 GROUP BY model_id, color_id, size) as k', 'k.product_id = products.id', 'left')
                ->join('(SELECT product_barcodes.product_id, SUM(product_logs.qty) as stok_retur FROM product_logs JOIN product_barcodes ON product_barcodes.id = product_logs.product_id JOIN products ON products.id = product_barcodes.product_id  WHERE product_logs.status = 4 GROUP BY model_id, color_id, size) as r', 'r.product_id = products.id', 'left')
                ->join('(SELECT product_barcodes.product_id, SUM(product_logs.qty) as pengiriman FROM product_logs JOIN product_barcodes ON product_barcodes.id = product_logs.product_id JOIN products ON products.id = product_barcodes.product_id  WHERE product_logs.status = 5 GROUP BY model_id, color_id, size) as s', 's.product_id = products.id', 'left')
            
                ->groupBy('models.id, colors.id, products.size')
                ->get();
            $stok = array();
            $out = $this->productModel
            ->select('products.*')
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')
            ->where('product_barcodes.status', '3')
            ->get();
            $selling = 0;        
            if ($getStok->getNumRows() > 0) {
                foreach ($getStok->getResultObject() as $product) {                
                    if ($penjualan->getNumRows() > 0 || $out->getNumRows() > 0) {
                        foreach ($penjualan->getResultObject() as $sell) {                
                            if (($sell->model_id == $product->model_id) && ($sell->color_id == $product->color_id) && ($sell->size == $product->size)) {
                                $selling = $selling + $sell->qty;                         
                            }
                        }        
                        foreach($out->getResultObject() as $keluar) {
                            if (($keluar->model_id == $product->model_id) && ($keluar->color_id == $product->color_id) && ($keluar->size == $product->size)) {
                                $selling = $selling + 1;                         
                            }
                        }
                        $sisa = ($product->stok + $product->stok_masuk + $product->stok_retur - ($selling)) ;                                                            
                        array_push($stok, [
                            'id' => $product->id,
                            'model_id' => $product->model_id,
                            'product_name' => $product->product_name,
                            'model_name' => $product->model_name,
                            'color' => $product->color,
                            'size' => $product->size,
                            'stok' => $product->stok,
                            'stok_masuk' => $product->stok_masuk,
                            'penjualan' => $selling,
                            'stok_retur' => $product->stok_retur,
                            'sisa' => $sisa,
                            'hpp' => $product->hpp,
                            'hpp_jual' => $product->hpp_jual,
                        ]);
                        $selling = 0;
                    } else {
                        $sisa = ($product->stok + $product->stok_masuk + $product->stok_retur - ($selling)) ;                                                            
                        array_push($stok, [
                            'id' => $product->id,
                            'model_id' => $product->model_id,
                            'product_name' => $product->product_name,
                            'model_name' => $product->model_name,
                            'color' => $product->color,
                            'size' => $product->size,
                            'stok' => $product->stok,
                            'stok_masuk' => $product->stok_masuk,
                            'penjualan' => $selling,
                            'stok_retur' => $product->stok_retur,
                            'sisa' => $sisa,
                            'hpp' => $product->hpp,
                            'hpp_jual' => $product->hpp_jual,
                        ]);
                    }
                }
            }
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
                'models' => $models,
                'stokProduk' => $sisaStok,
                'shippings' => $shippings,
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
