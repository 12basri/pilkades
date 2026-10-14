<?php

namespace App\Controllers\Saksi;

use App\Controllers\BaseController;
use App\Models\HasilTpsModel;
use App\Models\PaslonModel;
use App\Models\WilayahModel;

class HasilTps extends BaseController
{
    protected $hasilTpsModel;
    protected $paslonModel;
    protected $wilayahModel;

    public function __construct()
    {
        $this->hasilTpsModel = new HasilTpsModel();
        $this->paslonModel   = new PaslonModel();
        $this->wilayahModel  = new WilayahModel();
    }

    /**
     * Halaman Utama Input Suara & Unggah Foto C1
     */
    public function index()
    {
        $idSaksi   = session()->get('id_user');
        $idWilayah = session()->get('id_wilayah');

        $data = [
            'title'     => 'Input Suara & Foto C1',
            'paslon'    => $this->paslonModel->orderBy('no_urut', 'ASC')->findAll(),
            'hasil_tps' => $this->hasilTpsModel->where('id_saksi', $idSaksi)->findAll()
        ];

        return view('saksi/hasil_tps/index', $data);
    }

    /**
     * Proses Simpan Data Perolehan Suara & File C1
     */
    public function store()
    {
        // 1. Validasi Input Form
        $rules = [
            'suara_paslon.*' => 'required|numeric',
            'foto_c1'        => 'uploaded[foto_c1]|is_image[foto_c1]|mime_in[foto_c1,image/jpg,image/jpeg,image/png]|max_size[foto_c1,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. Ambil ID Saksi dan ID Wilayah dari Session User
        $idSaksi   = session()->get('id_user');
        $idWilayah = session()->get('id_wilayah');

        // Validasi keberadaan Session Wilayah (Mencegah Foreign Key Exception #1452)
        if (!$idWilayah) {
            return redirect()->back()->withInput()->with('errors', ['id_wilayah' => 'Akun Saksi ini belum terhubung ke Wilayah/TPS manapun.']);
        }

        $cekWilayah = $this->wilayahModel->find($idWilayah);
        if (!$cekWilayah) {
            return redirect()->back()->withInput()->with('errors', ['id_wilayah' => 'Data Wilayah/TPS tidak ditemukan di database.']);
        }

        // 3. Proses Upload File Foto C1
        $fileFoto = $this->request->getFile('foto_c1');
        $namaFoto = $fileFoto->getRandomName();
        $fileFoto->move(FCPATH . 'uploads/c1', $namaFoto);

        // 4. Simpan Perolehan Suara per Paslon ke Tabel hasil_tps
        $suaraInput = $this->request->getPost('suara_paslon'); // Array [id_paslon => jumlah_suara]

        if (is_array($suaraInput)) {
            foreach ($suaraInput as $idPaslon => $jumlahSuara) {
                // Hapus data lama jika saksi melakukan input ulang di wilayah yang sama
                $this->hasilTpsModel->where([
                    'id_wilayah' => $idWilayah,
                    'id_paslon'  => $idPaslon
                ])->delete();

                // Insert baris baru sesuai skema database db_kades
                $this->hasilTpsModel->insert([
                    'id_wilayah'      => $idWilayah,
                    'id_saksi'        => $idSaksi,
                    'id_paslon'       => $idPaslon,
                    'jumlah_suara'    => $jumlahSuara,
                    'foto_c1'         => $namaFoto,
                    'status_validasi' => 'pending'
                ]);
            }
        }

        return redirect()->to(base_url('saksi/dashboard'))->with('success', 'Data TPS dan Form C1 berhasil dikirim!');
    }
}
