<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
    protected $userModel = "";

    public function __construct() {
        $userId = session()->get('user_id');
        if (is_null($userId)) {            
            header('Location: '.base_url('/'));
            exit(); 
        }
        $this->userModel = new UserModel();
    }

    public function index() {
        $users = $this->userModel->getAllUser();
        $data = array(
            'title' => 'Pengguna',
            'users' => $users
        );
        return view('admin/user', $data);    
    }

    public function settings() {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);
        $data = array(
            'title' => 'Pengaturan'
        );
        return view('admin/settings', $data);
    }

}
