<?php

namespace App\Controllers;

use App\Models\ModelMerk;
use App\Models\ModelDataMerk;
use App\Models\ModelLogHistory;
use Config\Services;

class Merk extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->ModelMerk = new ModelMerk();
        $this->ModelLogHistory = new ModelLogHistory();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Merk',
        ];
        return view('merk/v_index', $data);
    }

    public function listData()
    {
        $request = Services::request();
        $this->ModelDataMerk = new ModelDataMerk($request);
        if ($request->getMethod(true) == 'POST') {
            $merk = $this->ModelDataMerk->get_datatables();
            $data = [];
            $no = $request->getPost("start") + 1;
            foreach ($merk as $sat) {
                $row = [];
                $row[] = $no++;
                $row[] = $sat['kode_merk'];
                $row[] = $sat['nama_merk'];
                $row[] =
                    '<a href="' . base_url('merk/edit/' . $sat['kode_merk']) . '" class="btn btn-success btn-xs mr-2" style="height: 26px;font-size: 12px;">EDIT</a>' .
                    "<button type=\"button\" class=\"btn btn-danger btn-sm\" style=\"height: 26px; font-size: 12px;\"  onclick=\"hapusMerk('" . $sat['kode_merk'] .  "','" . $sat['nama_merk'] . "') \">DELETE</button>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $this->ModelDataMerk->count_all(),
                "recordsFiltered" => $this->ModelDataMerk->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function add()
    {
        $data = [
            'title'      => 'Tambah Merk',
            'validation'  => \config\Services::validation()
        ];
        return view('merk/v_add', $data);
    }


    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $kode_merk = $this->request->getVar('kode_merk');
            $nama_merk = $this->request->getVar('nama_merk');

            $validation =  \Config\Services::validation();
            $valid = $this->validate([
                'kode_merk' => [
                    'label' => 'Kode Merk',
                    'rules' => 'required|is_unique[tbl_merk.kode_merk]',
                    'errors' => [
                        'is_unique' => '{field} sudah ada, coba dengan kode yang lain',
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],

                'nama_merk' => [
                    'label' => 'Nama Merk',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorKodeMerk'  => $validation->getError('kode_merk'),
                        'errorNamaMerk'   => $validation->getError('nama_merk'),
                    ]
                ];
            } else {
                //    data sudah Valid
                $data = [
                    'kode_merk' => $kode_merk,
                    'nama_merk' => $nama_merk,
                ];

                $this->ModelMerk->add($data);
                
                date_default_timezone_set('Asia/Jakarta');
                $datalog = [
                    'username'  => session()->get('username'),
                    'jamtrx'    => date('Y-m-d H:i:s'),
                    'kegiatan'  => 'Menambah Tabel Merk : ' . $nama_merk,
                ];
                $this->ModelLogHistory->add($datalog);
                
                $msg = [
                    'sukses' => 'Merk Baru Berhasil ditambahkan'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function edit($kode_merk)
    {
        $data = [
            'merk' => $this->ModelMerk->find($kode_merk),
        ];
        return view('merk/v_edit', $data);
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $kode_merk  = $this->request->getVar('kode_merk');
            $nama_merk  = $this->request->getVar('nama_merk');
            $validation =  \Config\Services::validation();

            $valid = $this->validate([

                'nama_merk' => [
                    'label' => 'Nama Merk',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorNamaMerk'   => $validation->getError('nama_merk'),
                    ]
                ];
            } else {
                $data = [
                    'kode_merk' => $kode_merk,
                    'nama_merk' => $nama_merk,
                ];
                $this->ModelMerk->edit($data);

                date_default_timezone_set('Asia/Jakarta');
                $datalog = [
                    'username'  => session()->get('username'),
                    'jamtrx'    => date('Y-m-d H:i:s'),
                    'kegiatan'  => 'Merubah Tabel Merk : ' . $nama_merk,
                ];
                $this->ModelLogHistory->add($datalog);

                $msg = [
                    'sukses' => 'Data Merk Berhasil diupdate'
                ];
            }
            echo json_encode($msg);
        }
    }


    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $kode_merk = $this->request->getVar('kode_merk');
            $nama_merk = $this->request->getVar('nama_merk');

            $this->ModelMerk->hapus($kode_merk);
            
            date_default_timezone_set('Asia/Jakarta');
            $datalog = [
                'username'  => session()->get('username'),
                'jamtrx'    => date('Y-m-d H:i:s'),
                'kegiatan'  => 'Menghapus Tabel Merk : ' . $nama_merk,
            ];
            $this->ModelLogHistory->add($datalog);
            
            $msg = ['sukses' => 'Data Merk berhasil dihapus !!!'];
            echo json_encode($msg);
        } else {
            exit('Maaf, tidak dapat diproses');
        }
    }
}
