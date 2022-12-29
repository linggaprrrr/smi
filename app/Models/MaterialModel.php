<?php

namespace App\Models;

use CodeIgniter\Model;

use function PHPUnit\Framework\returnSelf;

class MaterialModel extends Model
{
    protected $table = 'materials';
    protected $allowedFields = ['material_id', 'material_type', 'vendor_id', 'color_id', 'weight', 'roll', 'qrcode', 'status', 'price', 'user_id', 'gudang_id', 'updated_at', 'vendor_pola'];

    public function getAllMaterial($date1 = null, $date2 = null) {
        if (!is_null($date1)) {
            $query =  $this->db->table('materials')
            ->select('materials.*, materials.weight - IFNULL(berat_cutting, 0) as total_berat, material_vendors.vendor, material_types.type, colors.color')
            ->join('material_types', 'material_types.id = materials.material_type')
            ->join('colors', 'colors.id = materials.color_id')
            ->join('gudang', 'gudang.id = materials.gudang_id')
            ->join('material_vendors', 'material_vendors.id = materials.vendor_id')            
            ->join('(SELECT m.id, SUM(c.berat) as berat_cutting FROM cutting c JOIN materials as m ON m.id = c.material_id GROUP BY c.material_id) as m','materials.id = m.id', 'left')
            ->where('status', '1')
            ->where('created_at BETWEEN "'.$date1.'" AND "'.$date2.'" ')
            ->orderBy('created_at', 'desc')->get(); 
        } else {
            $query =  $this->db->table('materials')
            ->select('materials.*, (materials.weight - IFNULL(berat_cutting, 0)) as total_berat, material_vendors.vendor, material_types.type, colors.color')
            ->join('material_types', 'material_types.id = materials.material_type')
            ->join('colors', 'colors.id = materials.color_id')
            ->join('gudang', 'gudang.id = materials.gudang_id')
            ->join('material_vendors', 'material_vendors.id = materials.vendor_id')        
            ->join('(SELECT m.id, SUM(c.berat) as berat_cutting FROM cutting c JOIN materials as m ON m.id = c.material_id GROUP BY c.material_id) as m','materials.id = m.id', 'left')
            ->where('status', '1')
            ->orderBy('created_at', 'desc')->get();
        }
        return $query;
    }
    
    public function getAllMaterialRetur($date1 = null, $date2 = null) {
        if (!is_null($date1)) {
            $query =  $this->db->table('materials')
            ->select('materials.*, material_vendors.vendor, material_types.type, colors.color')
            ->join('material_types', 'material_types.id = materials.material_type')
            ->join('colors', 'colors.id = materials.color_id')
            ->join('gudang', 'gudang.id = materials.gudang_id')
            ->join('material_vendors', 'material_vendors.id = materials.vendor_id')            
            ->where('status', '0')
            ->where('materials.created_at BETWEEN "'.$date1.'" AND "'.$date2.'" ')
            ->orderBy('materials.created_at', 'DESC')
            ->get(); 
        } else {
            $query =  $this->db->table('materials')
            ->select('materials.*, material_vendors.vendor, material_types.type, colors.color')
            ->join('material_types', 'material_types.id = materials.material_type')
            ->join('colors', 'colors.id = materials.color_id')
            ->join('gudang', 'gudang.id = materials.gudang_id')
            ->join('material_vendors', 'material_vendors.id = materials.vendor_id')        
            ->where('status', '0')
            ->orderBy('materials.created_at', 'desc')
            ->get();
        }
        return $query;
    }

