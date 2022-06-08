<?php

namespace App\Models;

use CodeIgniter\Model;

class DesignModel extends Model
{
    protected $table = 'models';
    protected $allowedFields = ['model_name', 'jahit_price', 'hpp_price', 'vendor'];

    public function getAllModel() {
        $query =  $this->db->table('models')->get();
        return $query;
    }
}