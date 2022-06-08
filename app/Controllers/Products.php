<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\DesignModel;

class Products extends BaseController
{
    protected $productModel = "";
    protected $designModel = "";

    public function __construct() { 
        $userId = session()->get('user_id');
        if (is_null($userId)) {            
            header('Location: '.base_url('/'));
            exit(); 
        }
        $this->productModel = new ProductModel();
        $this->designModel = new DesignModel();

    }
    
    public function index() {
        $products = $this->productModel->getAllProduct();
        $models = $this->designModel->getAllModel();
        $data = array(
            'title' => 'Produk & Model',
            'products' => $products,
            'models' => $models
        );
        return view('admin/products', $data);    
    }

    public function getProduct() {
        $productId = $this->request->getVar('product_id');
        $product = $this->productModel->find($productId);
        echo json_encode($product);
    }
    
    public function saveProduct() {
        $post = $this->request->getVar();
        $product = [
            'product_name' => $post['nama_produk'],
            'color'  => $post['warna'],
            'weight'  => $post['berat'],
            'model_id'  => $post['model'],
        ];
        $this->productModel->save($product);
        return redirect()->back()->with('create', 'Produk berhasil ditambahkan');
    }

    public function updateProduct() {
        $post = $this->request->getVar();
        $product = [
            'id' => $post['id'],
            'product_name' => $post['nama_produk'],
            'color'  => $post['warna'],
            'weight'  => $post['berat'],
            'model_id'  => $post['model'],
        ];
        $this->productModel->save($product);
        return redirect()->back()->with('update', 'Produk berhasil ditambahkan');
    }

    public function deleteProduct() {
        $productId = $this->request->getVar('product_id');
        $this->productModel->where('id', $productId)->delete();
    }

    public function getModel() {
        $modelId = $this->request->getVar('model_id');
        $model = $this->designModel->find($modelId);
        echo json_encode($model);
    } 

    public function saveModel() {
        $post = $this->request->getVar();
        $model = [
            'model_name' => $post['nama_model'],
            'jahit_price'  => $post['harga_jahit'],
            'hpp_price'  => $post['hpp'],
            'vendor'  => $post['vendor'],
        ];
        $this->designModel->save($model);
        return redirect()->back()->with('create', 'Model berhasil ditambahkan');
    }

    public function updateModel() {
        $post = $this->request->getVar();
        $model = [
            'id' => $post['id'],
            'model_name' => $post['nama_model'],
            'jahit_price'  => $post['harga_jahit'],
            'hpp_price'  => $post['hpp'],
            'vendor'  => $post['vendor'],
        ];
        $this->designModel->save($model);
        return redirect()->back()->with('update', 'Model berhasil ditambahkan');
    }

    public function deleteModel() {
        $modelId = $this->request->getVar('model_id');
        $this->designModel->where('id', $modelId)->delete();
    }
}
