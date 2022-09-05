<?php

namespace App\Controllers;

use App\Models\LovishProductModel;
use App\Models\DesignModel;
use App\Models\LogModel;
use App\Models\MaterialModel;
use App\Models\ProductModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LovishProducts extends BaseController
{ 
    protected $productModel = "";
    protected $productLovishModel = "";
    protected $designModel = "";
    protected $logModel = "";
    protected $materialModel = "";

    public function __construct() { 
        $userId = session()->get('user_id');
        if (is_null($userId)) {            
            header('Location: '.base_url('/'));
            exit(); 
        }
        $this->productModel = new ProductModel();
        $this->productLovishModel = new LovishProductModel();
        $this->designModel = new DesignModel();
        $this->logModel = new LogModel();
        $this->materialModel = new MaterialModel();
    }

    public function gudangLovishProduk() {
        $productsIn = $this->productLovishModel->getAllProductLovish();        
        $productsOut = $this->productModel->getAllProductOut();        
        $productsExp = $this->productModel->getAllProductExp();        
        $models = $this->designModel->getAllModel();
        $colors = $this->materialModel->getAllColors();
        $products = $this->productModel->getAllProduct();
        $vendors = $this->productModel->getAllVendorPenjualan();
        $data = array(
            'title' => 'Produk',
            'productsIn' => $productsIn,
            'productsOut' => $productsOut,
            'productsExp' => $productsExp,
            'models' => $models,
            'products' => $products,
            'colors' => $colors,
            'vendors' => $vendors
        );
        return view('gudang_lovish/products', $data);    
    }

    

    public function addProductLovish() {
        $post = $this->request->getVar();
        $product = [
            'product_id' => $post['nama_produk'],
            'color_id'  => $post['warna'],
            'weight'  => $post['berat'],
            'model_id'  => $post['model'],
            'user_id' => session()->get('user_id'),
            'qty' => $post['qty'],
            'vendor_id' => $post['vendor'],
            'price' => $post['harga'],
            'status' => '2'
        ];
        $this->productModel->save($product);
        $productId = $this->productModel->insertID();
        
       

        $this->productModel->createLog($productId, $post['qty'], 2);

        $getProduct = $this->productModel
            ->select('products.id, product_name, model_name, color')
            ->join('models', 'models.id = products.model_id')
            ->join('product_types', 'product_types.id = product_id')
            ->join('colors', 'colors.id = products.color_id')
            ->orderBy('products.id', 'desc')
            ->first();
        
        $this->logModel->save([
            'description' => 'Menambahkan produk baru ('.$getProduct['product_name'].' '.$getProduct['model_name'].' '.$getProduct['color'].') sebanyak '.$post['qty'].'. ',
            'user_id' =>  session()->get('user_id'),
        ]);
        return redirect()->back()->with('create', 'Produk berhasil ditambahkan');
    }

    public function updateProductDetail() {
        $post = $this->request->getVar();
        $product = [
            'id' => $post['id'],
            'product_id' => $post['nama_produk'],
            'color_id'  => $post['warna'],
            'weight'  => $post['berat'],
            'model_id'  => $post['model'],
            'user_id' => session()->get('user_id'),
        ];
        $this->productModel->save($product);
        $getProduct = $this->productModel
            ->join('models', 'models.id = products.model_id')
            ->join('product_types', 'product_types.id = product_id')
            ->join('colors', 'colors.id = products.color_id')
            ->where('products.id',  $post['id'])
            ->first();
        $this->logModel->save([
            'description' => 'Mengubah produk baru ('.$getProduct['product_name'].' '.$getProduct['model_name'].' '.$getProduct['color'].')',
            'user_id' =>  session()->get('user_id'),
        ]);
        return redirect()->back()->with('create', 'Produk berhasil ditambahkan');
    }
}