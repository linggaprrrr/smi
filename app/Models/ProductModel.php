<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $allowedFields = ['product_id', 'color_id', 'weight', 'price', 'model_id', 'size', 'status', 'qrcode', 'user_id', 'updated_at', 'qty', 'vendor_id', 'hpp_jual'];


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

    public function getAllProductIn($date1 = null, $date2=null) {
        if (is_null($date1)) {
            $query = $this->db->table('products')
            ->select('products.*, model_name, jenis as product_name, color, name, price, (products.qty - IFNULL(k.stok_keluar,0) - IFNULL(r.stok_reject,0)) as stok')
            ->join('models', 'models.id = products.model_id')
            ->join('colors', 'colors.id = products.color_id')
            ->join('users', 'users.id = products.user_id')
            ->join('(SELECT b.product_id, COUNT(b.id) as stok_keluar FROM product_barcodes b WHERE b.status = "2") as k','products.id = k.product_id', 'left')
            ->join('(SELECT b.product_id, COUNT(b.id) as stok_reject FROM product_barcodes b WHERE b.status = "0") as r','products.id = r.product_id', 'left')
            ->groupBy('products.id')
            ->orderBy('created_at', 'desc')
            ->get();
        } else {
            $query = $this->db->table('products')
            ->select('products.*, model_name, jenis as product_name, color, name, price, (products.qty - SUM(IFNULL(product_logs.qty,0))) as stok')
            ->join('models', 'models.id = products.model_id')
    
            ->join('colors', 'colors.id = products.color_id')
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')
            ->join('product_logs', 'product_logs.product_id = product_barcodes.id', 'left')
            ->join('users', 'users.id = products.user_id')
            ->where('product_logs.status', '2')
            ->where('products.status', '1')     
            ->where('products.created_at BETWEEN "'.$date1.'" AND "'.$date2.'" ')        
            ->groupBy('products.id')
            ->orderBy('created_at', 'desc')
            ->get();
        }
        
        return $query;
    }

    public function getAllProductInLovish() {
        $query = $this->db->table('products')
            ->select('products.*, model_name, jenis as product_name, color, name, price')
            ->join('models', 'models.id = products.model_id')            
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
            ->select('products.*, model_name, jenis as product_name, color, name, price')
            ->join('models', 'models.id = products.model_id')            
            ->join('colors', 'colors.id = products.color_id')
            ->join('users', 'users.id = products.user_id')
            ->join('product_logs', 'product_logs.product_id = products.id')
            ->where('products.status', 2)
            // ->orderBy('product_logs.created_at', 'desc')
            ->get();
        return $query;
    }

    public function getAllStockProductLovish($date1 = null, $date2 = null) {
        if (is_null($date1)) {
            $query = $this->db->table('products')
            ->select('products.*, model_name, jenis as product_name, color, hpp, name, price, stok, stok_masuk, stok_retur, scan_in')            
            ->join('models', 'models.id = products.model_id')            
            ->join('colors', 'colors.id = products.color_id')
            ->join('users', 'users.id = products.user_id')
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')                   
            ->join('(SELECT m.product_id, SUM(m.qty) as stok_masuk FROM product_logs m JOIN product_barcodes b ON b.id = m.product_id JOIN products as p ON p.id = b.product_id WHERE b.status = 2 AND (MONTH(m.created_at) = MONTH(CURRENT_DATE()) AND YEAR(m.created_at) = YEAR(CURRENT_DATE()) ) GROUP BY p.model_id, p.color_id, p.size) as m','product_barcodes.id = m.product_id', 'left')
            ->join('(SELECT id, SUM(qty) as stok FROM products WHERE status= 2 GROUP BY model_id, color_id, size) as a','products.id = a.id', 'left')            
            ->join('(SELECT m.product_id, SUM(m.qty) as stok_retur FROM product_logs m JOIN product_barcodes b ON b.id = m.product_id JOIN products as p ON p.id = b.product_id WHERE m.status = 4 AND (MONTH(m.created_at) = MONTH(CURRENT_DATE()) AND YEAR(m.created_at) = YEAR(CURRENT_DATE()) ) GROUP BY p.model_id, p.color_id, p.size) as r','product_barcodes.id = r.product_id', 'left')                        
            ->join('(SELECT b.product_id, SUM(m.qty) as scan_in FROM scan_so m JOIN product_barcodes b ON b.id = m.product_id JOIN products as p ON p.id = b.product_id WHERE m.status=1 AND (MONTH(m.created_at) = MONTH(CURRENT_DATE()) AND YEAR(m.created_at) = YEAR(CURRENT_DATE()) ) GROUP BY  p.model_id, p.color_id, p.size) as so','product_barcodes.id = so.product_id', 'left')                                    
            ->groupBy('model_id, color_id, size')        

            ->get();
        } else {
            $query = $this->db->table('products')
            ->select('products.*, model_name, jenis as product_name, color, hpp, name, price, stok, stok_retur, stok_masuk, scan_in')
            ->join('models', 'models.id = products.model_id')            
            ->join('colors', 'colors.id = products.color_id')
            ->join('users', 'users.id = products.user_id')            
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')                   
            ->join('(SELECT m.product_id, SUM(m.qty) as stok_masuk FROM product_logs m JOIN product_barcodes b ON b.id = m.product_id JOIN products as p ON p.id = b.product_id WHERE m.status = 2 AND (MONTH(m.created_at) = MONTH(CURRENT_DATE()) AND YEAR(m.created_at) = YEAR(CURRENT_DATE()) ) GROUP BY  p.model_id, p.color_id, p.size) as m','product_barcodes.id = m.product_id', 'left')
            ->join('(SELECT id, SUM(qty) as stok FROM products WHERE status= 2 GROUP BY model_id, color_id, size) as a','products.id = a.id', 'left')            
            ->join('(SELECT m.product_id, SUM(m.qty) as stok_retur FROM product_logs m JOIN product_barcodes b ON b.id = m.product_id JOIN products as p ON p.id = b.product_id WHERE m.status = 4 AND (MONTH(m.created_at) = MONTH(CURRENT_DATE()) AND YEAR(m.created_at) = YEAR(CURRENT_DATE()) ) GROUP BY  p.model_id, p.color_id, p.size) as r','product_barcodes.id = r.product_id', 'left')                        
            ->join('(SELECT b.product_id, SUM(m.qty) as scan_in FROM scan_so m JOIN product_barcodes b ON b.id = m.product_id JOIN products as p ON p.id = b.product_id WHERE m.status=1 AND (MONTH(m.created_at) = MONTH(CURRENT_DATE()) AND YEAR(m.created_at) = YEAR(CURRENT_DATE()) ) GROUP BY  p.model_id, p.color_id, p.size) as so','product_barcodes.id = so.product_id', 'left')       
            ->where('products.created_at BETWEEN "'.$date1.'" AND "'.$date2.'" ')        
            ->groupBy('model_id, color_id, size')            
            ->get();
        }
        
        return $query;
    }

    public function getAllStockProductLovishMonth($date1 = null, $date2 = null) {
        if (is_null($date1)) {
            $query = $this->db->table('products')
            ->select('products.*, model_name,jenis as product_name, color, hpp, name, price, stok, stok_masuk, stok_retur, scan_in')            
            ->join('models', 'models.id = products.model_id')            
            ->join('colors', 'colors.id = products.color_id')
            ->join('users', 'users.id = products.user_id')
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')                   
            ->join('(SELECT m.product_id, SUM(m.qty) as stok_masuk FROM product_logs m JOIN product_barcodes b ON b.id = m.product_id JOIN products as p ON p.id = b.product_id WHERE m.status = 2 AND (MONTH(m.created_at) = MONTH(CURRENT_DATE()) AND YEAR(m.created_at) = YEAR(CURRENT_DATE()) ) GROUP BY  p.model_id, p.color_id, p.size) as m','product_barcodes.id = m.product_id', 'left')
            ->join('(SELECT id, SUM(qty) as stok FROM products WHERE status= 2 GROUP BY model_id, product_id, color_id, size) as a','products.id = a.id', 'left')            
            ->join('(SELECT m.product_id, SUM(m.qty) as stok_retur FROM product_logs m JOIN product_barcodes b ON b.id = m.product_id JOIN products as p ON p.id = b.product_id WHERE m.status = 4 AND (MONTH(m.created_at) = MONTH(CURRENT_DATE()) AND YEAR(m.created_at) = YEAR(CURRENT_DATE()) ) GROUP BY  p.model_id, p.color_id, p.size) as r','product_barcodes.id = r.product_id', 'left')                        
            ->join('(SELECT b.product_id, SUM(m.qty) as scan_in FROM scan_so m JOIN product_barcodes b ON b.id = m.product_id JOIN products as p ON p.id = b.product_id WHERE m.status=2 AND (MONTH(m.created_at) = MONTH(CURRENT_DATE()) AND YEAR(m.created_at) = YEAR(CURRENT_DATE()) ) GROUP BY  p.model_id, p.color_id, p.size) as so','product_barcodes.id = so.product_id', 'left')                                    
            ->groupBy('model_id, color_id, size')        
            
            ->get();
        } else {
            $query = $this->db->table('products')
            ->select('products.*, model_name, jenis as product_name, color, hpp, name, price, stok, stok_retur, stok_masuk, penjualan')
            ->join('models', 'models.id = products.model_id')            
            ->join('colors', 'colors.id = products.color_id')
            ->join('users', 'users.id = products.user_id')            
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')                   
            ->join('(SELECT m.product_id, SUM(m.qty) as stok_masuk FROM product_logs m JOIN product_barcodes b ON b.id = m.product_id JOIN products as p ON p.id = b.product_id WHERE m.status = 2 AND (MONTH(m.created_at) = MONTH(CURRENT_DATE()) AND YEAR(m.created_at) = YEAR(CURRENT_DATE()) ) GROUP BY  p.model_id, p.color_id, p.size) as m','product_barcodes.id = m.product_id', 'left')
            ->join('(SELECT id, SUM(qty) as stok FROM products WHERE status= 2 GROUP BY model_id, product_id, color_id, size) as a','products.id = a.id', 'left')            
            ->join('(SELECT m.product_id, SUM(m.qty) as stok_retur FROM product_logs m JOIN product_barcodes b ON b.id = m.product_id JOIN products as p ON p.id = b.product_id WHERE m.status = 4 AND (MONTH(m.created_at) = MONTH(CURRENT_DATE()) AND YEAR(m.created_at) = YEAR(CURRENT_DATE()) ) GROUP BY  p.model_id, p.color_id, p.size) as r','product_barcodes.id = r.product_id', 'left')                        
            ->join('(SELECT b.product_id, SUM(m.qty) as scan_in FROM scan_so m JOIN product_barcodes b ON b.id = m.product_id JOIN products as p ON p.id = b.product_id WHERE m.status =2 AND (MONTH(m.created_at) = MONTH(CURRENT_DATE()) AND YEAR(m.created_at) = YEAR(CURRENT_DATE()) ) GROUP BY  p.model_id, p.color_id, p.size) as so','product_barcodes.id = so.product_id', 'left')       
            ->where('products.created_at BETWEEN "'.$date1.'" AND "'.$date2.'" ')        
            ->groupBy('model_id, color_id, size')            
            ->get();
        }
        
        return $query;
    }

    public function scanIn() {

    }

    public function penjualan() {
        $query = $this->db->table('sellings')
            ->select('sellings.*, model_name, jenis as product_name, color, SUM(qty) as penjualan')            
            ->join('models', 'models.id = sellings.model_id')            
            ->join('colors', 'colors.id = sellings.color_id')
            ->groupBy('model_id, color_id, size')            
            ->get();

        return $query;
    }

    public function getAllProductOut($date1 = null, $date2 = null) {
        if (is_null($date1)) { 
            $query = $this->db->table('products')
            ->select('product_logs.created_at, model_name,jenis as product_name, color, name, price, weight')
            ->join('models', 'models.id = products.model_id')
            ->join('colors', 'colors.id = products.color_id')
            ->join('users', 'users.id = products.user_id')
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')
            ->join('product_logs', 'product_logs.product_id = product_barcodes.id')
            ->where('product_logs.status','2')
            ->where('product_logs.qty !=','0')
            ->where('product_barcodes.status','2')
            ->groupBy('product_barcodes.id')
            ->orderBy('created_at', 'desc')
            ->get();
        } else {
            $query = $this->db->table('products')
            ->select('SUM(product_logs.qty) as qtyy, product_logs.created_at, model_name, jenis as product_name, color, name, price, weight')
            ->join('models', 'models.id = products.model_id')
            ->join('colors', 'colors.id = products.color_id')
            ->join('users', 'users.id = products.user_id')
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')
            ->join('product_logs', 'product_logs.product_id = product_barcodes.id')
            ->where('product_logs.status','2')
            ->where('product_logs.qty !=','0')
            ->where('product_barcodes.status !=','2')
            ->where('products.created_at BETWEEN "'.$date1.'" AND "'.$date2.'" ')
            ->orderBy('created_at', 'desc')
            ->get();
        }
        
        return $query;
    }

    public function getAllProductExp() {
        $query = $this->db->table('products')
        ->select('product_logs.qty as qtyy, products.*, model_name, jenis as product_name, color, name, price')
            ->join('models', 'models.id = products.model_id')
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
            ->select('model_name, jenis as product_name, color, SUM(product_logs.qty) as qty, product_logs.updated_at')
            ->join('models', 'models.id = products.model_id')            
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
        $query = $this->db->table('products')
            ->select('products.*, model_name, jenis as product_name, color, name, price, (products.qty - IFNULL(k.stok_keluar,0) - IFNULL(r.stok_reject,0)) as stok')
            ->join('models', 'models.id = products.model_id')
            ->join('colors', 'colors.id = products.color_id')
            ->join('users', 'users.id = products.user_id')
            ->join('(SELECT b.product_id, COUNT(b.id) as stok_keluar FROM product_barcodes b WHERE b.status = "2") as k','products.id = k.product_id', 'left')
            ->join('(SELECT b.product_id, COUNT(b.id) as stok_reject FROM product_barcodes b WHERE b.status = "0") as r','products.id = r.product_id', 'left')
            ->groupBy('products.id')
            ->orderBy('created_at', 'desc')
            ->get();  
        return $query;
    }

    public function getStokProductOut() {
        $query =  $this->db->table('models')
            ->select('products.id, jenis as product_name, model_name, color, weight, product_logs.status, products.created_at, products.qty, SUM(IFNULL(product_logs.qty, 0)) as stok')            
            ->join('products', 'products.model_id = models.id')
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

    public function totalGesit() {
        $query = $this->db->table('products')
            ->select('products.*, model_name, jenis as product_name, color, name, price, (products.qty - IFNULL(k.stok_keluar,0) - IFNULL(r.stok_reject,0)) as stok')
            ->join('models', 'models.id = products.model_id')
            ->join('colors', 'colors.id = products.color_id')
            ->join('users', 'users.id = products.user_id')
            ->join('(SELECT b.product_id, COUNT(b.id) as stok_keluar FROM product_barcodes b WHERE b.status = "2") as k','products.id = k.product_id', 'left')
            ->join('(SELECT b.product_id, COUNT(b.id) as stok_reject FROM product_barcodes b WHERE b.status = "0") as r','products.id = r.product_id', 'left')
            ->groupBy('products.id')
            ->orderBy('created_at', 'desc')
            ->get(); 
        return $query;
    }

    public function getStokProductAlmostOut() {
        $query =  $this->db->table('models')
            ->select('products.id, jenis as product_name, model_name, color, weight, product_logs.status, products.created_at')
            ->selectCount('products.id', 'stok')
            ->join('products', 'products.model_id = models.id')
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
            ->select('products.id, jenis as product_name, model_name, color, weight, size, product_logs.status, products.created_at, product_logs.qty')            
            ->join('products', 'products.model_id = models.id')
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

    public function findProductIn($id) {
        $query = $this->db->table('products')
            ->select('product_barcodes.id')
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')
            ->join('product_logs', 'product_logs.product_id = product_barcodes.id')
            ->where('product_logs.product_id', $id)
            ->where('product_barcodes.status', '1')
            ->get();
        return $query;    
    }

    public function findProductRejectSold($id) {
        $query = $this->db->table('products')
            ->select('product_barcodes.id')
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')            
            ->join('reject', 'reject.barcode_id = product_barcodes.id')
            ->where('reject.barcode_id', $id)
            ->get();
        return $query;    
    }

    public function findProductReject($id) {
        $query = $this->db->table('product_barcodes')            
            ->where('id', $id)
            ->where('status', '1')
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

    public function setProductIn($id) {
        $getProduct = $this->db->query("SELECT * FROM product_barcodes WHERE id = '$id' ");
        $productId = "";
        if ($getProduct->getNumRows() > 0) {
            $productId = $getProduct->getResultArray();
        }
        $this->db->query("INSERT INTO product_logs(product_id, status) VALUES('$id', 2) ");
    }

    public function updateQRStatus($id) {
        $this->db->query("UPDATE product_barcodes SET status = 2 WHERE id = '$id'");
    }

    public function setProductOut($id) {
        $this->db->query("UPDATE product_barcodes SET status = '3' WHERE id = '$id' ");
        $this->db->query("INSERT product_logs(product_id, qty, status) VALUES('$id', '1', '3') ");
    }

    public function updateStokOut($id, $user) {

        $this->db->query("INSERT product_logs(product_id, qty, status, user_id) VALUES('$id', '1', '3', '$user') ");
    }

    public function createBarcode($productId, $stat = null) {
        if (is_null($stat)) {
            $this->db->query("INSERT INTO product_barcodes(product_id) VALUES('$productId') ");
        } else {
            $this->db->query("INSERT INTO product_barcodes(product_id, status) VALUES('$productId', '$stat') ");
        }
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
        $this->db->query("INSERT product_logs(product_id, status) VALUES('$id', 4) ");
    }
    
    public function deleteProductBarcode($productId) {
        $this->db->query("DELETE FROM product_barcodes WHERE product_id='$productId' ");
    }

    public function productsRetur() {
        $query = $this->db->table('products')
            ->select('product_logs.qty as qty, size, product_logs.created_at, model_name,jenis as  product_name, color, name, price, weight')
            ->join('models', 'models.id = products.model_id')
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

    public function saveReject($id, $reject) {
        
        $this->db->query("UPDATE product_barcodes SET status = '0' WHERE id='$id' ");
        $this->db->query("INSERT reject(barcode_id, category) VALUES('$id', '$reject') ");
        if ($reject == 'permanent') {
            $this->db->query("INSERT penjualan_reject(reject_id) VALUES('$id') ");
            $this->db->query("UPDATE product_logs SET qty = '1' WHERE product_id='$id' ");
        }
    }
    
    public function saveJualReject($id) {
        $this->db->query("UPDATE penjualan_reject SET status = '2', tanggal_jual = NOW() WHERE reject_id='$id' ");
    }

    public function rejectedProduct() {
        $query = $this->db->table('reject')
            ->select('model_name, jenis as product_name, color, reject.category, reject.barcode_id, reject.date, reject.status, reject.id')
            ->join('product_barcodes', 'product_barcodes.id = reject.barcode_id')
            ->join('products', 'products.id = product_barcodes.product_id')
            ->join('models', 'models.id = products.model_id')
            ->join('colors', 'colors.id = products.color_id')
            ->get();
        return $query;
    }

    public function rejectIn($id) {
        
        $this->db->query("UPDATE product_barcodes SET status = '1' WHERE id = '$id' ");
        $this->db->query("UPDATE reject SET category = CONCAT(category, ' perbaikan'),  status = '2' WHERE barcode_id = '$id' ");
    }

    public function findPola($id) {
        $query = $this->db->table('pola')
        ->select('models.*, colors.id as color, pola.jumlah_setor')
        ->join('cutting', 'cutting.id = pola.cutting_id')
        ->join('materials', 'materials.id = cutting.material_id')
        ->join('models', 'models.id = cutting.model_id')
        ->join('colors', 'colors.id = materials.color_id')
        ->where('pola.id', $id)
        ->get();

        return $query->getFirstRow();
    }

    public function setProductSO($id) {
        $this->db->query("INSERT INTO scan_so(product_id) VALUES('$id') ");
    }

    public function setProductSOMonth($id) {
        $this->db->query("INSERT INTO scan_so(product_id, status) VALUES('$id', 2) ");
    }

    public function setProductSOReplace($id) {
        $this->db->query("INSERT INTO so_replace(product_id) VALUES('$id') ");
    }

    public function updateHPPJual($product, $model, $size, $hpp) {
        if (empty($size) || is_null($size)) {
            $this->db->query("UPDATE products SET hpp_jual = '$hpp' WHERE product_id ='$product' AND model_id = '$model' ");
        } else {
            $this->db->query("UPDATE products SET hpp_jual = '$hpp' WHERE product_id ='$product' AND model_id = '$model' AND size='$size' ");
        }
    }

    public function listReject(){
        $query = $this->db->table('reject')
            ->select('model_name, jenis as product_name, color, reject.category, reject.status, reject.date, reject.id')
            ->join('product_barcodes', 'product_barcodes.id = reject.barcode_id')
            ->join('products', 'products.id = product_barcodes.product_id')
            ->join('models', 'models.id = products.model_id')
            ->join('colors', 'colors.id = products.color_id')
            ->orderBy('reject.date', 'DESC')
            ->get();
        return $query;
    }

    public function rejectedSold() {
        $query = $this->db->table('reject')
            ->select('model_name, jenis as product_name, color, reject.category, reject.status, reject.barcode_id,  reject.date, reject.id, penjualan_reject.hpp, tanggal_jual, penjualan_reject.qr, penjualan_reject.status')
            ->join('product_barcodes', 'product_barcodes.id = reject.barcode_id')
            ->join('products', 'products.id = product_barcodes.product_id')
            ->join('models', 'models.id = products.model_id')
            ->join('colors', 'colors.id = products.color_id')
            ->join('penjualan_reject', 'product_barcodes.id = penjualan_reject.reject_id')
            ->orderBy('tanggal_jual', 'DESC')
            ->get();
        return $query;
    }

    public function updateHargaJual($id, $harga) {
        $this->db->query("UPDATE penjualan_reject SET hpp='$harga' WHERE reject_id = '$id' ");
    }

    public function rejectPermanent($id) {
        $this->db->query("UPDATE reject SET category=CONCAT(category, ' permanent'), status='3' WHERE barcode_id = '$id' ");
        $this->db->query("INSERT INTO penjualan_reject(reject_id) VALUES('$id')");
        
    }

    public function totalNilaiJualReject() {
        $query = $this->db->table('reject')
            ->select('IFNULL(SUM(hpp), 0) as total_jual')
            ->join('penjualan_reject', 'penjualan_reject.reject_id = reject.barcode_id')
            ->where('penjualan_reject.status', '2')
            ->get();
        return $query->getFirstRow();
    }

    public function getTop10() {
        $query = $this->db->query("SELECT jenis as product_name, model_name, color, size, models.brand, COUNT(sellings.qty) as total_qty FROM sellings JOIN models ON models.id = sellings.model_id JOIN colors ON colors.id = sellings.color_id GROUP BY sellings.model_id, sellings.brand ORDER BY total_qty DESC LIMIT 10");
        return $query;
    }

    public function getAllProductReject($date1 = null, $date2 = null) {
        if ($date1 == null) {
            $query = $this->db->table('reject')
            ->select('model_name, jenis as  product_name, color, reject.category, reject.date, reject.id')
            ->join('product_barcodes', 'product_barcodes.id = reject.barcode_id')
            ->join('products', 'products.id = product_barcodes.product_id')
            ->join('models', 'models.id = products.model_id')
            ->join('colors', 'colors.id = products.color_id')
            ->orderBy('reject.date', 'DESC')
            ->get();
        } else {
            $query = $this->db->table('reject')
            ->select('model_name, jenis as  product_name, color, reject.category, reject.date, reject.id')
            ->join('product_barcodes', 'product_barcodes.id = reject.barcode_id')
            ->join('products', 'products.id = product_barcodes.product_id')
            ->join('models', 'models.id = products.model_id')
            ->join('colors', 'colors.id = products.color_id')
            ->where('reject.date BETWEEN "'.$date1.'" AND "'.$date2.'" ')        
            ->orderBy('reject.date', 'DESC')
            ->get();
        }
        return $query;
    }

}   