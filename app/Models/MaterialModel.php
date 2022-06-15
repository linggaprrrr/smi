<?php

namespace App\Models;

use CodeIgniter\Model;

class MaterialModel extends Model
{
    protected $table = 'materials';
    protected $allowedFields = ['type', 'color', 'weight', 'qrcode', 'status', 'updated_at'];

    public function getAllMaterial() {
        $query =  $this->db->table('materials')
        ->where('status', '1')
        ->orderBy('created_at', 'desc')->get();
        return $query;
    }

    public function getAllMaterialOut() {
        $query =  $this->db->table('materials')
        ->where('status', '2')
        ->orderBy('created_at', 'desc')->get();
        return $query;
    }
    
}