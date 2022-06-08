<?php

namespace App\Controllers;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class QRCodeGenerator extends BaseController
{
    public function __construct() { 
        $userId = session()->get('user_id');
        if (is_null($userId)) {            
            header('Location: '.base_url('/'));
            exit(); 
        }
    }
    
    public function QRGenerator() {
        $data = array(
            'title' => 'QR Generator'
        );
        return view('admin/qr_generator', $data);    
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
