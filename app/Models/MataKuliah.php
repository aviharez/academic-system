<?php

namespace App\Models;

use CodeIgniter\Model;

class MataKuliah extends Model
{
    protected $table            = 'mata_kuliah';
    protected $primaryKey       = 'kd_mk';
    protected $allowedFields    = [
        'kd_mk', 'nama_mk', 'sks', 'harga'
    ];
}
