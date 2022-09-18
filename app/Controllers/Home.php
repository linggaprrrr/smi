<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\DesignModel;
use App\Models\MaterialModel;
use App\Models\LovishProductModel;
use App\Models\ShippingModel;

class Home extends BaseController
{
    protected $productModel = "";
    protected $designModel = "";
    protected $materialModel = "";
    protected $productLovishModel = "";
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
        $this->productLovishModel = new LovishProductModel();
        $this->shippinglModel = new ShippingModel();
    }

    public function index() {
        $totalGesit = $this->productModel->selectSum('qty')->where('status','1')->first();
        $totalLovish = $this->productLovishModel->selectSum('qty')->where('status','2')->first();
        $totalLovishIn = $this->productModel
            ->select('SUM(product_logs.qty) as qty')
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')
            ->join('product_logs', 'product_logs.product_id = product_barcodes.id')
            // ->where('product_logs.status','2')
            ->first();
        $totalLovishOut = $this->productModel
            ->select('SUM(product_logs.qty) as qty')
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')
            ->join('product_logs', 'product_logs.product_id = product_barcodes.id')
            ->where('product_logs.status','3')
            ->orWhere('product_logs.status', '4')
            ->first();

        $totalLovishAlmostOut = $this->productModel->getStokProductAlmostOut();
        $productsIn = $this->productModel->getStokProductIn();    
        $productsOut = $this->productModel->getStokProductOut();
        $shipmentToLovish = $this->productModel->getAllShipmentToLovish();
        $productsRetur = $this->productLovishModel->productsRetur();
        $productsExp = $this->productModel->getStokProductExp();
        $productsNonQR = $this->productLovishModel->getProductsNonQR();
        $materials = $this->materialModel->getAllMaterial();
        $materialStock = $this->materialModel->getAllMaterialStock(); 
           
        $models = $this->designModel->getAllModel();
        $data = array(
            'title' => 'Dashboard',
            'totalGesit' => $totalGesit['qty'],            
            'totalLovishIn' => ($totalLovishIn['qty'] + $totalLovish['qty']),
            'totalLovishOut' => $totalLovishOut['qty'],
            'totalLovishAlmostOut' => $totalLovishAlmostOut->getNumRows(),
            'productsIn' => $productsIn,
            'productsOut' => $productsOut,
            'productsExp' => $productsExp,
            'productsNonQR' => $productsNonQR,
            'productsRetur' => $productsRetur,
            'materials' => $materials,
            'models' => $models,
            'materialStock' => $materialStock,
            'shipmentToLovish' => $shipmentToLovish
        );
        return view('admin/dashboard', $data);
    }

    public function gudangLovish() {
        $totalLovish = $this->productLovishModel->selectSum('qty')->where('status','2')->first();        
        $totalLovishIn = $this->productModel
            ->select('SUM(product_logs.qty) as qty')
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')
            ->join('product_logs', 'product_logs.product_id = product_barcodes.id')
            // ->where('product_logs.status','2')
            ->first();

        $totalLovishOut = $this->productModel
            ->select('SUM(product_logs.qty) as qty')
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')
            ->join('product_logs', 'product_logs.product_id = product_barcodes.id')
            ->where('product_logs.status','3')
            ->orWhere('product_logs.status', '4')
            ->first();

        $totalLovishAlmostOut = $this->productModel->getStokProductAlmostOut();
        $productsOut = $this->productModel->getStokProductOut();
        $productsRetur = $this->productLovishModel->productsRetur();
        $productsExp = $this->productModel->getStokProductExp();
        $productLovish = $this->productLovishModel->getAllStockProductLovish();
        $shippings = $this->shippinglModel
            ->select('shippings.*, shipping_details.product_id')
            ->join('shipping_details', 'shipping_details.shipping_id = shippings.id')
            ->orderBy('qrcode', 'asc')
            ->orderBy('created_at', 'desc')
            ->groupBy('shippings.id')
            ->get();
        $data = array(
            'title' => 'Dashboard',
            'totalLovishIn' => ($totalLovishIn['qty'] + $totalLovish['qty']),
            'totalLovishOut' => $totalLovishOut['qty'],
            'totalLovishAlmostOut' => $totalLovishAlmostOut->getNumRows(),
            'productsOut' => $productsOut,
            'productsExp' => $productsExp,
            'productLovish' => $productLovish,
            'productsRetur' => $productsRetur,
            'shippings' => $shippings
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
        $totalGesit = $this->productModel
            ->select('products.qty - SUM(IFNULL(product_logs.qty,0)) as qty')
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')
            ->join('product_logs', 'product_logs.product_id = product_barcodes.id', 'left')
            ->first();
        $productsIn = $this->productModel->getStokProductIn();    
        $materials = $this->materialModel->getAllMaterial();
        $models = $this->designModel->getAllModel();
        $data = array(
            'title' => 'Dashboard',
            'totalGesit' => $totalGesit['qty'],
            'totalKainGesit' => $totalKainGesit['total_kain'],
            'totalKainGesitMonth' => $totalKainGesitMonth['total_kain_month'],
            'totalCutting' => $totalCutting['total_cutting'],
            'totalPolaKeluar' => $totalPolaKeluar['total_pola_keluar'],
            'totalPolaMasuk' => $totalPolaMasuk['total_pola_masuk'],
            'totalKainRetur' => $totalKainRetur['total_kain'],
            'polaReject' => $polaReject['total_pola'],
            'productsIn' => $productsIn,
            'materials' => $materials,
            'models' => $models
        );
        return view('gudang_gesit/dashboard', $data);
    }

}
