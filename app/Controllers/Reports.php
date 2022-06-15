<?php

namespace App\Controllers;

use App\Models\MaterialModel;
use App\Models\ProductModel;

class Reports extends BaseController
{   

    protected $materialModel = "";
    protected $productModel = "";
    
    public function __construct() { 
        $userId = session()->get('user_id');
        if (is_null($userId)) {            
            header('Location: '.base_url('/'));
            exit(); 
        }
        $this->materialModel = new MaterialModel();
        $this->productModel = new ProductModel();
    }

    public function index() {
        $materials = $this->materialModel->getAllMaterial();
        $productsIn = $this->productModel->getAllProductIn();
        $productsOut = $this->productModel->getAllProductOut();
        $data = array(
            'title' => 'Laporan',
            'materials' => $materials,
            'productsIn' => $productsIn,
            'productsOut' => $productsOut,

        );
        return view('admin/reports', $data);    
    }
}
