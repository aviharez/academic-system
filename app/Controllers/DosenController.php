<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Dosen;
use App\Models\User;
use Hermawan\DataTables\DataTable;

class DosenController extends BaseController
{
    public function index()
    {
        return view('admin/dosen/index');
    }

    public function getDataAdmin() {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $builder = $db->table('dosen')->select('nip, nama, jenis_kelamin, email');

            return DataTable::of($builder)
                ->addNumbering()
                ->add('action', function($row){
                    return '<button type="button" class="btn btn-sm btn-info" title="Ubah Data" onclick="updateData(\''.$row->nip.'\')"><i class="fas fa-edit"></i></button>
                    <button type="button" class="btn btn-sm btn-danger" title="Hapus Data" onclick="deleteData(\''.$row->nip.'\')"><i class="fas fa-trash-alt"></i></button>';
                }, 'last')
                ->format('jenis_kelamin', function($value){
                    return $value == 'L' ? 'Laki-laki' : 'Perempuan';
                })
                ->toJson();
        }
    }

    public function getAllEmailData() {
        if ($this->request->isAJAX()) {
            $model_user = new User();
            $data = $model_user->where('id_group', 2)->findAll();
            $json = [
                'data' => $data
            ];
            echo json_encode($json);
        }
    }

    public function getSelectedDosenData($nip) {
        if ($this->request->isAJAX()) {
            $model_dosen = new Dosen();
            $row_dosen = $model_dosen->find($nip);
            $data = [
                'nip' => $nip,
                'nama' => $row_dosen['nama'],
                'jenis_kelamin' => $row_dosen['jenis_kelamin'],
                'email' => $row_dosen['email']
            ];
            $json = [
                'data' => $data
            ];
            echo json_encode($json);
        }
    }

    public function saveData() {
        if ($this->request->isAJAX()) {
            $nip = $this->request->getPost('nip');
            $nama = $this->request->getPost('nama');
            $jenis_kelamin = $this->request->getPost('jenis_kelamin');
            $email = $this->request->getPost('email');

            $rules = $this->validate([
                'nip' => [
                    'label' => 'NIP',
                    'rules' => 'required|is_unique[dosen.nip]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} sudah terdaftar'
                    ]
                ],
                'nama' => [
                    'label' => 'Nama Dosen',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'jenis_kelamin' => [
                    'label' => 'Jenis Kelamin',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'email' => [
                    'label' => 'Email',
                    'rules' => 'required|is_unique[dosen.email]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} sudah terdaftar'
                    ]
                ],
            ]);

            if (!$rules) {
                $validation = \Config\Services::validation();

                $error = [
                    'errorNIP' => $validation->getError('nip'),
                    'errorNama' => $validation->getError('nama'),
                    'errorJK' => $validation->getError('jenis_kelamin'),
                    'errorEmail' => $validation->getError('email'),
                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $model_dosen = new Dosen();
                $model_dosen->insert([
                    'nip' => $nip,
                    'nama' => $nama,
                    'jenis_kelamin' => $jenis_kelamin,
                    'email' => $email
                ]);

                $json = [
                    'success' => 'Data dosen berhasil disimpan'
                ];
            }

            echo json_encode($json);
        }
    }

    public function deleteData($nip = null) {
        $model_dosen = new Dosen();
        $is_exist = $model_dosen->find($nip);
        $is_used = false;

        if ($is_exist) {
            if ($is_used) {
                $msg = [
                    'error' => 'Data sedang digunakan pada KRS'
                ];
            } else {
                $model_dosen->delete($nip);
                $msg = [
                    'success' => 'Data dosen berhasil dihapus'
                ];
            }
        }

        echo json_encode($msg);
    }

    public function updateData() {
        if ($this->request->isAJAX()) {
            $nip = $this->request->getPost('nip');
            $nama = $this->request->getPost('nama');
            $jenis_kelamin = $this->request->getPost('jenis_kelamin');
            $email = $this->request->getPost('email');

            $rules = $this->validate([
                'nip' => [
                    'label' => 'NIP',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'nama' => [
                    'label' => 'Nama Dosen',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'jenis_kelamin' => [
                    'label' => 'Jenis Kelamin',
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
                    'errorNama' => $validation->getError('nama'),
                    'errorJK' => $validation->getError('jenis_kelamin'),
                    'errorEmail' => $validation->getError('email'),
                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $model_dosen = new Dosen();
                $model_dosen->update($nip, [
                    'nip' => $nip,
                    'nama' => $nama,
                    'jenis_kelamin' => $jenis_kelamin,
                    'email' => $email
                ]);

                $json = [
                    'success' => 'Data dosen berhasil diubah'
                ];
            }

            echo json_encode($json);
        } 
    }
}
