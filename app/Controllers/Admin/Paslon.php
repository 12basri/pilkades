<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PaslonModel;

class Paslon extends BaseController
{
    protected $paslonModel;

    public function __construct()
    {
        $this->paslonModel = new PaslonModel();
    }

    /**
     * Menampilkan daftar Paslon
     */
    public function index()
    {
        $data['paslon'] = $this->paslonModel->orderBy('no_urut', 'ASC')->findAll();

        return view('admin/paslon/index', $data);
    }

    /**
     * Menampilkan form tambah Paslon
     */
    public function create()
    {
        return view('admin/paslon/create');
    }

    /**
     * Menyimpan data Paslon baru
     */
    public function store()
    {
        $rules = [
            'no_urut'    => 'required|numeric|is_unique[paslon.no_urut]',
            'nama_calon' => 'required|min_length[3]',
            'foto'       => 'max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fotoFile = $this->request->getFile('foto');
        $namaFoto = null;

        if ($fotoFile && $fotoFile->isValid() && !$fotoFile->hasMoved()) {
            $namaFoto = $fotoFile->getRandomName();
            $fotoFile->move('uploads/paslon', $namaFoto);
        }

        $this->paslonModel->save([
            'no_urut'    => $this->request->getPost('no_urut'),
            'nama_calon' => $this->request->getPost('nama_calon'),
            'nama_wakil' => null, // Sembunyikan/kosongkan data wakil
            'foto'       => $namaFoto
        ]);

        return redirect()->to('admin/paslon')->with('success', 'Data Paslon berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit Paslon
     */
    public function edit($id = null)
    {
        $paslon = $this->paslonModel->find($id);

        if (!$paslon) {
            return redirect()->to('admin/paslon')->with('errors', ['Data Paslon tidak ditemukan.']);
        }

        $data['paslon'] = $paslon;
        return view('admin/paslon/edit', $data);
    }

    /**
     * Memperbarui data Paslon
     */
    public function update($id = null)
    {
        $paslon = $this->paslonModel->find($id);

        if (!$paslon) {
            return redirect()->to('admin/paslon')->with('errors', ['Data Paslon tidak ditemukan.']);
        }

        $primaryKey = $this->paslonModel->primaryKey;

        $rules = [
            'no_urut'    => "required|numeric|is_unique[paslon.no_urut,{$primaryKey},{$id}]",
            'nama_calon' => 'required|min_length[3]',
            'foto'       => 'max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fotoFile = $this->request->getFile('foto');
        $namaFoto = $paslon['foto'];

        if ($fotoFile && $fotoFile->isValid() && !$fotoFile->hasMoved()) {
            if ($namaFoto && file_exists('uploads/paslon/' . $namaFoto)) {
                unlink('uploads/paslon/' . $namaFoto);
            }
            $namaFoto = $fotoFile->getRandomName();
            $fotoFile->move('uploads/paslon', $namaFoto);
        }

        $this->paslonModel->update($id, [
            'no_urut'    => $this->request->getPost('no_urut'),
            'nama_calon' => $this->request->getPost('nama_calon'),
            'nama_wakil' => null, // Sembunyikan/kosongkan data wakil
            'foto'       => $namaFoto
        ]);

        return redirect()->to('admin/paslon')->with('success', 'Data Paslon berhasil diperbarui.');
    }

    /**
     * Menghapus data Paslon beserta file foto terkait
     */
    public function delete($id = null)
    {
        $paslon = $this->paslonModel->find($id);

        if ($paslon) {
            if (!empty($paslon['foto']) && file_exists('uploads/paslon/' . $paslon['foto'])) {
                unlink('uploads/paslon/' . $paslon['foto']);
            }

            $this->paslonModel->delete($id);

            return redirect()->to('admin/paslon')->with('success', 'Data Paslon berhasil dihapus.');
        }

        return redirect()->to('admin/paslon')->with('errors', ['Data Paslon gagal dihapus atau tidak ditemukan.']);
    }
}
