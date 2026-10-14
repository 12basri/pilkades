<?php

namespace App\Models;

use CodeIgniter\Model;

class DistribusiLogistikModel extends Model
{
    protected $table            = 'distribusi_logistik';
    protected $primaryKey       = 'id_distribusi';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'id_logistik',
        'id_wilayah',
        'id_petugas',
        'jumlah',
        'tanggal_distribusi',
        'status',
        'keterangan'
    ];

    protected $useTimestamps = false;

    // Ambil data distribusi lengkap dengan nama logistik, petugas, dan wilayah
    public function getDistribusiLengkap()
    {
        return $this->select('
                        distribusi_logistik.*, 
                        logistik.nama_barang, 
                        users.nama_lengkap as nama_petugas, 
                        users.role as role_petugas,
                        wilayah.nama_dusun, 
                        wilayah.no_tps
                    ')
                    ->join('logistik', 'logistik.id_logistik = distribusi_logistik.id_logistik', 'left')
                    ->join('users', 'users.id_user = distribusi_logistik.id_petugas', 'left')
                    ->join('wilayah', 'wilayah.id_wilayah = distribusi_logistik.id_wilayah', 'left')
                    ->orderBy('distribusi_logistik.id_distribusi', 'DESC')
                    ->findAll();
    }

    // Ambil daftar petugas (Kordes & Relawan) untuk isi Option Select
    public function getDaftarPetugas()
    {
        return $this->db->table('users')
                        ->select('id_user, nama_lengkap, role, id_wilayah')
                        ->whereIn('role', ['kordes', 'relawan'])
                        ->where('status_aktif', 1)
                        ->get()
                        ->getResultArray();
    }
}