<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LogistikModel;
use App\Models\WilayahModel;

class Logistik extends BaseController
{
    protected $logistikModel;
    protected $wilayahModel;

    public function __construct()
    {
        $this->logistikModel = new LogistikModel();
        $this->wilayahModel  = new WilayahModel();
    }

    public function index()
    {
        // Mengambil data logistik beserta nama_dusun dari tabel wilayah
        $logistik = $this->logistikModel
            ->select('logistik.*, wilayah.nama_dusun, wilayah.no_tps')
            ->join('wilayah', 'wilayah.id_wilayah = logistik.id_wilayah', 'left')
            ->orderBy('logistik.id_logistik', 'DESC')
            ->findAll();

        $data = [
            'title'    => 'Kelola Logistik',
            'logistik' => $logistik,
            'wilayah'  => $this->wilayahModel->findAll(),
        ];

        return view('admin/logistik/index', $data);
    }

    public function store()
    {
        $rules = [
            'nama_barang' => 'required|min_length[3]',
            'jumlah'      => 'required|numeric',
            'status'      => 'required|in_list[stok_awal,dikirim,diterima]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idWilayah = $this->request->getPost('id_wilayah');

        $this->logistikModel->save([
            'nama_barang' => $this->request->getPost('nama_barang'),
            'jumlah'      => (int) $this->request->getPost('jumlah'),
            'id_wilayah'  => !empty($idWilayah) ? $idWilayah : null,
            'status'      => $this->request->getPost('status'),
            'keterangan'  => $this->request->getPost('keterangan'),
        ]);

        return redirect()->to('admin/logistik')->with('success', 'Data logistik berhasil ditambahkan.');
    }

    public function update($id = null)
    {
        $barang = $this->logistikModel->find($id);

        if (!$barang) {
            return redirect()->to('admin/logistik')->with('errors', ['Data logistik tidak ditemukan.']);
        }

        $rules = [
            'nama_barang' => 'required|min_length[3]',
            'jumlah'      => 'required|numeric',
            'status'      => 'required|in_list[stok_awal,dikirim,diterima]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idWilayah = $this->request->getPost('id_wilayah');

        $this->logistikModel->update($id, [
            'nama_barang' => $this->request->getPost('nama_barang'),
            'jumlah'      => (int) $this->request->getPost('jumlah'),
            'id_wilayah'  => !empty($idWilayah) ? $idWilayah : null,
            'status'      => $this->request->getPost('status'),
            'keterangan'  => $this->request->getPost('keterangan'),
        ]);

        return redirect()->to('admin/logistik')->with('success', 'Data logistik berhasil diperbarui.');
    }

    public function delete($id = null)
    {
        $barang = $this->logistikModel->find($id);

        if ($barang) {
            $this->logistikModel->delete($id);
            return redirect()->to('admin/logistik')->with('success', 'Barang logistik berhasil dihapus.');
        }

        return redirect()->to('admin/logistik')->with('errors', ['Gagal menghapus data logistik.']);
    }
}
