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
    
    public function logout() {
        $data = array(
            'user_id', 'name', 'role'
        );
        session()->remove($data);
        
        return redirect()->to(base_url('/'));
    }

    public function saveUser() {
        $post = $this->request->getVar();
        $newUser = [
            'name' => $post['nama'],
            'username' => $post['username'],
            'password' => password_hash($post['new_password'], PASSWORD_BCRYPT),
            'role' => $post['role'],
        ];
        $this->userModel->save($newUser);
        return redirect()->back()->with('create', 'User berhasil ditambahkan');
    }

    public function getUser() {
        $userId = $this->request->getVar('user_id');
        $user = $this->userModel->find($userId);
        echo json_encode($user);
    }

    public function updateUser() {
        $post = $this->request->getVar();
        $newUser = [
            'id' => $post['id'],
            'name' => $post['nama'],
            'password' => password_hash($post['new_password'], PASSWORD_BCRYPT),
            'role' => $post['role'],
        ];
        $this->userModel->save($newUser);
        return redirect()->back()->with('update', 'User berhasil diupdate');
    }

    public function deleteUser() {
        $id = $this->request->getVar('user_id');
        $this->userModel->where('id', $id)->delete();
        return redirect()->back()->with('Delete', 'User berhasil dihapus');

    }

}
