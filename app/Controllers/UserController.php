<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Group;
use App\Models\User;
use Hermawan\DataTables\DataTable;

class UserController extends BaseController
{
    public function index()
    {
        return view('admin/user/index');
    }

    public function getDataAdmin() {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $builder = $db->table('users')->select('id_user, nama_user, email, id_group');

            return DataTable::of($builder)
                ->addNumbering()
                ->add('action', function($row){
                    return '<button type="button" class="btn btn-sm btn-info" title="Ubah Data" onclick="updateData(\''.$row->id_user.'\')"><i class="fas fa-edit"></i></button>
                    <button type="button" class="btn btn-sm btn-danger" title="Hapus Data" onclick="deleteData(\''.$row->id_user.'\')"><i class="fas fa-trash-alt"></i></button>';
                }, 'last')
                ->format('id_group', function($value){
                    $badge = $value == 1 ? 'badge-danger' : ($value == 2 ? 'badge-info' : 'badge-success');
                    return '<span class="badge '.$badge.'">'.$this->getGroupName($value).'</span>';
                })
                ->hide('id_user')
                ->toJson();
        }
    }

    private function getGroupName($id): string {
        $model_group = new Group();
        $row_group = $model_group->find($id);
        if ($row_group) {
            return $row_group['nama_group'];
        } else {
            return '';
        }
    }

    public function getAllGroupData() {
        if ($this->request->isAJAX()) {
            $model_group = new Group();
            $data = $model_group->findAll();
            $json = [
                'data' => $data
            ];
            echo json_encode($json);
        }
    }

    public function getSelectedUserData($id_user) {
        if ($this->request->isAJAX()) {
            $model_user = new User();
            $row_user = $model_user->find($id_user);
            $data = [
                'id_user' => $row_user['id_user'],
                'nama_user' => $row_user['nama_user'],
                'id_group' => $row_user['id_group'],
                'email' => $row_user['email']
            ];
            $json = [
                'data' => $data
            ];
            echo json_encode($json);
        }
    }

    public function saveData() {
        if ($this->request->isAJAX()) {
            $nama_user = $this->request->getPost('nama_user');
            $id_group = $this->request->getPost('id_group');
            $pass_user = $this->request->getPost('pass_user');
            $email = $this->request->getPost('email');

            $rules = $this->validate([
                'nama_user' => [
                    'label' => 'Nama User',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'id_group' => [
                    'label' => 'Group',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'pass_user' => [
                    'label' => 'Password',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'email' => [
                    'label' => 'Email',
                    'rules' => 'required|is_unique[users.email]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} sudah terdaftar'
                    ]
                ],
            ]);

            if (!$rules) {
                $validation = \Config\Services::validation();

                $error = [
                    'errorNama' => $validation->getError('nama_user'),
                    'errorPass' => $validation->getError('pass_user'),
                    'errorEmail' => $validation->getError('email'),
                    'errorGroup' => $validation->getError('id_group'),
                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $model_user = new User();
                $model_user->insert([
                    'nama_user' => $nama_user,
                    'id_group' => $id_group,
                    'email' => $email,
                    'pass_user' => password_hash($pass_user, PASSWORD_BCRYPT)
                ]);

                $json = [
                    'success' => 'Data user berhasil disimpan'
                ];
            }

            echo json_encode($json);
        }
    }

    public function deleteData($id_user = null) {
        $model_user = new User();
        $is_exist = $model_user->find($id_user);
        $is_used = false;

        if ($is_exist) {
            if ($is_used) {
                $msg = [
                    'error' => 'Data sedang digunakan pada KRS'
                ];
            } else {
                $model_user->delete($id_user);
                $msg = [
                    'success' => 'Data berhasil dihapus'
                ];
            }
        }

        echo json_encode($msg);
    }

    public function updateData() {
        if ($this->request->isAJAX()) {
            $id_user = $this->request->getPost('id_user');
            $nama_user = $this->request->getPost('nama_user');
            $id_group = $this->request->getPost('id_group');
            $email = $this->request->getPost('email');

            $rules = $this->validate([
                'nama_user' => [
                    'label' => 'Nama User',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'id_group' => [
                    'label' => 'Group',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'email' => [
                    'label' => 'Email',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
            ]);

            if (!$rules) {
                $validation = \Config\Services::validation();
                $error = [
                    'errorNama' => $validation->getError('nama_user'),
                    'errorEmail' => $validation->getError('email'),
                    'errorGroup' => $validation->getError('id_group'),
                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $model_user = new User();
                $model_user->update($id_user, [
                    'nama_user' => $nama_user,
                    'id_group' => $id_group,
                    'email' => $email
                ]);

                $json = [
                    'success' => 'Data user berhasil diubah'
                ];
            }

            echo json_encode($json);
        } 
    }
}