    public function getStokMaterialIn($date1 = null, $date2 = null) {

        if (is_null($date1)) {
            $query =  $this->db->table('materials')
                ->select('material_types.type, colors.color, stok_masuk, stok_retur, stok_habis, materials.created_at, weight')
                ->join('material_types', 'material_types.id = materials.material_type')
                ->join('colors', 'colors.id = materials.color_id')
                ->join('material_vendors', 'material_vendors.id = materials.vendor_id')        
                ->join('(SELECT materials.material_type, materials.color_id, COUNT(*) as stok_masuk FROM materials GROUP BY material_type, color_id) as s', 's.material_type = materials.material_type AND s.color_id = materials.color_id', 'left')
                ->join('(SELECT materials.material_type, materials.color_id, COUNT(*) as stok_retur FROM materials WHERE materials.status = 0 AND status = 0 GROUP BY material_type, color_id) as sr', 'sr.material_type = materials.material_type AND s.color_id = materials.color_id', 'left')
                ->join('(SELECT materials.material_type, materials.color_id, COUNT(*) as stok_habis FROM materials LEFT JOIN (SELECT cutting.material_id, SUM(berat) as total_berat FROM cutting GROUP BY cutting.material_id) as ct ON ct.material_id = materials.id WHERE (materials.weight - IFNULL(ct.total_berat, 0)) <= 0 GROUP BY material_type, color_id) as ct', 'ct.material_type = materials.material_type AND ct.color_id = materials.color_id', 'left')           
                ->groupBy('materials.material_type, materials.color_id')
                ->orderBy('materials.created_at', 'desc')
                ->get();
        } else {
            $query =  $this->db->table('materials')
                ->select('material_types.type, colors.color, stok_masuk, stok_retur, stok_habis, materials.created_at, weight')
                ->join('material_types', 'material_types.id = materials.material_type')
                ->join('colors', 'colors.id = materials.color_id')
                ->join('material_vendors', 'material_vendors.id = materials.vendor_id')        
                ->join('(SELECT materials.material_type, materials.color_id, COUNT(*) as stok_masuk FROM materials WHERE created_at BETWEEN "'.$date1.'" AND "'.$date2.'" GROUP BY material_type, color_id) as s', 's.material_type = materials.material_type AND s.color_id = materials.color_id', 'left')
                ->join('(SELECT materials.material_type, materials.color_id, COUNT(*) as stok_retur FROM materials WHERE materials.status = 0 AND status = 0 AND created_at BETWEEN "'.$date1.'" AND "'.$date2.'" GROUP BY material_type, color_id) as sr', 'sr.material_type = materials.material_type AND s.color_id = materials.color_id', 'left')
                ->join('(SELECT materials.material_type, materials.color_id, COUNT(*) as stok_habis FROM materials LEFT JOIN (SELECT cutting.material_id, SUM(berat) as total_berat FROM cutting WHERE tgl BETWEEN "'.$date1.'" AND "'.$date2.'" GROUP BY cutting.material_id) as ct ON ct.material_id = materials.id WHERE (materials.weight - IFNULL(ct.total_berat, 0)) <= 0 AND created_at BETWEEN "'.$date1.'" AND "'.$date2.'" GROUP BY material_type, color_id) as ct', 'ct.material_type = materials.material_type AND ct.color_id = materials.color_id', 'left')           
                ->groupBy('materials.material_type, materials.color_id')
                ->orderBy('materials.created_at', 'desc')
                ->get();
        }
        return $query;
    }
    
    public function getMaterialIn($date1 = null, $date2 = null) {
        if (is_null($date1)) {
            $query = $this->db->table('materials')
                ->join('material_types', 'material_types.id = materials.material_type')
                ->join('colors', 'colors.id = materials.color_id')
                ->join('material_vendors', 'material_vendors.id = materials.vendor_id')        
                ->orderBy('materials.created_at', 'DESC')
                ->get();
        } else {
            $query = $this->db->table('materials')
            ->join('material_types', 'material_types.id = materials.material_type')
            ->join('colors', 'colors.id = materials.color_id')
            ->join('material_vendors', 'material_vendors.id = materials.vendor_id')        
            ->where('created_at BETWEEN "'.$date1.'" AND "'.$date2.'"  ')
            ->orderBy('materials.created_at', 'DESC')
            ->get();
        }
        return $query;
    }

    public function getAllMaterialQR() {
        $query =  $this->db->table('materials')
        ->select('materials.*, material_types.type, colors.color, users.name, gudang, roll, vendor')
        ->join('material_types', 'material_types.id = materials.material_type')
        ->join('colors', 'colors.id = materials.color_id')
        ->join('gudang', 'gudang.id = materials.gudang_id')
        ->join('material_vendors', 'material_vendors.id = materials.vendor_id')
        ->join('users', 'users.id = materials.user_id')
        ->where('status', '1')
        ->orderBy('qrcode', 'asc')
        ->orderBy('created_at', 'desc')
        ->get();
        return $query;
    }

