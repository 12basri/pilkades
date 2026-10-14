<?php

namespace App\Controllers\Kordes;

use App\Controllers\BaseController;
use App\Models\LogistikModel;
use App\Models\DistribusiLogistikModel;
use App\Models\WilayahModel;
use App\Models\UserModel;

class Logistik extends BaseController
{
    protected $logistikModel;
    protected $distribusiModel;
    protected $wilayahModel;
    protected $userModel;

    public function __construct()
    {
        $this->logistikModel   = new LogistikModel();
        $this->distribusiModel = new DistribusiLogistikModel();
        $this->wilayahModel    = new WilayahModel();
        $this->userModel       = new UserModel();
    }

    /**
     * Halaman Utama Logistik (Index)
     */
    public function index()
    {
        $idWilayahUser = session()->get('id_wilayah');

        // Builder Query Distribusi Logistik
        $builder = $this->distribusiModel
            ->select('
                distribusi_logistik.*, 
                logistik.nama_barang, 
                users.nama_lengkap as nama_petugas, 
                wilayah.nama_dusun, 
                wilayah.no_tps
            ')
            ->join('logistik', 'logistik.id_logistik = distribusi_logistik.id_logistik', 'left')
            ->join('users', 'users.id_user = distribusi_logistik.id_petugas', 'left')
            ->join('wilayah', 'wilayah.id_wilayah = distribusi_logistik.id_wilayah', 'left');

        // Filter otomatis khusus wilayah Kordes yang sedang login
        if (!empty($idWilayahUser)) {
            $builder->where('distribusi_logistik.id_wilayah', $idWilayahUser);
        }

        $data = [
            'title'           => 'Kelola Logistik & Distribusi',
            'logistik_list'   => $this->logistikModel->findAll(),
            'distribusi_list' => $builder->orderBy('distribusi_logistik.id_distribusi', 'DESC')->findAll()
        ];

        return view('kordes/logistik/index', $data);
    }
}