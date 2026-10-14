<?php

namespace App\Models;

use CodeIgniter\Model;

class PemilihModel extends Model
{
    protected $table            = 'pemilih';
    protected $primaryKey       = 'id_pemilih';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    // Kolom yang diizinkan untuk diisi via insert/update
    protected $allowedFields    = [
        'nik',
        'nama',
        'jenis_kelamin',
        'usia',
        'alamat',
        'id_wilayah',
        'id_relawan',
        'status_pemilih',
        'keterangan_aspirasi'
    ];

    // Dates & Timestamps (Ubah ke true jika tabel 'pemilih' memiliki kolom created_at & updated_at)
    protected $useTimestamps   = false;
    protected $dateFormat      = 'datetime';
    protected $createdField    = 'created_at';
    protected $updatedField    = 'updated_at';

    // Validation Rules bawaan Model untuk menjaga integritas data
    protected $validationRules = [
        'nama'           => 'required|min_length[3]|max_length[255]',
        'jenis_kelamin'  => 'required|in_list[L,P]',
        'id_wilayah'     => 'required|numeric',
        'nik'            => 'permit_empty|numeric|exact_length[16]',
        'status_pemilih' => 'permit_empty|in_list[belum_didata,pasti_pilih,ragu_ragu,lawan]',
    ];

    protected $validationMessages = [
        'nama' => [
            'required'   => 'Nama pemilih wajib diisi.',
            'min_length' => 'Nama pemilih minimal 3 karakter.',
        ],
        'jenis_kelamin' => [
            'required'   => 'Jenis kelamin wajib dipilih.',
            'in_list'    => 'Jenis kelamin harus L (Laki-laki) atau P (Perempuan).',
        ],
        'id_wilayah' => [
            'required'   => 'Wilayah wajib dipilih.',
            'numeric'    => 'ID Wilayah harus berupa angka.',
        ],
        'nik' => [
            'numeric'      => 'NIK harus berupa angka.',
            'exact_length' => 'NIK harus persis 16 digit.',
        ],
        'status_pemilih' => [
            'in_list'    => 'Status pemilih tidak valid.',
        ],
    ];

    protected $skipValidation = false;
}