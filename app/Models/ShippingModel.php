<?php

namespace App\Models;

use CodeIgniter\Model;

class ShippingModel extends Model
{
    protected $table = 'shippings';
    protected $allowedFields = ['box_name', 'created_at', 'resi', 'qrcode', 'status', 'user_id', 'updated_at'];

    public function getAllShipping() {
        $query = $this->db->table('shippings')
            ->select('shippings.*, product_name, model_name, color, name')
            ->join('shipping_details', 'shipping_details.shipping_id = shippings.id')
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
            ->select('shipping_details.*, models.jenis as product_name, model_name, color, COUNT(product_barcodes.id) as qty')
            ->join('product_barcodes', 'product_barcodes.id = shipping_details.product_id')                        
            ->join('products', 'products.id = product_barcodes.product_id')
            ->join('models', 'models.id = products.model_id')            
            ->join('colors', 'colors.id = products.color_id')
            ->where('shipping_id', $id)
               
            ->groupBy('models.id, colors.id, size')
            ->get();
        return $query;
    }

    public function getAllShippingDetail($date1 = null, $date2 = null) {
        if (is_null($date1)) {
            $query = $this->db->table('shipping_details')
            ->select('shipping_details.*, models.jenis as product_name, model_name, color, COUNT(product_barcodes.id) as qty, size, resi, box_name, shippings.created_at')
            ->join('shippings', 'shippings.id = shipping_details.shipping_id')
            ->join('product_barcodes', 'product_barcodes.id = shipping_details.product_id')
            ->join('products', 'products.id = product_barcodes.product_id')
            ->join('models', 'models.id = products.model_id')
            ->join('colors', 'colors.id = products.color_id')
            ->groupBy('shipping_details.shipping_id')
            ->where('product_barcodes.status', '5')
            ->groupBy('models.id')
            ->groupBy('colors.id')
            ->groupBy('size')
            
            ->get();
        } else {
            $query = $this->db->table('shipping_details')
            ->select('shipping_details.*, models.jenis as product_name, model_name, color, COUNT(product_barcodes.id) as qty, size, resi, box_name, shippings.created_at')
            ->join('shippings', 'shippings.id = shipping_details.shipping_id')
            ->join('product_barcodes', 'product_barcodes.id = shipping_details.product_id')
            ->join('products', 'products.id = product_barcodes.product_id')
            ->join('models', 'models.id = products.model_id')
            ->join('colors', 'colors.id = products.color_id')
            ->where('shippings.created_at BETWEEN "'.$date1.'" AND "'.$date2.'"  ')
            ->where('product_barcodes.status', '5')
            
            ->groupBy('shipping_details.shipping_id')
            ->groupBy('models.id')
            ->groupBy('colors.id')
            ->groupBy('size')
            ->get();
        }
        return $query;
    }


    public function insertShippingDetail($info, $resi) {
        $data = [
            'box_name' => $info,
            'user_id'  => session()->get('user_id'),
            'resi' => $resi
        ];
        $builder = $this->db->table('shippings');
        $builder->ignore(true)->insert($data);
        $last = $this->db->insertID();
        
    }

    public function insertProductShipment($product_id, $shipping_id) {
        $this->db->query("INSERT INTO shipping_details(product_id, shipping_id) VALUES('$product_id', '$shipping_id')") ;
    }

}