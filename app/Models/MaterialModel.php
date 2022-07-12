<?php

namespace App\Models;

use CodeIgniter\Model;

class MaterialModel extends Model
{
    protected $table = 'materials';
    protected $allowedFields = ['material_id', 'vendor_id', 'color_id', 'weight', 'roll', 'qrcode', 'status', 'price', 'user_id', 'gudang_id', 'updated_at', 'pic_cutting', 'gelar1', 'gelar2', 'tgl_cutting', 'vendor_pola'];

    public function getAllMaterial() {
        $query =  $this->db->table('materials')
        ->select('materials.*, material_types.type, colors.color, gudang, roll, vendor, tim_cutting.name as pic')
        ->join('material_types', 'material_types.id = materials.material_id')
        ->join('colors', 'colors.id = materials.color_id')
        ->join('gudang', 'gudang.id = materials.gudang_id')
        ->join('tim_cutting', 'tim_cutting.id = materials.pic_cutting')
        ->join('material_vendors', 'material_vendors.id = materials.vendor_id')
        ->where('status', '1')
        ->orderBy('created_at', 'desc')->get();
        return $query;
    }

    public function getAllMaterialQR() {
        $query =  $this->db->table('materials')
        ->select('materials.*, material_types.type, colors.color, users.name, gudang, roll, vendor')
        ->join('material_types', 'material_types.id = materials.material_id')
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
        ->select('materials.*, material_types.type, colors.color, gudang, roll, vendor, tim_cutting.name as pic, material_patterns.created_at as created_at_pola, users.name ')
        ->join('material_types', 'material_types.id = materials.material_id')
        ->join('colors', 'colors.id = materials.color_id')
        ->join('gudang', 'gudang.id = materials.gudang_id')
        ->join('tim_cutting', 'tim_cutting.id = materials.pic_cutting')
        ->join('material_vendors', 'material_vendors.id = materials.vendor_id')
        ->join('material_patterns', 'material_patterns.material_id = materials.id')
        ->join('users', 'users.id = material_patterns.user_id_in')
        ->where('status', '2')
        ->orderBy('created_at', 'desc')->get();
        return $query;
    }

    public function getMaterialDetail($id) {
        $query =  $this->db->table('materials')
        ->select('materials.*, material_types.type, colors.color, users.name, gudang, roll, vendor_id, price')
        ->join('material_types', 'material_types.id = materials.material_id')
        ->join('colors', 'colors.id = materials.color_id')
        ->join('gudang', 'gudang.id = materials.gudang_id')
        ->join('material_vendors', 'material_vendors.id = materials.vendor_id')
        ->join('users', 'users.id = materials.user_id')
        ->where('materials.id', $id)
        ->orderBy('created_at', 'desc')->get();
        return $query->getResult();
    }

    public function getAllPolaIn() {
        $query =  $this->db->table('materials')
        ->select('material_patterns.*, weight, material_types.type, colors.color, users.name, gudang, roll, vendor_pola.name as vendor_pola')
        ->join('material_types', 'material_types.id = materials.material_id')
        ->join('colors', 'colors.id = materials.color_id')
        ->join('gudang', 'gudang.id = materials.gudang_id')
        ->join('vendor_pola', 'vendor_pola.id = materials.vendor_pola', 'left')
        ->join('material_patterns', 'material_patterns.material_id = materials.id')
        ->join('users', 'users.id = material_patterns.user_id_in')
        ->where('status', '3')
        ->orderBy('created_at', 'desc')->get();
        return $query;
    }

    public function getAllMaterialStock() {
        $query = $this->db->table('materials')
            ->select('material_types.type, colors.color, SUM(roll) as roll, SUM(weight) as berat')
            ->join('material_types', 'material_types.id = materials.material_id')
            ->join('colors', 'colors.id = materials.color_id')
            ->groupBy('material_types.type')
            ->groupBy('colors.color')
            ->get();
        return $query;
    }

    public function setPolaOut($id, $user) {
        $this->db->query("INSERT INTO material_patterns(material_id, user_id_out) VALUES('$id', '$user') ");
    }

    public function setPolaIn($id, $user) {
        $this->db->query("UPDATE material_patterns SET user_id_in= '$user', updated_at = date('Y-m-d H:i:s') WHERE material_id='$id' ");
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

    public function saveMaterialType($type) {
        $this->db->query("INSERT INTO material_types(type) VALUES('$type') ");
    }

    public function updateMaterialType($id, $type) {
        $this->db->query("UPDATE material_types SET type='$type' WHERE id='$id' ");
    }

    public function deleteMaterialType($id) {
        $this->db->query("DELETE FROM material_types WHERE id='$id' ");
    }

    public function saveWarna($warna) {
        $this->db->query("INSERT INTO colors(color) VALUES('$warna') ");
    }

    public function saveVendorSupplier($vendor) {
        $this->db->query("INSERT INTO supplier_vendors(vendor) VALUES('$vendor') ");
    }

    public function saveVendorPenjualan($vendor) {
        $this->db->query("INSERT INTO selling_vendors(vendor) VALUES('$vendor') ");
    }

    public function getColor($id) {
        $query = $this->db->table('colors')
            ->where('id', $id)->get();
        return $query->getResult();
    }

    public function updateColor($id, $color) {
        $this->db->query("UPDATE colors SET color='$color' WHERE id='$id' ");
    }

    public function deleteColor($id) {
        $this->db->query("DELETE FROM colors WHERE id='$id' ");
    }

    public function getVendorSupplier($id) {
        $query = $this->db->table('material_vendors')
            ->where('id', $id)->get();
        return $query->getResult();
    }

    public function updateVendorSupplier($id, $vendor, $price) {
        $this->db->query("UPDATE material_vendors SET vendor='$vendor', 'price' = '$price' WHERE id='$id' ");
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

    public function updateMaterialStokRetur($id) {
        $this->db->query("UPDATE materials SET qty = qty - 1, status = 0 WHERE id = $id ");
    }

    public function getAllVendorPola() {
        $query = $this->db->table('vendor_pola')->get();
        return $query;
    }

}