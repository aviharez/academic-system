<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MataKuliah;
use Hermawan\DataTables\DataTable;

class MataKuliahController extends BaseController
{
    public function index()
    {
        return view('admin/mata-kuliah/index');
    }

    public function getDataAdmin() {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $builder = $db->table('mata_kuliah')->select('kd_mk, nama_mk, sks, harga');

            return DataTable::of($builder)
                ->addNumbering()
                ->add('action', function($row){
                    return '<button type="button" class="btn btn-sm btn-info" title="Ubah Data" onclick="updateData(\''.$row->kd_mk.'\')"><i class="fas fa-edit"></i></button>
                    <button type="button" class="btn btn-sm btn-danger" title="Hapus Data" onclick="deleteData(\''.$row->kd_mk.'\')"><i class="fas fa-trash-alt"></i></button>';
                }, 'last')
                ->format('harga', function($value){
                    return 'IDR '.number_format($value, 2,'.',',');
                })
                ->toJson();
        }
    }

    public function getSelectedMatkulData($kd_mk) {
        if ($this->request->isAJAX()) {
            $model_matkul = new MataKuliah();
            $row_mk = $model_matkul->find($kd_mk);
            $data = [
                'kd_mk' => $kd_mk,
                'nama_mk' => $row_mk['nama_mk'],
                'sks' => $row_mk['sks']
            ];
            $json = [
                'data' => $data
            ];
            echo json_encode($json);
        }
    }

    public function saveData() {
        if ($this->request->isAJAX()) {
            $kd_mk = $this->request->getPost('kd_mk');
            $nama_mk = $this->request->getPost('nama_mk');
            $sks = $this->request->getPost('sks');

            $rules = $this->validate([
                'kd_mk' => [
                    'label' => 'Kode Mata Kuliah',
                    'rules' => 'required|is_unique[mata_kuliah.kd_mk]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} sudah terdaftar'
                    ]
                ],
                'nama_mk' => [
                    'label' => 'Nama Mata Kuliah',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'sks' => [
                    'label' => 'Jumlah SKS',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
            ]);

            if (!$rules) {
                $validation = \Config\Services::validation();

                $error = [
                    'errorKdMk' => $validation->getError('kd_mk'),
                    'errorNamaMk' => $validation->getError('nama_mk'),
                    'errorSKS' => $validation->getError('sks'),
                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $model_matkul = new MataKuliah();
                $harga = $sks * 150000;
                $model_matkul->insert([
                    'kd_mk' => $kd_mk,
                    'nama_mk' => $nama_mk,
                    'sks' => $sks,
                    'harga' => $harga
                ]);

                $json = [
                    'success' => 'Data mata kuliah berhasil disimpan'
                ];
            }

            echo json_encode($json);
        }
    }

    public function deleteData($kd_mk = null) {
        $model_matkul = new MataKuliah();
        $is_exist = $model_matkul->find($kd_mk);
        $is_used = false;

        if ($is_exist) {
            if ($is_used) {
                $msg = [
                    'error' => 'Data sedang digunakan pada KRS'
                ];
            } else {
                $model_matkul->delete($kd_mk);
                $msg = [
                    'success' => 'Data berhasil dihapus'
                ];
            }
        }

        echo json_encode($msg);
    }

    public function updateData() {
        if ($this->request->isAJAX()) {
            $kd_mk = $this->request->getPost('kd_mk');
            $nama_mk = $this->request->getPost('nama_mk');
            $sks = $this->request->getPost('sks');

            $rules = $this->validate([
                'nama_mk' => [
                    'label' => 'Nama Mata Kuliah',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'sks' => [
                    'label' => 'Jumlah SKS',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
            ]);

            if (!$rules) {
                $validation = \Config\Services::validation();
                $error = [
                    'errorNamaMk' => $validation->getError('nama_mk'),
                    'errorSKS' => $validation->getError('sks'),
                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $model_matkul = new MataKuliah();
                $harga = $sks * 150000;
                $model_matkul->update($kd_mk, [
                    'nama_mk' => $nama_mk,
                    'sks' => $sks,
                    'harga' => $harga
                ]);

                $json = [
                    'success' => 'Data mata kuliah berhasil diubah'
                ];
            }

            echo json_encode($json);
        }

        

        

        
    }
}
