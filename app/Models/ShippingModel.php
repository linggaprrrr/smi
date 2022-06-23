<?php

namespace App\Models;

use CodeIgniter\Model;

class ShippingModel extends Model
{
    protected $table = 'shippings';
    protected $allowedFields = ['shipping_det', 'box_name', 'created_at', 'resi', 'user_id'];

    public function getAllShipping() {
        $query = $this->db->table('shippings')
            ->select('shippings.*, product_name, model_name, color, name')
            ->join('shipping_details', 'shipping_details.id = shippings.shipping_det')
            ->join('products', 'products.id = shipping_details.product_id')
            ->join('models', 'models.id = products.model_id')
            ->join('product_types', 'product_types.id = products.product_id')
            ->join('colors', 'colors.id = products.color_id')
            ->join('users', 'users.id = shippings.user_id')
            ->groupBy('shippings.id')
            ->get();
        return $query;
    }

    public function getShippingDetail($id) {
        $query = $this->db->table('shipping_details')
            ->select('shipping_details.*, product_name, model_name, color')
            ->join('products', 'products.id = shipping_details.product_id')
            ->join('models', 'models.id = products.model_id')
            ->join('product_types', 'product_types.id = products.product_id')
            ->join('colors', 'colors.id = products.color_id')
            ->where('shipping_id', $id)
            ->get();
        return $query;
    }
}