<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Main extends BaseController
{
    public function index()
    {
        return view('admin/dashboard/index');
    }
}
