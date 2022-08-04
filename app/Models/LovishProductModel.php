<?php

namespace App\Models;

use CodeIgniter\Model;

class LovishProductModel extends Model
{
    protected $table = 'lovish_products';
    protected $allowedFields = ['product_id', 'color_id', 'weight', 'price', 'model_id', 'status', 'qrcode', 'user_id', 'created_at', 'updated_at', 'qty', 'vendor_id'];

    public function getAllProductLovish() {
        $query = $this->db->table('lovish_products')
        ->select('product_logs.qty as qtyy, lovish_products.*, model_name, product_name, color, name, price')
        ->join('models', 'models.id = lovish_products.model_id')
        ->join('product_types', 'product_types.id = product_id')
        ->join('colors', 'colors.id = lovish_products.color_id')
        ->join('users', 'users.id = lovish_products.user_id')
        ->where('lovish_products.status', 2)
        ->orderBy('created_at', 'desc')
        ->get();
        return $query;
    }
    
}   