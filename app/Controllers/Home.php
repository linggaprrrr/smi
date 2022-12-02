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
        $productsExp = $this->productModel
            ->select('products.id, size, models.jenis as product_name, model_name, color, k.updated_at')
            ->join('models', 'models.id = products.model_id')
            ->join('colors', 'colors.id = products.color_id')
            ->join('(SELECT product_barcodes.product_id, product_barcodes.updated_at FROM product_logs JOIN product_barcodes ON product_barcodes.id = product_logs.product_id JOIN products ON products.id = product_barcodes.product_id WHERE product_logs.status = 3 AND product_barcodes.status = 3) as k', 'k.product_id = products.id')
            ->get();;
        $productLovish = $this->productModel->getAllStockProductLovish();
        $top10Lovish = $this->productModel->getTop10Lovish();
        $top10Odelia = $this->productModel->getTop10Odelia();
        $top10Basundari = $this->productModel->getTop10Basundari();
        $totalGudang = $this->productModel
            ->select('((SELECT COUNT(product_barcodes.id) as stok_awal FROM product_barcodes WHERE product_barcodes.status != "0" AND product_barcodes.status != "1") - (SELECT SUM(product_logs.qty) as total_keluar FROM product_logs JOIN product_barcodes ON product_barcodes.id = product_logs.product_id WHERE product_logs.status = 3) + (SELECT SUM(product_logs.qty) as total_keluar FROM product_logs JOIN product_barcodes ON product_barcodes.id = product_logs.product_id WHERE product_logs.status = 4) ) as stok')
            ->first();
        
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
            ->where('product_barcodes.status <>', '2')
            ->groupBy('models.id, colors.id, products.size')
            ->get();
        $totalStokMasuk = $this->productModel
            ->select('COUNT(product_barcodes.id) as stok')
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')
            ->where('product_barcodes.status', '2')
            ->orWhere('product_barcodes.status', '3')
            ->where('MONTH(product_barcodes.updated_at) = MONTH(CURRENT_DATE())')
            ->where('YEAR(product_barcodes.updated_at) = YEAR(CURRENT_DATE())')
            ->first();
        $stokKeluar = $this->productModel
            ->select('penjualan as stok')
            ->join('(SELECT product_barcodes.product_id, SUM(product_logs.qty) as penjualan FROM product_logs JOIN product_barcodes ON product_barcodes.id = product_logs.product_id JOIN products ON products.id = product_barcodes.product_id WHERE product_logs.status = 3 GROUP BY model_id, color_id, size) as k', 'k.product_id = products.id', 'left')
            ->where('MONTH(products.updated_at) = MONTH(CURRENT_DATE())')
            ->where('YEAR(products.updated_at) = YEAR(CURRENT_DATE())')
            ->first();
        $stokRetur = $this->productModel
            ->select('SUM(product_logs.qty) as stok')
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')
            ->join('product_logs', 'product_logs.product_id = product_barcodes.id')
            ->where('product_logs.status', '4')
            ->where('MONTH(product_logs.created_at) = MONTH(CURRENT_DATE())')
            ->where('YEAR(product_logs.created_at) = YEAR(CURRENT_DATE())')
            ->first();
        $productsIn = $this->productModel
            ->select('model_name, jenis as product_name, color, size, COUNT(product_barcodes.id) as stok, products.updated_at')
            ->join('models', 'models.id = products.model_id')
            ->join('colors', 'colors.id = products.color_id')
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')
            ->where('product_barcodes.status', '2')
            ->orWhere('product_barcodes.status', '3')
            
            ->groupBy('product_barcodes.product_id')   
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
        $out = $this->productModel
            ->select('products.*')
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')
            ->where('product_barcodes.status', '3')
            ->get();
        $stok = array();
        $selling = 0;        
        $totalNilaiBarang = 0;
        $totalNilaiBarangJual = 0;
        if ($getStok->getNumRows() > 0) {
            foreach ($getStok->getResultObject() as $product) {                
                if ($penjualan->getNumRows() > 0 || $out->getNumRows() > 0) {
                    foreach ($penjualan->getResultObject() as $sell) {                
                        if (($sell->model_id == $product->model_id) && ($sell->color_id == $product->color_id) && ($sell->size == $product->size)) {
                            $selling = $selling + 1;                         
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
                $totalNilaiBarang = $totalNilaiBarang + ($product->hpp * $sisa);
                $totalNilaiBarangJual = $totalNilaiBarangJual + ($product->hpp_jual * $sisa);
            }
        }    


        $totalKainGesit = $this->materialModel->select(' COUNT(materials.id) as total_kain')
            ->join('cutting', 'cutting.material_id = materials.id', 'left')
            ->where('materials.status','1')
            ->where('(materials.weight - IFNULL(cutting.berat, 1)) > ', 0)   
            ->first();
        $totalKainGesitMonth = $this->materialModel->select('COUNT(*) as total_kain_month')
            ->where('status','1')
            ->where('weight > ', '0')   
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
        $totalGesit = $this->productModel->totalGesit();
        $totalGesit = $totalGesit->getResultArray();        
        if (count($totalGesit) > 0) {
            $totalGesit = $totalGesit[0]['stok'];
        } else {
            $totalGesit = 0;
        }
        $materials = $this->materialModel->getStokMaterialIn();
        $materialsIn = $this->materialModel->getMaterialIn();
        $productsInGesit = $this->productModel->getStokProductIn(); 
        $productsOutGesit = $this->productModel->getStokProductOut();                   
        $materialRetur = $this->materialModel->getMaterialRetur();


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
            'productsInGesit' => $productsInGesit,
            'productsOutGesit' => $productsOutGesit,
            'materials' => $materials,
            'materialsIn' => $materialsIn,
            'materialRetur' => $materialRetur,

            'totalGudang' => $totalGudang,
            'totalStokMasuk' => $totalStokMasuk,
            'stokKeluar' => $stokKeluar,
            'stokRetur' => $stokRetur,
            'productsIn' => $productsIn,
            'productsOut' => $productsOut,
            'productsExp' => $productsExp,
            'productLovish' => $sisaStok,
            'productsRetur' => $productsRetur,
            'shippings' => $shippings,
            'totalNilaiBarang' => $totalNilaiBarang,
            'totalNilaiBarangJual' => $totalNilaiBarangJual,
            'top10Lovish' => $top10Lovish,
            'top10Odelia' => $top10Odelia,
            'top10Basundari' => $top10Basundari


        );
        
        return view('admin/dashboard', $data);
    }

    public function gudangLovish() {
        $date = $this->request->getVar('dates');
        $date1 = null;
        $date2 = null;
        
        if (is_null($date)) {
            $productsOut = $this->productModel->getStokProductOut();
            $productsRetur = $this->productModel->productsRetur();
            $productsExp = $this->productModel
                ->select('products.id, size, models.jenis as product_name, model_name, color, k.updated_at')
                ->join('models', 'models.id = products.model_id')
                ->join('colors', 'colors.id = products.color_id')
                ->join('(SELECT product_barcodes.product_id, product_barcodes.updated_at FROM product_logs JOIN product_barcodes ON product_barcodes.id = product_logs.product_id JOIN products ON products.id = product_barcodes.product_id WHERE product_logs.status = 3 OR product_logs.status = 5) as k', 'k.product_id = products.id')
                ->get();;
            $productLovish = $this->productModel->getAllStockProductLovish();
            $top10Lovish = $this->productModel->getTop10Lovish();
            $top10Odelia = $this->productModel->getTop10Odelia();
            $top10Basundari = $this->productModel->getTop10Basundari();
            $totalGudang = $this->productModel
                ->select('( IFNULL((SELECT COUNT(product_barcodes.id) as stok_awal FROM product_barcodes WHERE product_barcodes.status != "0" AND product_barcodes.status != "1"), 0) - IFNULL((SELECT COUNT(product_barcodes.id) as stok_awal FROM product_barcodes WHERE product_barcodes.status = "5"), 0) - IFNULL((SELECT SUM(product_logs.qty) as total_keluar FROM product_logs JOIN product_barcodes ON product_barcodes.id = product_logs.product_id WHERE product_logs.status = 3), 0) + IFNULL((SELECT SUM(product_logs.qty) as total_retur FROM product_logs JOIN product_barcodes ON product_barcodes.id = product_logs.product_id WHERE product_logs.status = 4), 0) ) as stok')
                ->first();
            
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
                ->where('product_barcodes.status <>', '2')
                ->groupBy('models.id, colors.id, products.size')
                ->get();
            $totalStokMasuk = $this->productModel
                ->select('COUNT(product_barcodes.id) as stok')
                ->join('product_barcodes', 'product_barcodes.product_id = products.id')
                ->where('product_barcodes.status', '2')
                ->orWhere('product_barcodes.status', '3')
                ->where('MONTH(product_barcodes.updated_at) = MONTH(CURRENT_DATE())')
                ->where('YEAR(product_barcodes.updated_at) = YEAR(CURRENT_DATE())')
                ->first();
            $stokKeluar = $this->productModel
                ->select('penjualan as stok')
                ->join('(SELECT product_barcodes.product_id, SUM(product_logs.qty) as penjualan FROM product_logs JOIN product_barcodes ON product_barcodes.id = product_logs.product_id JOIN products ON products.id = product_barcodes.product_id WHERE product_logs.status = 3 GROUP BY model_id, color_id, size) as k', 'k.product_id = products.id', 'left')
                ->where('MONTH(products.updated_at) = MONTH(CURRENT_DATE())')
                ->where('YEAR(products.updated_at) = YEAR(CURRENT_DATE())')
                ->first();
            $stokRetur = $this->productModel
                ->select('SUM(product_logs.qty) as stok')
                ->join('product_barcodes', 'product_barcodes.product_id = products.id')
                ->join('product_logs', 'product_logs.product_id = product_barcodes.id')
                ->where('product_logs.status', '4')
                ->where('MONTH(product_logs.created_at) = MONTH(CURRENT_DATE())')
                ->where('YEAR(product_logs.created_at) = YEAR(CURRENT_DATE())')
                ->first();
            $productsIn = $this->productModel
                ->select('model_name, jenis as product_name, color, size, COUNT(product_barcodes.id) as stok, products.updated_at')
                ->join('models', 'models.id = products.model_id')
                ->join('colors', 'colors.id = products.color_id')
                ->join('product_barcodes', 'product_barcodes.product_id = products.id')
                ->where('product_barcodes.status', '2')
                ->orWhere('product_barcodes.status', '3')
                ->orWhere('product_barcodes.status', '5')
                
                ->groupBy('product_barcodes.product_id')   
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
            $out = $this->productModel
                ->select('products.*')
                ->join('product_barcodes', 'product_barcodes.product_id = products.id')
                ->where('product_barcodes.status', '3')
                ->get();
            $stok = array();
            $selling = 0;        
            $totalNilaiBarang = 0;
            $totalNilaiBarangJual = 0;
            if ($getStok->getNumRows() > 0) {
                foreach ($getStok->getResultObject() as $product) {                
                    if ($penjualan->getNumRows() > 0 || $out->getNumRows() > 0) {
                        foreach ($penjualan->getResultObject() as $sell) {                
                            if (($sell->model_id == $product->model_id) && ($sell->color_id == $product->color_id) && ($sell->size == $product->size)) {
                                $selling = $selling + 1;                         
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
                    $totalNilaiBarang = $totalNilaiBarang + ($product->hpp * $sisa);
                    $totalNilaiBarangJual = $totalNilaiBarangJual + ($product->hpp_jual * $sisa);
                }
            }    
        } else {
            $date = explode("-",$date);   
            $date1 = date('Y-m-d 00:00:00', strtotime($date[0]));
            $date2 = date('Y-m-d 00:00:00', strtotime($date[1]));
            
            $productsOut = $this->productModel->getStokProductOut($date1, $date2);
            $productsRetur = $this->productModel->productsRetur($date1, $date2);
            $productsExp = $this->productModel
                ->select('products.id, size, models.jenis as product_name, model_name, color, product_barcodes.updated_at')
                ->join('models', 'models.id = products.model_id')
                ->join('colors', 'colors.id = products.color_id')
                ->join('product_barcodes', 'product_barcodes.product_id = products.id')
                ->join('product_logs', 'product_logs.product_id = product_barcodes.id')
                ->where('product_barcodes.status <>', '1')
                ->where('product_barcodes.status <>', '0')
                ->where('product_barcodes.status <>', '3')
                ->where('product_barcodes.status <>', '5')          
                ->where('product_logs.created_at BETWEEN "'.$date1.'" AND "'.$date2.'"  ')
                ->get();;
            $productLovish = $this->productModel->getAllStockProductLovish();
            $top10Lovish = $this->productModel->getTop10Lovish($date1, $date2);
            $top10Odelia = $this->productModel->getTop10Odelia($date1, $date2);
            $top10Basundari = $this->productModel->getTop10Basundari($date1, $date2);
            $totalGudang = $this->productModel
                ->select('COUNT(product_barcodes.id) as stok')
                ->join('product_barcodes', 'product_barcodes.product_id = products.id')
                ->where('product_barcodes.status <>', '1')
                ->first();
            
            $sisaStok = $this->productModel
                ->select('models.jenis as product_name, model_name, color, size, product_barcodes.updated_at, COUNT(product_barcodes.id) as stok')
                ->join('models', 'models.id = products.model_id')
                ->join('colors', 'colors.id = products.color_id')
                ->join('product_barcodes', 'product_barcodes.product_id = products.id')            
                ->where('product_barcodes.status <>', '1')
                ->where('product_barcodes.status <>', '0')
                ->where('product_barcodes.updated_at BETWEEN "'.$date1.'" AND "'.$date2.'"  ')
                ->groupBy('models.id, colors.id, products.size')
                ->get();
            $totalStokMasuk = $this->productModel
                ->select('COUNT(product_barcodes.id) as stok')
                ->join('product_barcodes', 'product_barcodes.product_id = products.id')
                ->where('product_barcodes.status <> ', '1')
                ->where('MONTH(product_barcodes.updated_at) = MONTH(CURRENT_DATE())')
                ->where('YEAR(product_barcodes.updated_at) = YEAR(CURRENT_DATE())')
                ->first();
            $stokKeluar = $this->productModel
                ->select('COUNT(SELECT * FROM product_barcodes WHERE product_barcodes.status = 3) as stok')
                ->where('MONTH(products.updated_at) = MONTH(CURRENT_DATE())')
                ->where('YEAR(products.updated_at) = YEAR(CURRENT_DATE())')
                ->first();
            $stokRetur = $this->productModel
                ->select('SUM(product_logs.qty) as stok')
                ->join('product_barcodes', 'product_barcodes.product_id = products.id')
                ->join('product_logs', 'product_logs.product_id = product_barcodes.id')
                ->where('product_logs.status', '4')
                ->where('MONTH(product_logs.created_at) = MONTH(CURRENT_DATE())')
                ->where('YEAR(product_logs.created_at) = YEAR(CURRENT_DATE())')
                ->first();
            $productsIn = $this->productModel
                ->select('model_name, jenis as product_name, color, size, COUNT(product_barcodes.id) as stok, products.updated_at')
                ->join('models', 'models.id = products.model_id')
                ->join('colors', 'colors.id = products.color_id')
                ->join('product_barcodes', 'product_barcodes.product_id = products.id')                
                ->where('product_barcodes.status', '2')
                ->orWhere('product_barcodes.status', '3')
                ->where('product_barcodes.created_at BETWEEN "'.$date1.'" AND "'.$date2.'"  ')
                ->groupBy('product_barcodes.product_id')   
                ->get();
            
            $shippings = $this->shippinglModel
                ->select('shippings.*, shipping_details.product_id')
                ->join('shipping_details', 'shipping_details.shipping_id = shippings.id')
                ->where('shippings.created_at BETWEEN "'.$date1.'" AND "'.$date2.'"  ')
                ->orderBy('qrcode', 'asc')
                ->orderBy('created_at', 'desc')
                ->groupBy('shippings.id')
                ->get();
            $getStok = $this->productModel->getAllStockProductLovish($date1, $date2);
            $penjualan = $this->productModel->penjualan($date1, $date2);
             $out = $this->productModel
                ->select('products.*')
                ->join('product_barcodes', 'product_barcodes.product_id = products.id')
                ->where('product_barcodes.status', '3')
                ->where('product_barcodes.updated_at BETWEEN "'.$date1.'" AND "'.$date2.'"  ')
                ->get();
            $stok = array();
            $selling = 0;        
            $totalNilaiBarang = 0;
            $totalNilaiBarangJual = 0;
            if ($getStok->getNumRows() > 0) {
                foreach ($getStok->getResultObject() as $product) {                
                    if ($penjualan->getNumRows() > 0 || $out->getNumRows() > 0) {
                        foreach ($penjualan->getResultObject() as $sell) {                
                            if (($sell->model_id == $product->model_id) && ($sell->color_id == $product->color_id) && ($sell->size == $product->size)) {
                                $selling = $selling + 1;                         
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
                    $totalNilaiBarang = $totalNilaiBarang + ($product->hpp * $sisa);
                    $totalNilaiBarangJual = $totalNilaiBarangJual + ($product->hpp_jual * $sisa);
                }
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
            'productLovish' => $sisaStok,
            'productsRetur' => $productsRetur,
            'shippings' => $shippings,
            'totalNilaiBarang' => $totalNilaiBarang,
            'totalNilaiBarangJual' => $totalNilaiBarangJual,
            'top10Lovish' => $top10Lovish,
            'top10Odelia' => $top10Odelia,
            'top10Basundari' => $top10Basundari
        );
        return view('gudang_lovish/dashboard', $data);
    }

    public function gudangGesit() {
        $totalKainGesit = $this->materialModel->select(' COUNT(materials.id) as total_kain')
            ->join('(SELECT material_id, SUM(berat) as total_berat FROM cutting GROUP BY material_id) as ct', 'materials.id = ct.material_id', 'left')
            ->where('materials.status','1')
            ->where('(materials.weight - IFNULL(ct.total_berat, 1)) > ', 0)   
            
            ->first();
        
        $totalKainGesitMonth = $this->materialModel->select('COUNT(*) as total_kain_month')
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
        $totalGesit = $this->productModel->totalGesit();
        $totalGesit = $totalGesit->getResultArray();        
        if (count($totalGesit) > 0) {
            $totalGesit = $totalGesit[0]['stok'];
        } else {
            $totalGesit = 0;
        }
        $materials = $this->materialModel->getStokMaterialIn();
        $materialsIn = $this->materialModel->getMaterialIn();
        $productsIn = $this->productModel->getStokProductIn(); 
        $productsOut = $this->productModel->getStokProductOut();           
        $models = $this->designModel->getAllModel();
        $materialRetur = $this->materialModel->getMaterialRetur();
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
            'materialsIn' => $materialsIn,
            'materialRetur' => $materialRetur,
            'models' => $models
        );
        
        return view('gudang_gesit/dashboard', $data);
    }

}
