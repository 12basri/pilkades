<?php

namespace App\Controllers;

class Pemilih extends BaseController
{
    public function index()
    {
        // Tampilkan halaman index pemilih
        return view('pemilih/index');
    }
}