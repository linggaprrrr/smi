<?php

namespace App\Controllers;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use App\Models\MaterialModel;
use App\Models\ProductModel;

class QRCodeGenerator extends BaseController
{
    protected $materialModel = "";

    public function __construct() { 
        $userId = session()->get('user_id');
        if (is_null($userId)) {            
            header('Location: '.base_url('/'));
            exit(); 
        }
        $this->materialModel = new MaterialModel();
    }
    
    public function QRGenerator() {
        $materials = $this->materialModel->getAllMaterial();
        $data = array(
            'title' => 'QR Generator',
            'materials' => $materials
            
        );
        return view('admin/qr_generator', $data);    
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
                $getMaterial = $this->materialModel->find($materials[$i]);                
                $data = $getMaterial['id'].'-'.substr($getMaterial['type'], 0, 3).'-'.$getMaterial['color'];                
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

    public function QRScanner() {
        $data = array(
            'title' => 'QR Scanner'
        );
        return view('admin/qr_scanner', $data);    
    }

    public function test() {
        $qr = QrCode::create("hayy guys");
        $writer = new PngWriter();
        $result = $writer->write($qr);        
        header("Content-Type: " . $result->getMimeType()); 
        echo "<img src='{$result->getDataUri()}'/>";
    }

}
