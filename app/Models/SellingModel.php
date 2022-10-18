<?php

namespace App\Models;

use CodeIgniter\Model;

class SellingModel extends Model
{
    protected $table = 'sellings';
    protected $allowedFields = ['product_id', 'color_id', 'model_id', 'size', 'brand' ,'qty', 'created_at', 'hpp_jual', 'status'] ;
}

?>