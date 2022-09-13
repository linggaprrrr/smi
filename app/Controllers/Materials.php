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
        $materialsPolaIn = $this->materialModel->getAllPolaIn();
        $gudangs = $this->materialModel->getAllGudang();
        $picCutting = $this->materialModel->getAllPICCutting();
        $getAllTimGelar = $this->materialModel->getAllTimGelar();
        $vendorPola = $this->materialModel->getAllVendorPola();
        $data = array(
            'title' => 'Kain',
            'materials' => $materials,
            'colors' => $colors,
            'materialsIn' => $materialsIn,
            'materialsOut' => $materialsOut,
            'materialsPolaIn' => $materialsPolaIn,
            'gudangs' => $gudangs,
            'materialVendors' => $materialVendors,
            'picCutting' => $picCutting,
            'timGelars' => $getAllTimGelar,
            'vendorPola' => $vendorPola
        );
        return view('admin/materials', $data);    
    }

    public function saveMaterial() {
        $post = $this->request->getVar();
        $type = strtoupper($post['jenis']);
        $this->materialModel->saveMaterialType($type);
    }

    public function addMaterial() {
        $post = $this->request->getVar();
        $material = [
            'material_id' => $post['jenis'],
            'vendor_id' => $post['vendor'],
            'color_id'  => $post['warna'],
            'weight'  => $post['berat'],
            'price' => $post['harga'],
            'user_id' => session()->get('user_id'),
            'gudang_id' => $post['gudang'],
            'tgl_cutting' => NULL,
            'gelar1' => $post['gelar1'],
            'gelar2' => $post['gelar2'],
            'pic_cutting' => $post['pic-cutting'],
        ];

        $this->materialModel->save($material);
        $this->logModel->save([
            'description' => 'Menambahkan data kain baru ('.$post['jenis'].' '.$post['warna'].')',
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
        $this->materialModel->updateMaterialType($post['id'], strtoupper($post['jenis']));
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
            ->join('material_types', 'material_types.id = materials.material_id')
            ->join('colors', 'colors.id = materials.color_id')
            ->where('materials.id', $id)
            ->first();
        $this->logModel->save([
            'description' => 'Menghapus data kain ('.$getMaterial['type'].' '.$getMaterial['color'].')',
            'user_id' =>  session()->get('user_id'),
        ]);
        $this->materialModel->where('id', $id)->delete();
    }

    public function exportData() {
        $materials = $this->materialModel->getAllMaterial();
        $date = time();
        $fileName = "Data Kain Masuk {$date}.xlsx";  
        $spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Jenis');
		$sheet->setCellValue('C1', 'Warna');
		$sheet->setCellValue('D1', 'Berat (Kg)');
		$sheet->setCellValue('E1', 'Tanggal Masuk');
        $i = 2;
        $no = 1;
        foreach($materials->getResultObject() as $row) {
            $sheet->setCellValue('A' . $i, $no++);
            $sheet->setCellValue('B' . $i, $row->type);
            $sheet->setCellValue('C' . $i, $row->color);
            $sheet->setCellValue('D' . $i, number_format($row->weight/1000, 2));
            $sheet->setCellValue('E' . $i, $row->created_at);
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

    // Gudang Gesit
    public function gudangGesitKain() {
        $materials = $this->materialModel->getAllMaterialType();
        $colors = $this->materialModel->getAllColors();
        $materialVendors = $this->materialModel->getMaterialVendors();
        $materialsIn = $this->materialModel->getAllMaterial();        
        $materialsOut = $this->materialModel->getAllMaterialOut();
        $materialsPolaIn = $this->materialModel->getAllPolaIn();
        $gudangs = $this->materialModel->getAllGudang();
        $picCutting = $this->materialModel->getAllPICCutting();
        $getAllTimGelar = $this->materialModel->getAllTimGelar();
        $vendorPola = $this->materialModel->getAllVendorPola();
        $cuttings = $this->materialModel->getAllCuttingData();        
        $data = array(
            'title' => 'Kain',
            'materials' => $materials,
            'colors' => $colors,
            'materialsIn' => $materialsIn,
            'materialsOut' => $materialsOut,
            'materialsPolaIn' => $materialsPolaIn,
            'gudangs' => $gudangs,
            'materialVendors' => $materialVendors,
            'picCutting' => $picCutting,
            'timGelars' => $getAllTimGelar,
            'vendorPola' => $vendorPola,
            'cuttings' => $cuttings
        );

        return view('gudang_gesit/materials', $data);    
    }
    
    public function onChangeMaterialType() {
        $id = $this->request->getVar('id');
        $type = $this->request->getVar('type');

        $this->materialModel->save([
            'id' => $id,
            'material_id' => $type
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
            'weight' => $weight * 1000
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
    
    public function exportDataPolaIn() {
        $materials = $this->materialModel->getAllPolaIn();
        $date = time(); 
        $fileName = "Data Pola In {$date}.xlsx";  
        $spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Jenis');
		$sheet->setCellValue('C1', 'Warna');
		$sheet->setCellValue('D1', 'Berat (Kg)');
		$sheet->setCellValue('E1', 'Tanggal Masuk');
        $i = 2;
        $no = 1;
        foreach($materials->getResultObject() as $row) {
            $sheet->setCellValue('A' . $i, $no++);
            $sheet->setCellValue('B' . $i, $row->type);
            $sheet->setCellValue('C' . $i, $row->color);
            $sheet->setCellValue('D' . $i, number_format($row->weight/1000, 2));
            $sheet->setCellValue('E' . $i, $row->created_at);
            $i++;
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

    public function exportDataPolaOut() {
        $materials = $this->materialModel->getAllMaterialOut();
        $date = time();
        $fileName = "Data Pola Out {$date}.xlsx";  
        
        $spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
        
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Jenis');
		$sheet->setCellValue('C1', 'Warna');
		$sheet->setCellValue('D1', 'Berat (Kg)');
		$sheet->setCellValue('E1', 'Tanggal Masuk');
        $i = 2;
        $no = 1;
        foreach($materials->getResultObject() as $row) {
            $sheet->setCellValue('A' . $i, $no++);
            $sheet->setCellValue('B' . $i, $row->type);
            $sheet->setCellValue('C' . $i, $row->color);
            $sheet->setCellValue('D' . $i, number_format($row->weight/1000, 2));
            $sheet->setCellValue('E' . $i, $row->created_at);
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

    public function datamaster() {
        $materials = $this->materialModel->getAllMaterialType();
        $products = $this->productModel->getAllProduct();
        $models = $this->designModel->getAllModel();
        $colors = $this->materialModel->getAllColors();
        $vendorPenjualan = $this->productModel->getAllVendorPenjualan();
        $vendorKain = $this->materialModel->getAllVendorKain();        
        $data = array(
            'title' => 'Data Master',
            'materials' => $materials,
            'products' => $products,
            'models' => $models,
            'colors' => $colors,
            'vendorPenjualan' => $vendorPenjualan,
            'vendorKain' => $vendorKain
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
        $harga = $this->request->getVar('harga');
        $this->materialModel->saveVendorSupplier($vendor, $harga );
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
        $this->materialModel->updateVendorSupplier($post['id'], $post['vendor'], $post['harga']);
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

    

    
}
