<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Dosen;
use App\Models\Krs;
use App\Models\MataKuliah;
use Hermawan\DataTables\DataTable;

class KrsController extends BaseController
{
    public function index()
    {
        return view('admin/krs/index');
    }

    public function getDataAdmin() {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $builder = $db->table('krs')
                          ->select('kd_krs, mata_kuliah.nama_mk, dosen.nama, mata_kuliah.sks')
                          ->join('mata_kuliah', 'mata_kuliah.kd_mk = krs.kd_mk')
                          ->join('dosen', 'dosen.nip = krs.nip');

            return DataTable::of($builder)
                ->addNumbering('no')
                ->add('action', function($row){
                    return '<button type="button" class="btn btn-sm btn-info" style="width: 31px;" title="Detail Data" onclick="showDetail(\''.$row->kd_krs.'\')"><i class="fas fa-info"></i></button>
                    <button type="button" class="btn btn-sm btn-warning" style="width: 31px;" title="Ubah Data" onclick="updateData(\''.$row->kd_krs.'\')"><i class="fas fa-edit"></i></button>
                    <button type="button" class="btn btn-sm btn-danger" style="width: 31px;" title="Hapus Data" onclick="deleteData(\''.$row->kd_krs.'\')"><i class="fas fa-trash-alt"></i></button>';
                })
                ->toJson(true);
        }
    }

    public function getAllMatkulData() {
        if ($this->request->isAJAX()) {
            $model_matkul = new MataKuliah();
            $data = $model_matkul->findAll();
            $json = [
                'data' => $data
            ];
            echo json_encode($json);
        }
    }

    public function getAllDosenData() {
        if ($this->request->isAJAX()) {
            $model_dosen = new Dosen();
            $data = $model_dosen->findAll();
            $json = [
                'data' => $data
            ];
            echo json_encode($json);
        }
    }

    private function getDataMatkul($id, $column): string {
        $model_matkul = new MataKuliah();
        $row_matkul = $model_matkul->find($id);
        if ($row_matkul) {
            return $row_matkul[$column];
        } else {
            return '';
        }
    }

    private function getDataDosen($id, $column): string {
        $model_dosen = new Dosen();
        $row_dosen = $model_dosen->find($id);
        if ($row_dosen) {
            return $row_dosen[$column];
        } else {
            return '';
        }
    }

    public function getSelectedKrsData($id) {
        if ($this->request->isAJAX()) {
            $model_krs = new Krs();
            $row_krs = $model_krs->find($id);
            $data = [
                'kd_krs' => $id,
                'kd_mk' => $row_krs['kd_mk'],
                'nama_mk' => $this->getDataMatkul($row_krs['kd_mk'], 'nama_mk'),
                'nip' => $row_krs['nip'],
                'nama_dosen' => $this->getDataDosen($row_krs['nip'], 'nama'),
                'semester' => $row_krs['semester'],
                'thn_ajaran' => $row_krs['thn_ajaran'],
                'sks' => $this->getDataMatkul($row_krs['kd_mk'], 'sks'),
                'hari' => $row_krs['hari'],
                'jam' => $row_krs['jam'],
                'harga' => 'IDR '.number_format($this->getDataMatkul($row_krs['kd_mk'], 'harga'), 2,'.',',')
            ];
            $json = [
                'data' => $data
            ];
            echo json_encode($json);
        }
    }

    public function saveData() {
        if ($this->request->isAJAX()) {
            $kd_krs = $this->request->getPost('kd_krs');
            $nip = $this->request->getPost('nip');
            $kd_mk = $this->request->getPost('kd_mk');
            $semester = $this->request->getPost('semester');
            $thn_ajaran = $this->request->getPost('thn_ajaran');
            $hari = $this->request->getPost('hari');
            $jam = $this->request->getPost('jam');

            $rules = $this->validate([
                'kd_krs' => [
                    'label' => 'Kode KRS',
                    'rules' => 'required|is_unique[krs.kd_krs]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} sudah terdaftar'
                    ]
                ],
                'nip' => [
                    'label' => 'Nama Dosen',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'kd_mk' => [
                    'label' => 'Mata Kuliah',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'thn_ajaran' => [
                    'label' => 'Tahun Ajaran',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'hari' => [
                    'label' => 'Hari',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'jam' => [
                    'label' => 'Jam',
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
                ]
            ]);

            if (!$rules) {
                $validation = \Config\Services::validation();

                $error = [
                    'errorKdKrs' => $validation->getError('kd_krs'),
                    'errorNIP' => $validation->getError('nip'),
                    'errorKdMk' => $validation->getError('kd_mk'),
                    'errorThn' => $validation->getError('thn_ajaran'),
                    'errorHari' => $validation->getError('hari'),
                    'errorJam' => $validation->getError('jam'),
                    'errorSem' => $validation->getError('semester'),
                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $model_krs = new Krs();
                $model_krs->insert([
                    'kd_krs' => $kd_krs,
                    'nip' => $nip,
                    'kd_mk' => $kd_mk,
                    'thn_ajaran' => $thn_ajaran,
                    'hari' => $hari,
                    'jam' => $jam,
                    'semester' => $semester,
                    'sks' => $this->getDataMatkul($kd_mk, 'sks'),
                    'harga' => $this->getDataMatkul($kd_mk, 'harga')
                ]);

                $json = [
                    'success' => 'Data KRS berhasil disimpan'
                ];
            }

            echo json_encode($json);
        }
    }

    public function deleteData($kd_krs = null) {
        $model_krs = new Krs();
        $is_exist = $model_krs->find($kd_krs);

        if ($is_exist) {
            $model_krs->delete($kd_krs);
            $msg = [
                'success' => 'Data berhasil dihapus'
            ];
        }

        echo json_encode($msg);
    }

    public function updateData() {
        if ($this->request->isAJAX()) {
            $kd_krs = $this->request->getPost('kd_krs');
            $nip = $this->request->getPost('nip');
            $kd_mk = $this->request->getPost('kd_mk');
            $thn_ajaran = $this->request->getPost('thn_ajaran');
            $hari = $this->request->getPost('hari');
            $jam = $this->request->getPost('jam');
            $semester = $this->request->getPost('semester');

            $rules = $this->validate([
                'nip' => [
                    'label' => 'Nama Dosen',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'kd_mk' => [
                    'label' => 'Mata Kuliah',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'thn_ajaran' => [
                    'label' => 'Tahun Ajaran',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'hari' => [
                    'label' => 'Hari',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'jam' => [
                    'label' => 'Jam',
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
                ]
            ]);

            if (!$rules) {
                $validation = \Config\Services::validation();
                $error = [
                    'errorNIP' => $validation->getError('nip'),
                    'errorKdMk' => $validation->getError('kd_mk'),
                    'errorThn' => $validation->getError('thn_ajaran'),
                    'errorHari' => $validation->getError('hari'),
                    'errorJam' => $validation->getError('jam'),
                    'errorSem' => $validation->getError('semester'),
                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $model_krs = new Krs();
                $model_krs->update($kd_krs, [
                    'nip' => $nip,
                    'kd_mk' => $kd_mk,
                    'thn_ajaran' => $thn_ajaran,
                    'hari' => $hari,
                    'jam' => $jam,
                    'semester' => $semester,
                    'sks' => $this->getDataMatkul($kd_mk, 'sks'),
                    'harga' => $this->getDataMatkul($kd_mk, 'harga')
                ]);

                $json = [
                    'success' => 'Data KRS berhasil diubah'
                ];
            }

            echo json_encode($json);
        }  
    }
}
