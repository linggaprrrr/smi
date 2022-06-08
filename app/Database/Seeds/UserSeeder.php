<?php

namespace App\Database\Seeds;

use App\Models\UserModel;
use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();
        $data = [
            'name' => 'Gudang Gesit',            
            'username' => 'gesit',
            'password' => password_hash('gesit123', PASSWORD_BCRYPT),
            'role' => 'gudang_1'
        ];
        $userModel->insert($data);
    }
}
