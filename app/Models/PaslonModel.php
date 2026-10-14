<?php

namespace App\Models;

use CodeIgniter\Model;

class PaslonModel extends Model
{
    protected $table            = 'paslon';
    protected $primaryKey       = 'id_paslon';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['no_urut', 'nama_calon', 'nama_wakil', 'foto'];

    // Matikan Timestamps
    protected $useTimestamps    = false;
}