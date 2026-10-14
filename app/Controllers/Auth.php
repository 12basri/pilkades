<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function index()
    {
        // Jika sudah login, arahkan langsung sesuai rolenya
        if (session()->get('isLoggedIn')) {
            return $this->redirectByRole(session()->get('role'));
        }
        return view('auth/login');
    }

    public function loginProcess()
    {
        $session   = session();
        $userModel = new UserModel();

        $noHp    = $this->request->getPost('no_hp');
        $password = $this->request->getPost('password');

        $user = $userModel->where('no_hp', $noHp)->first();

        if ($user) {
            // Cek status aktif user
            if ((int)$user['status_aktif'] === 0) {
                $session->setFlashdata('error', 'Akun Anda tidak aktif. Hubungi Admin.');
                return redirect()->back()->withInput();
            }

            // Verifikasi Password Hash (dukung fallback plain-text jika data lama belum ter-hash)
            $isPasswordValid = password_verify($password, $user['password']) || $password === $user['password'];

            if ($isPasswordValid) {
                $sessionData = [
                    'id_user'      => $user['id_user'],
                    'nama_lengkap' => $user['nama_lengkap'],
                    'role'         => $user['role'],        // 'admin', 'relawan', atau 'saksi'
                    'id_wilayah'   => $user['id_wilayah'],  // ID Dusun/TPS penugasan
                    'isLoggedIn'   => true,
                ];
                $session->set($sessionData);

                // Redirect sesuai role
                return $this->redirectByRole($user['role']);
            }

            $session->setFlashdata('error', 'Password salah.');
            return redirect()->back()->withInput();
        }

        $session->setFlashdata('error', 'Nomor HP tidak terdaftar.');
        return redirect()->back()->withInput();
    }

    /**
     * Helper privat untuk menentukan halaman tujuan berdasarkan role user
     */
    private function redirectByRole($role)
    {
        switch ($role) {
            case 'admin':
                return redirect()->to('/admin/dashboard');
            case 'relawan':
                return redirect()->to('/relawan/pemilih');
            case 'saksi':
                return redirect()->to('/saksi/hasil-tps');
            default:
                return redirect()->to('/login');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
