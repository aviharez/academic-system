<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Level;
use App\Models\Mahasiswa;
use App\Models\User;
use Hermawan\DataTables\DataTable;

class MahasiswaController extends BaseController
{
    public function index()
    {
        return view('admin/mahasiswa/index');
    }

    public function getDataAdmin() {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $builder = $db->table('mahasiswa')->select('nim, nama, program_studi, semester');

            return DataTable::of($builder)
                ->addNumbering()
                ->add('action', function($row){
                    return '<button type="button" class="btn btn-sm btn-info" style="width: 31px;" title="Detail Data" onclick="showDetail(\''.$row->nim.'\')"><i class="fas fa-info"></i></button>
                    <button type="button" class="btn btn-sm btn-warning" style="width: 31px;" title="Ubah Data" onclick="updateData(\''.$row->nim.'\')"><i class="fas fa-edit"></i></button>
                    <button type="button" class="btn btn-sm btn-danger" style="width: 31px;" title="Hapus Data" onclick="deleteData(\''.$row->nim.'\')"><i class="fas fa-trash-alt"></i></button>';
                }, 'last')
                ->toJson();
        }
    }

    public function getAllEmailData() {
        if ($this->request->isAJAX()) {
            $model_user = new User();
            $data = $model_user->where('id_group', 3)->findAll();
            $json = [
                'data' => $data
            ];
            echo json_encode($json);
        }
    }

    public function getAllLevelData() {
        if ($this->request->isAJAX()) {
            $model_user = new Level();
            $data = $model_user->findAll();
            $json = [
                'data' => $data
            ];
            echo json_encode($json);
        }
    }

    public function getSelectedMhsData($nim) {
        if ($this->request->isAJAX()) {
            $model_mhs = new Mahasiswa();
            $row_mhs = $model_mhs->find($nim);
            $data = [
                'nim' => $nim,
                'nama' => $row_mhs['nama'],
                'jenis_kelamin' => $row_mhs['jenis_kelamin'],
                'tanggal_lahir' => date('m/d/Y',strtotime($row_mhs['tanggal_lahir'])),
                'alamat' => $row_mhs['alamat'],
                'program_studi' => $row_mhs['program_studi'],
                'semester' => $row_mhs['semester'],
                'email' => $row_mhs['email'],
                'kd_level' => $row_mhs['kd_level'],
                'nama_level' => $this->getLevelName($row_mhs['kd_level'])
            ];
            $json = [
                'data' => $data
            ];
            echo json_encode($json);
        }
    }

    private function getLevelName($id): string {
        $model_level = new Level();
        $row_level = $model_level->find($id);
        if ($row_level) {
            return $row_level['nama_level'];
        } else {
            return '';
        }
    }

    public function saveData() {
        if ($this->request->isAJAX()) {
            $nim = $this->request->getPost('nim');
            $nama = $this->request->getPost('nama');
            $jenis_kelamin = $this->request->getPost('jenis_kelamin');
            $tanggal_lahir = $this->request->getPost('tanggal_lahir');
            $alamat = $this->request->getPost('alamat');
            $program_studi = $this->request->getPost('program_studi');
            $semester = $this->request->getPost('semester');
            $email = $this->request->getPost('email');
            $kd_level = $this->request->getPost('kd_level');

            $rules = $this->validate([
                'nim' => [
                    'label' => 'NIM',
                    'rules' => 'required|is_unique[mahasiswa.nim]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} sudah terdaftar'
                    ]
                ],
                'nama' => [
                    'label' => 'Nama Mahasiswa',
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
                'tanggal_lahir' => [
                    'label' => 'Tanggal Lahir',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'alamat' => [
                    'label' => 'Alamat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'program_studi' => [
                    'label' => 'Program Studi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'semester' => [
                    'label' => 'Semester',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'email' => [
                    'label' => 'Email',
                    'rules' => 'required|is_unique[mahasiswa.email]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} sudah terdaftar'
                    ]
                ],
                'kd_level' => [
                    'label' => 'Level',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
            ]);

            if (!$rules) {
                $validation = \Config\Services::validation();

                $error = [
                    'errorNIM' => $validation->getError('nim'),
                    'errorNama' => $validation->getError('nama'),
                    'errorJK' => $validation->getError('jenis_kelamin'),
                    'errorTL' => $validation->getError('tanggal_lahir'),
                    'errorAlamat' => $validation->getError('alamat'),
                    'errorProdi' => $validation->getError('program_studi'),
                    'errorSem' => $validation->getError('semester'),
                    'errorEmail' => $validation->getError('email'),
                    'errorLevel' => $validation->getError('kd_level'),
                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $model_mhs = new Mahasiswa();
                $model_mhs->insert([
                    'nim' => $nim,
                    'nama' => $nama,
                    'jenis_kelamin' => $jenis_kelamin,
                    'tanggal_lahir' => date('Y-m-d',strtotime($tanggal_lahir)),
                    'alamat' => $alamat,
                    'program_studi' => $program_studi,
                    'semester' => $semester,
                    'email' => $email,
                    'kd_level' => $kd_level,
                ]);

                $json = [
                    'success' => 'Data mahasiswa berhasil disimpan'
                ];
            }

            echo json_encode($json);
        }
    }

    public function deleteData($nim = null) {
        $model_mhs = new Mahasiswa();
        $is_exist = $model_mhs->find($nim);

        if ($is_exist) {
            $model_mhs->delete($nim);
            $msg = [
                'success' => 'Data berhasil dihapus'
            ];
        }

        echo json_encode($msg);
    }

    public function updateData() {
        if ($this->request->isAJAX()) {
            $nim = $this->request->getPost('nim');
            $nama = $this->request->getPost('nama');
            $jenis_kelamin = $this->request->getPost('jenis_kelamin');
            $tanggal_lahir = $this->request->getPost('tanggal_lahir');
            $alamat = $this->request->getPost('alamat');
            $program_studi = $this->request->getPost('program_studi');
            $semester = $this->request->getPost('semester');
            $email = $this->request->getPost('email');
            $kd_level = $this->request->getPost('kd_level');

            $rules = $this->validate([
                'nama' => [
                    'label' => 'Nama Mahasiswa',
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
                'tanggal_lahir' => [
                    'label' => 'Tanggal Lahir',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'alamat' => [
                    'label' => 'Alamat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'program_studi' => [
                    'label' => 'Program Studi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'semester' => [
                    'label' => 'Semester',
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
                'kd_level' => [
                    'label' => 'Level',
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
                    'errorTL' => $validation->getError('tanggal_lahir'),
                    'errorAlamat' => $validation->getError('alamat'),
                    'errorProdi' => $validation->getError('program_studi'),
                    'errorSem' => $validation->getError('semester'),
                    'errorEmail' => $validation->getError('email'),
                    'errorLevel' => $validation->getError('kd_level'),
                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $model_mhs = new Mahasiswa();
                $model_mhs->update($nim, [
                    'nama' => $nama,
                    'jenis_kelamin' => $jenis_kelamin,
                    'tanggal_lahir' => date('Y-m-d',strtotime($tanggal_lahir)),
                    'alamat' => $alamat,
                    'program_studi' => $program_studi,
                    'semester' => $semester,
                    'email' => $email,
                    'kd_level' => $kd_level,
                ]);

                $json = [
                    'success' => 'Data mahasiswa berhasil diubah'
                ];
            }

            echo json_encode($json);
        }  
    }
}
