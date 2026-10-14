<?php

namespace App\Controllers\Kordes;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        // Tampilkan view dashboard kordes
        return view('kordes/dashboard');
    }
}