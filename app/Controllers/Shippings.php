<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\ShippingModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
        $shippings = $this->shippinglModel
            ->orderBy('qrcode', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
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
        

    }

    public function exportShipments($date1= null, $date2 = null) {
         if (is_null($date1)) {
            $shippings = $this->shippinglModel->getAllShippingDetail();     
        } else {
            $shippings = $this->shippinglModel->getAllShippingDetail($date1, $date2);
        }
        
        $date = time();
        $fileName = "Data Pengiriman {$date}.xlsx";  
        $spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Resi');
		$sheet->setCellValue('C1', 'Tanggal');
		$sheet->setCellValue('D1', 'Produk');
		$sheet->setCellValue('E1', 'Jumlah');
        $i = 2;
        $no = 1;
        $resi = "";
        foreach($shippings->getResultObject() as $row) {
            if ($resi != $row->resi) {
                $sheet->setCellValue('A' . $i, $no++);
                $sheet->setCellValue('B' . $i, $row->resi);
                $sheet->setCellValue('C' . $i, $row->created_at);
                $sheet->setCellValue('D' . $i, $row->product_name.' '.$row->model_name.' '.$row->color.' '.$row->size);
                $sheet->setCellValue('E' . $i, $row->qty);
                $resi = $row->resi;
            } else {
                $sheet->setCellValue('D' . $i, $row->product_name.' '.$row->model_name.' '.$row->color.' '.$row->size);
                $sheet->setCellValue('E' . $i, $row->qty);
            }
            $i++;
        }
        
        $writer = new Xlsx($spreadsheet);

        $writer->save($fileName);
        header("Content-Type: application/vnd.ms-excel");

		header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length:' . filesize($fileName));
		flush();
		readfile($fileName);
		exit;
    }

}