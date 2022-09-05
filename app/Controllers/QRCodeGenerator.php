<?php

namespace App\Controllers;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use App\Models\MaterialModel;
use App\Models\ProductModel;
use App\Models\ShippingModel;

class QRCodeGenerator extends BaseController
{
    protected $materialModel = "";
    protected $produkModel = "";
    protected $shippinglModel = "";
    

    public function __construct() { 
        $userId = session()->get('user_id');
        if (is_null($userId)) {            
            header('Location: '.base_url('/'));
            exit(); 
        }
        $this->materialModel = new MaterialModel();
        $this->produkModel = new ProductModel();
        $this->shippinglModel = new ShippingModel();
    }
    
    public function QRGeneratorMaterial() {
        $materials = $this->materialModel->getAllMaterialQR();
        $data = array(
            'title' => 'QR Generator - Kain',
            'materials' => $materials
            
        );
        return view('admin/qr_generator', $data);    
    }

    public function QRGeneratorProductIn() {
        $products = $this->produkModel->select('products.*, models.model_name')
            ->join('models', 'models.id = products.model_id')
            ->orderBy('qrcode', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $data = array(
            'title' => 'QR Generator - Produk',
            'products' => $products
            
        );
        return view('admin/qr_generator_produk', $data);    
    }

    public function QRGeneratorMaterialGesit() {
        $materials = $this->materialModel->getAllMaterialQR();
        $data = array(
            'title' => 'QR Generator - Kain',
            'materials' => $materials
            
        );
        return view('gudang_gesit/qr_generator_material', $data);    
    }

    public function QRGeneratorProductInGesit() {
        $products = $this->produkModel->select('products.*, model_name, product_name, color, name, product_barcodes.qrcode as qr')
            ->join('models', 'models.id = products.model_id')
            ->join('product_types', 'product_types.id = product_id')
            ->join('colors', 'colors.id = products.color_id')
            ->join('users', 'users.id = products.user_id')
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')
            ->where('products.status', 1)
            ->groupBy('products.id')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $data = array(
            'title' => 'QR Generator - Produk',
            'products' => $products
            
        );
        return view('gudang_gesit/qr_generator_produk', $data);    
    }

    public function generateQR() {
        $materials = $this->request->getVar('print');        
        if (!is_null($materials)) {
            $json = array();
            $qrs = array(
                'key' => '',
                'qr' => ''
            );
            for ($i=0; $i < count($materials); $i++) {
                $getMaterial = $this->materialModel->getMaterialDetail($materials[$i]);
                          
                $data = $getMaterial[0]->id.'-'.$getMaterial[0]->type.'-'.$getMaterial[0]->color;                
                $qr = QrCode::create($data);
                $writer = new PngWriter();
                $result = $writer->write($qr);    
                $this->materialModel->set('qrcode', $result->getDataUri())->where('id', $materials[$i])->update();            
                $qrs['key'] = $data;
                $qrs['qr'] = $result->getDataUri();
                array_push($json, $qrs);
            }
            echo json_encode($json);         
        }   
    }
    
    public function generateQRProduct() {
        
        $products = $this->request->getVar('print');                
        if (!is_null($products)) {
            $json = array();
            $qrs = array(
                'key' => '',
                'qr' => ''
            );
            for ($i=0; $i < count($products); $i++) {
                $getProducts = $this->produkModel->select('product_barcodes.id, model_name, product_name, color')
                    ->join('product_types', 'product_types.id = product_id')
                    ->join('colors', 'colors.id = products.color_id')
                    ->join('models', 'products.model_id = models.id')                
                    ->join('product_barcodes', 'product_barcodes.product_id = products.id')
                    ->where('products.id', $products[$i])                                        
                    ->get();
                
                foreach ($getProducts->getResultArray() as $row) {
                    $data = $row['id'].'-'.$row['product_name'].'-'.$row['model_name'].'-'.$row['color'];                
                    $qr = QrCode::create($data);
                    $writer = new PngWriter();
                    $result = $writer->write($qr);    
                    $this->produkModel->setBarocde($row['id'], $result->getDataUri());
                    $qrs['key'] = $data;
                    $qrs['qr'] = $result->getDataUri();
                    array_push($json, $qrs);
                }                
            }
            echo json_encode($json);         
        }   
    }

    public function generateQRShipment() {
        $shipments = $this->request->getVar('print');        
        if (!is_null($shipments)) {
            $json = array();
            $qrs = array(
                'key' => '',
                'qr' => ''
            );
            for ($i=0; $i < count($shipments); $i++) {
                $getShipment = $this->shippinglModel->find($shipments[$i]);
                $data = $getShipment['box_name'];            
                $qr = QrCode::create($data);
                $writer = new PngWriter();
                $result = $writer->write($qr);    
                $this->shippinglModel->set('qrcode', $result->getDataUri())->where('id', $shipments[$i])->update();            
                $qrs['key'] = $data;
                $qrs['qr'] = $result->getDataUri();
                array_push($json, $qrs);
            }
            echo json_encode($json);         
        }   
    }

    public function QRScanner() {
        $data = array(
            'title' => 'QR Scanner'
        );
        return view('admin/qr_scanner', $data);    
    }

    public function scannerMaterialIn() {
        $data = array(
            'title' => 'QR Scanner IN'
        );
        return view('gudang_gesit/qr_scanner_material_in', $data);    
    }

    public function scannerPolaIn() {
        $data = array(
            'title' => 'QR Scanner Pola (IN)'
        );
        return view('gudang_gesit/qr_scanner_material_in', $data);    
    }

    public function scannerPolaOut() {
        $data = array(
            'title' => 'QR Scanner Pola (OUT)'
        );
        return view('gudang_gesit/qr_scanner_material_out', $data);    
    }

    public function scannerProductIn() {
        $data = array(
            'title' => 'QR Scanner Produk (IN)'
        );
        return view('gudang_gesit/qr_scanner_product_in', $data);    
    }

    public function scannerProductOut() {
        $data = array(
            'title' => 'QR Scanner Product Out'
        );
        return view('gudang_lovish/qr_scanner_out', $data);    
    }

    public function scannerProductRetur() {
        $data = array(
            'title' => 'QR Scanner Retur'
        );
        return view('gudang_lovish/qr_scanner_retur_in', $data);    
    }

    public function scannerShipment() {
        $shippings = $this->shippinglModel
            ->select('shippings.*, shipping_details.product_id')
            ->join('shipping_details', 'shipping_details.shipping_id = shippings.id')
            ->orderBy('qrcode', 'asc')
            ->orderBy('created_at', 'desc')
            ->groupBy('shippings.id')
            ->get();
        $data = array(
            'title' => 'QR Scanner Pengiriman',
            'shippings' => $shippings
        );
        return view('gudang_lovish/qr_scanner_shipping', $data);    
    }

    public function scanningMaterialIn() {
        $qr = $this->request->getVar('qr');
        $qr = explode("-",$qr);
                
        $getMaterial = $this->materialModel->find($qr[0]);
        $status = '0';
        if (!is_null($getMaterial) && $getMaterial['status'] == '2') {
            $status = '1';
            $this->materialModel->save([
                'id' => $qr[0],
                'status' => 3,
            ]);    
            $this->materialModel->setPolaIn($qr[0], session()->get('user_id'));
        }
        echo json_encode($status);
    }

    public function scanningMaterialOut() {
        $qr = $this->request->getVar('qr');
        $qr = explode("-",$qr);
                
        $getMaterial = $this->materialModel->find($qr[0]);
        $status = '0';
        if (!is_null($getMaterial) && $getMaterial['status'] == '1') {
            $status = '1';
            $this->materialModel->save([
                'id' => $qr[0],
                'status' => 2,
                'updated_at' => date("Y-m-d H:i:s")
            ]);
            $this->logModel->save([
                'description' => 'melakukan scan untuk input pola ',
                'user_id' =>  session()->get('user_id'),
            ]);
            $this->materialModel->setPolaOut($qr[0], session()->get('user_id'));
        }
        echo json_encode($status);
    }

    public function scanningProductIn() {
        $qr = $this->request->getVar('qr');
        $qr = explode("-",$qr);
        
        $getProduct = $this->produkModel->findQR($qr[0]);
        
        $productStatus = $this->produkModel->productStatus($qr[0]);        
        $status = '0';
        
        if ($getProduct != false && $productStatus[0]->status == '1') {
            $status = '1';       
            $this->produkModel->updateQRStatus($qr[0]);     
            $this->produkModel->setProductIn($qr[0], session()->get('user_id'));
        }
        echo json_encode($status);
        
    }

    public function scanningProductOut() {
        $qr = $this->request->getVar('qr');
        $qr = explode("-",$qr);
        
        $getProduct = $this->produkModel->find($qr[0]);
        $status = '0';
        if (!is_null($getProduct)) {
            $status = '1'; 
            $this->produkModel->setProductOut($qr[0], session()->get('user_id'));
        }
        echo json_encode($status);
    }

    public function scanningProductRetur() {
        $qr = $this->request->getVar('qr');
        $qr = explode("-",$qr);
        
        $getProduct = $this->produkModel->find($qr[0]);
        $status = '0';
        if (!is_null($getProduct)) {
            $status = '1';           
            $this->produkModel->setProductIn($qr[0], session()->get('user_id'));
        }
        echo json_encode($status);
    }

    public function scanningMaterialRetur() {
        $qr = $this->request->getVar('qr');
        $qr = explode("-",$qr);
        
        $getProduct = $this->materialModel->find($qr[0]);
        $status = '0';
        if (!is_null($getProduct) && $getProduct['status'] == '3') {
            $status = '1'; 
            $this->materialModel->updateMaterialStokRetur($qr[0]);
            
        }
        echo json_encode($status);
    }

    public function scanningBox() {
        $qr = $this->request->getVar('qr');    
        $status = '0';
        $getProduct = $this->produkModel->find($qr);
        if (!is_null($getProduct) || !empty($getProduct)) {
            $qr = explode("-",$qr);
            $resi = $this->request->getVar('box_name'); 
            $getShipment = $this->shippinglModel->where('resi', $resi)->first();            
            if (!is_null($getShipment) || !empty($getShipment)) {
                $status = '2'; 
                $this->produkModel->updateStokOut($qr[0]);     
                $this->shippinglModel->insertProductShipment($getProduct['id'], $getShipment['id']);   
                // $this->produkModel->setProductOut($qr[0], session()->get('user_id'));
            }            
        } else {            
            $getShipment = $this->shippinglModel->where('resi', $qr)->first();
            if (is_null($getShipment) || empty($getShipment)) {
                $str = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
                $numbers = rand(1000, 9999);
                $info = 'BOX-'.substr($str, 0, 3).''.$numbers;
                $this->shippinglModel->insertShippingDetail($info, $qr);
                $status = 1;
            }
        }
        echo json_encode($status);
    }

    public function scanningShipment() {
        $qr = $this->request->getVar('qr');
        $qr = explode("-",$qr);
        
        $this->produkModel->save([
            'id' => $qr[0],
            'status' => 2,
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        
    }

    

    public function test() {
        $getMaterial = $this->materialModel->find(1);
        if (is_null($getMaterial)) {
            echo "heyy";
        } else {
            echo "hoyy";
        }
    } 

}
