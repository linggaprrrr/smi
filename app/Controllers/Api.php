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
        $status = '1';
        $resi = $post['qr'];
        $qr = explode('-', $post['qr']);
        
        switch($jenis) {
            case "cutting" :                 
                $getMaterial = $this->materialModel->find($qr[0]);
                if ($getMaterial) {
                    $status = '1';
                    $getCOA = $this->materialModel->getCOA();
                    $this->materialModel->insertCutting($qr[0], $getCOA[0]->biaya, $getCOA[1]->biaya);
                    
                } else {
                    $status = '0';
                }
                break;
            case "produk-keluar" : 
                $productStatus = $this->produkModel->productStatus($qr[0]);        
                $status = '0';                                                
                if (count($productStatus) > 0) {                    
                    if ($productStatus[0]->status == '1') {                        
                        $status = '1';       
                        $this->produkModel->updateQRStatus($qr[0]);     
                        $data = $this->produkModel->setProductIn($qr[0]);
                        $this->logModel->saveHistoryStok($data);
                    }  
                }      
                break;
            case "reject" : 
                $check = $this->produkModel->findProductReject($qr[0]);
                $status = '0';
                
                if ($check->getNumRows() > 0) {
                    $status = '1';
                    $data = $this->produkModel->saveReject($qr[0], 'noda');    
                    $this->logModel->saveHistoryStok($data);
                }
                break;
            case "reject-jahit" : 
                $check = $this->produkModel->findProductReject($qr[0]);
                $status = 0;
                
                if ($check->getNumRows() > 0) {
                    $status = '1';
                    $data = $this->produkModel->saveReject($qr[0], 'jahit'); 
                    $this->logModel->saveHistoryStok($data);  
                }
                break;
            case "reject-permanent" : 
                $check = $this->produkModel->findProductRejectPermanent($qr[0]);
                $status = '0';                
                
                if ($check->getNumRows() > 0) {
                    $data = $check->getResultObject(); 
                                                 
                    if ($data[0]->status == '1') {                        
                        $this->produkModel->rejectPermanent($qr[0]);                        
                        $status = '1';             
                    } 
                    
                } else {
                    $temp = $this->produkModel->saveReject($qr[0], 'permanent');  
                    $this->logModel->saveHistoryStok($temp);   
                }
                break;
            case "penjualan-reject" : 
                $check = $this->produkModel->findProductRejectSold($qr[0]);
                $status = '0';
                
                if ($check->getNumRows() > 0) {
                    $status = '1';
                    $this->produkModel->saveJualReject($qr[0]);    
                }
                break;
            case "retur-kain" : 
                $getMaterial = $this->materialModel->find($qr[0]);
                $status = '0';
                if (!is_null($getMaterial) && $getMaterial['status'] == '1') {
                    $status = '1'; 
                    $this->materialModel->updateMaterialStokRetur($qr[0]);
                    
                }
                break;
            case "produk-keluar-gudang" : 
                $getProduct = $this->produkModel->findProductOut($qr[0]);
                $status = '0';
                if ($getProduct->getNumRows() > 0) {
                    $status = '1'; 
                    $this->produkModel->setProductOut($qr[0]);
                }
                break;
            case "pengiriman" :                 
                $status = '0';
                $getShipment = $this->shippinglModel->where('resi', $resi)->first();
                if (is_null($getShipment) || empty($getShipment)) {
                    $str = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
                    $numbers = rand(1000, 9999);
                    $info = 'BOX-'.substr($str, 0, 3).''.$numbers;
                    $this->shippinglModel->insertShippingDetail($info, $qr);
                    $status = '1';
                    
                }
                break;
            case "pengiriman-produk" :      
                    $status = '1';
                    $resi = $post['qr'];
                    $prod = explode('-', $post['prod']);
                    $getShipment = $this->shippinglModel->where('resi', $resi)->first();            
                    $this->shippinglModel->insertProductShipment($prod[0], $getShipment['id']);   
                    $data = $this->produkModel->setProductOutShipment($prod[0], '0');
                    $this->logModel->saveHistoryStok($data);    
                break;
            case "so" : 
                $getProduct = $this->produkModel->findProductSo($qr[0]);
                $status = '0';
                $check = $this->produkModel
                    ->join('product_barcodes', 'product_barcodes.product_id = products.id')
                    ->join('scan_so', 'scan_so.product_id = product_barcodes.id')
                    ->where('scan_so.product_id', $qr[0])
                    ->get();

                if ($getProduct->getNumRows() > 0) {
                    $status = '1'; 
                    if ($check->getNumRows() == 0) {
                        $this->produkModel->setProductSO($qr[0]);
                    }
                }
                break;
            case "retur-produk" : 
                $getProduct = $this->produkModel
                ->join('product_barcodes', 'product_barcodes.product_id = products.id')
                ->where('product_barcodes.id', $qr[0])
                ->where('product_barcodes.status != ', '1')
                ->get();
                $status = '0';
                if ($getProduct->getNumRows() > 0) {
                    $status = '1';           
                    $data = $this->produkModel->returProduct($qr[0]);
                    $this->logModel->saveHistoryStok($data); 
                    $this->logModel->save([
                        'description' => 'Meretur data Produk ('.$qr[1].' '.$qr[2].' '.$qr[3].')',
                        'user_id' =>  session()->get('user_id'),
                    ]);
                }
                break;
            case "perbaikan" : 
                    $check = $this->produkModel->findProductRejectPermanent($qr[0]);
                    $status = '0';      

                    if ($check->getNumRows() > 0) {
                        $data = $check->getResultObject();                        
                        if ($data[0]->status != '1') { 
                            $status = '0';
                        } else {
                            $this->produkModel->rejectIn($qr[0]);
                            $status = '1';
                        }
                    }

                    
                break;
        }

        $data = [            
            'status' => $status
        ];
        echo json_encode($data);
    }    
}