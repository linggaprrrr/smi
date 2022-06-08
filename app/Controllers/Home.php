<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\DesignModel;

class Home extends BaseController
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
            'title' => 'Dashboard',
            'products' => $products,
            'models' => $models
        );
        return view('admin/dashboard', $data);
    }

    public function gudang() {
        return view('gudang/dashboard');
    }

}
