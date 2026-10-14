<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id_user';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama_lengkap',
        'no_hp',
        'password',
        'role',
        'id_wilayah',
        'status_aktif',
        'created_at'
    ];

    // Dates
    protected $useTimestamps = false; // Set true jika ingin CodeIgniter mengelola timestamp secara otomatis
}