    public function getAllMaterialOut() {
        $query =  $this->db->table('materials')
        ->select('materials.*, material_types.type, colors.color, gudang, roll, vendor, material_patterns.created_at as created_at_pola, users.name ')
        ->join('material_types', 'material_types.id = materials.material_type')
        ->join('colors', 'colors.id = materials.color_id')
        ->join('gudang', 'gudang.id = materials.gudang_id')
        ->join('material_vendors', 'material_vendors.id = materials.vendor_id')
        ->join('material_patterns', 'material_patterns.material_id = materials.id')
        ->join('users', 'users.id = material_patterns.user_id_out')
        ->where('status', '2')
        ->orderBy('created_at', 'desc')->get();
        return $query;
    }

    public function getMaterialDetail($id) {
        $query =  $this->db->table('materials')
        ->select('materials.*, material_types.type, colors.color, users.name, gudang, roll, vendor_id, price')
        ->join('material_types', 'material_types.id = materials.material_type')
        ->join('colors', 'colors.id = materials.color_id')
        ->join('gudang', 'gudang.id = materials.gudang_id')
        ->join('material_vendors', 'material_vendors.id = materials.vendor_id')
        ->join('users', 'users.id = materials.user_id')
        ->where('materials.id', $id)
        ->orderBy('created_at', 'desc')->get();
        return $query->getResult();
    }

 

    public function getAllMaterialStock() {
        $query = $this->db->table('materials')
            ->select('material_types.type, colors.color, SUM(roll) as roll, SUM(weight) as berat')
            ->join('material_types', 'material_types.id = materials.material_type')
            ->join('colors', 'colors.id = materials.color_id')
            ->groupBy('material_types.type')
            ->groupBy('colors.color')
            ->get();
        return $query;
    }

    public function getMaterialRetur($date1 = null, $date2 = null) {
        if (is_null($date1)) {
            $query = $this->db->table('materials')
                ->select('materials.material_id, material_types.type, vendor, colors.color,  materials.updated_at')
                ->join('material_types', 'material_types.id = materials.material_type')
                ->join('colors', 'colors.id = materials.color_id')
                ->join('material_vendors', 'material_vendors.id = materials.vendor_id')  
                ->where('materials.status', '0')
                ->orderBy('materials.updated_at', 'DESC')
                ->get();
        } else {
            $query = $this->db->table('materials')
                ->select('materials.material_id, material_types.type, vendor, colors.color,  materials.updated_at')
                ->join('material_types', 'material_types.id = materials.material_type')
                ->join('colors', 'colors.id = materials.color_id')
                ->join('material_vendors', 'material_vendors.id = materials.vendor_id')  
                ->where('materials.status', '0')
                ->where('updated_at BETWEEN "'.$date1.'" AND "'.$date2.'"  ')
                ->orderBy('materials.updated_at', 'DESC')
                ->get();
        }
        return $query;
    }

    public function setPolaOut($id, $user) {
        $this->db->query("INSERT INTO material_patterns(material_type, user_id_out) VALUES('$id', '$user') ");
    }

    public function setPolaIn($id, $user) {
        $this->db->query("UPDATE material_patterns SET user_id_in= '$user', updated_at = date('Y-m-d H:i:s') WHERE material_type='$id' ");
    }

    

    public function getMaterialVendors() {
        $query = $this->db->table('material_vendors')->get();
        return $query;
    }

    public function getVendor($id) {
        $query = $this->db->table('material_vendors')
            ->where('id', $id)
            ->get();
        return $query;
    }

    public function getJenisKain($id) {
        $query = $this->db->table('material_types')
        ->where('id', $id)
        ->get();
    return $query;
    }

    public function getVendorPola($id) {
        $query = $this->db->table('vendor_pola')
            ->where('id', $id)
            ->get();
        return $query->getFirstRow();
    }

    public function getAllMaterialType() {
        $query =  $this->db->table('material_types')
        ->orderBy('material_types.id', 'desc')->get();
        return $query;
    }
    
    public function getMaterialType($id) {
        $query =  $this->db->table('material_types')
        ->where('id', $id)
        ->get();
        return $query->getResult();
    }

    public function getAllColors() {
        $query =  $this->db->table('colors')
        ->orderBy('id', 'desc')->get();
        return $query;
    }

   

