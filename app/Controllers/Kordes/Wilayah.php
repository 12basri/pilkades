<?php

namespace App\Controllers\Kordes;

use App\Controllers\BaseController;
use App\Models\WilayahModel;
use App\Models\PemilihModel;

class Wilayah extends BaseController
{
    protected $wilayahModel;
    protected $pemilihModel;

    public function __construct()
    {
        $this->wilayahModel = new WilayahModel();
        $this->pemilihModel = new PemilihModel();
    }

    /**
     * Halaman Utama Wilayah (Index)
     */
    public function index()
    {
        $idWilayahUser = session()->get('id_wilayah');

        $builder = $this->wilayahModel
            ->select('wilayah.*, COUNT(pemilih.id_pemilih) as total_pemilih, 
                SUM(CASE WHEN pemilih.status_pemilih = "pasti_pilih" THEN 1 ELSE 0 END) as pasti_pilih')
            ->join('pemilih', 'pemilih.id_wilayah = wilayah.id_wilayah', 'left')
            ->groupBy('wilayah.id_wilayah');

        // Filter khusus wilayah milik Kordes yang sedang login
        if (!empty($idWilayahUser)) {
            $builder->where('wilayah.id_wilayah', $idWilayahUser);
        }

        $data = [
            'title'        => 'Data Wilayah & Target Suara',
            'wilayah_list' => $builder->findAll()
        ];

        return view('kordes/wilayah/index', $data);
    }
}