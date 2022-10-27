<?php

namespace App\Controllers;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use App\Models\MaterialModel;
use App\Models\ProductModel;
use App\Models\ShippingModel;
use App\Models\LogModel;

class Api extends BaseController {
    protected $materialModel = "";
    protected $produkModel = "";
    protected $shippinglModel = "";
    protected $logModel = "";
    

    public function __construct() {  
        $this->materialModel = new MaterialModel();
        $this->produkModel = new ProductModel();
        $this->shippinglModel = new ShippingModel();
        $this->logModel = new LogModel();
    }

    public function kirimQR() {
        $post = $this->request->getVar();
        $jenis = $post['jenis'];
        $status = 0;
        $qr = explode('-', $post['qr']);

        switch($jenis) {
            case "cutting" :                 
                $getMaterial = $this->materialModel->find($qr[0]);
                if ($getMaterial) {
                    $status = 1;
                    $getCOA = $this->materialModel->getCOA();
                    $this->materialModel->insertCutting($qr[0], $getCOA[0]->biaya, $getCOA[1]->biaya);
                    $this->materialModel->save([
                        'id' => $qr[0],
                        'tgl_cutting' => date('Y-m-d')
                    ]);
                }
                break;
            case "produk-keluar" : 
                $productStatus = $this->produkModel->productStatus($qr[0]);        
                $status = '0';                
                if ($productStatus[0]->status == '1') {
                    $status = '1';       
                    $this->produkModel->updateQRStatus($qr[0]);     
                    $this->produkModel->setProductIn($qr[0], session()->get('user_id'));
                }        
                break;
            case "reject-noda" : 
                $check = $this->productModel->findProductReject($qr[0]);
                $status = 0;
                
                if ($check->getNumRows() > 0) {
                    $status = 1;
                    $this->productModel->saveReject($qr[0], 'noda');    
                }
                break;
            case "reject-jahit" : 
                $check = $this->productModel->findProductReject($qr[0]);
                $status = 0;
                
                if ($check->getNumRows() > 0) {
                    $status = 1;
                    $this->productModel->saveReject($qr[0], 'jahit');    
                }
                break;
            case "reject-permanent" : 
                $check = $this->productModel->findProductReject($qr[0]);
                $status = 0;
                
                if ($check->getNumRows() > 0) {
                    $status = 1;
                    $this->productModel->saveReject($qr[0], 'permanent');    
                }
                break;
            case "penjualan-reject" : 
                $check = $this->productModel->findProductReject($qr[0]);
                $status = 0;
                
                if ($check->getNumRows() > 0) {
                    $status = 1;
                    $this->productModel->saveJualReject($qr[0]);    
                }
                break;
            case "retur-kain" : 
                $getProduct = $this->materialModel->find($qr[0]);
                $status = '0';
                if (!is_null($getProduct) && $getProduct['status'] == '3') {
                    $status = '1'; 
                    $this->materialModel->updateMaterialStokRetur($qr[0]);
                    
                }
                break;
        }

        $data = [            
            'status' => $status
        ];
        echo json_encode($data);
    }    
}