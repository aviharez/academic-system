<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Group;
use App\Models\User;

class Login extends BaseController
{
    public function index()
    {
        return view('login/index');
    }

    public function validateUser(){
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'email' => [
                'label' => 'Email',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ],
        ]);

        if (!$valid) {
            $session_error = [
                'error_email' => $validation->getError(('email')),
                'error_password' => $validation->getError(('password')),
            ];

            session()->setFlashdata($session_error);
            return redirect()->back()->withInput();
        } else {
            $model_login = new User();

            $datauser = $model_login->where('email', $email)->first();

            if ($datauser == null) {
                $session_error = [
                    'error_email' => 'Email/Password tidak valid',
                ];
    
                session()->setFlashdata($session_error);
                return redirect()->back()->withInput();
            } else {
                $password_user = $datauser['pass_user'];
                if (password_verify($password, $password_user)) {
                    $model_group = new Group();
                    $datagroup = $model_group->find($datauser['id_group']);
                    $save_session = [
                        'email' => $email,
                        'namauser' => $datauser['nama_user'],
                        'idgroup' => $datauser['id_group'],
                        'namagroup' => $datagroup['nama_group']
                    ];
                    session()->set($save_session);
                    return redirect()->to('/admin/main/index');
                } else {
                    $session_error = [
                        'error_email' => 'Password tidak valid',
                    ];
        
                    session()->setFlashdata($session_error);
                    return redirect()->back()->withInput();
                }
            }
        }
    }

    public function logout() {
        session()->destroy();
        return redirect()->to('/login/index');
    }
}
