<?php

namespace App\Models;

use CodeIgniter\Model;

class LogistikModel extends Model
{
    protected $table            = 'logistik';
    protected $primaryKey       = 'id_logistik';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'nama_barang',
        'jumlah',
        'id_wilayah',
        'status',
        'keterangan'
    ];

    protected $useTimestamps = false;

    /**
     * Ambil daftar logistik beserta nama dusun/wilayah penugasan
     */
    public function getLogistikLengkap()
    {
        return $this->select('
                        logistik.*, 
                        wilayah.nama_dusun, 
                        wilayah.no_tps
                    ')
            ->join('wilayah', 'wilayah.id_wilayah = logistik.id_wilayah', 'left')
            ->orderBy('logistik.id_logistik', 'DESC')
            ->findAll();
    }
}
