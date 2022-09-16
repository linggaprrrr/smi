<?php

namespace App\Models;

use CodeIgniter\Model;

class DesignModel extends Model
{
    protected $table = 'models';
    protected $allowedFields = ['model_name', 'harga_jahit', 'hpp'];

    public function getAllModel() {
        $query =  $this->db->table('models')
        ->orderBy('id', 'desc')
        ->get();
        return $query;
    }

   
}