    public function getAllVendorKain() {
        $query = $this->db->table('material_vendors')
        ->orderBy('id', 'desc')->get();
        return $query;
    }

    public function saveMaterialType($type, $harga) {
        $this->db->query("INSERT INTO material_types(type, harga) VALUES('$type', '$harga') ");
    }

    public function updateMaterialType($id, $type, $harga) {
        $this->db->query("UPDATE material_types SET type='$type', harga = '$harga' WHERE id='$id' ");
    }

    public function deleteMaterialType($id) {
        $this->db->query("DELETE FROM material_types WHERE id='$id' ");
    }

    public function saveWarna($warna) {
        $this->db->table('colors')->insert([
            'color' => $warna
        ]);

        return $this->db->insertID();
        // $this->db->query("INSERT INTO colors(color) VALUES('$warna') ");
    }

    public function saveVendorSupplier($vendor) {
        $this->db->query("INSERT IGNORE INTO material_vendors(vendor) VALUES('$vendor') ");
    }

    public function saveVendorPenjualan($vendor) {
        $this->db->query("INSERT INTO selling_vendors(vendor) VALUES('$vendor') ");
    }

    public function getColor($id) {
        $query = $this->db->table('colors')
            ->where('id', $id)->get();
        return $query->getResult();
    }

    public function getColorByName($color) {
        $query = $this->db->table('colors')
            ->where('color', $color)
            ->get();
        return $query->getFirstRow();
    }

    public function updateColor($id, $color) {
        $this->db->query("UPDATE colors SET color='$color' WHERE id='$id' ");
    }

    public function deleteColor($id) {
        $this->db->query("DELETE FROM colors WHERE id='$id' ");
    }

    public function deleteGelar($id) {
        $this->db->query("DELETE FROM tim_gelar WHERE id='$id' ");
    }

    public function deleteCutting($id) {
        $this->db->query("DELETE FROM tim_cutting WHERE id='$id' ");
    }

    public function deleteCuttingPola($id) {
        $this->db->query("DELETE FROM cutting WHERE id='$id'");
        $this->db->query("DELETE FROM pola WHERE cutting_id='$id'");
    }

    public function getVendorSupplier($id) {
        $query = $this->db->table('material_vendors')
            ->where('id', $id)->get();
        return $query->getResult();
    }

    public function updateVendorSupplier($id, $vendor) {
        $this->db->query("UPDATE material_vendors SET vendor='$vendor' WHERE id='$id' ");
    }

    public function getVendorSelling($id) {
        $query = $this->db->table('selling_vendors')
            ->where('id', $id)->get();
        return $query->getResult();
    }

    public function updateVendorSelling($id, $vendor) {
        $this->db->query("UPDATE selling_vendors SET vendor='$vendor' WHERE id='$id' ");
    }

    public function deleteVendorSupplier($id) {
        $this->db->query("DELETE FROM material_vendors WHERE id='$id' ");
    }

    public function deleteVendorSelling($id) {
        $this->db->query("DELETE FROM selling_vendors WHERE id='$id' ");
    }

    public function deleteVendorPola($id) {
        $this->db->query("DELETE FROM vendor_pola WHERE id='$id' ");
    }

    public function getAllGudang() {
        $query = $this->db->table('gudang')->get();
        return $query;
    }

    public function getAllPICCutting() {
        $query = $this->db->table('tim_cutting')->get();
        return $query;
    }

    public function getAllTimGelar() {
        $query = $this->db->table('tim_gelar')->get();
        return $query;
    }   

    public function getAllTimCutting() {
        $query = $this->db->table('tim_cutting')->get();
        return $query;
    }

    public function updateMaterialStokRetur($id) {
        $this->db->query("UPDATE materials SET status = 0, updated_at = NOW() WHERE id = $id ");
    } 

    public function getAllVendorPola() {
        $query = $this->db->table('vendor_pola')->get();
        return $query;
    }

    public function saveVendorPola($name) {
        $this->db->query("INSERT IGNORE INTO vendor_pola(name) VALUES('$name')");
    }

    public function saveTimGelar($name) {
        $this->db->query("INSERT IGNORE INTO tim_gelar(name) VALUES('$name') ");
    }

    public function saveTimCutting($name) {
        $this->db->query("INSERT IGNORE INTO tim_cutting(name) VALUES('$name') ");
    }

