<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id_user';
    protected $allowedFields    = [
        // 'id_user',
        'nama_user',
        'pass_user',
        'id_group',
        'email'
    ];
}
