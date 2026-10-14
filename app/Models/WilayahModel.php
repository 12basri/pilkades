<?php

namespace App\Models;

use CodeIgniter\Model;

class WilayahModel extends Model
{
    protected $table            = 'wilayah';
    protected $primaryKey       = 'id_wilayah';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    // Sesuaikan 100% dengan nama kolom di database db_kades
    protected $allowedFields    = [
        'nama_dusun',
        'no_tps',
        'target_suara'
    ];

    // Timestamps Configuration
    protected $useTimestamps    = false; // Diset false karena di MySQL menggunakan default CURRENT_TIMESTAMP
}