    public function updateVendorPola($id, $name) {
        $this->db->query("UPDATE vendor_pola SET name = '$name' WHERE id ='$id' ");
    }

    public function importMaterial($type, $harga) {
        $this->db->query("INSERT IGNORE INTO material_types(type, harga) VALUES('$type', '$harga') ");
    }
    public function importModel($brand, $jenis, $type, $jahit, $hpp) {
        $this->db->query("INSERT IGNORE INTO models(brand, jenis, model_name, harga_jahit, hpp) VALUES('$brand', '$jenis', '$type', '$jahit', '$hpp') ");
    }
    public function importProduk($type) {
        $this->db->query("INSERT IGNORE INTO product_types(product_name) VALUES('$type') ");
    }
    public function importColor($type) {
        $this->db->query("INSERT IGNORE INTO colors(color) VALUES('$type') ");
    }
    public function importVendorSupp($type) {
        $this->db->query("INSERT IGNORE INTO material_vendors(vendor) VALUES('$type') ");
    }

    public function importVendorSell($type) {
        $this->db->query("INSERT IGNORE INTO selling_vendors(vendor) VALUES('$type') ");
    }

    public function getAllCuttingData($date1=null, $date2=null) {
        if (is_null($date1)) {
            $query = $this->db->table('materials as m')
            ->select('m.id as material_id, m.material_id as mid, ct.*, mt.type, md.model_name, c.color, g1.name as gelar1, g2.name as gelar2, tc.name as pic, p.id as pid')
            ->join('material_types as mt', 'mt.id = m.material_type')
            ->join('colors as c', 'c.id = m.color_id')
            ->join('cutting as ct', 'ct.material_id = m.id')
            ->join('models as md', 'md.id = ct.model_id', 'left')
            ->join('tim_gelar as g1', 'g1.id = ct.gelar1', 'left')
            ->join('tim_gelar as g2', 'g2.id = ct.gelar2', 'left')
            ->join('tim_cutting as tc', 'tc.id = ct.pic', 'left')
            ->join('pola as p', 'p.cutting_id = ct.id', 'left')
            ->groupBy('ct.id')
            ->orderBy('ct.id', 'desc')
            ->get();
        } else {
            $query = $this->db->table('materials as m')
            ->select('m.material_id as mid, ct.*, mt.type, md.model_name, c.color, g1.name as gelar1, g2.name as gelar2, tc.name as pic, p.id as pid')
            ->join('material_types as mt', 'mt.id = m.material_type')
            ->join('colors as c', 'c.id = m.color_id')
            ->join('cutting as ct', 'ct.material_id = m.id')
            ->join('models as md', 'md.id = ct.model_id', 'left')
            ->join('tim_cutting as tc', 'tc.id = ct.pic')
            ->join('tim_gelar as g1', 'g1.id = ct.gelar1')
            ->join('tim_gelar as g2', 'g2.id = ct.gelar2')
            ->join('pola as p', 'p.cutting_id = ct.id', 'left')
            ->where('ct.tgl BETWEEN "'.$date1.'" AND "'.$date2.'" ')
            ->groupBy('ct.id')
            ->orderBy('ct.id', 'desc')
            ->get();
        }
        

        return $query;
    }

    public function getAllCuttingData2($date1=null, $date2=null) {
        if (is_null($date1)) {
            $query = $this->db->table('materials as m')
            ->select('m.id as material_id, m.material_id as mid, ct.*, mt.type, md.model_name, c.color, p.id as pid')
            ->join('material_types as mt', 'mt.id = m.material_type')
            ->join('colors as c', 'c.id = m.color_id')
            ->join('cutting as ct', 'ct.material_id = m.id')
            ->join('models as md', 'md.id = ct.model_id', 'left')
            ->join('pola as p', 'p.cutting_id = ct.id', 'left')
            ->groupBy('ct.id')
            ->orderBy('ct.id', 'desc')
            ->get();
        } else {
            $query = $this->db->table('materials as m')
            ->select('m.material_id as mid, ct.*, mt.type, md.model_name, c.color, p.id as pid')
            ->join('material_types as mt', 'mt.id = m.material_type')
            ->join('colors as c', 'c.id = m.color_id')
            ->join('cutting as ct', 'ct.material_id = m.id')
            ->join('models as md', 'md.id = ct.model_id', 'left')
            ->join('pola as p', 'p.cutting_id = ct.id', 'left')
            ->where('ct.tgl BETWEEN "'.$date1.'" AND "'.$date2.'" ')
            ->groupBy('ct.id')
            ->orderBy('ct.id', 'desc')
            ->get();
        }
        

        return $query;
    }

