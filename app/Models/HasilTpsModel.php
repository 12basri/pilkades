<?php

namespace App\Models;

use CodeIgniter\Model;

class HasilTpsModel extends Model
{
    protected $table            = 'hasil_tps';
    protected $primaryKey       = 'id_hasil';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_wilayah',
        'id_saksi',
        'id_paslon',
        'jumlah_suara',
        'foto_c1',
        'status_validasi'
    ];

    public function getHasilLengkap()
    {
        return $this->select('hasil_tps.*, paslon.no_urut, paslon.nama_calon, users.nama_lengkap as nama_saksi, wilayah.nama_dusun, wilayah.no_tps')
                    ->join('paslon', 'paslon.id_paslon = hasil_tps.id_paslon', 'left')
                    ->join('users', 'users.id_user = hasil_tps.id_saksi', 'left')
                    ->join('wilayah', 'wilayah.id_wilayah = hasil_tps.id_wilayah', 'left')
                    ->orderBy('hasil_tps.id_hasil', 'DESC')
                    ->findAll();
    }
}