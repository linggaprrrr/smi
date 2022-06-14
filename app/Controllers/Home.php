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
        $totalGesit = $this->productModel->selectSum('id')->where('status','1')->first();
        $totalLovishIn = $this->productModel->selectSum('id')->where('status','2')->first();
        $totalLovishOut = $this->productModel->selectSum('id')->where('status','3')->first();
        $totalLovishAlmostOut = $this->productModel->getStokProductAlmostOut();
        $productsIn = $this->productModel->getStokProductIn();    
        $productsOut = $this->productModel->getStokProductOut();
        $productsExp = $this->productModel->getStokProductExp();
        $materials = $this->materialModel->getAllMaterial();
        $models = $this->designModel->getAllModel();
        $data = array(
            'title' => 'Dashboard',
            'totalGesit' => $totalGesit['id'],
            'totalLovishIn' => $totalLovishIn['id'],
            'totalLovishOut' => $totalLovishOut['id'],
            'totalLovishAlmostOut' => $totalLovishAlmostOut->getNumRows(),
            'productsIn' => $productsIn,
            'productsOut' => $productsOut,
            'productsExp' => $productsExp,
            'materials' => $materials,
            'models' => $models
        );
        return view('admin/dashboard', $data);
    }

    public function gudang() {
        return view('gudang/dashboard');
    }

}
