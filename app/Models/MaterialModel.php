<?php

namespace App\Models;

use CodeIgniter\Model;

class MaterialModel extends Model
{
    protected $table = 'materials';
    protected $allowedFields = ['material_id', 'color_id', 'weight', 'qrcode', 'status', 'user_id', 'gudang_id', 'updated_at'];

    public function getAllMaterial() {
        $query =  $this->db->table('materials')
        ->select('materials.*, material_types.type, colors.color, users.name, gudang')
        ->join('material_types', 'material_types.id = materials.material_id')
        ->join('colors', 'colors.id = materials.color_id')
        ->join('gudang', 'gudang.id = materials.gudang_id')
        ->join('users', 'users.id = materials.user_id')
        ->where('status', '1')
        ->orderBy('created_at', 'desc')->get();
        return $query;
    }

    public function getAllMaterialQR() {
        $query =  $this->db->table('materials')
        ->select('materials.*, material_types.type, colors.color, users.name, gudang')
        ->join('material_types', 'material_types.id = materials.material_id')
        ->join('colors', 'colors.id = materials.color_id')
        ->join('gudang', 'gudang.id = materials.gudang_id')
        ->join('users', 'users.id = materials.user_id')
        ->where('status', '1')
        ->orderBy('qrcode', 'asc')
        ->orderBy('created_at', 'desc')
        ->get();
        return $query;
    }

    public function getAllMaterialOut() {
        $query =  $this->db->table('materials')
        ->select('materials.*, material_types.type, colors.color, users.name, gudang')
        ->join('material_types', 'material_types.id = materials.material_id')
        ->join('colors', 'colors.id = materials.color_id')
        ->join('gudang', 'gudang.id = materials.gudang_id')
        ->join('users', 'users.id = materials.user_id')
        ->where('status', '2')
        ->orderBy('created_at', 'desc')->get();
        return $query;
    }

    public function getMaterialDetail($id) {
        $query =  $this->db->table('materials')
        ->select('materials.*, material_types.type, colors.color, users.name, gudang')
        ->join('material_types', 'material_types.id = materials.material_id')
        ->join('colors', 'colors.id = materials.color_id')
        ->join('gudang', 'gudang.id = materials.gudang_id')
        ->join('users', 'users.id = materials.user_id')
        ->where('materials.id', $id)
        ->orderBy('created_at', 'desc')->get();
        return $query->getResult();
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
        $query = $this->db->table('supplier_vendors')
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
        $query = $this->db->table('supplier_vendors')
            ->where('id', $id)->get();
        return $query->getResult();
    }

    public function updateVendorSupplier($id, $vendor) {
        $this->db->query("UPDATE supplier_vendors SET vendor='$vendor' WHERE id='$id' ");
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
        $this->db->query("DELETE FROM supplier_vendors WHERE id='$id' ");
    }

    public function deleteVendorSelling($id) {
        $this->db->query("DELETE FROM selling_vendors WHERE id='$id' ");
    }

    public function getAllGudang() {
        $query = $this->db->table('gudang')->get();
        return $query;
    }
}