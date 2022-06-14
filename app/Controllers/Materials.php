<?php

namespace App\Controllers;

use App\Models\MaterialModel;

class Materials extends BaseController
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

    public function index() {
        $materials = $this->materialModel->getAllMaterial();
        $materialsOut = $this->materialModel->getAllMaterialOut();
        $data = array(
            'title' => 'Kain',
            'materials' => $materials,
            'materialsOut' => $materialsOut
        );
        return view('admin/materials', $data);    
    }

    public function saveMaterial() {
        $post = $this->request->getVar();
        $material = [
            'type' => strtoupper($post['jenis']),
            'color' => strtoupper($post['warna']),
            'weight' => $post['berat'],
        ];
        $this->materialModel->save($material);
        // return redirect()->back()->with('create', 'Kain berhasil ditambahkan');
    }

    public function getMaterial() {
        $id = $this->request->getVar('material_id');
        $material = $this->materialModel->find($id);
        echo json_encode($material);
    }

    public function updateMaterial() {
        $post = $this->request->getVar();
        $material = [
            'id' => $post['id'],
            'type' => strtoupper($post['jenis']),
            'color' => strtoupper($post['warna']),
            'weight' => $post['berat'],
        ];
        $this->materialModel->save($material);
        return redirect()->back()->with('create', 'Kain berhasil ditambahkan');
    }

    public function deleteMaterial() {
        $id = $this->request->getVar('material_id');
        $this->materialModel->where('id', $id)->delete();
        return redirect()->back()->with('delete', 'Kain berhasil dihapus');
    }

    public function exportData() {
        $materials = $this->materialModel->getAllMaterial();
        $data = array(
            'title' => 'Kain',
            'materials' => $materials
        );
        return view('admin/export/kain', $data);   
    }
 
}
