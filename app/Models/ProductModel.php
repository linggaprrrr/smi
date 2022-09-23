<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $allowedFields = ['product_id', 'color_id', 'weight', 'price', 'model_id', 'size', 'status', 'qrcode', 'user_id', 'updated_at', 'qty', 'vendor_id'];


    public function getAllProduct() {
        $query = $this->db->table('product_types')
        ->orderBy('id', 'desc')
        ->get();

        return $query;
    }

    public function getProductType($type) {
        $query = $this->db->table('product_types')
            ->where('product_name', $type)
            ->get();
        return $query->getFirstRow();
    }

    public function getAllProductIn() {
        $query = $this->db->table('products')
            ->select('products.*, model_name, product_name, color, name, price, (products.qty - SUM(IFNULL(product_logs.qty,0))) as stok')
            ->join('models', 'models.id = products.model_id')
            ->join('product_types', 'product_types.id = product_id')
            ->join('colors', 'colors.id = products.color_id')
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')
            ->join('product_logs', 'product_logs.product_id = product_barcodes.id', 'left')
            ->join('users', 'users.id = products.user_id')
            ->where('product_logs.status', '2')
            ->where('products.status', '1')             
            ->groupBy('products.id')
            ->orderBy('created_at', 'desc')
            ->get();
        return $query;
    }

    public function getAllProductInLovish() {
        $query = $this->db->table('products')
            ->select('products.*, model_name, product_name, color, name, price')
            ->join('models', 'models.id = products.model_id')
            ->join('product_types', 'product_types.id = products.product_id')            
            ->join('colors', 'colors.id = products.color_id')
            ->join('users', 'users.id = products.user_id')
            ->join('product_logs', 'product_logs.product_id = products.id')
            ->where('product_logs.status', 2)
            ->orderBy('product_logs.created_at', 'desc')
            ->get();
        return $query;
    }

    public function getAllProductLovish() {
        $query = $this->db->table('products')
            ->select('products.*, model_name, product_name, color, name, price')
            ->join('models', 'models.id = products.model_id')
            ->join('product_types', 'product_types.id = products.product_id')            
            ->join('colors', 'colors.id = products.color_id')
            ->join('users', 'users.id = products.user_id')
            ->join('product_logs', 'product_logs.product_id = products.id')
            ->where('products.status', 2)
            // ->orderBy('product_logs.created_at', 'desc')
            ->get();
        return $query;
    }

    public function getAllStockProductLovish() {
        $query = $this->db->table('products')
            ->select('products.*, model_name, product_name, color, hpp, name, price, stok, stok_retur, stok_masuk, penjualan')
            ->join('models', 'models.id = products.model_id')
            ->join('product_types', 'product_types.id = product_id')
            ->join('colors', 'colors.id = products.color_id')
            ->join('users', 'users.id = products.user_id')
            ->join('(SELECT id, SUM(qty) as stok FROM products WHERE status= 2 GROUP BY model_id, product_id, color_id, size) as a','products.id = a.id', 'left')
            ->join('(SELECT product_id, SUM(qty) as stok_masuk FROM product_logs m  WHERE status=2 AND (MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE()) ) GROUP BY product_id) as m','products.id = m.product_id', 'left')
            ->join('(SELECT product_id, SUM(qty) as stok_retur FROM product_logs WHERE status = 4 AND (MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE()) ) GROUP BY product_id) as r','products.id = r.product_id', 'left')            
            ->join('(SELECT product_id, SUM(qty) as penjualan FROM product_logs WHERE status = 3 AND (MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE()) ) GROUP BY product_id) as p','products.id = p.product_id', 'left')            
            ->groupBy('model_id, product_id, color_id, size')            
            ->get();
        return $query;
    }

    public function getAllProductOut() {
        $query = $this->db->table('products')
            ->select('product_logs.qty as qtyy, product_logs.created_at, model_name, product_name, color, name, price, weight')
            ->join('models', 'models.id = products.model_id')
            ->join('product_types', 'product_types.id = product_id')
            ->join('colors', 'colors.id = products.color_id')
            ->join('users', 'users.id = products.user_id')
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')
            ->join('product_logs', 'product_logs.product_id = product_barcodes.id')
            ->where('product_logs.status','2')
            ->where('product_logs.qty !=','0')
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
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')
            ->join('product_logs', 'product_logs.product_id = product_barcodes.id') 
            ->join('users', 'users.id = product_logs.user_id')
            ->where('product_logs.status', 2)
            ->groupBy('product_name')
            ->groupBy('color')
            ->groupBy('DATE(FROM_UNIXTIME(product_logs.created_at))')
            ->orderBy('product_logs.created_at', 'desc')
            ->get();
        return $query;
    }

    public function getStokProductIn() {
        $query =  $this->db->table('models')
            ->select('products.id, product_name, model_name, color, weight, product_logs.status, products.created_at, products.qty, products.qty - SUM(IFNULL(product_logs.qty, 0)) as stok')            
            ->join('products', 'products.model_id = models.id')
            ->join('product_types', 'product_types.id = product_id')
            ->join('colors', 'colors.id = products.color_id')
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')
            ->join('product_logs', 'product_logs.product_id = product_barcodes.id', 'left')            
            ->where('product_logs.status', '2')
            ->groupBy('product_name')
            ->groupBy('color')
            ->groupBy('model_name')
            ->groupBy('products.id')
            ->orderBy('products.created_at', 'desc')
            ->get();  
        return $query;
    }

    public function getStokProductOut() {
        $query =  $this->db->table('models')
            ->select('products.id, product_name, model_name, color, weight, product_logs.status, products.created_at, products.qty, products.qty - SUM(IFNULL(product_logs.qty, 0)) as stok')            
            ->join('products', 'products.model_id = models.id')
            ->join('product_types', 'product_types.id = product_id')
            ->join('colors', 'colors.id = products.color_id')
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')
            ->join('product_logs', 'product_logs.product_id = product_barcodes.id',)            
            ->where('product_barcodes.status', '2')
            ->groupBy('product_name')
            ->groupBy('color')
            ->groupBy('model_name')
            ->groupBy('products.id')
            ->orderBy('products.created_at', 'desc')
            ->get();  
        return $query;
    }

    public function getStokProductAlmostOut() {
        $query =  $this->db->table('models')
            ->select('products.id, product_name, model_name, color, weight, product_logs.status, products.created_at')
            ->selectCount('products.id', 'stok')
            ->join('products', 'products.model_id = models.id')
            ->join('product_types', 'product_types.id = product_id')
            ->join('colors', 'colors.id = products.color_id')
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')
            ->join('product_logs', 'product_logs.product_id = product_barcodes.id')
            ->where('product_logs.status', '2')
            ->groupBy('product_name')
            ->orderBy('product_logs.created_at', 'desc')
            ->having("SUM('product_logs.qty') <= ", '20')
            ->get();  
        return $query;
    }

    public function getStokProductExp() {
        $query =  $this->db->table('models')
            ->select('products.id, product_name, model_name, color, weight, size, product_logs.status, products.created_at, product_logs.qty')            
            ->join('products', 'products.model_id = models.id')
            ->join('product_types', 'product_types.id = product_id')
            ->join('colors', 'colors.id = products.color_id')
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')
            ->join('product_logs', 'product_logs.product_id = product_barcodes.id')
            ->where('product_logs.status', '3')    
            ->orWhere('product_logs.status', '4')    
            ->orderBy('created_at', 'desc')
            ->get();  
        return $query;
    }

    public function findProductOut($id) {
        $query = $this->db->table('products')
            ->select('product_logs.product_id')
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')
            ->join('product_logs', 'product_logs.product_id = product_barcodes.id')
            ->where('product_logs.product_id', $id)
            ->where('product_barcodes.status', '2')
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
        $this->db->table('product_types')->insert([
            'product_name' => $product_name
        ]);

        return $this->db->insertID();
        // $this->db->query("INSERT INTO product_types(product_name) VALUES('$product_name') ");
    }

    public function deleteProduct($id) {
        $this->db->query("DELETE FROM product_types WHERE id='$id' ");
    }

    public function updateProductType($id, $product) {
        $this->db->query("UPDATE product_types SET product_name='$product' WHERE id='$id' ");
    }

    public function setProductIn($id, $user) {
        $getProduct = $this->db->query("SELECT * FROM product_barcodes WHERE id = '$id' ");
        $productId = "";
        if ($getProduct->getNumRows() > 0) {
            $productId = $getProduct->getResultArray();
            
        }
        $this->db->query("INSERT INTO product_logs(product_id, user_id, status) VALUES('$id', '$user', 2) ");
    }

    public function updateQRStatus($id) {
        $this->db->query("UPDATE product_barcodes SET status = 2 WHERE id = '$id'");
    }

    public function setProductOut($id, $user) {
        $this->db->query("UPDATE product_barcodes SET status = '3' WHERE id = '$id' ");
        $this->db->query("INSERT product_logs(product_id, qty, status, user_id) VALUES('$id', '1', '3', '$user') ");
    }

    public function updateStokOut($id, $user) {

        $this->db->query("INSERT product_logs(product_id, qty, status, user_id) VALUES('$id', '1', '3', '$user') ");
    }

    public function createBarcode($productId) {
        $this->db->query("INSERT INTO product_barcodes(product_id) VALUES('$productId') ");
        $insert_id = $this->db->insertID();
        return $insert_id;
    }

    public function setBarocde($id, $qrcode) {
        $this->db->query("UPDATE product_barcodes SET qrcode = '$qrcode' WHERE id='$id' ");
    }

    public function createLog($id, $qty, $status = null) {
        $user = session()->get('user_id');
        $this->db->query("INSERT product_logs(product_id, qty, user_id, status) VALUES('$id', '$qty', '$user', '$status')");
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
    
    public function returProduct($id) {
        $this->db->query("INSERT product_logs(product_id, status, user_id) VALUES('$id', 4, ".session()->get('user_id').") ");
    }
    
    public function deleteProductBarcode($productId) {
        $this->db->query("DELETE FROM product_barcodes WHERE product_id='$productId' ");
    }

    public function productsRetur() {
        $query = $this->db->table('products')
            ->select('product_logs.qty as qty, size, product_logs.created_at, model_name, product_name, color, name, price, weight')
            ->join('models', 'models.id = products.model_id')
            ->join('product_types', 'product_types.id = product_id')
            ->join('colors', 'colors.id = products.color_id')
            ->join('users', 'users.id = products.user_id')
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')
            ->join('product_logs', 'product_logs.product_id = product_barcodes.id')
            ->where('product_logs.status','4')
            ->where('MONTH(product_logs.created_at) = MONTH(CURRENT_DATE())')
            ->where('YEAR(product_logs.created_at) = YEAR(CURRENT_DATE())')
            ->orderBy('created_at', 'desc')
            ->get();
        return $query;
    }

}   