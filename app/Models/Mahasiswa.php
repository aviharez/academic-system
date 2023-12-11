<?php

namespace App\Models;

use CodeIgniter\Model;

class Mahasiswa extends Model
{
    protected $table            = 'mahasiswa';
    protected $primaryKey       = 'nim';
    protected $allowedFields    = [
        'nim',
        'kd_level',
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat', 
        'program_studi',
        'semester',
        'email'
    ];
}
