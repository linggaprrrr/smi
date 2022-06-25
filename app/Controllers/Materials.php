<?php

namespace App\Controllers;

use App\Models\MaterialModel;
use App\Models\ProductModel;
use App\Models\DesignModel;
use App\Models\LogModel;

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
        $materialsIn = $this->materialModel->getAllMaterial();
        $materialsOut = $this->materialModel->getAllMaterialOut();
        $gudangs = $this->materialModel->getAllGudang();
        $data = array(
            'title' => 'Kain',
            'materials' => $materials,
            'colors' => $colors,
            'materialsIn' => $materialsIn,
            'materialsOut' => $materialsOut,
            'gudangs' => $gudangs
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
            'color_id'  => $post['warna'],
            'weight'  => $post['berat'],
            'user_id' => session()->get('user_id'),
            'gudang_id' => $post['gudang']
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
        $data = array(
            'title' => 'Kain',
            'materials' => $materials
        );
        return view('admin/export/kain', $data);   
    }

    // Gudang Gesit
    public function gudangGesitKain() {
        $materials = $this->materialModel->getAllMaterialType();
        $colors = $this->materialModel->getAllColors();
        $materialsIn = $this->materialModel->getAllMaterial();
        $materialsOut = $this->materialModel->getAllMaterialOut();
        $gudangs = $this->materialModel->getAllGudang();
        $data = array(
            'title' => 'Kain',
            'materials' => $materials,
            'colors' => $colors,
            'materialsIn' => $materialsIn,
            'materialsOut' => $materialsOut,
            'gudangs' => $gudangs
        );
        return view('gudang_gesit/materials', $data);    
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
        $this->materialModel->saveVendorSupplier($vendor);
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

    

    
}
