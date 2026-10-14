<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\WilayahModel;

class Users extends BaseController
{
    protected $userModel;
    protected $wilayahModel;

    public function __construct()
    {
        $this->userModel    = new UserModel();
        $this->wilayahModel = new WilayahModel();
    }

    // 1. Tampil Data Users
    public function index()
    {
        $data = [
            'users' => $this->userModel
                ->select('users.*, wilayah.nama_dusun, wilayah.no_tps')
                ->join('wilayah', 'wilayah.id_wilayah = users.id_wilayah', 'left')
                ->orderBy('users.id_user', 'DESC')
                ->findAll()
        ];

        return view('admin/users/index', $data);
    }

    // 2. Form Tambah User
    public function create()
    {
        $data = [
            'wilayah'    => $this->wilayahModel->orderBy('nama_dusun', 'ASC')->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/users/create', $data);
    }

    // 3. Simpan User Baru
    public function store()
    {
        $rules = [
            'nama_lengkap' => 'required|min_length[3]',
            'no_hp'        => 'required|is_unique[users.no_hp]',
            'password'     => 'required|min_length[6]',
            'role'         => 'required|in_list[admin,kordes,relawan,saksi]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $role      = $this->request->getPost('role');
        $idWilayah = ($role === 'admin') ? null : ($this->request->getPost('id_wilayah') ?: null);

        $this->userModel->save([
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'no_hp'        => $this->request->getPost('no_hp'),
            'password'     => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'         => $role,
            'id_wilayah'   => $idWilayah,
            'status_aktif' => 1
        ]);

        return redirect()->to('/admin/users')->with('success', 'User berhasil ditambahkan.');
    }

    // 4. Form Edit User
    public function edit($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'Data user tidak ditemukan.');
        }

        $data = [
            'user'       => $user,
            'wilayah'    => $this->wilayahModel->orderBy('nama_dusun', 'ASC')->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/users/edit', $data);
    }

    // 5. Update User
    public function update($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'Data user tidak ditemukan.');
        }

        $rules = [
            'nama_lengkap' => 'required|min_length[3]',
            'no_hp'        => "required|is_unique[users.no_hp,id_user,{$id}]",
            'role'         => 'required|in_list[admin,kordes,relawan,saksi]',
            'status_aktif' => 'required|in_list[0,1]'
        ];

        // Jika password diisi, tambahkan aturan minimal panjang karakter
        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $role      = $this->request->getPost('role');
        $idWilayah = ($role === 'admin') ? null : ($this->request->getPost('id_wilayah') ?: null);

        $updateData = [
            'id_user'      => $id,
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'no_hp'        => $this->request->getPost('no_hp'),
            'role'         => $role,
            'id_wilayah'   => $idWilayah,
            'status_aktif' => $this->request->getPost('status_aktif')
        ];

        if ($this->request->getPost('password')) {
            $updateData['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->userModel->save($updateData);

        return redirect()->to('/admin/users')->with('success', 'Data user berhasil diperbarui.');
    }

    // 6. Hapus User
    public function delete($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan.');
        }

        $this->userModel->delete($id);
        return redirect()->to('/admin/users')->with('success', 'User berhasil dihapus.');
    }
}
