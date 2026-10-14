<?php

namespace App\Controllers\Relawan;

use App\Controllers\BaseController;
use App\Models\PemilihModel;
use App\Models\WilayahModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $pemilihModel = new PemilihModel();
        $wilayahModel = new WilayahModel();

        // 1. Ambil ID Wilayah dari session login relawan
        $idWilayah = session()->get('id_wilayah') ?? session()->get('wilayah_id');

        // Jika session belum terset, beri nilai default 0
        if (!$idWilayah) {
            $idWilayah = 0;
        }

        // 2. Ambil data detail wilayah berdasarkan id_wilayah
        $wilayah = $wilayahModel->find($idWilayah);

        // 3. Hitung Agregat Data Pemilih berdasarkan id_wilayah
        $targetPemilih = $pemilihModel->where('id_wilayah', $idWilayah)
                                      ->countAllResults();

        $terdataMemilih = $pemilihModel->where('id_wilayah', $idWilayah)
                                       ->where('status_pemilih', 'pasti_pilih')
                                       ->countAllResults();

        $perluKunjungan = $pemilihModel->where('id_wilayah', $idWilayah)
                                       ->where('status_pemilih', 'ragu_ragu')
                                       ->countAllResults();

        // 4. Ambil 5 data pemilih terbaru di wilayah tersebut
        $pemilihTerbaru = $pemilihModel->where('id_wilayah', $idWilayah)
                                       ->orderBy('updated_at', 'DESC')
                                       ->findAll(5);

        // 5. Data disalurkan ke View
        $data = [
            'wilayah'          => $wilayah,
            'target_pemilih'   => $targetPemilih,
            'terdata_memilih'  => $terdataMemilih,
            'perlu_kunjungan'  => $perluKunjungan,
            'pemilih_terbaru'  => $pemilihTerbaru,
        ];

        return view('relawan/dashboard', $data);
    }
}