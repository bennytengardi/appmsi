<?php

namespace App\Controllers;

use App\Models\ModelSalesman;
use App\Models\ModelDataSalesman;
use App\Models\ModelCounter;
use App\Models\ModelLogHistory;
use Config\Services;

class Salesman extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->ModelSalesman  = new ModelSalesman();
        $this->ModelCounter = new ModelCounter();
        $this->ModelLogHistory = new ModelLogHistory();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Salesman',
        ];
        return view('salesman/v_index', $data);
    }

    public function listData()
    {
        $request = Services::request();
        $this->ModelDataSalesman = new ModelDataSalesman($request);
        if ($request->getMethod(true) == 'POST') {
            $salesman = $this->ModelDataSalesman->get_datatables();
            $data = [];
            $no = $request->getPost("start") + 1;
            foreach ($salesman as $sls) {
                $row = [];
                $row[] = $no++;
                $row[] = $sls['kode_salesman'];
                $row[] = $sls['nama_salesman'];
                $row[] =
                    '<a href="' . base_url('salesman/edit/' . $sls['kode_salesman']) . '" class="btn btn-success btn-xs mr-2">EDIT</a>' .
                    "<button type=\"button\" class=\"btn btn-danger btn-sm\" style=\"height: 26px; font-size: 12px;\"  onclick=\"hapusSalesman('" . $sls['kode_salesman'] .  "','" . $sls['nama_salesman'] . "') \">DELETE</button>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $this->ModelDataSalesman->count_all(),
                "recordsFiltered" => $this->ModelDataSalesman->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function add()
    {
        $ctr = $this->ModelCounter->allData();
        $kode_salesman = 'S' . str_pad(strval(($ctr['salesman'] + 1)), 3, '0', STR_PAD_LEFT);
        $data = [
            'title'      => 'Tambah Salesman',
            'kode_salesman' => $kode_salesman,
            'validation'  => \config\Services::validation()
        ];
        return view('salesman/v_add', $data);
    }


    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $kode_salesman    = $this->request->getPost('kode_salesman');
            $nama_salesman    = $this->request->getPost('nama_salesman');

            $validation =  \Config\Services::validation();

            $valid = $this->validate([
                'nama_salesman' => [
                    'label' => 'Nama Salesman',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],

            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorNamaSalesman'   => $validation->getError('nama_salesman'),
                    ]
                ];
            } else {
                $data = [
                    'kode_salesman'   => $kode_salesman,
                    'nama_salesman'   => $nama_salesman,
                ];

                $this->ModelSalesman->add($data);

                // Update Counter Salesman
                $ctr = $this->ModelCounter->allData();
                $inv = $ctr['salesman'] + 1;
                $data = [
                    'salesman' => $inv
                ];
                $this->ModelCounter->updctr($data);

                date_default_timezone_set('Asia/Jakarta');
                $datalog = [
                    'username'  => session()->get('username'),
                    'jamtrx'    => date('Y-m-d H:i:s'),
                    'kegiatan'  => 'Menambah Tabel Salesman : ' . $nama_salesman,
                ];
                $this->ModelLogHistory->add($datalog);

                $msg = [
                    'sukses' => 'Data Salesman Baru Berhasil ditambahkan'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function edit($kode_salesman)
    {
        $data = [
            'salesman'    => $this->ModelSalesman->detail($kode_salesman),
            'validation'  => \config\Services::validation()
        ];

        return view('salesman/v_edit', $data);
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $kode_salesman    = $this->request->getPost('kode_salesman');
            $nama_salesman    = $this->request->getPost('nama_salesman');


            $validation =  \Config\Services::validation();
            $valid = $this->validate([
                'nama_salesman' => [
                    'label' => 'Nama Salesman',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorNamaSalesman'   => $validation->getError('nama_salesman'),
                    ]
                ];
            } else {
                $data = [
                    'kode_salesman'   => $kode_salesman,
                    'nama_salesman'   => $nama_salesman,
                ];

                $this->ModelSalesman->edit($data);

                date_default_timezone_set('Asia/Jakarta');
                $datalog = [
                    'username'  => session()->get('username'),
                    'jamtrx'    => date('Y-m-d H:i:s'),
                    'kegiatan'  => 'Merubah Tabel Salesman : ' . $nama_salesman,
                ];
                $this->ModelLogHistory->add($datalog);

                $msg = [
                    'sukses' => 'Data Salesman Berhasil diupdate'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $kode_salesman = $this->request->getVar('kode_salesman');
            $nama_salesman = $this->request->getVar('nama_salesman');
            $this->ModelSalesman->hapus($kode_salesman);

                date_default_timezone_set('Asia/Jakarta');
                $datalog = [
                    'username'  => session()->get('username'),
                    'jamtrx'    => date('Y-m-d H:i:s'),
                    'kegiatan'  => 'Menghapus Tabel Salesman : ' . $nama_salesman,
                ];
                $this->ModelLogHistory->add($datalog);

            $msg = ['sukses' => 'Data Salesman berhasil dihapus !!!'];
            echo json_encode($msg);
        } else {
            exit('Maaf, tidak dapat diproses');
        }
    }

    public function cari_kodesalesman()
    {
        $kode_salesman = $this->request->getPost('kode_salesman');
        $data = $this->ModelSalesman->detail($kode_salesman);
        session()->set('vat', $data['ppn']);
        echo json_encode($data);
    }
}
