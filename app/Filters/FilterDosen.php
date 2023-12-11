<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class FilterDosen implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (session()->idgroup == '') {
            return redirect()->to('/login/index');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        if (session()->idgroup == '2') {
            return redirect()->to('/dosen/main/index');
        }
    }
}
