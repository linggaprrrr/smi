<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel = "";
    
    public function __construct()
    {
        $user = session()->get('role');
        if ($user) {            
            if ($user == "administrator") {
                header('Location: '.base_url('/admin/dashboard'));
                exit;
            } elseif ($user == 'gudang_1') {
                header('Location: '.base_url('/gudang-gesit/dashboard'));
                exit;
            } else {
                header('Location: '.base_url('/operasional/dashboard'));
                exit;
            }
        }
        helper('cookie');   
        $this->userModel = new UserModel();
    }

    public function index() {
        return view('login');
    }

    public function loginProccess() {
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $remember = $this->request->getVar('rememberme');
        if (isset($remember)) {                      
            setcookie("sw-username-smi", $username, time()+ (10 * 365 * 24 * 60 * 60));            
            setcookie("sw-pw-smi", $password, time()+ (10 * 365 * 24 * 60 * 60));            
        }
        $user = $this->userModel->getWhere(['username' => $username])->getRow();
        if ($user) {
            if (password_verify($password, $user->password)) {
                $params = [
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'role' => $user->role,
                    'accessibility' => $user->accessibility
                ];
                session()->set($params);
                if ($user->role == "administrator") {
                    return redirect()->to(base_url('/admin/dashboard'))->with('message', 'Login Successful!');
                } elseif ($user->role == "gudang_1") {
                    return redirect()->to(base_url('/gudang-gesit/dashboard'))->with('message', 'Login Successful!');
                } else {
                    return redirect()->to(base_url('/operasional/dashboard'))->with('message', 'Login Successful!');
                }
            } else {
                return redirect()->to(base_url('/'))->with('error', 'Incorrect Password!');
            }
        } else {
            return redirect()->to(base_url('/'))->with('error', 'Username Not Found!');
        }
    }
}
