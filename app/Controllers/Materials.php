<?php

namespace App\Controllers;

use App\Models\MaterialModel;
use App\Models\ProductModel;
use App\Models\DesignModel;
use App\Models\LogModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Materials extends BaseController
{   
    protected $materialModel = "";
    protected $productModel = "";
    protected $designModel = "";
    protected $logModel = "";

    public function __construct() { 
        $userId = session()->get('user_id');
        if (is_null($userId)) {            
            header('Location: '.base_url('/'));
            exit(); 
        }
        $this->materialModel = new MaterialModel();
        $this->productModel = new ProductModel();
        $this->designModel = new DesignModel();
        $this->logModel = new LogModel();
    }

    public function index() {
        $materials = $this->materialModel->getAllMaterialType();
        $colors = $this->materialModel->getAllColors();
        $materialVendors = $this->materialModel->getMaterialVendors();
        $materialsIn = $this->materialModel->getAllMaterial();        
        
        $materialsOut = $this->materialModel->getAllMaterialOut();        
        $gudangs = $this->materialModel->getAllGudang();
        $picCutting = $this->materialModel->getAllPICCutting();
        $getAllTimGelar = $this->materialModel->getAllTimGelar();
        $vendorPola = $this->materialModel->getAllVendorPola();
        $cuttings = $this->materialModel->getAllCuttingData();    
        $polaOut = $this->materialModel->getAllPolaOut();        
        $polaIn = $this->materialModel->getAllPolaIn();
        $models = $this->designModel->getAllModel();
        $data = array(
            'title' => 'Kain',
            'materials' => $materials,
            'colors' => $colors,
            'models' => $models,
            'materialsIn' => $materialsIn,
            'gudangs' => $gudangs,
            'materialVendors' => $materialVendors,
            'picCutting' => $picCutting,
            'timGelars' => $getAllTimGelar,
            'vendorPola' => $vendorPola,
            'cuttings' => $cuttings,
            'polaOut' => $polaOut,
            'polaIn' => $polaIn
        );
        return view('admin/materials', $data);    
    }

    public function saveMaterial() {
        $post = $this->request->getVar();
        $type = strtoupper($post['jenis']);
        $harga = strtoupper($post['harga']);
        $this->materialModel->saveMaterialType($type, $harga);
    }

    public function addMaterial() {
        $post = $this->request->getVar();
        
        for ($i = 0; $i < $post['roll']; $i++) {
            do {
                $str = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
                $numbers = rand(1000, 9999);
                $id = 'M-'.substr($str, 0, 3).''.$numbers;      
                
                $isExist = $this->materialModel->getWhere(['material_id' => $id]);
            } while ($isExist->getNumRows() > 0);        
            $material = [
                'material_id' => $id,
                'material_type' => $post['jenis'],            
                'vendor_id' => $post['vendor'],
                'color_id'  => $post['warna'],
                'weight'  => $post['berat'],
                'price' => $post['harga'],
                'user_id' => session()->get('user_id'),
            ];
            $this->materialModel->save($material);
        }        
        $this->logModel->save([
            'description' => 'Menambahkan data kain baru ('.$post['jenis'].' '.$post['warna'].') Sebanyak '.$post['roll'].' roll',
            'user_id' =>  session()->get('user_id'),
        ]);
        return redirect()->back()->with('create', 'Kain berhasil ditambahkan');
    }

    public function getMaterial() {
        $id = $this->request->getVar('material_id');
        $material = $this->materialModel->getMaterialType($id);
        echo json_encode($material[0]);
    }

    public function getMaterialDetail() {
        $id = $this->request->getVar('material_id');
        $material = $this->materialModel->getMaterialDetail($id);
        echo json_encode($material[0]);
    }

    public function updateMaterial() {
        $post = $this->request->getVar();
        $this->materialModel->updateMaterialType($post['id'], strtoupper($post['jenis']), $post['harga']);
        return redirect()->back()->with('update', 'Kain berhasil ditambahkan');
    }

    
    public function updateMaterialDetail() {
        $post = $this->request->getVar();
        $material = [
            'id' => $post['id'],
            'material_id' => $post['jenis'],
            'color_id'  => $post['warna'],
            'weight'  => $post['berat'],
            'vendor_id' => $post['vendor'],
            'price' => $post['harga'],
            'user_id' => session()->get('user_id'),
            'gudang_id' => $post['gudang']
        ];
        $this->materialModel->save($material);
        $getMaterial = $this->materialModel
            ->select('material_types.type, colors.color')
            ->join('material_types', 'material_types.id = materials.material_id')
            ->join('colors', 'colors.id = materials.color_id')
            ->where('materials.id', $post['id'])
            ->first();
        $this->logModel->save([
            'description' => 'Mengubah data kain ('.$getMaterial['type'].' '.$getMaterial['color'].')',
            'user_id' =>  session()->get('user_id'),
        ]);
        return redirect()->back()->with('create', 'Kain berhasil ditambahkan');
    }

    public function deleteMaterial() {
        $id = $this->request->getVar('material_id');
        $this->materialModel->deleteMaterialType($id);
        return redirect()->back()->with('delete', 'Kain berhasil dihapus');
    }

    public function deleteMaterialDetail() {
        $id = $this->request->getVar('material_id');
        $getMaterial = $this->materialModel
            ->select('material_types.type, colors.color')
            ->join('material_types', 'material_types.id = materials.material_type')
            ->join('colors', 'colors.id = materials.color_id')
            ->where('materials.id', $id)
            ->first();
        $this->logModel->save([
            'description' => 'Menghapus data kain ('.$getMaterial['type'].' '.$getMaterial['color'].')',
            'user_id' =>  session()->get('user_id'),
        ]);
        $this->materialModel->where('id', $id)->delete();
    }

    public function exportData($date1 = null, $date2 = null) {
        if (is_null($date1)) {
            $materials = $this->materialModel->getAllMaterial();
        } else {
            $materials = $this->materialModel->getAllMaterial($date1, $date2);
        }
        $date = date('m-d-Y H.i.s');
        $fileName = "Data Kain Masuk {$date}.xlsx";  
        $spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Jenis');
		$sheet->setCellValue('C1', 'Warna');
		$sheet->setCellValue('D1', 'Berat (Kg)');
		$sheet->setCellValue('E1', 'Tanggal Masuk');
		$sheet->setCellValue('F1', 'Vendor');
        $i = 2;
        $no = 1;
        foreach($materials->getResultObject() as $row) {
            $sheet->setCellValue('A' . $i, $no++);
            $sheet->setCellValue('B' . $i, $row->type);
            $sheet->setCellValue('C' . $i, $row->color);
            $sheet->setCellValue('D' . $i, $row->weight);
            $sheet->setCellValue('E' . $i, $row->created_at);
            $sheet->setCellValue('F' . $i, $row->vendor);
            $i++;
        }
        
        $writer = new Xlsx($spreadsheet);

        $writer->save("file/". $fileName);
        header("Content-Type: application/vnd.ms-excel");

		header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length:' . filesize("file/". $fileName));
		flush();
		readfile("file/". $fileName);
		exit;
    }

    public function exportDataRetur($date1 = null, $date2 = null) {
        if (is_null($date1)) {
            $materials = $this->materialModel->getAllMaterialRetur();
        } else {
            $materials = $this->materialModel->getAllMaterialRetur($date1, $date2);
        }
        $date = date('m-d-Y H.i.s');
        $fileName = "Data Kain Retur {$date}.xlsx";  
        $spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Jenis');
		$sheet->setCellValue('C1', 'Warna');
		$sheet->setCellValue('D1', 'Berat (Kg)');
		$sheet->setCellValue('E1', 'Tanggal Retur');
		$sheet->setCellValue('F1', 'Vendor');
        $i = 2;
        $no = 1;
        foreach($materials->getResultObject() as $row) {
            $sheet->setCellValue('A' . $i, $no++);
            $sheet->setCellValue('B' . $i, $row->type);
            $sheet->setCellValue('C' . $i, $row->color);
            $sheet->setCellValue('D' . $i, $row->weight);
            $sheet->setCellValue('E' . $i, $row->updated_at);
            $sheet->setCellValue('F' . $i, $row->vendor);
            $i++;
        }
        
        $writer = new Xlsx($spreadsheet);

        $writer->save("file/". $fileName);
        header("Content-Type: application/vnd.ms-excel");

		header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length:' . filesize("file/". $fileName));
		flush();
		readfile("file/". $fileName);
		exit;
    }

    public function exportDataStok($date1 = null, $date2 = null) {       
        if (is_null($date1)) {
            $materials = $this->materialModel->getStokMaterialIn(); 
        } else {
            $materials = $this->materialModel->getStokMaterialIn($date1, $date2); 
        }
        $date = date('m-d-Y H.i.s');
        $fileName = "Data Stok Kain {$date}.xlsx";  
        $spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Tanggal Masuk');
		$sheet->setCellValue('C1', 'Jenis');
		$sheet->setCellValue('D1', 'Warna');
		$sheet->setCellValue('E1', 'Stok');
        $i = 2;
        $no = 1;
        foreach($materials->getResultObject() as $row) {
            if ($row->stok_masuk > 0) {
                $sheet->setCellValue('A' . $i, $no++);
                $sheet->setCellValue('B' . $i, $row->created_at);            
                $sheet->setCellValue('C' . $i, $row->type);
                $sheet->setCellValue('D' . $i, $row->color);
                $sheet->setCellValue('E' . $i, $row->stok_masuk);            
                
                
                $i++;
            }
            
        }
        
        $writer = new Xlsx($spreadsheet);

        $writer->save("file/". $fileName);
        header("Content-Type: application/vnd.ms-excel");

		header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length:' . filesize("file/". $fileName));
		flush();
		readfile("file/". $fileName);
		exit;
    }

    // Gudang Gesit
    public function gudangGesitKain() {
        $materials = $this->materialModel->getAllMaterialType();
        $colors = $this->materialModel->getAllColors();
        $materialVendors = $this->materialModel->getMaterialVendors();
        $materialsIn = $this->materialModel->getAllMaterial();         
        
        $materialsOut = $this->materialModel->getAllMaterialOut();        
        $gudangs = $this->materialModel->getAllGudang();
        $picCutting = $this->materialModel->getAllPICCutting();
        $getAllTimGelar = $this->materialModel->getAllTimGelar();
        $vendorPola = $this->materialModel->getAllVendorPola();
        $cuttings = $this->materialModel->getAllCuttingData2();    
        $polaOut = $this->materialModel->getAllPolaOut();  
        // d($polaOut->getResultObject());
        $polaIn = $this->materialModel->getAllPolaIn();
        // dd($polaIn->getResultObject());
        $models = $this->designModel->getAllModel();
        $data = array(
            'title' => 'Kain',
            'materials' => $materials,
            'colors' => $colors,
            'models' => $models,
            'materialsIn' => $materialsIn,
            'gudangs' => $gudangs,
            'materialVendors' => $materialVendors,
            'picCutting' => $picCutting,
            'timGelars' => $getAllTimGelar,
            'vendorPola' => $vendorPola,
            'cuttings' => $cuttings,
            'polaOut' => $polaOut,
            'polaIn' => $polaIn
        );
     
        return view('gudang_gesit/materials', $data);    
    }
    
    public function onChangeMaterialType() {
        $id = $this->request->getVar('id');
        $type = $this->request->getVar('type');

        $this->materialModel->save([
            'id' => $id,
            'material_type' => $type
        ]);
    }

    public function onChangeMaterialCutting() {
        $id = $this->request->getVar('id');
        $pic = $this->request->getVar('pic');

        $this->materialModel->save([
            'id' => $id,
            'pic_cutting' => $pic
        ]);
    }

    public function onChangeMaterialGelar1() {
        $id = $this->request->getVar('id');
        $gelar = $this->request->getVar('gelar');

        $this->materialModel->save([
            'id' => $id,
            'gelar1' => $gelar
        ]);
    }

    public function onChangeCuttingGelar1() {
        $id = $this->request->getVar('id');
        $gelar = $this->request->getVar('gelar');

        $this->materialModel->changeGelar1([
            'id' => $id,
            'gelar1' => $gelar
        ]);
    }

    public function onChangeCuttingGelar2() {
        $id = $this->request->getVar('id');
        $gelar = $this->request->getVar('gelar');

        $this->materialModel->changeGelar2([
            'id' => $id,
            'gelar2' => $gelar
        ]);
    }

    public function onChangeCuttingPIC() {
        $id = $this->request->getVar('id');
        $pic = $this->request->getVar('pic');

        $this->materialModel->changeCuttingPIC([
            'id' => $id,
            'pic' => $pic
        ]);
    }

    public function onChangeMaterialGelar2() {
        $id = $this->request->getVar('id');
        $gelar = $this->request->getVar('gelar');

        $this->materialModel->save([
            'id' => $id,
            'gelar2' => $gelar
        ]);
    }

    public function onChangeMaterialVendorPola() {
        $id = $this->request->getVar('id');
        $ven = $this->request->getVar('ven');

        $this->materialModel->save([
            'id' => $id,
            'vendor_pola' => $ven
        ]);
        
    }

    public function onChangeMaterialColor() {
        $id = $this->request->getVar('id');
        $color = $this->request->getVar('color');

        $this->materialModel->save([
            'id' => $id,
            'color_id' => $color
        ]);
    }

    public function onChangeMaterialTglCutting() {
        $id = $this->request->getVar('id');
        $tgl = $this->request->getVar('tgl');
        $tgl = date('Y-m-d', strtotime($tgl));
      

        $this->materialModel->save([
            'id' => $id,
            'tgl_cutting' => $tgl
        ]);
    }

    public function onChangeMaterialWeight() {
        $id = $this->request->getVar('id');
        $weight = $this->request->getVar('weight');

        $this->materialModel->save([
            'id' => $id,
            'weight' => $weight
        ]);
    }

    public function onChangeMaterialVendor() {
        $id = $this->request->getVar('id');
        $vendor = $this->request->getVar('vendor');

        $this->materialModel->save([
            'id' => $id,
            'vendor_id' => $vendor
        ]);
        $vendor = $this->materialModel->getVendor($vendor);
        echo json_encode($vendor->getResultArray());        
    }

    public function onChangeMaterialPrice() {
        $id = $this->request->getVar('id');
        $harga = $this->request->getVar('harga');

        $this->materialModel->save([
            'id' => $id,
            'price' => $harga
        ]);
    }


    public function onChangeMaterialGudang() {
        $id = $this->request->getVar('id');
        $gudang = $this->request->getVar('gudang');

        $this->materialModel->save([
            'id' => $id,
            'gudang_id' => $gudang
        ]);
    }
    
    public function onChangeCuttingProductType() {
        $id = $this->request->getVar('id');
        $prod = $this->request->getVar('type');
        
        $this->materialModel->updateCuttingProduct($id, $prod);        
    }
    
    public function onChangeCuttingProductTypePola() {
        $id = $this->request->getVar('id');
        $prod = $this->request->getVar('type');
        
        $res = $this->materialModel->updateCuttingProductPola($id, $prod);     
        echo json_encode($res);   
    }

    public function onChangeCuttingQty() {
        $id = $this->request->getVar('id');
        $qty = $this->request->getVar('qty');
        $gelar = $this->request->getVar('gelar');
        $cutting = $this->request->getVar('cutting');
        $res = $this->materialModel->updateCuttingQty($id, $qty, $gelar, $cutting);
        echo json_encode($res);
    }

    public function onChangeCuttingBerat() {
        $id = $this->request->getVar('id');
        $berat = $this->request->getVar('berat');
        $material = $this->request->getVar('material');
        $this->materialModel->updateBeratCutting($id, $berat, $material);
    }

    public function onChangeCuttingQtyPola() {
        $id = $this->request->getVar('id');
        $qty = $this->request->getVar('qty');
        $gelar = $this->request->getVar('gelar');
        $cutting = $this->request->getVar('cutting');
        $res = $this->materialModel->updateCuttingQtyPola($id, $qty, $gelar, $cutting);
        echo json_encode($res);
    }

    public function onChangeJumlahPola() {
        $id = $this->request->getVar('id');
        $jum = $this->request->getVar('jum');
        $this->materialModel->updateJumlahPolaOut($id, $jum);
    }

    public function onChangeVendorPola() {
        $id = $this->request->getVar('id');
        $vendor = $this->request->getVar('vendor');
        $data = $this->materialModel->updateVendorPolaOut($id, $vendor);
        echo json_encode($data);
    }

    public function onChangeJumlahSetor() {
        $id = $this->request->getVar('id');
        $jum = $this->request->getVar('jum');
        
        $data = $this->materialModel->updateJumlahSetorPolaIn($id, $jum);
        echo json_encode($data);
    }

    public function onChangeReject() {
        $id = $this->request->getVar('id');
        $reject = $this->request->getVar('reject');

        $data = $this->materialModel->updateReject($id, $reject);
        echo json_encode($data);
    }

    public function exportDataPolaIn($date1 = null, $date2 = null) {
        if (is_null($date1)) {
            $materials = $this->materialModel->getAllPolaIn();    
        } else {
            $materials = $this->materialModel->getAllPolaIn($date1, $date2);
        }
        
        $date = date('m-d-Y H.i.s'); 
        $fileName = "Data Pola In {$date}.xlsx";  
        $spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Tanggal Ambil');
		$sheet->setCellValue('C1', 'Produk');
		$sheet->setCellValue('D1', 'Warna');
		$sheet->setCellValue('E1', 'Jumlah Pola');
        $sheet->setCellValue('F1', 'Bahan');
        $sheet->setCellValue('G1', 'Vendor');
        $sheet->setCellValue('H1', 'Tgl Setor');
        $sheet->setCellValue('I1', 'Jumlah Setor');
        $sheet->setCellValue('J1', 'Reject');
        $sheet->setCellValue('K1', 'Sisa');
        $sheet->setCellValue('L1', 'Gelar 1');
        $sheet->setCellValue('M1', 'Gelar 2');
        $sheet->setCellValue('N1', 'PIC');
        $sheet->setCellValue('O1', 'Harga Jahit');
        $sheet->setCellValue('P1', 'Harga HPP');
        $sheet->setCellValue('Q1', 'Total');
        $i = 2;
        $no = 1;
        foreach($materials->getResultObject() as $row) {
            if ($row->status == '2') {
                $sheet->setCellValue('A' . $i, $no++);
                $sheet->setCellValue('B' . $i, $row->tgl_ambil);
                $sheet->setCellValue('C' . $i, $row->model_name);
                $sheet->setCellValue('D' . $i, $row->color);
                $sheet->setCellValue('E' . $i, $row->jumlah_pola);
                $sheet->setCellValue('F' . $i, $row->type);
                $sheet->setCellValue('G' . $i, $row->name);
                $sheet->setCellValue('H' . $i, $row->tgl_setor);
                $sheet->setCellValue('I' . $i, $row->jumlah_setor);
                $sheet->setCellValue('J' . $i, $row->reject);
                $sheet->setCellValue('K' . $i, $row->sisa);
                $sheet->setCellValue('L' . $i, $row->gelar1);
                $sheet->setCellValue('M' . $i, $row->gelar2);
                $sheet->setCellValue('N' . $i, $row->pic);
                $sheet->setCellValue('O' . $i, $row->harga_jahit);
                $sheet->setCellValue('P' . $i, $row->hpp);
                $sheet->setCellValue('Q' . $i, $row->hpp * $row->jumlah_setor);
                $i++;
            }
        }
        
        $writer = new Xlsx($spreadsheet);
       
        $writer->save('file/'. $fileName);
        header("Content-Type: application/vnd.ms-excel");

		header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length:' . filesize('file/'.$fileName));
		flush();
		readfile('file/'.$fileName);
		exit;
    }

    public function exportDataPolaOut($date1 = null, $date2 = null) {
        if (is_null($date1)) {
            $materials = $this->materialModel->getAllPolaOut();
        } else {
            $materials = $this->materialModel->getAllPolaOut($date1, $date2);
        }
        
        $date = date('m-d-Y H.i.s');
        $fileName = "Data Pola Out {$date}.xlsx";  
        
        $spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Tanggal Ambil');
		$sheet->setCellValue('C1', 'Produk');
		$sheet->setCellValue('D1', 'Warna');
		$sheet->setCellValue('E1', 'Jumlah Pola');
        $sheet->setCellValue('F1', 'Bahan');
        $sheet->setCellValue('G1', 'Vendor');
        $sheet->setCellValue('H1', 'Tgl Setor');
        $sheet->setCellValue('I1', 'Jumlah Setor');
        $sheet->setCellValue('J1', 'Reject');
        $sheet->setCellValue('K1', 'Sisa');
        $sheet->setCellValue('L1', 'Gelar 1');
        $sheet->setCellValue('M1', 'Gelar 2');
        $sheet->setCellValue('N1', 'PIC');
        $sheet->setCellValue('O1', 'Harga');
        $sheet->setCellValue('P1', 'Total');
        $i = 2;
        $no = 1;
        foreach($materials->getResultObject() as $row) {
            if ($row->status == '1') {
                $sheet->setCellValue('A' . $i, $no++);
                $sheet->setCellValue('B' . $i, $row->tgl_ambil);
                $sheet->setCellValue('C' . $i, $row->model_name);
                $sheet->setCellValue('D' . $i, $row->color);
                $sheet->setCellValue('E' . $i, $row->jumlah_pola);
                $sheet->setCellValue('F' . $i, $row->type);
                $sheet->setCellValue('G' . $i, $row->name);
                $sheet->setCellValue('H' . $i, $row->tgl_setor);
                $sheet->setCellValue('I' . $i, $row->jumlah_setor);
                $sheet->setCellValue('J' . $i, $row->reject);
                $sheet->setCellValue('K' . $i, $row->sisa);
                $sheet->setCellValue('L' . $i, $row->gelar1);
                $sheet->setCellValue('M' . $i, $row->gelar2);
                $sheet->setCellValue('N' . $i, $row->pic);
                $sheet->setCellValue('O' . $i, $row->harga);
                $sheet->setCellValue('P' . $i, $row->total_harga);
                $i++;
            }
        }
        
        $writer = new Xlsx($spreadsheet);
       
        $writer->save("file/". $fileName);
      
        header("Content-Type: application/vnd.ms-excel");

		header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length:' . filesize("file/". $fileName));
		flush();
		readfile("file/". $fileName);
		exit;
    }

    public function exportDataCutting($date1 = null, $date2 = null) {
        if (is_null($date1)) {
            $cutting = $this->materialModel->getAllCuttingData();
        } else {
            $cutting = $this->materialModel->getAllCuttingData($date1, $date2);
        }
        $date = date('m-d-Y H.i.s');
        $fileName = "Data Cutting {$date}.xlsx";  
        
        $spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
        
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Tanggal');
		$sheet->setCellValue('C1', 'Produk');
		$sheet->setCellValue('D1', 'Warna');
		$sheet->setCellValue('E1', 'Qty');
        $sheet->setCellValue('F1', 'Gelar 1');
        $sheet->setCellValue('G1', 'Gelar 2');
        $sheet->setCellValue('H1', 'PIC');
        $sheet->setCellValue('I1', 'Biaya Gelar 1');
        $sheet->setCellValue('J1', 'Biaya Gelar 2');
        $sheet->setCellValue('K1', 'Biaya Cutting');
        $sheet->setCellValue('L1', 'Total');
        $i = 2;
        $no = 1;
        foreach($cutting->getResultObject() as $row) {
            $sheet->setCellValue('A' . $i, $no++);
            $sheet->setCellValue('B' . $i, $row->tgl);
            $sheet->setCellValue('C' . $i, $row->model_name);
            $sheet->setCellValue('D' . $i, $row->color);
            $sheet->setCellValue('E' . $i, $row->qty);
            $sheet->setCellValue('F' . $i, $row->gelar1);
            $sheet->setCellValue('G' . $i, $row->gelar2);
            $sheet->setCellValue('H' . $i, $row->pic);
            $sheet->setCellValue('I' . $i, $row->biaya_gelar1);
            $sheet->setCellValue('J' . $i, $row->biaya_gelar2);
            $sheet->setCellValue('K' . $i, $row->biaya_cutting);
            $sheet->setCellValue('L' . $i, $row->total);
            $i++;
        }
        
        $writer = new Xlsx($spreadsheet);
       
        $writer->save("file/". $fileName);
      
        header("Content-Type: application/vnd.ms-excel");

		header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length:' . filesize("file/". $fileName));
		flush();
		readfile("file/". $fileName);
		exit;
    }

    public function getVendor() {
        $id = $this->request->getVar('id');
        $vendor = $this->materialModel->getVendor($id);
        echo json_encode($vendor->getResultArray());
    }

    public function getJenisKain() {
        $id = $this->request->getVar('id');
        $vendor = $this->materialModel->getJenisKain($id);
        echo json_encode($vendor->getResultArray());
    }

    public function datamaster() {
        $materials = $this->materialModel->getAllMaterialType();
        $products = $this->productModel->getAllProduct();
        $models = $this->designModel->getAllModel();
        $colors = $this->materialModel->getAllColors();
        $vendorPenjualan = $this->productModel->getAllVendorPenjualan();
        $vendorKain = $this->materialModel->getAllVendorKain();    
        $vendrPola = $this->materialModel->getAllVendorPola();
        $timGelar = $this->materialModel->getAllTimGelar();
        $timCutting = $this->materialModel->getAllTimCutting();
        $coa = $this->materialModel->getCOA();
        $data = array(
            'title' => 'Data Master',
            'materials' => $materials,
            'products' => $products,
            'models' => $models,
            'colors' => $colors,
            'vendorPenjualan' => $vendorPenjualan,
            'vendorKain' => $vendorKain,
            'vendorPola' => $vendrPola,
            'timGelar' => $timGelar,
            'timCutting' => $timCutting,
            'coa' => $coa
        );
        return view('admin/datamaster', $data);    
    }

    public function saveWarna() {
        $warna = $this->request->getVar('warna');
        $this->materialModel->saveWarna($warna);
        return redirect()->back()->with('create', 'Warna berhasil ditambahkan');
    }

    public function saveVendorSupplier() {
        $vendor = $this->request->getVar('vendor');
        $this->materialModel->saveVendorSupplier($vendor );
        return redirect()->back()->with('create', 'Vendor berhasil ditambahkan');
    }

    public function saveVendorPenjualan() {
        $vendor = $this->request->getVar('vendor');
        $this->materialModel->saveVendorPenjualan($vendor);
        return redirect()->back()->with('create', 'Vendor berhasil ditambahkan');
    }

    public function getColor() {
        $id = $this->request->getVar('color_id');
        $color = $this->materialModel->getColor($id);
        echo json_encode($color[0]);
    }

    public function updateWarna() {
        $post = $this->request->getVar();
        $this->materialModel->updateColor($post['id'], $post['warna']);
        return redirect()->back()->with('update', 'Warna berhasil diubah');
    }

    public function deleteColor() {
        $id = $this->request->getVar('color_id');
        $this->materialModel->deleteColor($id);
    }

    public function getVendorSupplier() {
        $id = $this->request->getVar('vendor_id');
        $vendor = $this->materialModel->getVendorSupplier($id);
        echo json_encode($vendor[0]);
    }

    public function updateVendorSupplier() {
        $post = $this->request->getVar();
        $this->materialModel->updateVendorSupplier($post['id'], $post['vendor']);
        return redirect()->back()->with('update', 'Vendor berhasil diubah');
    }

    public function deleteVendorSupplier() {
        $id = $this->request->getVar('vendor_id');
        $this->materialModel->deleteVendorSupplier($id);
    }

    public function getVendorSelling() {
        $id = $this->request->getVar('vendor_id');
        $vendor = $this->materialModel->getVendorSelling($id);
        echo json_encode($vendor[0]);
    }

    public function updateVendorSelling() {
        $post = $this->request->getVar();
        $this->materialModel->updateVendorSelling($post['id'], $post['vendor']);
        return redirect()->back()->with('update', 'Vendor berhasil diubah');
    }

    public function deleteVendorSelling() {
        $id = $this->request->getVar('vendor_id');
        $this->materialModel->deleteVendorSelling($id);
    }
    
    public function getCutting() {
        $id = $this->request->getVar('id');
        $cutting = $this->materialModel->getCutting($id);
        echo json_encode($cutting[0]);
    }

    public function savePolaKeluar() {
        $id = $this->request->getVar('id');
        $berat = $this->request->getVar('berat');
        $material = $this->request->getVar('material');
        $tgl = $this->request->getVar('tgl-pola');
        $jumlah = $this->request->getVar('jumlah-pola');
        $total = $this->request->getVar('total-pola');
        $remain = $total - $jumlah;
        $vendor = $this->request->getVar('vendor');        
        if ($jumlah < $total) {
            $status = 2;            
            $this->materialModel->updateStatusCutting($id, $remain, $status);
        } else if ($jumlah > $total) {
            $status = 3;
            $this->materialModel->updateStatusCutting($id, $remain, $status);
        }

        $tgl = date('Y-m-d H:i:s', strtotime($tgl));
        $this->materialModel->savePolaOut($id, $tgl, $jumlah, $vendor, $berat, $material);
        return redirect()->back()->with('input', 'Pola berhasil diinput');
    }

    public function savePolaMasuk() {
        $post = $this->request->getVar();
        $harga = ($post['hargajahit'] == NULL) ? 0 : $post['hargajahit']; 
        $pola = [
            'cuttingID' => $post['cutting-id'],
            'vendorID' => $post['vendor-id'],
            'vendorID' => $post['vendor-id'],
            'tglAmbil' => date('Y-m-d H:i:s', strtotime($post['tgl-ambil'])),
            'jumlahPola' => $post['jumlah'],
            'tglSetor'=> date('Y-m-d H:i:s', strtotime($post['tgl-setor'])),
            'jumlahSetor' => $post['jumlah-setor'],
            'reject' => $post['reject'],
            'sisa' => $post['jumlah'] - $post['jumlah-setor'] - $post['reject'],
            'harga' => $harga,
            'total' => $harga * $post['jumlah-setor']          
        ];

        $this->materialModel->savePolaIn($pola);
        return redirect()->back()->with('input', 'Pola berhasil diinput');
    }

    public function saveVendorPola() {
        $vendor = $this->request->getVar('vendor');
        $this->materialModel->saveVendorPola($vendor);
        return redirect()->back()->with('create', 'Pola berhasil diinput');
    }

    public function updateVendorPola() {
        $id = $this->request->getVar('id');
        $vendor = $this->request->getVar('vendor');
        $this->materialModel->updateVendorPola($id, $vendor);
        return redirect()->back()->with('create', 'Pola berhasil diinput');
    }

    public function deleteVendorPola() {
        $id = $this->request->getVar('vendor_id');
        $this->materialModel->deleteVendorPola($id);        
    }

    public function getPolaOut() {
        $id = $this->request->getVar('id');
        $pola = $this->materialModel->getPolaOut($id);
        echo json_encode($pola[0]);
    }

    public function getVendorPola() {
        $id = $this->request->getVar('vendor_id');
        $vendor = $this->materialModel->getVendorPola($id);
        echo json_encode($vendor);
    }

    public function saveGelar() {
        $name = $this->request->getVar('name');
        $this->materialModel->saveTimGelar($name);
        return redirect()->back()->with('create', 'Tim berhasil diinput');
    }

    public function saveCutting() {
        $name = $this->request->getVar('name');
        $this->materialModel->saveTimCutting($name);
        return redirect()->back()->with('create', 'Tim berhasil diinput');
    }

    public function deleteGelar() {
        $id = $this->request->getVar('id');
        $this->materialModel->deleteGelar($id);   
        echo $id;
        // return redirect()->back()->with('create', 'Tim berhasil diinput');
    }

    public function deleteCutting() {
        $id = $this->request->getVar('id');
        $this->materialModel->deleteCutting($id);   
        return redirect()->back()->with('create', 'Tim berhasil diinput');
    }

    public function getCOA() {
        $id = $this->request->getVar('id');
        $data = $this->materialModel->editCOA($id);
        echo json_encode($data);
    }

    public function getGelar() {
        $id = $this->request->getVar('id');
        $data = $this->materialModel->editGelar($id);
        echo json_encode($data);
    }

    public function updateGelar() {
        $id = $this->request->getVar('id');
        $name = $this->request->getVar('name');
        $this->materialModel->updateGelar($id, $name);   
        return redirect()->back()->with('create', 'Tim berhasil diinput');
    }

    public function getTimCutting() {
        $id = $this->request->getVar('id');        
        $data = $this->materialModel->editTimCutting($id);
        echo json_encode($data);
    }

    public function updateTimCutting() {
        $id = $this->request->getVar('id');
        $name = $this->request->getVar('name');
        $this->materialModel->updateTimCutting($id, $name);   
        return redirect()->back()->with('create', 'Tim berhasil diinput');
    }
    
    public function updateCOA() {
        $id = $this->request->getVar('id');
        $ket = $this->request->getVar('ket');
        $biaya = $this->request->getVar('biaya');

        $this->materialModel->updateCOA($id, $ket, $biaya);
        return redirect()->back()->with('create', 'Tim berhasil diinput');
    }

    public function deleteCuttingPola() {
        $cutting = $this->request->getVar('cutting');
        $this->materialModel->deleteCuttingPola($cutting);
    }

    public function getSizeCutting() {
        $id = $this->request->getVar('id');
        $data = $this->materialModel->getSizeCutting($id);
        echo json_encode($data);
    }

    public function simpanSize() {
        $post = $this->request->getVar();        
        $this->materialModel->simpanSize($post);
    }

    public function getSizePola() {
        $id = $this->request->getVar('id');
        $data = $this->materialModel->getSizePola($id);
        echo json_encode($data);
    }

    public function loadMaterial() {
        $params['draw'] = $_REQUEST['draw'];
        $start = $_REQUEST['start'];
        $length = $_REQUEST['length'];
        $search_value = $_REQUEST['search']['value'];
        ini_set('memory_limit', '-1');
        if(!empty($search_value)){
            $total_count = $this->materialModel->getAllMaterialDatatables($search_value);
            // $total_count = $this->db->query("SELECT upc, asin, item_description, CONCAT('$',retail_value) as retail_value, vendor_name from upc WHERE upc like '%".$search_value."%' OR item_description like '%".$search_value."%' OR vendor_name like '%".$search_value."%' ")->getResult(); 
            $data = $this->db->query("SELECT upc, asin, item_description, CONCAT('$',retail_value) as retail_value, vendor_name from upc WHERE upc like '%".$search_value."%' OR item_description like '%".$search_value."%' OR vendor_name like '%".$search_value."%'  limit $start, $length")->getResult();
        }else{
            $total_count = $this->db->query("SELECT upc, asin, item_description, CONCAT('$',retail_value) as retail_value, vendor_name from upc")->getResult();
            $data = $this->db->query("SELECT upc, asin, item_description, CONCAT('$',retail_value) as retail_value, vendor_name from upc limit $start, $length")->getResult();
        }
        $json_data = array(
            "draw" => intval($params['draw']),
            "recordsTotal" => count($total_count),
            "recordsFiltered" => count($total_count),
            "data" => $data   // total data array
        );

        echo json_encode($json_data);
    }

    public function importKainMasuk() {
        $file = $this->request->getFile('file');  
        if (!is_null($file)) {
            $ext = $file->getClientExtension();
            if ($ext == 'xls') {
                $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet = $render->load($file);
            $data = $spreadsheet->getActiveSheet()->toArray();   
            foreach ($data as $idx => $row) {
                if ($idx > 0) {
                    
                }
            }
        }
        
    }

}
