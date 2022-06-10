<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\DesignModel;
use App\Models\MaterialModel;

class Home extends BaseController
{
    protected $productModel = "";
    protected $designModel = "";
    protected $materialModel = "";

    public function __construct() { 
        $userId = session()->get('user_id');
        if (is_null($userId)) {            
            header('Location: '.base_url('/'));
            exit(); 
        }

        $this->productModel = new ProductModel();
        $this->designModel = new DesignModel();
        $this->materialModel = new MaterialModel();
    }

    public function index() {
        $productsIn = $this->productModel->getStokProductIn();    
        $productsOut = $this->productModel->getStokProductOut();
        $materials = $this->materialModel->getAllMaterial();
        $models = $this->designModel->getAllModel();
        $data = array(
            'title' => 'Dashboard',
            'productsIn' => $productsIn,
            'productsOut' => $productsOut,
            'materials' => $materials,
            'models' => $models
        );
        return view('admin/dashboard', $data);
    }

    public function gudang() {
        return view('gudang/dashboard');
    }

}
