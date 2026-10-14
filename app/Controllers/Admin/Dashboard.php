<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PemilihModel;
use App\Models\WilayahModel;
use App\Models\LogistikModel;

class Dashboard extends BaseController
{
    protected $pemilihModel;
    protected $wilayahModel;
    protected $logistikModel;

    public function __construct()
    {
        $this->pemilihModel  = new PemilihModel();
        $this->wilayahModel  = new WilayahModel();
        $this->logistikModel = new LogistikModel();
    }

    public function index()
    {
        // 1. Data Ringkasan KPI Cards
        $totalDpt         = $this->pemilihModel->countAllResults();
        $targetPemenangan = $this->wilayahModel->selectSum('target_suara')->first()['target_suara'] ?? 0;

        $pemilihPasti     = $this->pemilihModel->where('status_pemilih', 'pasti_pilih')->countAllResults();
        $pemilihRagu      = $this->pemilihModel->where('status_pemilih', 'ragu_ragu')->countAllResults();
        $pemilihLawan     = $this->pemilihModel->where('status_pemilih', 'lawan')->countAllResults();
        $pemilihBelum     = $this->pemilihModel->where('status_pemilih', 'belum_didata')->countAllResults();

        // Hitung total TPS unik (mengabaikan nilai NULL jika ada dusun belum memiliki TPS)
        $totalTps         = $this->wilayahModel->where('no_tps IS NOT NULL')->select('COUNT(DISTINCT no_tps) as total')->first()['total'] ?? 0;

        // 2. Data Grafik 1: Target Suara vs Pemilih Pasti per Dusun
        $grafikWilayahRaw = $this->wilayahModel
            ->select('wilayah.nama_dusun, MAX(wilayah.target_suara) as target_dusun, SUM(CASE WHEN pemilih.status_pemilih = "pasti_pilih" THEN 1 ELSE 0 END) as total_pasti')
            ->join('pemilih', 'pemilih.id_wilayah = wilayah.id_wilayah', 'left')
            ->groupBy('wilayah.id_wilayah, wilayah.nama_dusun')
            ->findAll();

        $labelsDusun = [];
        $dataTarget  = [];
        $dataPasti   = [];

        foreach ($grafikWilayahRaw as $row) {
            $labelsDusun[] = $row['nama_dusun'];
            $dataTarget[]  = (int) $row['target_dusun'];
            $dataPasti[]   = (int) $row['total_pasti'];
        }

        // 3. Data Grafik 2: Logistik Terdistribusi per Dusun (Tabel Logistik Baru)
        $logistikRaw = $this->logistikModel
            ->select('wilayah.nama_dusun, SUM(logistik.jumlah) as total')
            ->join('wilayah', 'wilayah.id_wilayah = logistik.id_wilayah', 'left')
            ->groupBy('logistik.id_wilayah')
            ->findAll();

        $labelsLogistik = [];
        $dataLogistik   = [];

        foreach ($logistikRaw as $row) {
            $labelsLogistik[] = $row['nama_dusun'] ?? 'Stok Pusat';
            $dataLogistik[]   = (int) $row['total'];
        }

        $data = [
            'totalDpt'         => $totalDpt,
            'targetPemenangan' => $targetPemenangan,
            'pemilihPasti'     => $pemilihPasti,
            'totalTps'         => $totalTps,

            'chartWilayah' => [
                'labels' => $labelsDusun,
                'target' => $dataTarget,
                'pasti'  => $dataPasti,
            ],
            'chartKlasifikasi' => [
                'pasti' => $pemilihPasti,
                'ragu'  => $pemilihRagu,
                'lawan' => $pemilihLawan,
                'belum' => $pemilihBelum,
            ],
            'chartLogistik' => [
                'labels' => $labelsLogistik,
                'data'   => $dataLogistik,
            ]
        ];

        return view('admin/dashboard', $data);
    }
}
