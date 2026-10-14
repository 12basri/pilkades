<?php

namespace App\Controllers\Relawan;

use App\Controllers\BaseController;
use App\Models\PemilihModel;
use App\Models\WilayahModel;

class Pemilih extends BaseController
{
    protected $pemilihModel;
    protected $wilayahModel;

    public function __construct()
    {
        $this->pemilihModel = new PemilihModel();
        $this->wilayahModel = new WilayahModel();
    }

    /**
     * Halaman Utama Daftar Pemilih Relawan + Search + Pagination
     */
    public function index()
    {
        // Mengambil ID User Relawan dari session login
        $idRelawan = session()->get('id_user');
        $keyword   = $this->request->getGet('keyword');

        $builder = $this->pemilihModel
            ->select('pemilih.*, wilayah.nama_dusun, wilayah.no_tps')
            ->join('wilayah', 'wilayah.id_wilayah = pemilih.id_wilayah', 'left')
            ->where('pemilih.id_relawan', $idRelawan);

        // Fitur Pencarian
        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('pemilih.nama', $keyword)
                ->orLike('pemilih.nik', $keyword)
                ->orLike('pemilih.alamat', $keyword)
            ->groupEnd();
        }

        $perPage = 10; // Jumlah baris per halaman

        $data = [
            'title'        => 'Data Pemilih Terdata',
            'pemilih_list' => $builder->orderBy('pemilih.updated_at', 'DESC')->paginate($perPage, 'pemilih'),
            'pager'        => $this->pemilihModel->pager,
            'keyword'      => $keyword
        ];

        return view('relawan/pemilih/index', $data);
    }

    /**
     * Form Tambah Pemilih Baru
     */
    public function create()
    {
        $data = [
            'title'   => 'Tambah Data Pemilih Baru',
            'wilayah' => $this->wilayahModel->findAll()
        ];

        return view('relawan/pemilih/create', $data);
    }

    /**
     * Simpan Data Pemilih Baru
     */
    public function store()
    {
        $rules = [
            'nama'           => 'required|min_length[3]',
            'nik'            => 'permit_empty|numeric|exact_length[16]',
            'jenis_kelamin'  => 'required|in_list[L,P]',
            'usia'           => 'permit_empty|numeric',
            'id_wilayah'     => 'required|numeric',
            'status_pemilih' => 'required|in_list[belum_didata,pasti_pilih,ragu_ragu,lawan]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idRelawan = session()->get('id_user');

        $this->pemilihModel->save([
            'nik'                 => $this->request->getPost('nik') ?: null,
            'nama'                => $this->request->getPost('nama'),
            'jenis_kelamin'       => $this->request->getPost('jenis_kelamin'),
            'usia'                => $this->request->getPost('usia') ?: null,
            'alamat'              => $this->request->getPost('alamat'),
            'id_wilayah'          => $this->request->getPost('id_wilayah'),
            'id_relawan'          => $idRelawan,
            'status_pemilih'      => $this->request->getPost('status_pemilih'),
            'keterangan_aspirasi' => $this->request->getPost('keterangan_aspirasi')
        ]);

        return redirect()->to(base_url('relawan/pemilih'))->with('success', 'Data pemilih berhasil ditambahkan!');
    }
}