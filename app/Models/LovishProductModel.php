<?php

namespace App\Models;

use CodeIgniter\Model;

class LovishProductModel extends Model
{
    protected $table = 'lovish_products';
    protected $allowedFields = ['product_id', 'color_id', 'weight', 'price', 'model_id', 'status', 'qrcode', 'user_id', 'created_at', 'updated_at', 'qty', 'vendor_id'];

    public function getAllProductLovish() {
        $query = $this->db->table('lovish_products')
        ->select('lovish_products.*, model_name, product_name, color, name, price, qty')
        ->join('models', 'models.id = lovish_products.model_id')
        ->join('product_types', 'product_types.id = product_id')
        ->join('colors', 'colors.id = lovish_products.color_id')
        ->join('users', 'users.id = lovish_products.user_id')
        ->where('lovish_products.status', 2)
        ->orderBy('created_at', 'desc')
        ->get();
        return $query;
    }

    public function getAllProductOut() {
        $query = $this->db->table('products')
            ->select('product_logs.qty as qtyy, products.*, model_name, product_name, color, name, price')
            ->join('models', 'models.id = products.model_id')
            ->join('product_types', 'product_types.id = product_id')
            ->join('colors', 'colors.id = products.color_id')
            ->join('users', 'users.id = products.user_id')
            ->join('product_logs', 'product_logs.product_id = products.id')
            ->where('product_logs.status', 2)
            ->where('products.status', 1)
            ->orderBy('created_at', 'desc')
            ->get();
        return $query;
    }
    
    
}   