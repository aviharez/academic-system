<?php

namespace App\Models;

use CodeIgniter\Model;

class Krs extends Model
{
    protected $table            = 'krs';
    protected $primaryKey       = 'kd_krs';
    protected $allowedFields    = [
        'kd_krs',
        'kd_mk',
        'nip',
        'semester',
        'thn_ajaran',
        'sks',
        'hari',
        'jam',
        'harga'
    ];
}
