<?php

namespace App\Models;

use CodeIgniter\Model;

class LogModel extends Model
{
    protected $table = 'logs';
    protected $allowedFields = ['description', 'user_id', 'created_at'];

    public function getAllLogs() {
        $query = $this->db->table('logs')
            ->select('users.name, logs.description, logs.created_at')
            ->join('users', 'users.id = logs.user_id')
            ->where('date_format(created_at, "%Y-%m-%d") !=', 'CURDATE()', false)
            ->orderBy('created_at', 'desc')
            ->get();
        return $query;
    }

    

    public function getDailyLogs() {
        $query = $this->db->table('logs')
            ->select('users.name, logs.description, logs.created_at')
            ->join('users', 'users.id = logs.user_id')
            ->where('date_format(created_at, "%Y-%m-%d")', 'CURDATE()', false)
            ->orderBy('created_at', 'desc')
            ->get();
        return $query;
    }

    public function saveHistoryStok($data) {
        $this->db->table('history_stok')
            ->insert($data);
    }

}