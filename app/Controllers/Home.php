<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\DesignModel;
use App\Models\MaterialModel;
use App\Models\ShippingModel;

class Home extends BaseController
{
    protected $productModel = "";
    protected $designModel = "";
    protected $materialModel = "";
    protected $shippinglModel = "";

    public function __construct() { 
        $userId = session()->get('user_id');
        if (is_null($userId)) {            
            header('Location: '.base_url('/'));
            exit(); 
        }

        $this->productModel = new ProductModel();
        $this->designModel = new DesignModel();
        $this->materialModel = new MaterialModel();
        $this->shippinglModel = new ShippingModel();
    }

    public function index() {
        
        $productsOut = $this->productModel->getStokProductOut();
        $productsRetur = $this->productModel->productsRetur();
        $productsExp = $this->productModel->getStokProductExp();
        $productLovish = $this->productModel->getAllStockProductLovish();
        $getStok = $this->productModel->getAllStockProductLovish();
        $penjualan = $this->productModel->penjualan();
        $stok = array();
        $selling = 0;        
        $totalNilaiBarang = 0;
        $totalNilaiBarangJual = 0;
        if ($getStok->getNumRows() > 0) {
            foreach ($getStok->getResultObject() as $product) {                
                if ($penjualan->getNumRows() > 0) {
                    foreach ($penjualan->getResultObject() as $sell) {                
                        if (($sell->model_id == $product->model_id) && ($sell->color_id == $product->color_id) && ($sell->size == $product->size)) {
                            $selling = $selling + $sell->qty;                         
                        }
                    }        
                    $sisa = ($product->stok + $product->stok_masuk - ($selling - $product->stok_retur)) ;                                                                               
                    $selling = 0;
                    array_push($stok, [
                        'product_id' => $product->product_id,
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
                } else {
                    $sisa = ($product->stok + $product->stok_masuk - ($selling - $product->stok_retur)) ;                                                            
                    array_push($stok, [
                        'product_id' => $product->product_id,
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
                $totalNilaiBarang = $totalNilaiBarang + ($product->hpp * $sisa);
                $totalNilaiBarangJual = $totalNilaiBarangJual + ($product->hpp_jual * $sisa);
            }
        }
        $totalGudang = $this->productModel
            ->select('SUM(qty) as stok')
            ->where('status', '2')
            ->first();
        $totalStokMasuk = $this->productModel
            ->select('SUM(product_logs.qty) as stok')
            ->join('product_logs', 'product_logs.product_id = products.id')
            ->where('product_logs.status', '2')
            ->where('MONTH(product_logs.created_at) = MONTH(CURRENT_DATE())')
            ->where('YEAR(product_logs.created_at) = YEAR(CURRENT_DATE())')
            ->first();
        $stokKeluar = $this->productModel
            ->select('SUM(product_logs.qty) as stok')
            ->join('product_logs', 'product_logs.product_id = products.id')
            ->where('product_logs.status', '3')
            ->where('MONTH(product_logs.created_at) = MONTH(CURRENT_DATE())')
            ->where('YEAR(product_logs.created_at) = YEAR(CURRENT_DATE())')
            ->first();
        $stokRetur = $this->productModel
            ->select('SUM(product_logs.qty) as stok')
            ->join('product_logs', 'product_logs.product_id = products.id')
            ->where('product_logs.status', '4')
            ->where('MONTH(product_logs.created_at) = MONTH(CURRENT_DATE())')
            ->where('YEAR(product_logs.created_at) = YEAR(CURRENT_DATE())')
            ->first();
        $productsIn = $this->productModel
            ->select('model_name, jenis as product_name, color, size, SUM(product_logs.qty) as stok')
            ->join('models', 'models.id = products.model_id')
            ->join('colors', 'colors.id = products.color_id')
            ->join('product_logs', 'product_logs.product_id = products.id')
            ->where('product_logs.status', '2')
            ->where('product_logs.qty > ', '0')
            ->where('MONTH(product_logs.created_at) = MONTH(CURRENT_DATE())')
            ->where('YEAR(product_logs.created_at) = YEAR(CURRENT_DATE())')
            ->groupBy('model_id, product_logs.product_id, color_id, size')   
            ->get();
        $shippings = $this->shippinglModel
            ->select('shippings.*, shipping_details.product_id')
            ->join('shipping_details', 'shipping_details.shipping_id = shippings.id')
            ->orderBy('qrcode', 'asc')
            ->orderBy('created_at', 'desc')
            ->groupBy('shippings.id')
            ->get();
        /////////
        $totalKainGesit= $this->materialModel->select('COUNT(*) as total_kain')
            ->where('status','1')
            ->first();
        $totalKainGesitMonth = $this->materialModel->select('COUNT(*) as total_kain_month')
            ->where('status','1')
            ->where('MONTH(created_at) = MONTH(CURRENT_DATE())')
            ->where('YEAR(created_at) = YEAR(CURRENT_DATE())')
            ->first();
        $totalCutting = $this->materialModel->select('COUNT(*) as total_cutting')
            ->join('cutting', 'cutting.material_id = materials.id')
            ->where('MONTH(cutting.tgl) = MONTH(CURRENT_DATE())')
            ->where('YEAR(cutting.tgl) = YEAR(CURRENT_DATE())')
            ->first();
        $totalPolaKeluar = $this->materialModel->select('COUNT(*) as total_pola_keluar')
            ->join('cutting', 'cutting.material_id = materials.id')    
            ->join('pola', 'pola.cutting_id = cutting.id')            
            ->where('MONTH(tgl_ambil) = MONTH(CURRENT_DATE())')
            ->where('YEAR(tgl_ambil) = YEAR(CURRENT_DATE())')
            ->where('pola.status', '1')
            ->first();
        $totalPolaMasuk = $this->materialModel->select('COUNT(*) as total_pola_masuk')
            ->join('cutting', 'cutting.material_id = materials.id')    
            ->join('pola', 'pola.cutting_id = cutting.id')            
            ->where('MONTH(tgl_ambil) = MONTH(CURRENT_DATE())')
            ->where('YEAR(tgl_ambil) = YEAR(CURRENT_DATE())')
            ->where('pola.status', '2')
            ->first();
        $totalKainRetur = $this->materialModel->select('COUNT(*) as total_kain')
            ->where('MONTH(created_at) = MONTH(CURRENT_DATE())')
            ->where('YEAR(created_at) = YEAR(CURRENT_DATE())')
            ->where('status','0')
            ->first();
        $polaReject = $this->materialModel->select("SUM(reject) as total_pola")
            ->join('cutting', 'cutting.material_id = materials.id')
            ->join('pola', 'pola.cutting_id = cutting.id')
            ->where('MONTH(tgl_setor) = MONTH(CURRENT_DATE())')
            ->where('YEAR(tgl_setor) = YEAR(CURRENT_DATE())')
            ->first();
        $totalGesit = $this->productModel
            ->select('products.qty - SUM(IFNULL(product_logs.qty,0)) as qty')
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')
            ->join('product_logs', 'product_logs.product_id = product_barcodes.id', 'left')
            ->first();
        $materials = $this->materialModel->getStokMaterialIn();
        $productsInGesit = $this->productModel->getStokProductIn(); 
        $productsOutGesit = $this->productModel->getStokProductOut();           
        $models = $this->designModel->getAllModel();
        $data = array(
            'title' => 'Dashboard',
            'totalGudang' => $totalGudang,
            'totalStokMasuk' => $totalStokMasuk,
            'stokKeluar' => $stokKeluar,
            'stokRetur' => $stokRetur,
            'productsIn' => $productsIn,
            'productsOut' => $productsOut,
            'productsExp' => $productsExp,
            'productLovish' => $stok,
            'totalNilaiBarang' => $totalNilaiBarang,
            'totalNilaiBarangJual' => $totalNilaiBarangJual,
            'productsRetur' => $productsRetur,
            'shippings' => $shippings,
            'totalGesit' => $totalGesit['qty'],
            'totalKainGesit' => $totalKainGesit['total_kain'],
            'totalKainGesitMonth' => $totalKainGesitMonth['total_kain_month'],
            'totalCutting' => $totalCutting['total_cutting'],
            'totalPolaKeluar' => $totalPolaKeluar['total_pola_keluar'],
            'totalPolaMasuk' => $totalPolaMasuk['total_pola_masuk'],
            'totalKainRetur' => $totalKainRetur['total_kain'],
            'polaReject' => $polaReject['total_pola'],
            'productsInGesit' => $productsInGesit,
            'productsOutGesit' => $productsOutGesit,
            'materials' => $materials,
            'models' => $models
        );
        return view('admin/dashboard', $data);
    }

    public function gudangLovish() {        
        $productsOut = $this->productModel->getStokProductOut();
        $productsRetur = $this->productModel->productsRetur();
        $productsExp = $this->productModel->getStokProductExp();
        $productLovish = $this->productModel->getAllStockProductLovish();
        $top10 = $this->productModel->getTop10();
        $totalGudang = $this->productModel
            ->select('SUM(qty) as stok')
            ->where('status', '2')
            ->first();
        $totalStokMasuk = $this->productModel
            ->select('SUM(product_logs.qty) as stok')
            ->join('product_logs', 'product_logs.product_id = products.id')
            ->where('product_logs.status', '2')
            ->where('MONTH(product_logs.created_at) = MONTH(CURRENT_DATE())')
            ->where('YEAR(product_logs.created_at) = YEAR(CURRENT_DATE())')
            ->first();
        $stokKeluar = $this->productModel
            ->select('SUM(product_logs.qty) as stok')
            ->join('product_logs', 'product_logs.product_id = products.id')
            ->where('product_logs.status', '3')
            ->where('MONTH(product_logs.created_at) = MONTH(CURRENT_DATE())')
            ->where('YEAR(product_logs.created_at) = YEAR(CURRENT_DATE())')
            ->first();
        $stokRetur = $this->productModel
            ->select('SUM(product_logs.qty) as stok')
            ->join('product_logs', 'product_logs.product_id = products.id')
            ->where('product_logs.status', '4')
            ->where('MONTH(product_logs.created_at) = MONTH(CURRENT_DATE())')
            ->where('YEAR(product_logs.created_at) = YEAR(CURRENT_DATE())')
            ->first();
        $productsIn = $this->productModel
            ->select('model_name, jenis as product_name, color, size, SUM(product_logs.qty) as stok')
            ->join('models', 'models.id = products.model_id')
            ->join('colors', 'colors.id = products.color_id')
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')
            ->join('product_logs', 'product_logs.product_id = product_barcodes.id')
            ->where('product_barcodes.status', '2')
            ->where('product_logs.qty > ', '0')
            ->where('MONTH(product_logs.created_at) = MONTH(CURRENT_DATE())')
            ->where('YEAR(product_logs.created_at) = YEAR(CURRENT_DATE())')
            ->groupBy('model_id, product_logs.product_id, color_id, size')   
            ->get();
        
        $shippings = $this->shippinglModel
            ->select('shippings.*, shipping_details.product_id')
            ->join('shipping_details', 'shipping_details.shipping_id = shippings.id')
            ->orderBy('qrcode', 'asc')
            ->orderBy('created_at', 'desc')
            ->groupBy('shippings.id')
            ->get();
        $getStok = $this->productModel->getAllStockProductLovish();
        $penjualan = $this->productModel->penjualan();
        $stok = array();
        $selling = 0;        
        $totalNilaiBarang = 0;
        $totalNilaiBarangJual = 0;
        if ($getStok->getNumRows() > 0) {
            foreach ($getStok->getResultObject() as $product) {                
                if ($penjualan->getNumRows() > 0) {
                    foreach ($penjualan->getResultObject() as $sell) {                
                        if (($sell->model_id == $product->model_id) && ($sell->color_id == $product->color_id) && ($sell->size == $product->size)) {
                            $selling = $selling + $sell->qty;                         
                        }
                    }        
                    $sisa = ($product->stok + $product->stok_masuk - ($selling - $product->stok_retur)) ;                                                                               
                    $selling = 0;
                    array_push($stok, [
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
                } else {
                    $sisa = ($product->stok + $product->stok_masuk - ($selling - $product->stok_retur)) ;                                                            
                    array_push($stok, [
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
                $totalNilaiBarang = $totalNilaiBarang + ($product->hpp * $sisa);
                $totalNilaiBarangJual = $totalNilaiBarangJual + ($product->hpp_jual * $sisa);
            }
        }
        
    
        
        $data = array(
            'title' => 'Dashboard',
            'totalGudang' => $totalGudang,
            'totalStokMasuk' => $totalStokMasuk,
            'stokKeluar' => $stokKeluar,
            'stokRetur' => $stokRetur,
            'productsIn' => $productsIn,
            'productsOut' => $productsOut,
            'productsExp' => $productsExp,
            'productLovish' => $stok,
            'productsRetur' => $productsRetur,
            'shippings' => $shippings,
            'totalNilaiBarang' => $totalNilaiBarang,
            'totalNilaiBarangJual' => $totalNilaiBarangJual,
            'top10' => $top10
        );
        return view('gudang_lovish/dashboard', $data);
    }

    public function gudangGesit() {
        $totalKainGesit= $this->materialModel->select('COUNT(*) as total_kain')
            ->where('status','1')
            ->first();
        $totalKainGesitMonth = $this->materialModel->select('COUNT(*) as total_kain_month')
            ->where('status','1')
            ->where('MONTH(created_at) = MONTH(CURRENT_DATE())')
            ->where('YEAR(created_at) = YEAR(CURRENT_DATE())')
            ->first();
        $totalCutting = $this->materialModel->select('COUNT(*) as total_cutting')
            ->join('cutting', 'cutting.material_id = materials.id')
            ->where('MONTH(cutting.tgl) = MONTH(CURRENT_DATE())')
            ->where('YEAR(cutting.tgl) = YEAR(CURRENT_DATE())')
            ->first();
        $totalPolaKeluar = $this->materialModel->select('COUNT(*) as total_pola_keluar')
            ->join('cutting', 'cutting.material_id = materials.id')    
            ->join('pola', 'pola.cutting_id = cutting.id')            
            ->where('MONTH(tgl_ambil) = MONTH(CURRENT_DATE())')
            ->where('YEAR(tgl_ambil) = YEAR(CURRENT_DATE())')
            ->where('pola.status', '1')
            ->first();
        $totalPolaMasuk = $this->materialModel->select('COUNT(*) as total_pola_masuk')
            ->join('cutting', 'cutting.material_id = materials.id')    
            ->join('pola', 'pola.cutting_id = cutting.id')            
            ->where('MONTH(tgl_ambil) = MONTH(CURRENT_DATE())')
            ->where('YEAR(tgl_ambil) = YEAR(CURRENT_DATE())')
            ->where('pola.status', '2')
            ->first();
        $totalKainRetur = $this->materialModel->select('COUNT(*) as total_kain')
            ->where('MONTH(created_at) = MONTH(CURRENT_DATE())')
            ->where('YEAR(created_at) = YEAR(CURRENT_DATE())')
            ->where('status','2')
            ->first();
        $polaReject = $this->materialModel->select("SUM(reject) as total_pola")
            ->join('cutting', 'cutting.material_id = materials.id')
            ->join('pola', 'pola.cutting_id = cutting.id')
            ->where('MONTH(tgl_setor) = MONTH(CURRENT_DATE())')
            ->where('YEAR(tgl_setor) = YEAR(CURRENT_DATE())')
            ->first();
        $totalGesit = $this->productModel->totalGesit();
        $totalGesit = $totalGesit->getResultArray();        
        if (count($totalGesit) > 0) {
            $totalGesit = $totalGesit[0]['stok'];
        } else {
            $totalGesit = 0;
        }
        $materials = $this->materialModel->getStokMaterialIn();
        $productsIn = $this->productModel->getStokProductIn(); 
        $productsOut = $this->productModel->getStokProductOut();           
        $models = $this->designModel->getAllModel();
        $data = array(
            'title' => 'Dashboard',
            'totalGesit' => $totalGesit,
            'totalKainGesit' => $totalKainGesit['total_kain'],
            'totalKainGesitMonth' => $totalKainGesitMonth['total_kain_month'],
            'totalCutting' => $totalCutting['total_cutting'],
            'totalPolaKeluar' => $totalPolaKeluar['total_pola_keluar'],
            'totalPolaMasuk' => $totalPolaMasuk['total_pola_masuk'],
            'totalKainRetur' => $totalKainRetur['total_kain'],
            'polaReject' => $polaReject['total_pola'],
            'productsIn' => $productsIn,
            'productsOut' => $productsOut,
            'materials' => $materials,
            'models' => $models
        );
        return view('gudang_gesit/dashboard', $data);
    }

}
