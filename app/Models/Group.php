<?php

namespace App\Models;

use CodeIgniter\Model;

class Group extends Model
{
    protected $table            = 'access_group';
    protected $primaryKey       = 'id_group';
    protected $allowedFields    = [
        'id_group',
        'nama_group',
    ];
}
