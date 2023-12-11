<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class FilterMahasiswa implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (session()->idgroup == '') {
            return redirect()->to('/login/index');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        if (session()->idgroup == '3') {
            return redirect()->to('/mahasiswa/main/index');
        }
    }
}
