<?php

namespace App\Models;

use CodeIgniter\Model;

class Dosen extends Model
{
    protected $table            = 'dosen';
    protected $primaryKey       = 'nip';
    protected $allowedFields    = [
        'nip', 'nama', 'jenis_kelamin', 'email'
    ];
}