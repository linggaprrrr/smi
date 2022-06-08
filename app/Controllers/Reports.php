<?php

namespace App\Controllers;

class Reports extends BaseController
{
    public function __construct() { 
        $userId = session()->get('user_id');
        if (is_null($userId)) {            
            header('Location: '.base_url('/'));
            exit(); 
        }
    }

    public function index() {
        $data = array(
            'title' => 'Laporan'
        );
        return view('admin/reports', $data);    
    }
}
