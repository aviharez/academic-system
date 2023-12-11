<?php

namespace App\Models;

use CodeIgniter\Model;

class Level extends Model
{
    protected $table            = 'level';
    protected $primaryKey       = 'kd_level';
    protected $allowedFields    = [
        'kd_level', 'nama_level', 'kriteria_level'
    ];
}
