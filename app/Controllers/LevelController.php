<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Level;
use Hermawan\DataTables\DataTable;

class LevelController extends BaseController
{
    public function index()
    {
        return view('admin/level/index');
    }

    public function getDataAdmin() {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $builder = $db->table('level')->select('kd_level, nama_level, kriteria_level');

            return DataTable::of($builder)
                ->addNumbering()
                ->add('action', function($row){
                    return '<button type="button" class="btn btn-sm btn-info" title="Ubah Data" onclick="updateData(\''.$row->kd_level.'\')"><i class="fas fa-edit"></i></button>
                    <button type="button" class="btn btn-sm btn-danger" title="Hapus Data" onclick="deleteData(\''.$row->kd_level.'\')"><i class="fas fa-trash-alt"></i></button>';
                }, 'last')
                ->format('kriteria_level', function($value){
                    return $value.' poin';
                })
                ->toJson();
        }
    }

    public function getSelectedLevelData($kd_level) {
        if ($this->request->isAJAX()) {
            $model_level = new Level();
            $row_level = $model_level->find($kd_level);
            $data = [
                'kd_level' => $kd_level,
                'nama_level' => $row_level['nama_level'],
                'kriteria_level' => $row_level['kriteria_level']
            ];
            $json = [
                'data' => $data
            ];
            echo json_encode($json);
        }
    }

    public function saveData() {
        if ($this->request->isAJAX()) {
            $kd_level = $this->request->getPost('kd_level');
            $nama_level = $this->request->getPost('nama_level');
            $kriteria_level = $this->request->getPost('kriteria_level');

            $rules = $this->validate([
                'kd_level' => [
                    'label' => 'Kode Level',
                    'rules' => 'required|is_unique[level.kd_level]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} sudah terdaftar'
                    ]
                ],
                'nama_level' => [
                    'label' => 'Nama Level',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'kriteria_level' => [
                    'label' => 'Kriteria Level',
                    'rules' => 'required|is_unique[level.kd_level]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} sudah terdaftar'
                    ]
                ],
            ]);

            if (!$rules) {
                $validation = \Config\Services::validation();

                $error = [
                    'errorKdLevel' => $validation->getError('kd_level'),
                    'errorNamaLevel' => $validation->getError('nama_level'),
                    'errorKriteriaLevel' => $validation->getError('kriteria_level'),
                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $model_level = new Level();
                $model_level->insert([
                    'kd_level' => $kd_level,
                    'nama_level' => $nama_level,
                    'kriteria_level' => $kriteria_level
                ]);

                $json = [
                    'success' => 'Data level berhasil disimpan'
                ];
            }

            echo json_encode($json);
        }
    }

    public function deleteData($kd_level = null) {
        $model_level = new Level();
        $is_exist = $model_level->find($kd_level);
        $is_used = false;

        if ($is_exist) {
            if ($is_used) {
                $msg = [
                    'error' => 'Data sedang digunakan pada KRS'
                ];
            } else {
                $model_level->delete($kd_level);
                $msg = [
                    'success' => 'Data berhasil dihapus'
                ];
            }
        }

        echo json_encode($msg);
    }

    public function updateData() {
        if ($this->request->isAJAX()) {
            $kd_level = $this->request->getPost('kd_level');
            $nama_level = $this->request->getPost('nama_level');
            $kriteria_level = $this->request->getPost('kriteria_level');

            $rules = $this->validate([
                'nama_level' => [
                    'label' => 'Nama Level',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'kriteria_level' => [
                    'label' => 'Kriteria Level',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
            ]);

            if (!$rules) {
                $validation = \Config\Services::validation();
                $error = [
                    'errorNamaLevel' => $validation->getError('nama_level'),
                    'errorKriteriaLevel' => $validation->getError('kriteria_level'),
                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $model_level = new Level();
                $model_level->update($kd_level, [
                    'nama_level' => $nama_level,
                    'kriteria_level' => $kriteria_level
                ]);

                $json = [
                    'success' => 'Data level berhasil diubah'
                ];
            }

            echo json_encode($json);
        } 
    }
}
