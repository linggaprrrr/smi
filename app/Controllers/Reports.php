<?php

namespace App\Controllers;

use App\Models\MaterialModel;
use App\Models\ProductModel;
use App\Models\LogModel;

class Reports extends BaseController
{   

    protected $materialModel = "";
    protected $productModel = "";
    protected $logModel = "";
    
    public function __construct() { 
        $userId = session()->get('user_id');
        if (is_null($userId)) {            
            header('Location: '.base_url('/'));
            exit(); 
        }
        $this->materialModel = new MaterialModel();
        $this->productModel = new ProductModel();
        $this->logModel = new LogModel();
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
}