    public function insertCutting($id, $gelar, $jahit) {        
        $this->db->query("INSERT INTO cutting(material_id, harga_gelar, harga_cutting) VALUES('$id','$gelar', '$jahit') ");

        return $this->db->insertID();
    }

    public function getCOA() {
        $query = $this->db->query('SELECT * FROM coa');
        return $query->getResultObject();
    }

    public function updateCOA($id, $ket, $biaya) {
        $this->db->query("UPDATE coa SET ket='$ket', biaya='$biaya' WHERE id='$id'  ");
    }

    public function editCOA($id) {
        $query = $this->db->table('coa')
            ->get();
        return $query->getFirstRow();
    }

    public function editGelar($id) {
        $query = $this->db->table('tim_gelar')
            ->where('id', $id)
            ->get();
        return $query->getFirstRow();
    }

    public function updateGelar($id, $name) {
        $this->db->query("UPDATE tim_gelar SET name='$name' WHERE id='$id' ");
    }

    public function editTimCutting($id) {
        $query = $this->db->table('tim_cutting')
            ->where('id', $id)
            ->get();
        return $query->getFirstRow();
    }

    public function updateTimCutting($id, $name) {
        $this->db->query("UPDATE tim_cutting SET name='$name' WHERE id='$id' ");
    }

    public function updateCuttingProduct($id, $prod) {
        $this->db->query("UPDATE cutting SET model_id = '$prod' WHERE id = '$id' ");
    }

    public function changeGelar1($data) {        
        $this->db->table('cutting')
            ->set('gelar1', $data['gelar1'])
            ->where('id', $data['id'])
            ->update($data);
    }

    public function changeGelar2($data) {
        $this->db->table('cutting')
            ->set('gelar2', $data['gelar2'])
            ->where('id', $data['id'])
            ->update($data);
    }

    public function changeCuttingPIC($data) {
        $this->db->table('cutting')
            ->set('pic', $data['pic'])
            ->where('id', $data['id'])
            ->update($data);
    }

    public function updateCuttingProductPola($id, $prod) {
        $this->db->query("UPDATE cutting SET model_id = '$prod' WHERE id = '$id' ");
        $query = $this->db->table('cutting')
            ->select('models.model_name')
            ->join('models', 'models.id = cutting.model_id')
            ->getWhere(['cutting.id' => 22])->getRow();
        return $query;
    }

    public function updateJumlahPolaOut($id, $jum) {
        $this->db->query("UPDATE pola SET jumlah_pola='$jum' WHERE cutting_id='$id' ");
    }

    public function updateCuttingQty($id, $qty, $gelar, $cutting) {
        $biayaGelar = $qty * $gelar;
        $biayaCutting = $qty * $cutting;
        $total = (2 * $biayaGelar) + $biayaCutting;
        $this->db->query("UPDATE cutting SET qty = '$qty', biaya_gelar1 = '$biayaGelar', biaya_gelar2 = '$biayaGelar', biaya_cutting = '$biayaCutting', total = '$total' WHERE id='$id' ");
        $res = [
            'gelar1' => $biayaGelar,
            'gelar2' => $biayaGelar,
            'cutting' => $biayaCutting,
            'total' => $total
        ];
        return $res;
    }

    public function updateCuttingQtyPola($id, $qty, $gelar, $cutting) {
        $biayaGelar = $qty * $gelar;
        $biayaCutting = $qty * $cutting;
        $total = (2 * $biayaGelar) + $biayaCutting;
        $this->db->query("UPDATE cutting SET qty = '$qty', biaya_gelar1 = '$biayaGelar', biaya_gelar2 = '$biayaGelar', biaya_cutting = '$biayaCutting', total = '$total' WHERE id='$id' ");
        $this->db->query("UPDATE pola SET jumlah_pola = '$qty' WHERE cutting_id='$id' ");
        $res = [
            'gelar1' => $biayaGelar,
            'gelar2' => $biayaGelar,
            'cutting' => $biayaCutting,
            'total' => $total,
            'qty' => $qty,
        ];
        return $res;
    }

