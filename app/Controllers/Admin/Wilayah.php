<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\WilayahModel;

class Wilayah extends BaseController
{
    protected $wilayahModel;

    public function __construct()
    {
        $this->wilayahModel = new WilayahModel();
    }

    /**
     * Menampilkan daftar Wilayah Penugasan / TPS
     */
    public function index()
    {
        $keyword = $this->request->getGet('search');

        if (!empty($keyword)) {
            $data['wilayah'] = $this->wilayahModel
                ->groupStart()
                ->like('nama_dusun', $keyword)
                ->orLike('no_tps', $keyword)
                ->groupEnd()
                ->orderBy('nama_dusun', 'ASC')
                ->orderBy('no_tps', 'ASC')
                ->findAll();
        } else {
            $data['wilayah'] = $this->wilayahModel
                ->orderBy('nama_dusun', 'ASC')
                ->orderBy('no_tps', 'ASC')
                ->findAll();
        }

        $data['search'] = $keyword;

        return view('admin/wilayah/index', $data);
    }

    /**
     * Menyimpan data Wilayah baru
     */
    public function store()
    {
        // Fleksibilitas penangkapan nama input dari form HTML (mencegah NULL)
        $namaDusun   = trim((string) ($this->request->getPost('nama_dusun') ?? $this->request->getPost('dusun')));
        $noTps       = trim((string) ($this->request->getPost('no_tps') ?? $this->request->getPost('tps')));
        $targetSuara = (int) ($this->request->getPost('target_suara') ?? 0);

        // Validasi Manual
        if (empty($namaDusun)) {
            return redirect()->back()->withInput()->with('errors', ['Nama Dusun wajib diisi.']);
        }

        if (empty($noTps)) {
            return redirect()->back()->withInput()->with('errors', ['Nomor TPS wajib diisi.']);
        }

        // Cek Duplikasi Kombinasi (Nama Dusun + No TPS)
        $isExist = $this->wilayahModel
            ->where('nama_dusun', $namaDusun)
            ->where('no_tps', $noTps)
            ->first();

        if ($isExist) {
            return redirect()->back()->withInput()->with('errors', [
                "TPS {$noTps} untuk Dusun '{$namaDusun}' sudah terdaftar dalam sistem."
            ]);
        }

        $this->wilayahModel->insert([
            'nama_dusun'   => $namaDusun,
            'no_tps'       => $noTps,
            'target_suara' => $targetSuara,
        ]);

        return redirect()->to('admin/wilayah')->with('success', 'Data wilayah berhasil ditambahkan.');
    }

    /**
     * Memperbarui data Wilayah
     */
    public function update($id = null)
    {
        if (empty($id)) {
            return redirect()->to('admin/wilayah')->with('errors', ['ID wilayah tidak valid.']);
        }

        $wilayah = $this->wilayahModel->find($id);

        if (!$wilayah) {
            return redirect()->to('admin/wilayah')->with('errors', ['Data wilayah tidak ditemukan.']);
        }

        // Fleksibilitas penangkapan nama input dari form HTML
        $namaDusun   = trim((string) ($this->request->getPost('nama_dusun') ?? $this->request->getPost('dusun')));
        $noTps       = trim((string) ($this->request->getPost('no_tps') ?? $this->request->getPost('tps')));
        $targetSuara = (int) ($this->request->getPost('target_suara') ?? 0);

        if (empty($namaDusun)) {
            return redirect()->back()->withInput()->with('errors', ['Nama Dusun wajib diisi.']);
        }

        if (empty($noTps)) {
            return redirect()->back()->withInput()->with('errors', ['Nomor TPS wajib diisi.']);
        }

        $primaryKey = $this->wilayahModel->primaryKey;

        // Cek Duplikasi Kombinasi kecuali data itu sendiri
        $isExist = $this->wilayahModel
            ->where('nama_dusun', $namaDusun)
            ->where('no_tps', $noTps)
            ->where("{$primaryKey} !=", $id)
            ->first();

        if ($isExist) {
            return redirect()->back()->withInput()->with('errors', [
                "TPS {$noTps} untuk Dusun '{$namaDusun}' sudah terdaftar pada data lain."
            ]);
        }

        $this->wilayahModel->update($id, [
            'nama_dusun'   => $namaDusun,
            'no_tps'       => $noTps,
            'target_suara' => $targetSuara,
        ]);

        return redirect()->to('admin/wilayah')->with('success', 'Data wilayah berhasil diperbarui.');
    }

    /**
     * Menghapus data Wilayah
     */
    public function delete($id = null)
    {
        if (empty($id)) {
            return redirect()->to('admin/wilayah')->with('errors', ['ID wilayah tidak valid.']);
        }

        $wilayah = $this->wilayahModel->find($id);

        if ($wilayah) {
            $this->wilayahModel->delete($id);
            return redirect()->to('admin/wilayah')->with('success', 'Data wilayah berhasil dihapus.');
        }

        return redirect()->to('admin/wilayah')->with('errors', ['Data wilayah tidak ditemukan atau gagal dihapus.']);
    }
}
