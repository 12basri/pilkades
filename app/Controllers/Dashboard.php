<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $role = session()->get('role');

        // Redirect otomatis sesuai role pengguna
        switch ($role) {
            case 'admin':
                return redirect()->to('/admin/dashboard');
            case 'kordes':
            case 'kor_rt':
                return redirect()->to('/kordes/dashboard');
            case 'relawan':
                return redirect()->to('/relawan/dashboard');
            case 'saksi':
                return redirect()->to('/saksi/dashboard');
            default:
                return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
    }
}