    public function updateVendorPolaOut($id, $vendor) {
        $this->db->query("UPDATE pola SET vendor_id='$vendor' WHERE cutting_id='$id' ");
        $query = $this->db->table('vendor_pola')
            ->getWhere(['id' => $vendor])
            ->getRow();
        return $query;
    }

    public function updateJumlahSetorPolaIn($id, $jum) {
        $this->db->query("UPDATE pola SET jumlah_setor = '$jum', sisa=jumlah_pola-'$jum'-reject WHERE id='$id' ");
        $query = $this->db->table('pola')
            ->getWhere(['id' => $id])
            ->getRow();

        return $query;
    }

    public function updateReject($id, $val) {
        $this->db->query("UPDATE pola SET reject = '$val' WHERE id='$id' ");
        $query = $this->db->table('pola')
            ->getWhere(['id' => $id])
            ->getRow();

        return $query;
    }

    public function getCutting($id) {
        $query = $this->db->query("SELECT * FROM cutting WHERE id='$id' ");
        return $query->getResultObject();
    }
    
    public function savePolaOut($id, $tgl, $jumlah, $vendor, $berat, $material) {
        $this->db->query("INSERT INTO pola(cutting_id, tgl_ambil, jumlah_pola, vendor_id) VALUES('$id', '$tgl', '$jumlah', '$vendor') ");        
    }

    public function savePolaIn($arr) {
        $this->db->query("INSERT INTO pola(cutting_id, tgl_ambil, jumlah_pola, vendor_id, tgl_setor, jumlah_setor, reject, sisa, harga, total_harga, status) VALUES (".$arr['cuttingID'].", '".$arr['tglAmbil']."', ".$arr['jumlahPola'].", ".$arr['vendorID'].", '".$arr['tglSetor']."',".$arr['jumlahSetor'].",".$arr['reject'].",".$arr['sisa'].",".$arr['harga'].", ".$arr['total'].", 2) ");
    } 

    public function updateStatusCutting($id, $remain, $status) {
        $this->db->query("UPDATE cutting SET status='$status', qty='$remain' WHERE id='$id' ");
    }

    public function updateStatusPola($id, $status) {
        
    }

    public function getAllPolaOut($date1 = null, $date2 = null) {
        if (is_null($date1)) {
            $query = $this->db->table('materials as m')
            ->select('m.material_id, ct.tgl, mt.type, md.model_name, c.color, p.*, vend.name, COUNT(p.id) as jum')
            ->join('material_types as mt', 'mt.id = m.material_type')
            ->join('colors as c', 'c.id = m.color_id')
            ->join('cutting as ct', 'ct.material_id = m.id')
            ->join('models as md', 'md.id = ct.model_id', 'left')
            ->join('pola as p', 'p.cutting_id = ct.id')
            ->join('vendor_pola as vend', 'vend.id = p.vendor_id')
            ->groupBy('m.id')
            ->orderBy('m.id DESC')
            ->get();
        } else {
            $query = $this->db->table('materials as m')
            ->select('m.material_id, ct.tgl, mt.type, md.model_name, c.color, p.*, vend.name, COUNT(p.id) as jum')
            ->join('material_types as mt', 'mt.id = m.material_type')
            ->join('colors as c', 'c.id = m.color_id')
            ->join('cutting as ct', 'ct.material_id = m.id')
            ->join('models as md', 'md.id = ct.model_id', 'left')            
            ->join('pola as p', 'p.cutting_id = ct.id')
            ->join('vendor_pola as vend', 'vend.id = p.vendor_id')
            ->where('p.tgl_ambil BETWEEN "'.$date1.'" AND "'.$date2.'"  ')
            ->groupBy('ct.id')
            ->orderBy('COUNT(p.id) ASC, p.id DESC')
            ->get();
        }
        return $query;
    }

