<?php

namespace App\Models;

use CodeIgniter\Model;

class LovishProductModel extends Model
{
    protected $table = 'lovish_products';
    protected $allowedFields = ['product_id', 'color_id', 'weight', 'price', 'model_id', 'status', 'qrcode', 'user_id', 'updated_at', 'qty', 'vendor_id'];


    
}   