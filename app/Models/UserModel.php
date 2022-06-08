<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $allowedFields = ['name', 'username', 'password', 'role', 'photo'];

    public function getAllUser() {
        $query = $this->db->table('users')->get();
        return $query;
    }

}