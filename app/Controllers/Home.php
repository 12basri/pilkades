<?php

namespace App\Controllers;

use App\Models\PaslonModel;

class Home extends BaseController
{
    /**
     * Instance dari PaslonModel
     *
     * @var PaslonModel
     */
    protected $paslonModel;

    public function __construct()
    {
        $this->paslonModel = new PaslonModel();
    }

    /**
     * Halaman Utama / Beranda
     */
    public function index(): string
    {
        $data = [
            'title'  => 'Beranda Utama',
            'paslon' => $this->paslonModel->orderBy('no_urut', 'ASC')->findAll(),
        ];

        return view('pages/index', $data);
    }

    /**
     * Halaman Detail/Daftar Pasangan Calon
     */
    public function paslon(): string
    {
        $data = [
            'title'  => 'Daftar Pasangan Calon',
            'paslon' => $this->paslonModel->orderBy('no_urut', 'ASC')->findAll(),
        ];

        return view('pages/paslon', $data);
    }

    /**
     * Halaman Informasi Publik
     */
    public function informasi(): string
    {
        $data = [
            'title' => 'Informasi Publik',
        ];

        return view('pages/informasi', $data);
    }
}