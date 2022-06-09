<?php

namespace App\Models;

use CodeIgniter\Model;

class MaterialModel extends Model
{
    protected $table = 'materials';
    protected $allowedFields = ['type', 'color', 'weight', 'qrcode'];

    public function getAllMaterial() {
        $query =  $this->db->table('materials')->orderBy('created_at', 'desc')->get();
        return $query;
    }
    
}