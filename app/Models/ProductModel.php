<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $allowedFields = ['product_id', 'product_name', 'color', 'weight', 'price', 'model_id', 'status'];

    public function getAllProductIn() {
        $query =  $this->db->table('models')
            ->select('products.id, product_name, model_name, color, weight, created_at')
            ->selectCount('products.id', 'stok')
            ->join('products', 'products.model_id = models.id')
            ->where('status', '1')
            ->groupBy('product_name')
            ->orderBy('created_at', 'desc')
            ->get();  
        return $query;
    }

    public function getAllProductOut() {
        $query =  $this->db->table('models')
            ->select('products.id, product_name, model_name, color, weight, created_at')
            ->selectCount('products.id', 'stok')
            ->join('products', 'products.model_id = models.id')
            ->where('status', '2')
            ->groupBy('product_name')
            ->orderBy('created_at', 'desc')
            ->get();  
        return $query;
    }
}