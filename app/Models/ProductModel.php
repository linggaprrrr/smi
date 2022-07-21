<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $allowedFields = ['product_id', 'color_id', 'weight', 'price', 'model_id', 'status', 'qrcode', 'user_id', 'updated_at', 'qty', 'vendor_id'];


    public function getAllProduct() {
        $query = $this->db->table('product_types')
        ->orderBy('id', 'desc')
        ->get();

        return $query;
    }

    public function getAllProductIn() {
        $query = $this->db->table('products')
            ->select('products.*, model_name, product_name, color, name, price')
            ->join('models', 'models.id = products.model_id')
            ->join('product_types', 'product_types.id = product_id')
            ->join('colors', 'colors.id = products.color_id')
            ->join('users', 'users.id = products.user_id')
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->get();
        return $query;
    }

    public function getAllProductOut() {
        $query = $this->db->table('products')
            ->select('products.*, model_name, product_name, color, name')
            ->join('models', 'models.id = products.model_id')
            ->join('product_types', 'product_types.id = product_id')
            ->join('colors', 'colors.id = products.color_id')
            ->join('product_logs', 'product_logs.product_id = products.id')
            ->join('users', 'users.id = product_logs.user_id_in')
            ->where('product_logs.status', 2)
            ->orderBy('created_at', 'desc')
            ->get();
        return $query;
    }

    public function getAllProductExp() {
        $query = $this->db->table('products')
            ->select('products.*, model_name, product_name, color, name')
            ->join('models', 'models.id = products.model_id')
            ->join('product_types', 'product_types.id = product_id')
            ->join('colors', 'colors.id = products.color_id')
            ->join('product_logs', 'product_logs.product_id = products.id')
            ->join('users', 'users.id = product_logs.user_id_in')
            ->where('product_logs.status', 3)
            ->orderBy('created_at', 'desc')
            ->get();
        return $query;
    }

    public function getAllShipmentToLovish() {
        $query = $this->db->table('products')
            ->select('model_name, product_name, color, SUM(product_logs.qty) as qty, product_logs.updated_at')
            ->join('models', 'models.id = products.model_id')
            ->join('product_types', 'product_types.id = product_id')
            ->join('colors', 'colors.id = products.color_id')
            ->join('product_logs', 'product_logs.product_id = products.id')
            ->join('users', 'users.id = product_logs.user_id_in')
            ->where('product_logs.status', 2)
            ->groupBy('product_name')
            ->groupBy('color')
            ->orderBy('product_logs.updated_at', 'desc')
            ->get();
        return $query;
    }

    public function getStokProductIn() {
        $query =  $this->db->table('models')
            ->select('products.id, product_name, model_name, color, weight, status, qrcode, created_at')
            ->selectCount('products.id', 'stok')
            ->join('products', 'products.model_id = models.id')
            ->join('product_types', 'product_types.id = product_id')
            ->join('colors', 'colors.id = products.color_id')
            ->where('status', '1')
            ->groupBy('product_name')
            ->orderBy('created_at', 'desc')
            ->get();  
        return $query;
    }

    public function getStokProductOut() {
        $query =  $this->db->table('models')
            ->select('products.id, product_name, model_name, color, weight, status, qrcode, created_at')
            ->selectCount('products.id', 'stok')
            ->join('products', 'products.model_id = models.id')
            ->join('product_types', 'product_types.id = product_id')
            ->join('colors', 'colors.id = products.color_id')
            ->where('status', '2')
            ->groupBy('product_name')
            ->orderBy('created_at', 'desc')
            ->get();  
        return $query;
    }

    public function getStokProductAlmostOut() {
        $query =  $this->db->table('models')
            ->select('products.id, product_name, model_name, color, weight, status, qrcode, created_at')
            ->selectCount('products.id', 'stok')
            ->join('products', 'products.model_id = models.id')
            ->join('product_types', 'product_types.id = product_id')
            ->join('colors', 'colors.id = products.color_id')
            ->where('status', '2')
            ->groupBy('product_name')
            ->orderBy('created_at', 'desc')
            ->having("count('products.id') <= ", '20')
            ->get();  
        return $query;
    }

    public function getStokProductExp() {
        $query =  $this->db->table('models')
            ->select('products.id, product_name, model_name, color, weight, status, qrcode, created_at')
            ->selectCount('products.id', 'stok')
            ->join('products', 'products.model_id = models.id')
            ->join('product_types', 'product_types.id = product_id')
            ->join('colors', 'colors.id = products.color_id')
            ->where('status', '3')
            ->groupBy('product_name')
            ->orderBy('created_at', 'desc')
            ->get();  
        return $query;
    }

    public function getAllVendorPenjualan() {
        $query = $this->db->table('selling_vendors')
        ->orderBy('id', 'desc')
        ->get();

        return $query;
    }

    public function getProduct($id) {
        $query = $this->db->table('product_types')
        ->where('id', $id)
        ->get();

        return $query->getResult();
    }
    
    public function saveProductType($product_name) {
        $this->db->query("INSERT INTO product_types(product_name) VALUES('$product_name') ");
    }

    public function deleteProduct($id) {
        $this->db->query("DELETE FROM product_types WHERE id='$id' ");
    }

    public function updateProductType($id, $product) {
        $this->db->query("UPDATE product_types SET product_name='$product' WHERE id='$id' ");
    }

    public function setProductIn($id, $user) {
        $this->db->query("INSERT INTO product_logs(product_id, user_id_in) VALUES('$id', '$user') ");

    }

    public function setProductOut($id, $user) {
        $this->db->query("UPDATE product_logs SET user_id_out='$user', status='2', updated_at = date('Y-m-d H:i:s') WHERE id='$id' ");
    }

    public function updateStokOut($id) {
        $this->db->query("UPDATE products SET qty = qty - 1 WHERE id='$id' ");
    }

    public function productStatus($id) {
        $query = $this->db->table('product_logs')
        ->where('product_id', $id)
        ->get();
        return $query->getResultObject();
    }
}   