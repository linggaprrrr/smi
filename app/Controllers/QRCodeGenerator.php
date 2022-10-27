<?php

namespace App\Controllers;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use App\Models\MaterialModel;
use App\Models\ProductModel;
use App\Models\ShippingModel;
use App\Models\LogModel;

class QRCodeGenerator extends BaseController
{
    protected $materialModel = "";
    protected $produkModel = "";
    protected $shippinglModel = "";
    protected $logModel = "";

    public function __construct() { 
        $userId = session()->get('user_id');
        if (is_null($userId)) {            
            header('Location: '.base_url('/'));
            exit(); 
        }
        $this->materialModel = new MaterialModel();
        $this->produkModel = new ProductModel();
        $this->shippinglModel = new ShippingModel();
        $this->logModel = new LogModel();
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
        $products = $this->produkModel->select('products.product_name, models.model_name, color, weight, qty, products.created_at, product_barcodes.qrcode')
            ->join('models', 'models.id = products.model_id')
            ->join('product_types', 'product_types.id = products.product_id')
            ->join('colors', 'colors.id = products.color_id')
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')            
            ->orderBy('products.created_at', 'desc')
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
        
        $productsGudang = $this->produkModel->select('products.*, model_name, product_name, color, name, product_barcodes.qrcode as qr')
            ->join('models', 'models.id = products.model_id')
            ->join('product_types', 'product_types.id = product_id')
            ->join('colors', 'colors.id = products.color_id')
            ->join('users', 'users.id = products.user_id')
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')
            ->where('products.status', 2)
            ->groupBy('products.id')
            ->orderBy('created_at', 'desc')
            ->get();

        $productReject = $this->produkModel->select('products.id, weight, size, reject.qty, reject.date, reject.status, model_name, product_name, color, name, product_barcodes.qrcode as qr')
            ->join('models', 'models.id = products.model_id')
            ->join('product_types', 'product_types.id = product_id')
            ->join('colors', 'colors.id = products.color_id')
            ->join('users', 'users.id = products.user_id')
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')
            ->join('reject', 'reject.barcode_id = product_barcodes.id')            
            ->groupBy('products.id')
            ->orderBy('created_at', 'desc')
            ->get();

            
        $data = array(
            'title' => 'QR Generator - Produk',
            'products' => $products,
            'productsGudang' => $productsGudang,
            'productReject' => $productReject,
            
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

    public function generateQRProductReject() {
        
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
                    ->join('reject', 'reject.barcode_id = product_barcodes.id')
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

    public function scannerMaterialRetur() {
        $data = array(
            'title' => 'QR Scanner Retur Kain (OUT)'
        );
        return view('gudang_gesit/qr_scanner_material_retur', $data);    
    }

    public function scannerProductIn() {
        $data = array(
            'title' => 'QR Scanner Produk (IN)'
        );
        return view('gudang_gesit/qr_scanner_product_in', $data);    
    }

    public function scannerProductSO() {
        $data = array(
            'title' => 'QR Scanner Produk IN'
        );
        return view('gudang_lovish/qr_scanner_so', $data);    
    }

    public function scannerProductSOMonth() {
        $data = array(
            'title' => 'QR Scanner Produk SO'
        );
        return view('gudang_lovish/qr_scanner_so_bulanan', $data);    
    }

    public function scannerProductSOReplace() {
        $data = array(
            'title' => 'QR Scanner Produk SO'
        );
        return view('gudang_lovish/qr_scanner_so_replace', $data);    
    }

    public function scannerProductOut() {
        $data = array(
            'title' => 'QR Scanner Product Out'
        );
        return view('gudang_lovish/qr_scanner_out', $data);    
    }

    public function scannerProductRetur() {
        
        $data = array(
            'title' => 'QR Scanner Retur',
            
        );
        return view('gudang_lovish/qr_scanner_retur_in', $data);    
    }

    public function scannerCutting() {
        $data = array(
            'title' => 'QR Scanner Cutting'
        );

        return view('gudang_gesit/qr_scanner_cutting', $data);
    }

    public function scannerReject() {
        $reject = $this->produkModel->rejectedProduct();        
        $data = array(
            'title' => 'QR Scanner Reject',
            'rejectedProducts' => $reject            
        );

        return view('gudang_gesit/qr_scanner_reject', $data);
    }

    public function scannerSellingReject() {
        $reject = $this->produkModel->rejectedSold();        
        $data = array(
            'title' => 'QR Scanner Penjualan Produk Reject',
            'rejectedProducts' => $reject            
        );

        return view('gudang_gesit/qr_scanner_penjualan_reject', $data);
    }

    public function scannerShipment() {
        $shippings = $this->shippinglModel
            ->select('shippings.*, shipping_details.product_id')
            ->join('shipping_details', 'shipping_details.shipping_id = shippings.id', 'left')
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
            $status = '1'; // ada barang di vendor
            $this->materialModel->save([
                'id' => $qr[0],
                'status' => 3,
            ]);    
            $this->materialModel->setPolaIn($qr[0], session()->get('user_id'));
        } else if (!is_null($getMaterial)) {
            $status = '2'; // tidak ada barang di vendor
        } else if ($getMaterial['status'] == '3') {
            $status = '3'; // sudah di scan
        }
        echo json_encode($status);
    }

    public function scanningMaterialOut() {
        $qr = $this->request->getVar('qr');
        $qr = explode("-",$qr);
                
        $getMaterial = $this->materialModel->find($qr[0]);
        $status = '0';
        if (!is_null($getMaterial)) {
            if ($getMaterial['status'] != '1') {
                $status = '3';   
            } else {
                $status = '1';
                $this->materialModel->save([
                    'id' => $qr[0],
                    'status' => 2,
                    'updated_at' => date("Y-m-d H:i:s")
                ]);
                $this->materialModel->setPolaOut($qr[0], session()->get('user_id'));
            }
        }
        echo json_encode($status);
    }

    public function scanningProductIn() {
        $qr = $this->request->getVar('qr');
        $qr = explode("-",$qr);
        
         
        $productStatus = $this->produkModel->productStatus($qr[0]);        
        $status = '0';
        
        if ($productStatus[0]->status == '1') {
            $status = '1';       
            $this->produkModel->updateQRStatus($qr[0]);     
            $this->produkModel->setProductIn($qr[0], session()->get('user_id'));
            
        }        
        echo json_encode($status);
        
    }

    public function scanningCutting() {
        $qr = $this->request->getVar('qr');
        $qr = explode('-', $qr);
        $status = 0;

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
        echo json_encode($status);
    }

    public function scanningReject() {
        $qr = $this->request->getVar('qr');
        $qr = explode("-",$qr);
        
        $getProduct = $this->produkModel->findProductIn($qr[0]);
        $status = '0';
        if ($getProduct->getNumRows() > 0) {
            $status = '1'; 
        }
        echo json_encode($status);
    }

    public function scanningRejectSold() {
        $qr = $this->request->getVar('qr');
        $qr = explode("-",$qr);
        
        $getProduct = $this->produkModel->findProductRejectSold($qr[0]);
        $status = '0';
        if ($getProduct->getNumRows() > 0) {
            $status = '1'; 
        }
        echo json_encode($status);
    }

    public function scanningProductOut() {
        $qr = $this->request->getVar('qr');
        $qr = explode("-",$qr);
        
        $getProduct = $this->produkModel->findProductOut($qr[0]);
        $status = '0';
        if ($getProduct->getNumRows() > 0) {
            $status = '1'; 
            $this->produkModel->setProductOut($qr[0], session()->get('user_id'));
        }
        echo json_encode($status);
    }

    public function scanningProductSO() {
        $qr = $this->request->getVar('qr');
        $qr = explode("-",$qr);
        
        $getProduct = $this->produkModel->findProductOut($qr[0]);
        $status = '0';
        if ($getProduct->getNumRows() > 0) {
            $status = '1'; 
            $this->produkModel->setProductSO($qr[0]);
        }
        echo json_encode($status);
    }

    public function scanningProductSOMonth() {
        $qr = $this->request->getVar('qr');
        $qr = explode("-",$qr);
        
        $getProduct = $this->produkModel->findProductOut($qr[0]);
        $status = '0';
        if ($getProduct->getNumRows() > 0) {
            $status = '1'; 
            $this->produkModel->setProductSOMonth($qr[0]);
        }
        echo json_encode($status);
    }

    public function scanningProductSOReplace() {
        $qr = $this->request->getVar('qr');
        $qr = explode("-",$qr);
        
        $getProduct = $this->produkModel->findProductOut($qr[0]);
        $status = '0';
        if ($getProduct->getNumRows() > 0) {
            $status = '1'; 
            $this->produkModel->setProductSOReplace($qr[0]);
        }
        echo json_encode($status);
    }

    public function scanningProductRetur() {
        $qr = $this->request->getVar('qr');
        $qr = explode("-",$qr);
        
        $getProduct = $this->produkModel
        ->join('product_barcodes', 'product_barcodes.product_id = products.id')
        ->join('product_logs', 'product_logs.product_id = product_barcodes.id')
        ->where('product_logs.product_id', $qr[0])
        ->get();
        $status = '0';
        if ($getProduct->getNumRows() > 0) {
            $status = '1';           
            $this->produkModel->returProduct($qr[0]);
            $this->logModel->save([
                'description' => 'Meretur data Produk ('.$qr[1].' '.$qr[2].' '.$qr[3].')',
                'user_id' =>  session()->get('user_id'),
            ]);
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
        $qr = explode("-",$qr);
        $status = '0';
        $getProduct = $this->produkModel
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')
            ->join('product_logs', 'product_logs.product_id = product_barcodes.id')
            ->where('product_barcodes.id', $qr[0])
            ->get();
        
        if ($getProduct->getNumRows() > 0) { 
            $resi = $this->request->getVar('box_name'); 
            $getShipment = $this->shippinglModel->where('resi', $resi)->first();            
            if (!is_null($getShipment) || !empty($getShipment)) {
                $status = '2';                 
                $this->shippinglModel->insertProductShipment($qr[0], $getShipment['id']);   
                $this->produkModel->setProductOut($qr[0], session()->get('user_id'));
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

    public function scanningCut() {
        $qr = $this->request->getVar('qr');
        $qr = explode("-",$qr);
        
        $getProduct = $this->materialModel->find($qr[0]);
        $status = '0';
        if (!is_null($getProduct)) {
            $status = '1'; 
            $coa = $this->materialModel->getCOA();
            $this->materialModel->setCutting($qr[0]);
            
        }
        echo json_encode($status);
    }   

    public function test() {
        $query = $this->materialModel->updateVendorPolaOut(22, 3);
        dd($query);


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

    public function kirimQR() {
        $post = $this->request->getVar();

        $data = [
            'title' => $post['title'],
            'body' => $post['text'],
            'userId' => $post['user_id'],
            'id' => $post['id']
        ];
        echo json_encode($data);
    }    

    

}
