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
            ->select('product_logs.qty as qtyy, products.*, model_name, product_name, color, name, price')
            ->join('models', 'models.id = products.model_id')
            ->join('product_types', 'product_types.id = product_id')
            ->join('colors', 'colors.id = products.color_id')
            ->join('users', 'users.id = products.user_id')
            ->join('product_logs', 'product_logs.product_id = products.id')
            ->where('product_logs.status', 1)
            ->orderBy('created_at', 'desc')
            ->get();
        return $query;
    }

    public function getAllProductInLovish() {
        $query = $this->db->table('products')
            ->select('SUM(product_logs.qty) as qtyy, products.*, model_name, product_name, color, name, price')
            ->join('models', 'models.id = products.model_id')
            ->join('product_types', 'product_types.id = products.product_id')            
            ->join('colors', 'colors.id = products.color_id')
            ->join('users', 'users.id = products.user_id')
            ->join('product_logs', 'product_logs.product_id = products.id')
            ->where('product_logs.status', 2)
            ->groupBy('product_logs.product_id')
            ->orderBy('product_logs.created_at', 'desc')
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

    public function getAllProductExp() {
        $query = $this->db->table('products')
        ->select('product_logs.qty as qtyy, products.*, model_name, product_name, color, name, price')
            ->join('models', 'models.id = products.model_id')
            ->join('product_types', 'product_types.id = product_id')
            ->join('colors', 'colors.id = products.color_id')
            ->join('users', 'users.id = products.user_id')
            ->join('product_logs', 'product_logs.product_id = products.id')
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
            ->where('product_logs.status', 1)
            ->groupBy('product_name')
            ->groupBy('color')
            ->orderBy('product_logs.updated_at', 'desc')
            ->get();
        return $query;
    }

    public function getStokProductIn() {
        $query =  $this->db->table('models')
            ->select('products.id, product_name, model_name, color, weight, status, qrcode, created_at, SUM(products.qty) as stok')            
            ->join('products', 'products.model_id = models.id')
            ->join('product_types', 'product_types.id = product_id')
            ->join('colors', 'colors.id = products.color_id')
            ->where('status', '1')
            ->groupBy('product_name')
            ->groupBy('color')
            ->groupBy('model_name')
            ->orderBy('products.created_at', 'desc')
            ->get();  
        return $query;
    }

    public function getStokProductOut() {
        $query =  $this->db->table('models')
            ->select('products.id, product_name, model_name, color, weight, qrcode, product_logs.created_at, SUM(product_logs.qty) as stok')            
            ->join('products', 'products.model_id = models.id')
            ->join('product_logs', 'product_logs.product_id = products.id')
            ->join('product_types', 'product_types.id = products.product_id')
            ->join('colors', 'colors.id = products.color_id')
            ->where('product_logs.status', '1')
            ->groupBy('product_name')
            ->groupBy('color')
            ->groupBy('model_name')
            ->orderBy('product_logs.created_at', 'desc')
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
        $getProduct = $this->db->query("SELECT product_barcode WHERE id = '$id' ");
        $productId = "";
        if ($getProduct->getNumRows() > 0) {
            $productId = $getProduct->getResultArray();
            
        }
        $this->db->query("INSERT INTO product_logs(product_id, user_id, status) VALUES('$id', '$user', 2) ");
        $this->db->query("UPDATE product_logs SET qty = qty - 1 WHERE product_id='$id' AND status = 1 AND qty != 0 LIMIT 1");

    }

    public function updateQRStatus($id) {
        $this->db->query("UPDATE product_barcodes SET status = 2 WHERE id = '$id'");
    }

    public function setProductOut($id, $user) {
        $this->db->query("UPDATE product_logs SET user_id_out='$user', status='2', updated_at = date('Y-m-d H:i:s') WHERE id='$id' ");
    }

    public function updateStokOut($id) {

        $this->db->query("UPDATE product_logs SET qty = qty - 1 WHERE product_id='$id' AND status = 2 AND qty != 0 LIMIT 1");
    }

    public function createBarcode($productId) {
        $this->db->query("INSERT INTO product_barcodes(product_id) VALUES('$productId') ");
    }

    public function setBarocde($id, $qrcode) {
        $this->db->query("UPDATE product_barcodes SET qrcode = '$qrcode' WHERE id='$id' ");
    }

    public function createLog($id, $qty, $status = null) {
        $user = session()->get('user_id');
        if (!is_null($status)) {
            $this->db->query("INSERT product_logs(product_id, qty, status, user_id) VALUES('$id', '$qty', '$status', '$user')");
        } else {
            $this->db->query("INSERT product_logs(product_id, qty, user_id) VALUES('$id', '$qty', '$user')");
        }
    }

    public function productStatus($id) {
        $query = $this->db->table('product_barcodes')
        ->where('product_barcodes.id', $id)
        ->get();
        return $query->getResultObject();
    }

    public function findQR($id) {
        $query = $this->db->query("SELECT * FROM product_barcodes WHERE id = '$id' AND status='1' LIMIT 1");
        if (!empty($query->getResultArray())) {
            return $query;
        } else {
            return false;
        }
    }
}   