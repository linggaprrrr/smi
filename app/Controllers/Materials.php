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
        $data = array(
            'title' => 'Kain',
            'materials' => $materials
        );
        return view('admin/materials', $data);    
    }
}
