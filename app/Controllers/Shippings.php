<?php

namespace App\Controllers;

use App\Models\ShippinglModel;
use App\Models\ProductModel;
use App\Models\ShippingModel;

class Shippings extends BaseController
{

    protected $shippinglModel = "";
    protected $produkModel = "";

    public function __construct() { 
        $userId = session()->get('user_id');
        if (is_null($userId)) {            
            header('Location: '.base_url('/'));
            exit(); 
        }
        $this->shippinglModel = new ShippingModel();
        $this->produkModel = new ProductModel();
    }

    public function index() {
        $shippings = $this->shippinglModel->getAllShipping();
        // dd($shippings->getResultArray());
        $data = array(
            'title' => 'Pengiriman',
            'shippings' => $shippings
        );
        
        return view('admin/shippings', $data);  
    }

    public function getShippingDetail() {
        $id = $this->request->getVar('ship_id');
        $details = $this->shippinglModel->getShippingDetail($id);
        echo json_encode($details->getResultArray());

    }
}