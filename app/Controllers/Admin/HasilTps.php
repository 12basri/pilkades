<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\HasilTpsModel;
use App\Models\PaslonModel;
use App\Models\UserModel;
use App\Models\WilayahModel;

class HasilTps extends BaseController
{
    protected $hasilTpsModel;
    protected $paslonModel;
    protected $userModel;
    protected $wilayahModel;

    public function __construct()
    {
        $this->hasilTpsModel = new HasilTpsModel();
        $this->paslonModel   = new PaslonModel();
        $this->userModel     = new UserModel();
        $this->wilayahModel  = new WilayahModel();
    }

    public function index()
    {
        $data = [
            'title'   => 'Hasil Perhitungan TPS',
            'hasil'   => $this->hasilTpsModel->getHasilLengkap(),
            'paslon'  => $this->paslonModel->findAll(),
            'saksi'   => $this->userModel->where('role', 'saksi')->findAll(),
            'wilayah' => $this->wilayahModel->findAll(),
        ];

        return view('admin/hasil_tps/index', $data);
    }

    public function store()
    {
        $rules = [
            'id_wilayah'   => 'required|numeric|is_not_unique[wilayah.id_wilayah]',
            'id_saksi'     => 'required|numeric|is_not_unique[users.id_user]',
            'id_paslon'    => 'required|numeric|is_not_unique[paslon.id_paslon]',
            'jumlah_suara' => 'required|numeric|greater_than_equal_to[0]',
            'foto_c1'      => 'max_size[foto_c1,2048]|is_image[foto_c1]|mime_in[foto_c1,image/jpg,image/jpeg,image/png]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fileFoto = $this->request->getFile('foto_c1');
        $namaFoto = null;

        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move(FCPATH . 'uploads/c1', $namaFoto);
        }

        $this->hasilTpsModel->save([
            'id_wilayah'      => $this->request->getPost('id_wilayah'),
            'id_saksi'        => $this->request->getPost('id_saksi'),
            'id_paslon'       => $this->request->getPost('id_paslon'),
            'jumlah_suara'    => $this->request->getPost('jumlah_suara'),
            'foto_c1'         => $namaFoto,
            'status_validasi' => 'pending',
        ]);

        return redirect()->to('admin/hasil-tps')->with('success', 'Data hasil TPS berhasil ditambahkan.');
    }

    public function update($id = null)
    {
        $dataLama = $this->hasilTpsModel->find($id);

        if (!$dataLama) {
            return redirect()->to('admin/hasil-tps')->with('errors', ['Data hasil TPS tidak ditemukan.']);
        }

        $rules = [
            'id_wilayah'   => 'required|numeric|is_not_unique[wilayah.id_wilayah]',
            'id_saksi'     => 'required|numeric|is_not_unique[users.id_user]',
            'id_paslon'    => 'required|numeric|is_not_unique[paslon.id_paslon]',
            'jumlah_suara' => 'required|numeric|greater_than_equal_to[0]',
            'foto_c1'      => 'max_size[foto_c1,2048]|is_image[foto_c1]|mime_in[foto_c1,image/jpg,image/jpeg,image/png]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fileFoto = $this->request->getFile('foto_c1');
        $namaFoto = $dataLama['foto_c1'];

        // Jika ada unggahan foto C1 baru
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move(FCPATH . 'uploads/c1', $namaFoto);

            // Hapus foto C1 lama jika ada
            if ($dataLama['foto_c1'] && file_exists(FCPATH . 'uploads/c1/' . $dataLama['foto_c1'])) {
                unlink(FCPATH . 'uploads/c1/' . $dataLama['foto_c1']);
            }
        }

        $this->hasilTpsModel->update($id, [
            'id_wilayah'   => $this->request->getPost('id_wilayah'),
            'id_saksi'     => $this->request->getPost('id_saksi'),
            'id_paslon'    => $this->request->getPost('id_paslon'),
            'jumlah_suara' => $this->request->getPost('jumlah_suara'),
            'foto_c1'      => $namaFoto,
        ]);

        return redirect()->to('admin/hasil-tps')->with('success', 'Data hasil TPS berhasil diperbarui.');
    }

    public function updateStatus($id = null)
    {
        $status = $this->request->getPost('status_validasi');

        if ($id && in_array($status, ['pending', 'terverifikasi', 'ditolak'])) {
            $this->hasilTpsModel->update($id, ['status_validasi' => $status]);
            return redirect()->to('admin/hasil-tps')->with('success', 'Status validasi berhasil diperbarui.');
        }

        return redirect()->to('admin/hasil-tps')->with('errors', ['Gagal memperbarui status validasi.']);
    }

    public function delete($id = null)
    {
        $hasil = $this->hasilTpsModel->find($id);

        if ($hasil) {
            // Hapus file fisik C1 jika ada
            if ($hasil['foto_c1'] && file_exists(FCPATH . 'uploads/c1/' . $hasil['foto_c1'])) {
                unlink(FCPATH . 'uploads/c1/' . $hasil['foto_c1']);
            }

            $this->hasilTpsModel->delete($id);
            return redirect()->to('admin/hasil-tps')->with('success', 'Data hasil TPS berhasil dihapus.');
        }

        return redirect()->to('admin/hasil-tps')->with('errors', ['Data tidak ditemukan.']);
    }
}
