<?php

namespace App\Controllers\Saksi;

use App\Controllers\BaseController;
use App\Models\HasilTpsModel;
use App\Models\PaslonModel;

class Dashboard extends BaseController
{
    protected $hasilTpsModel;
    protected $paslonModel;

    public function __construct()
    {
        $this->hasilTpsModel = new HasilTpsModel();
        $this->paslonModel   = new PaslonModel();
    }

    /**
     * Halaman Utama Dashboard Saksi
     */
    public function index()
    {
        $idSaksi = session()->get('id_user');

        $data = [
            'title'          => 'Dashboard Saksi TPS',
            'tps_info'       => [
                'nomor_tps' => session()->get('tps') ?? '01',
                'dusun'     => session()->get('dusun') ?? 'Dusun I',
                'rt_rw'     => 'RT 01 / RW 01'
            ],
            'total_paslon'   => $this->paslonModel->countAllResults(),
            'status_input'   => $this->hasilTpsModel->where('id_saksi', $idSaksi)->first() ? 'Sudah Input' : 'Belum Input',
            'hasil_suara'    => $this->hasilTpsModel->where('id_saksi', $idSaksi)->findAll()
        ];

        return view('saksi/dashboard', $data);
    }
}