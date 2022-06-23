<?php

namespace App\Controllers;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use App\Models\MaterialModel;
use App\Models\ProductModel;

class QRCodeGenerator extends BaseController
{
    protected $materialModel = "";
    protected $produkModel = "";

    public function __construct() { 
        $userId = session()->get('user_id');
        if (is_null($userId)) {            
            header('Location: '.base_url('/'));
            exit(); 
        }
        $this->materialModel = new MaterialModel();
        $this->produkModel = new ProductModel();
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
        $products = $this->produkModel->select('products.*, model_name, product_name, color, name')
            ->join('models', 'models.id = products.model_id')
            ->join('product_types', 'product_types.id = product_id')
            ->join('colors', 'colors.id = products.color_id')
            ->join('users', 'users.id = products.user_id')
            ->where('status', 1)
            ->orderBy('qrcode', 'asc')
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
                          
                $data = $getMaterial[0]->id.'-'.substr($getMaterial[0]->type, 0, 3).'-'.$getMaterial[0]->color;                
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
                $getProduct = $this->produkModel->select('products.id, model_name, product_name, color')
                    ->join('product_types', 'product_types.id = product_id')
                    ->join('colors', 'colors.id = products.color_id')
                    ->join('models', 'products.model_id = models.id')                
                    ->where('products.id', $products[$i])                                        
                    ->first();
                $data = $getProduct['id'].'-'.substr($getProduct['product_name'], 0, 1).''.$getProduct['model_name'].'-'.$getProduct['color'];                
                $qr = QrCode::create($data);
                $writer = new PngWriter();
                $result = $writer->write($qr);    
                $this->produkModel->set('qrcode', $result->getDataUri())                    
                    ->where('id', $products[$i])->update();            
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

    public function scannerProductIn() {
        $data = array(
            'title' => 'QR Scanner IN'
        );
        return view('gudang_lovish/qr_scanner_product_in', $data);    
    }

    public function scannerProductOut() {
        $data = array(
            'title' => 'QR Scanner OUT'
        );
        return view('gudang_lovish/qr_scanner_out', $data);    
    }

    public function scanningMaterialIn() {
        $qr = $this->request->getVar('qr');
        $qr = explode("-",$qr);
        
        $this->materialModel->save([
            'id' => $qr[0],
            'status' => 2,
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        $getMaterial = $this->materialModel->find($qr[0]);
        $status = '0';
        if (!is_null($getMaterial)) {
            $status = '1';
        }
        echo json_encode($status);
    }

    public function scanningProductIn() {
        $qr = $this->request->getVar('qr');
        $qr = explode("-",$qr);
        
        $this->produkModel->save([
            'id' => $qr[0],
            'status' => 2,
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        
        
    }

    public function scanningProductOut() {
        $qr = $this->request->getVar('qr');
        $qr = explode("-",$qr);
        
        $this->produkModel->save([
            'id' => $qr[0],
            'status' => 3,
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
