<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DistribusiLogistikModel;
use App\Models\LogistikModel;
use App\Models\UserModel;
use App\Models\WilayahModel;

class Distribusi extends BaseController
{
    protected $distribusiModel;
    protected $logistikModel;
    protected $userModel;
    protected $wilayahModel;
    protected $db;

    public function __construct()
    {
        $this->distribusiModel = new DistribusiLogistikModel();
        $this->logistikModel   = new LogistikModel();
        $this->userModel       = new UserModel();
        $this->wilayahModel    = new WilayahModel();
        $this->db              = \Config\Database::connect();
    }

    public function index()
    {
        $data = [
            'title'      => 'Distribusi Logistik',
            'distribusi' => $this->distribusiModel->getDistribusiLengkap(),
            'logistik'   => $this->logistikModel->where('stok_tersisa >', 0)->findAll(),
            'relawan'    => $this->userModel->whereIn('role', ['kordes', 'relawan'])->where('status_aktif', 1)->findAll(),
            'wilayah'    => $this->wilayahModel->findAll(),
        ];

        return view('admin/distribusi/index', $data);
    }

    public function store()
    {
        $rules = [
            'id_logistik'        => 'required|numeric',
            'id_petugas'         => 'permit_empty|numeric',
            'id_wilayah'         => 'required|numeric',
            'jumlah'             => 'required|numeric|greater_than[0]',
            'tanggal_distribusi' => 'required',
            'status'             => 'permit_empty|in_list[diproses,dikirim,diterima]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idLogistik = (int) $this->request->getPost('id_logistik');
        $jumlah     = (int) $this->request->getPost('jumlah');

        // Cek ketersediaan barang logistik
        $barang = $this->logistikModel->find($idLogistik);
        if (!$barang) {
            return redirect()->back()->withInput()->with('errors', ['Barang logistik tidak ditemukan.']);
        }

        if ($barang['stok_tersisa'] < $jumlah) {
            return redirect()->back()->withInput()->with('errors', ["Stok tersisa tidak mencukupi. Stok saat ini: {$barang['stok_tersisa']}."]);
        }

        // Format tanggal dari input datetime-local (Y-m-d\TH:i) ke format MySQL (Y-m-d H:i:s)
        $tglInput = $this->request->getPost('tanggal_distribusi');
        $tanggal  = date('Y-m-d H:i:s', strtotime($tglInput));

        $this->db->transBegin();

        try {
            // 1. Simpan Data Distribusi (Sesuai kolom tabel: id_petugas & keterangan)
            $this->distribusiModel->save([
                'id_logistik'        => $idLogistik,
                'id_petugas'         => $this->request->getPost('id_petugas') ?: null,
                'id_wilayah'         => $this->request->getPost('id_wilayah'),
                'jumlah'             => $jumlah,
                'tanggal_distribusi' => $tanggal,
                'status'             => $this->request->getPost('status') ?: 'diproses',
                'keterangan'         => $this->request->getPost('keterangan') ?: null,
            ]);

            // 2. Potong Stok Tersisa Logistik secara atomic
            $this->logistikModel
                 ->set('stok_tersisa', "stok_tersisa - {$jumlah}", false)
                 ->update($idLogistik);

            if ($this->db->transStatus() === false) {
                $this->db->transRollback();
                return redirect()->back()->withInput()->with('errors', ['Gagal menyimpan transaksi distribusi.']);
            }

            $this->db->transCommit();
            return redirect()->to('admin/distribusi')->with('success', 'Pencatatan distribusi logistik berhasil disimpan.');

        } catch (\Exception $e) {
            $this->db->transRollback();
            return redirect()->back()->withInput()->with('errors', ['Terjadi kesalahan sistem: ' . $e->getMessage()]);
        }
    }

    public function update($id = null)
    {
        if (empty($id)) {
            return redirect()->to('admin/distribusi')->with('errors', ['ID distribusi tidak valid.']);
        }

        $distribusiLama = $this->distribusiModel->find($id);
        if (!$distribusiLama) {
            return redirect()->to('admin/distribusi')->with('errors', ['Data distribusi tidak ditemukan.']);
        }

        $rules = [
            'id_logistik'        => 'required|numeric',
            'id_petugas'         => 'permit_empty|numeric',
            'id_wilayah'         => 'required|numeric',
            'jumlah'             => 'required|numeric|greater_than[0]',
            'tanggal_distribusi' => 'required',
            'status'             => 'permit_empty|in_list[diproses,dikirim,diterima]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idLogistikBaru = (int) $this->request->getPost('id_logistik');
        $jumlahBaru     = (int) $this->request->getPost('jumlah');
        
        $tglInput = $this->request->getPost('tanggal_distribusi');
        $tanggal  = date('Y-m-d H:i:s', strtotime($tglInput));

        $this->db->transBegin();

        try {
            // 1. Kembalikan stok barang lama terlebih dahulu
            $this->logistikModel
                 ->set('stok_tersisa', "stok_tersisa + {$distribusiLama['jumlah']}", false)
                 ->update($distribusiLama['id_logistik']);

            // 2. Cek kecukupan stok barang baru
            $barangBaru = $this->logistikModel->find($idLogistikBaru);
            if (!$barangBaru || $barangBaru['stok_tersisa'] < $jumlahBaru) {
                $this->db->transRollback();
                return redirect()->back()->withInput()->with('errors', ['Stok tidak mencukupi untuk penyesuaian baru.']);
            }

            // 3. Potong stok barang baru
            $this->logistikModel
                 ->set('stok_tersisa', "stok_tersisa - {$jumlahBaru}", false)
                 ->update($idLogistikBaru);

            // 4. Update data distribusi
            $this->distribusiModel->update($id, [
                'id_logistik'        => $idLogistikBaru,
                'id_petugas'         => $this->request->getPost('id_petugas') ?: null,
                'id_wilayah'         => $this->request->getPost('id_wilayah'),
                'jumlah'             => $jumlahBaru,
                'tanggal_distribusi' => $tanggal,
                'status'             => $this->request->getPost('status') ?: 'diproses',
                'keterangan'         => $this->request->getPost('keterangan') ?: null,
            ]);

            if ($this->db->transStatus() === false) {
                $this->db->transRollback();
                return redirect()->back()->withInput()->with('errors', ['Gagal memperbarui data distribusi.']);
            }

            $this->db->transCommit();
            return redirect()->to('admin/distribusi')->with('success', 'Data distribusi berhasil diperbarui.');

        } catch (\Exception $e) {
            $this->db->transRollback();
            return redirect()->back()->withInput()->with('errors', ['Terjadi kesalahan sistem: ' . $e->getMessage()]);
        }
    }

    public function delete($id = null)
    {
        if (empty($id)) {
            return redirect()->to('admin/distribusi')->with('errors', ['ID distribusi tidak valid.']);
        }

        $distribusi = $this->distribusiModel->find($id);
        if (!$distribusi) {
            return redirect()->to('admin/distribusi')->with('errors', ['Data distribusi tidak ditemukan.']);
        }

        $this->db->transBegin();

        try {
            // 1. Kembalikan stok logistik secara atomic
            $this->logistikModel
                 ->set('stok_tersisa', "stok_tersisa + {$distribusi['jumlah']}", false)
                 ->update($distribusi['id_logistik']);

            // 2. Hapus catatan distribusi
            $this->distribusiModel->delete($id);

            if ($this->db->transStatus() === false) {
                $this->db->transRollback();
                return redirect()->to('admin/distribusi')->with('errors', ['Gagal menghapus data distribusi.']);
            }

            $this->db->transCommit();
            return redirect()->to('admin/distribusi')->with('success', 'Data distribusi berhasil dihapus dan stok telah dikembalikan.');

        } catch (\Exception $e) {
            $this->db->transRollback();
            return redirect()->to('admin/distribusi')->with('errors', ['Terjadi kesalahan sistem: ' . $e->getMessage()]);
        }
    }
}