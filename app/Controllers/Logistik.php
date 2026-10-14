<?php

namespace App\Controllers;

class Logistik extends BaseController
{
    public function index()
    {
        // Menampilkan halaman index logistik
        return view('logistik/index');
    }

    public function create()
    {
        return view('logistik/input');
    }

    public function store()
    {
        // Proses simpan data logistik
    }
}