<?php

namespace App\Controllers;

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

    public function shipmentLovish() {
        $shippings = $this->shippinglModel
            ->orderBy('qrcode', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
        $data = array(
            'title' => 'Pengiriman',
            'shippings' => $shippings
        );
        
        return view('gudang_lovish/shippings', $data);  
    }

    public function getResi() {
        $id = $this->request->getVar('ship_id');
        $getShipment = $this->shippinglModel->find($id);
        echo json_encode($getShipment);
    }

    public function updateResi() {
        $post = $this->request->getVar();
        $this->shippinglModel->save([
            'id' => $post['id'],
            'resi' => $post['resi']
        ]);

        return redirect()->back()->with('update', 'Resi berhasil diubah');
    }

    public function addShipping() {
        $str = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
        $numbers = rand(1000, 9999);
        
        $info = 'BOX-'.substr($str, 0, 3).''.$numbers;
        
        $this->shippinglModel->insertShippingDetail($info);
        

    }
}