    public function getAllPolaIn($date1 = null, $date2 = null) {
        if (is_null($date1)) {
            $query = $this->db->table('materials as m')
            ->select('m.material_id, ct.tgl, mt.type, md.model_name, md.harga_jahit, md.hpp, c.color, g1.name as gelar1, g2.name as gelar2, tc.name as pic, p.*, vend.name, products.pola_id')
            ->join('material_types as mt', 'mt.id = m.material_type')
            ->join('colors as c', 'c.id = m.color_id')
            ->join('cutting as ct', 'ct.material_id = m.id')
            ->join('models as md', 'md.id = ct.model_id', 'left')
            ->join('tim_gelar as g1', 'g1.id = ct.gelar1')
            ->join('tim_gelar as g2', 'g2.id = ct.gelar2')
            ->join('tim_cutting as tc', 'tc.id = ct.pic')
            ->join('pola as p', 'p.cutting_id = ct.id')
            ->join('vendor_pola as vend', 'vend.id = p.vendor_id')
            ->join('products', 'products.pola_id = p.id', 'left')
            ->orderBy('p.id', 'desc')
            ->get();
        } else {
            $query = $this->db->table('materials as m')
            ->select('m.material_id, ct.tgl, mt.type, md.model_name, c.color, g1.name as gelar1, g2.name as gelar2, tc.name as pic, p.*, vend.name')
            ->join('material_types as mt', 'mt.id = m.material_type')
            ->join('colors as c', 'c.id = m.color_id')
            ->join('cutting as ct', 'ct.material_id = m.id')
            ->join('models as md', 'md.id = ct.model_id', 'left')
            ->join('tim_gelar as g1', 'g1.id = ct.gelar1')
            ->join('tim_gelar as g2', 'g2.id = ct.gelar2')
            ->join('tim_cutting as tc', 'tc.id = ct.pic')
            ->join('pola as p', 'p.cutting_id = ct.id')
            ->join('vendor_pola as vend', 'vend.id = p.vendor_id')
            ->where('p.tgl_ambil BETWEEN "'.$date1.'" AND "'.$date2.'"  ')
            ->orderBy('p.id', 'desc')
            ->get();
        }

        
        return $query;
    }

    public function getPolaOut($id) {
        $query = $this->db->table('materials as m')
            ->select('ct.tgl, mt.type, md.id as model_id, md.harga_jahit, md.model_name, c.color, g1.name as gelar1, g2.name as gelar2, tc.name as pic, p.*, vend.name')
            ->join('material_types as mt', 'mt.id = m.material_type')
            ->join('colors as c', 'c.id = m.color_id')
            ->join('cutting as ct', 'ct.material_id = m.id')
            ->join('models as md', 'md.id = ct.model_id', 'left')
            ->join('tim_gelar as g1', 'g1.id = ct.gelar1')
            ->join('tim_gelar as g2', 'g2.id = ct.gelar2')
            ->join('tim_cutting as tc', 'tc.id = ct.pic')
            ->join('pola as p', 'p.cutting_id = ct.id')
            ->join('vendor_pola as vend', 'vend.id = p.vendor_id')
            ->where('p.id', $id)
            ->get();
        return $query->getResultObject();
    }

    public function setCutting($id) {
        $this->db->query("INSERT INTO cutting(material_id) VALUES('$id') ");
    }

    public function updateBeratCutting($id, $berat, $material) {
        $this->db->query("UPDATE cutting SET berat = '$berat' WHERE id = '$id' ");
        
    }

    public function getSizeCutting($id) {
        $query = $this->db->table('cutting')  
            ->select('size.*, cutting.qty')          
            ->join('size', 'size.cutting_id = cutting.id')
            ->where('cutting.id', $id)
            ->get();
        return $query->getFirstRow();
    }

    public function getSizePola($id) {
        $query = $this->db->table('cutting')  
            ->select('size.*, jumlah_setor as qty')          
            ->join('pola', 'pola.cutting_id = cutting.id')
            ->join('size', 'size.cutting_id = cutting.id')
            ->where('pola.id', $id)
            ->get();
        return $query->getFirstRow();
    }

    public function simpanSize($data) {
        $this->db->table('size')
            ->set('s', $data['s'])
            ->set('m', $data['m'])
            ->set('l', $data['l'])
            ->set('xl', $data['xl'])
            ->set('xxl', $data['xxl'])
            ->where('cutting_id', $data['cutting_id'])
            ->update($data);
    }

    public function insertSize($id) {
        $this->db->query("INSERT INTO size(cutting_id) VALUES('$id') ");
    }

}