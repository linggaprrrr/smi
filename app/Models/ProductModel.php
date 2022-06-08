<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $allowedFields = ['product_id', 'product_name', 'color', 'weight', 'price', 'model_id'];

    public function getAllProduct() {
        $query =  $this->db->table('models')
         ->join('products', 'products.model_id = models.id')
         ->orderBy('created_at', 'desc')
         ->get();  
        return $query;
    }
}